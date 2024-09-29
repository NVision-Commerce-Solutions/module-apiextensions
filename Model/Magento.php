<?php

namespace Commerce365\MagentoApiExtensions\Model;

use Commerce365\MagentoApiExtensions\Api\MagentoManagementInterface;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Module\ModuleList;
use Magento\Framework\Module\PackageInfoFactory;

class Magento implements MagentoManagementInterface
{
    public function __construct(
        private readonly ProductMetadataInterface $productMetadata,
        private readonly PackageInfoFactory $packageInfoFactory,
        private readonly ModuleList $moduleList
    ) {}

    /**
     * Get current Magento version
     *
     * @return array
     * @api
     */
    public function getMagentoVersion(): array
    {
        $result = [[
            'module' => 'magento',
            'version' => $this->productMetadata->getVersion()
        ]];

        $packageInfo = $this->packageInfoFactory->create();
        foreach ($this->moduleList->getNames() as $moduleName) {
            if (str_contains($moduleName, 'Commerce365')) {
                $result[] = [
                    'module' => $moduleName,
                    'version' => $packageInfo->getVersion($moduleName),
                ];
            }
        }

        return $result;
    }
}
