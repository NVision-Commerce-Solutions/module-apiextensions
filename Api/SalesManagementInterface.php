<?php
namespace Commerce365\MagentoApiExtensions\Api;
 
/**
 * Sales Management Interface.
 * 
 * Additional admin method to create a custom order status.
 *  
 * @api
 * @since 0.0.5
 */
interface SalesManagementInterface
{
    /**
     * Post a new order status to make sure Magento knows the status NAV/BC is using
     * 
     * @api
     * @param string $statusCode 
     * @param string $statusLabel 
     * @return boolean
     */  
    public function createOrderStatus($statusCode, $statusLabel);

}