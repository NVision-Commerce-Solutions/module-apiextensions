<?php

namespace Commerce365\MagentoApiExtensions\Api;

use Commerce365\MagentoApiExtensions\Api\Data\AttributeOptionSwatchInterface;

/**
 * @api
 * @since 100.0.2
 */
interface ProductAttributeSwatchManagementInterface
{
    /**
     * Add swatch option to attribute
     *
     * @param string $attributeCode
     * @param AttributeOptionSwatchInterface $option
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\InputException
     * @return string
     */
    public function add($attributeCode, $option);

    /**
     * Update attribute option
     *
     * @param string $attributeCode
     * @param int $optionId
     * @param AttributeOptionSwatchInterface $option
     * @return bool
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function update(
        string $attributeCode,
        int $optionId,
        AttributeOptionSwatchInterface $option
    ): bool;
}
