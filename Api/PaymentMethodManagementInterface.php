<?php
namespace Commerce365\MagentoApiExtensions\Api;
 
/**
 * Payment Method Management Interface.
 * 
 * Additional admin method to retrieve a list of installed payment methods. 
 * 
 * @api
 * @since 0.0.3
 */
interface PaymentMethodManagementInterface
{
    /**
     * Get active payment methods
     * 
     * @api
     * @return string[]
     */  
    public function getActiveMethods();

}