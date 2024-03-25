<?php

namespace Commerce365\MagentoApiExtensions\Model;

use Commerce365\MagentoApiExtensions\Api\PaymentMethodManagementInterface;
use Magento\Payment\Api\PaymentMethodListInterface;
use Magento\Store\Model\StoreManagerInterface;

class PaymentMethod implements PaymentMethodManagementInterface
{
    private PaymentMethodListInterface $paymentMethodList;
    private StoreManagerInterface $storeManager;

    public function __construct(PaymentMethodListInterface $paymentMethodList, StoreManagerInterface $storeManager)
    {
        $this->paymentMethodList = $paymentMethodList;
        $this->storeManager = $storeManager;
    }

    /**
     * Get active payment methods
     *
     * @return array
     * @api
     */
    public function getActiveMethods(): array
    {
        $store = $this->storeManager->getStore();
        $activeMethods = $this->paymentMethodList->getActiveList($store->getId());
        $methods = [];

        foreach($activeMethods as $paymentMethod) {
            $methodCode = $paymentMethod->getCode();
            $methods[$methodCode] = array(
                'label' => $paymentMethod->getTitle(),
                'value' => $methodCode
            );
        }

        return $methods;
    }
}
