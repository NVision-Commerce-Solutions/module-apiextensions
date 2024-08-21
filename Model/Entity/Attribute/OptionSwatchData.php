<?php

declare(strict_types=1);

namespace Commerce365\MagentoApiExtensions\Model\Entity\Attribute;

use Commerce365\MagentoApiExtensions\Api\Data\AttributeOptionSwatchDataInterface;
use Magento\Framework\Model\AbstractModel;

class OptionSwatchData extends AbstractModel implements AttributeOptionSwatchDataInterface
{
    /**
     * @inheritDoc
     */
    public function getColor()
    {
        return $this->getData(self::COLOR);
    }

    /**
     * @inheritDoc
     */
    public function setColor($color)
    {
        return $this->setData(self::COLOR, $color);
    }

    /**
     * @inheritDoc
     */
    public function getFile()
    {
        return $this->getData(self::FILE);
    }

    /**
     * @inheritDoc
     */
    public function setFile($file)
    {
        return $this->setData(self::FILE, $file);
    }

    /**
     * @inheritDoc
     */
    public function getFilename()
    {
        return $this->getData(self::FILENAME);
    }

    /**
     * @inheritDoc
     */
    public function setFilename($file)
    {
        return $this->setData(self::FILENAME, $file);
    }
}
