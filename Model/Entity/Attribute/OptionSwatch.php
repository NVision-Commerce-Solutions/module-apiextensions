<?php
namespace Commerce365\MagentoApiExtensions\Model\Entity\Attribute;

use Commerce365\MagentoApiExtensions\Api\Data\AttributeOptionSwatchDataInterface;
use Commerce365\MagentoApiExtensions\Api\Data\AttributeOptionSwatchInterface;
use Magento\Eav\Model\Entity\Attribute\Option;

/**
 * Entity attribute option swatch model
 *
 * @method int getAttributeId()
 * @method \Commerce365\MagentoApiExtensions\Model\Entity\Attribute\OptionSwatch setAttributeId(int $value)
 *
 * @api
 * @codeCoverageIgnore
 * @since 100.0.2
 */
class OptionSwatch extends Option implements AttributeOptionSwatchInterface
{
    /**
     * {@inheritdoc}
     */
    public function getSwatchData()
    {
        return $this->getData(AttributeOptionSwatchInterface::SWATCH_DATA);
    }

    /**
     * Set option value
     *
     * @param AttributeOptionSwatchDataInterface $value
     * @return AttributeOptionSwatchInterface
     */
    public function setSwatchData($value): AttributeOptionSwatchInterface
    {
        return $this->setData(AttributeOptionSwatchInterface::SWATCH_DATA, $value);
    }
}
