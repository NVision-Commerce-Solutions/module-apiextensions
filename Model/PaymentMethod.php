<?php

namespace Commerce365\MagentoApiExtensions\Model;

use Commerce365\MagentoApiExtensions\Api\PaymentMethodManagementInterface;
use Commerce365\MagentoApiExtensions\Model\Data\PaymentMethodFactory;
use Magento\Payment\Api\PaymentMethodListInterface;
use Magento\Store\Model\StoreManagerInterface;

class PaymentMethod implements PaymentMethodManagementInterface
{
    public function __construct(
        private readonly PaymentMethodListInterface $paymentMethodList,
        private readonly StoreManagerInterface $storeManager,
        private readonly PaymentMethodFactory $paymentMethodFactory,
    ) {}

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
            $paymentMethodModel = $this->paymentMethodFactory->create();
            $paymentMethodModel->setLabel($paymentMethod->getTitle());
            $paymentMethodModel->setValue($methodCode);
            $methods[$methodCode] = $paymentMethodModel;
        }

        return $methods;
    }
}
