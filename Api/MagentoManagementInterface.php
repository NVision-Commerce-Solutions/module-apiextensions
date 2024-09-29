<?php
namespace Commerce365\MagentoApiExtensions\Api;

/**
 * Magento Management Interface.
 *
 * Additional admin method to obtain the current Magento version.
 *
 * @api
 * @since 0.0.4
 */
interface MagentoManagementInterface
{
    /**
     * Get current Magento version
     *
     * @api
     * @return string
     */
    public function getMagentoVersion(): array;
}


