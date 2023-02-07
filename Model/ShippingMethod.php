<?php
namespace Commerce365\MagentoApiExtensions\Model;
use Commerce365\MagentoApiExtensions\Api\ShippingMethodManagementInterface;

class ShippingMethod implements ShippingMethodManagementInterface
{

    protected $scopeConfig;

    protected $shipmentConfig;

    public function __construct(
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    \Magento\Shipping\Model\Config $shipmentConfig
    ) {
        $this->shipmentConfig = $shipmentConfig;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get active carriers / shipping methods
     * 
     * @api
     * @return object
     */  
    public function getActiveMethods(){

        $activeCarriers = $this->shipmentConfig->getActiveCarriers();
        $methods = array();

        foreach($activeCarriers as $carrierCode => $carrierModel)
        {
            $carrierTitle =$this->scopeConfig->getValue('carriers/'.$carrierCode.'/title');

            if( $carrierMethods = $carrierModel->getAllowedMethods() )
            {
                foreach ($carrierMethods as $methodCode => $method)
                {
                    $code= $carrierCode.'_'.$methodCode;
                    $methods[]=array(
                        'label'=>$carrierTitle,
                        'value'=>$code
                    );
                }
            }
        }

        return $methods;        
    }
}