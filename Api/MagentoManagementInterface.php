<?php

namespace Commerce365\MagentoApiExtensions\Api;

use Commerce365\MagentoApiExtensions\Api\Data\ModuleVersionInterface;

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
    public function getMagentoVersion(): string;


    /**
     * Get installed module versions
     *
     * @api
     * @return ModuleVersionInterface[]
     */
    public function getModuleVersions(): array;
}


