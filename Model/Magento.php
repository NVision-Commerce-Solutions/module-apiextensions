<?php

namespace Commerce365\MagentoApiExtensions\Model;

use Commerce365\MagentoApiExtensions\Api\MagentoManagementInterface;
use Commerce365\MagentoApiExtensions\Model\Data\ModuleVersionFactory;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Module\ModuleList;
use Magento\Framework\Module\PackageInfoFactory;

class Magento implements MagentoManagementInterface
{
    public function __construct(
        private readonly ProductMetadataInterface $productMetadata,
        private readonly PackageInfoFactory $packageInfoFactory,
        private readonly ModuleList $moduleList,
        private readonly ModuleVersionFactory $moduleVersionFactory
    ) {}

    /**
     * Get current Magento version
     *
     * @return string
     * @api
     */
    public function getMagentoVersion(): string
    {
        return $this->productMetadata->getVersion();
    }

    /**
     * Get installed module versions
     *
     * @return array
     * @api
     */
    public function getModuleVersions(): array
    {
        $magentoVersion = $this->moduleVersionFactory->create();
        $magentoVersion->setModule('magento');
        $magentoVersion->setVersion($this->productMetadata->getVersion());
        $result = [$magentoVersion];

        $packageInfo = $this->packageInfoFactory->create();
        foreach ($this->moduleList->getNames() as $moduleName) {
            if (str_contains($moduleName, 'Commerce365')) {
                $moduleVersion = $this->moduleVersionFactory->create();
                $moduleVersion->setModule($moduleName);
                $moduleVersion->setVersion($packageInfo->getVersion($moduleName));
                $result[] = $moduleVersion;
            }
        }

        return $result;
    }
}
