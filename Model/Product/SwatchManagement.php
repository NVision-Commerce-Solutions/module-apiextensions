<?php
namespace Commerce365\MagentoApiExtensions\Model\Product;

use Commerce365\MagentoApiExtensions\Api\Data\AttributeOptionSwatchInterface;
use Commerce365\MagentoApiExtensions\Api\ProductAttributeSwatchManagementInterface;
use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Eav\Api\AttributeOptionManagementInterface;

/**
 * Option swatch management model for product attribute.
 */
class SwatchManagement implements ProductAttributeSwatchManagementInterface
{
    public function __construct(private readonly AttributeOptionManagementInterface $eavOptionManagement) {}

    /**
     * @inheritdoc
     */
    public function add($attributeCode, $option)
    {
        return $this->eavOptionManagement->add(
            ProductAttributeInterface::ENTITY_TYPE_CODE,
            $attributeCode,
            $option
        );
    }

    /**
     * @inheritdoc
     */
    public function update(string $attributeCode, int $optionId, AttributeOptionSwatchInterface $option): bool
    {
        return $this->eavOptionManagement->update(
            ProductAttributeInterface::ENTITY_TYPE_CODE,
            $attributeCode,
            $optionId,
            $option
        );
    }
}
