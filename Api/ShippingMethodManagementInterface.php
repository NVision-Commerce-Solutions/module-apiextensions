<?php
namespace Commerce365\MagentoApiExtensions\Api;

/**
 * Shipping Method Management Interface.
 *
 * Additional admin method to retrieve a list of installed shipping methods.
 *
 * @api
 * @since 0.0.3
 */
interface ShippingMethodManagementInterface
{
    /**
     * Get active carriers / shipping methods
     *
     * @api
     * @return \Commerce365\MagentoApiExtensions\Api\Data\ShippingMethodInterface[]
     */
    public function getActiveMethods(): array;

}
