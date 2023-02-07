<?php
namespace Commerce365\MagentoApiExtensions\Model;
use Commerce365\MagentoApiExtensions\Api\PaymentMethodManagementInterface;

class PaymentMethod implements PaymentMethodManagementInterface
{

    protected $scopeConfig;

    protected $paymentConfig;

    public function __construct(
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    \Magento\Payment\Model\Config $paymentConfig
    ) {
        $this->paymentConfig= $paymentConfig;
        $this->scopeConfig = $scopeConfig;
    }
    
    /**
     * Get active payment methods
     * 
     * @api
     * @return object
     */ 
    public function getActiveMethods(){

        $activeMethods = $this->paymentConfig->getActiveMethods();
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $methods = array();

        foreach($activeMethods as $paymentCode => $paymentModel)
        {
            $paymentTitle = $this->scopeConfig->getValue('payment/'.$paymentCode.'/title');
            $methods[$paymentCode] = array(
                'label' => $paymentTitle,
                'value' => $paymentCode
            );
        }
        
        return $methods;        
    }
}