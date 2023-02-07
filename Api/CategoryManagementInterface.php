<?php
namespace Commerce365\MagentoApiExtensions\Api;
 
/**
 * Category Management Interface.
 * 
 * Additional admin methods to manage your Magento categories.
 * 
 * @api
 * @since 0.0.1
 */
interface CategoryManagementInterface
{
    /**
     * Put category position (within tree)
     *
     * @api
     * @param int $categoryId 
     * @param int $new
     * @return boolean
     */
    public function updatePosition($categoryId, $new);

}