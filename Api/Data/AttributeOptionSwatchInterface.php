<?php

namespace Commerce365\MagentoApiExtensions\Api\Data;

use Magento\Eav\Api\Data\AttributeOptionInterface;

interface AttributeOptionSwatchInterface extends AttributeOptionInterface
{
    const SWATCH_DATA = 'swatch_data';

    /**
     * Get swatch data
     *
     * @return \Commerce365\MagentoApiExtensions\Api\Data\AttributeOptionSwatchDataInterface|null
     */
    public function getSwatchData();

    /**
     * Set swatch data
     *
     * @param AttributeOptionSwatchDataInterface $value
     * @return \Commerce365\MagentoApiExtensions\Api\Data\AttributeOptionSwatchInterface
     */
    public function setSwatchData($value);
}
