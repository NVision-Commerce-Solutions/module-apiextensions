<?php

declare(strict_types=1);

namespace Commerce365\MagentoApiExtensions\Service;

use Commerce365\MagentoApiExtensions\Api\Data\AttributeOptionSwatchDataInterface;
use Magento\Catalog\Model\Product\Media\Config;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\Read;
use Magento\Framework\Filesystem\Io\File;
use Magento\MediaStorage\Model\File\Uploader;
use Magento\Swatches\Helper\Media;

class SwatchUploader
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly Media $swatchHelper,
        private readonly File $file,
        private readonly Config $config
    ) {}

    public function upload(AttributeOptionSwatchDataInterface $swatchData): string
    {
        $fileContent = base64_decode($swatchData->getFile());

        /** @var Read $mediaDirectory */
        $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $dispersionPath = Uploader::getDispersionPath($swatchData->getFilename());
        $destinationPath = $mediaDirectory->getAbsolutePath($this->config->getBaseTmpMediaPath()) . $dispersionPath;
        $this->file->setAllowCreateFolders(true);
        $this->file->createDestinationDir($destinationPath);
        $fileName = $destinationPath . DIRECTORY_SEPARATOR . $swatchData->getFilename();
        file_put_contents($fileName, $fileContent);

        $newFile = $this->swatchHelper
            ->moveImageFromTmp($dispersionPath . DIRECTORY_SEPARATOR . $swatchData->getFilename());
        $this->swatchHelper->generateSwatchVariations($newFile);

        return $newFile;
    }
}
