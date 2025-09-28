<?php

namespace Commerce365\MagentoApiExtensions\Model;

use Commerce365\MagentoApiExtensions\Api\ShippingMethodManagementInterface;
use Commerce365\MagentoApiExtensions\Model\Data\ShippingMethodFactory;
use Magento\Shipping\Model\Config;
use Magento\Store\Model\StoreManagerInterface;

class ShippingMethod implements ShippingMethodManagementInterface
{
    public function __construct(
        private readonly StoreManagerInterface $storeManager,
        private readonly Config $shipmentConfig,
        private readonly ShippingMethodFactory $shippingMethodFactory
    ) {}

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
                    $shippingMethodModel = $this->shippingMethodFactory->create();
                    $shippingMethodModel->setLabel($carrierModel->getConfigData('title'));
                    $shippingMethodModel->setValue($code);
                    $methods[] = $shippingMethodModel;
                }
            }
        }

        return $methods;
    }
}
