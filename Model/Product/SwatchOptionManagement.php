<?php

declare(strict_types=1);

namespace Commerce365\MagentoApiExtensions\Model\Product;

use Commerce365\MagentoApiExtensions\Service\SwatchUploader;
use Magento\Eav\Api\AttributeOptionManagementInterface;
use Magento\Eav\Api\AttributeOptionUpdateInterface;
use Magento\Eav\Api\Data\AttributeInterface as EavAttributeInterface;
use Magento\Eav\Api\Data\AttributeOptionInterface;
use Magento\Eav\Model\AttributeRepository;
use Magento\Eav\Model\ResourceModel\Entity\Attribute;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class SwatchOptionManagement implements AttributeOptionManagementInterface, AttributeOptionUpdateInterface
{
    public function __construct(
        private readonly AttributeRepository $attributeRepository,
        private readonly Attribute $resourceModel,
        private readonly SwatchUploader $swatchUploader
    ) {}

    /**
     * Add option to attribute.
     *
     * @param int $entityType
     * @param string $attributeCode
     * @param AttributeOptionInterface $option
     * @return string
     * @throws InputException
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function add($entityType, $attributeCode, $option)
    {
        $attribute = $this->loadAttribute($entityType, (string)$attributeCode);
        $attribute = $this->setSwatchData($attribute, $option);

        $label = trim((string)$option->getLabel());
        if ($label === '') {
            throw new InputException(__('The attribute option label is empty. Enter the value and try again.'));
        }

        if ($attribute->getSource()->getOptionId($label) !== null) {
            throw new InputException(
                __(
                    'Admin store attribute option label "%1" is already exists.',
                    $option->getLabel()
                )
            );
        }

        $optionId = $this->getNewOptionId($option);
        $this->saveOption($attribute, $option, $optionId);

        return $this->retrieveOptionId($attribute, $option);
    }

    /**
     * @inheritdoc
     */
    public function update(
        string $entityType,
        string $attributeCode,
        int $optionId,
        AttributeOptionInterface $option
    ): bool {
        $attribute = $this->loadAttribute($entityType, (string)$attributeCode);
        $attribute = $this->setSwatchData($attribute, $option, true);

        if (empty($optionId)) {
            throw new InputException(__('The option id is empty. Enter the value and try again.'));
        }
        $label = trim((string)$option->getLabel());
        if ($label === '') {
            throw new InputException(__('The attribute option label is empty. Enter the value and try again.'));
        }
        if ($attribute->getSource()->getOptionText($optionId) === false) {
            throw new InputException(
                __(
                    'The \'%1\' attribute doesn\'t include an option id \'%2\'.',
                    $attribute->getAttributeCode(),
                    $optionId
                )
            );
        }
        $optionIdByLabel = $attribute->getSource()->getOptionId($label);
        if (!empty($optionIdByLabel) && (int)$optionIdByLabel !== (int)$optionId) {
            throw new InputException(
                __(
                    'Admin store attribute option label \'%1\' is already exists.',
                    $option->getLabel()
                )
            );
        }

        $this->saveOption($attribute, $option, $optionId);

        return true;
    }

    /**
     * Save attribute option
     *
     * @param EavAttributeInterface $attribute
     * @param AttributeOptionInterface $option
     * @param int|string $optionId
     * @return AttributeOptionInterface
     * @throws StateException
     */
    private function saveOption(
        EavAttributeInterface $attribute,
        AttributeOptionInterface $option,
        $optionId
    ): AttributeOptionInterface {
        $optionLabel = $option->getLabel() !== null ? trim($option->getLabel()) : '';
        $options = [];
        $options['value'][$optionId][0] = $optionLabel;
        $options['order'][$optionId] = $option->getSortOrder();
        $options['is_default'][$optionId] = $option->getIsDefault();
        if (is_array($option->getStoreLabels())) {
            foreach ($option->getStoreLabels() as $label) {
                $options['value'][$optionId][$label->getStoreId()] = $label->getLabel();
            }
        }
        if ($option->getIsDefault()) {
            $attribute->setDefault([$optionId]);
        }

        $attribute->setOption($options);
        try {
            $this->resourceModel->save($attribute);
        } catch (\Exception $e) {
            throw new StateException(__('The "%1" attribute can\'t be saved.', $attribute->getAttributeCode()));
        }

        return $option;
    }

    /**
     * Get option id to create new option
     *
     * @param AttributeOptionInterface $option
     * @return string
     */
    private function getNewOptionId(AttributeOptionInterface $option, $update): string
    {
        $optionId = trim($option->getValue() ?: '');
        if (empty($optionId)) {
            $optionId = 'new_option';
        }

        return $update ? $optionId : 'id_' . $optionId;
    }

    /**
     * @inheritdoc
     */
    public function delete($entityType, $attributeCode, $optionId): void {}

    /**
     * @inheritdoc
     */
    public function getItems($entityType, $attributeCode): void {}

    /**
     * Load attribute
     *
     * @param string|int $entityType
     * @param string $attributeCode
     * @return EavAttributeInterface
     * @throws InputException
     * @throws NoSuchEntityException
     * @throws StateException
     */
    private function loadAttribute($entityType, string $attributeCode): EavAttributeInterface
    {
        if (empty($attributeCode)) {
            throw new InputException(__('The attribute code is empty. Enter the code and try again.'));
        }

        $attribute = $this->attributeRepository->get($entityType, $attributeCode);
        if (!$attribute->usesSource()) {
            throw new StateException(__('The "%1" attribute doesn\'t work with options.', $attributeCode));
        }

        $attribute->setStoreId(0);

        return $attribute;
    }

    private function setSwatchData($attribute, $option, $update = false)
    {
        $swatchData = $option->getSwatchData();
        $value = $swatchData->getColor();
        if (!$value) {
            $value = $this->swatchUploader->upload($swatchData);
        }

        $swatchVisual = [
            'value' => [
                $this->getNewOptionId($option, $update) => $value
            ]
        ];
        $attribute->setData('swatchvisual', $swatchVisual);

        return $attribute;
    }

    /**
     * Retrieve option id
     *
     * @param EavAttributeInterface $attribute
     * @param AttributeOptionInterface $option
     * @return string
     */
    private function retrieveOptionId(
        EavAttributeInterface $attribute,
        AttributeOptionInterface $option
    ) : string {
        $label = $option->getLabel() !== null ? trim($option->getLabel()) : '';
        $optionId = $attribute->getSource()->getOptionId($label);
        if ($optionId) {
            $option->setValue($optionId);
        } elseif (is_array($option->getStoreLabels())) {
            foreach ($option->getStoreLabels() as $label) {
                $optionId = $attribute->getSource()->getOptionId($label->getLabel());
                if ($optionId) {
                    break;
                }
            }
        }

        return (string) $optionId;
    }
}
