<?php

namespace Commerce365\MagentoApiExtensions\Model;

use Commerce365\MagentoApiExtensions\Api\ShippingMethodManagementInterface;
use Magento\Shipping\Model\Config;
use Magento\Store\Model\StoreManagerInterface;

class ShippingMethod implements ShippingMethodManagementInterface
{
    private Config $shipmentConfig;
    private StoreManagerInterface $storeManager;

    public function __construct(StoreManagerInterface $storeManager, Config $shipmentConfig)
    {
        $this->shipmentConfig = $shipmentConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Get active carriers / shipping methods
     *
     * @api
     * @return array
     */
    public function getActiveMethods(): array
    {
        $methods = [];
        $store = $this->storeManager->getStore();
        $activeCarriers = $this->shipmentConfig->getActiveCarriers($store);

        foreach($activeCarriers as $carrierCode => $carrierModel) {
            if ($carrierMethods = $carrierModel->getAllowedMethods()) {
                foreach ($carrierMethods as $methodCode => $method) {
                    $code = $carrierCode . '_' . $methodCode;
                    $methods[] = [
                        'label' => $carrierModel->getConfigData('title'),
                        'value' => $code
                    ];
                }
            }
        }

        return $methods;
    }
}
