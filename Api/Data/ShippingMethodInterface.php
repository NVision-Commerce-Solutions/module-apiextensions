<?php

namespace Commerce365\MagentoApiExtensions\Api\Data;

interface ShippingMethodInterface
{
    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label);

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param string $value
     * @return $this
     */
    public function setValue(string $value);

}
