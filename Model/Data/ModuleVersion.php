<?php

declare(strict_types=1);

namespace Commerce365\MagentoApiExtensions\Model\Data;

use Commerce365\MagentoApiExtensions\Api\Data\ModuleVersionInterface;
use Magento\Framework\Model\AbstractModel;

class ModuleVersion extends AbstractModel implements ModuleVersionInterface
{
    public const MODULE  = 'module';
    public const VERSION = 'version';

    public function getModule(): string
    {
        return (string) $this->getData(self::MODULE);
    }

    public function setModule(string $module): ModuleVersion
    {
        return $this->setData(self::MODULE, $module);
    }

    public function getVersion(): string
    {
        return (string) $this->getData(self::VERSION);
    }

    public function setVersion(string $version): ModuleVersion
    {
        return $this->setData(self::VERSION, $version);
    }
}
