<?php
namespace Commerce365\MagentoApiExtensions\Model;
use Commerce365\MagentoApiExtensions\Api\MagentoManagementInterface;
use Magento\Framework\App\ProductMetadataInterface;

class Magento implements MagentoManagementInterface
{

    protected $productMetadata;

    public function __construct(ProductMetadataInterface $productMetadata) {
        $this->productMetadata = $productMetadata;
    }
    
    /**
     * Get current Magento version
     *
     * @api
     * @return string
     */    
    public function getMagentoVersion(){
        return $this->productMetadata->getVersion();       
    }
}