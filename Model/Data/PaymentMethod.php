<?php

declare(strict_types=1);

namespace Commerce365\MagentoApiExtensions\Model\Data;

use Commerce365\MagentoApiExtensions\Api\Data\PaymentMethodInterface;
use Magento\Framework\Model\AbstractModel;

class PaymentMethod extends AbstractModel implements PaymentMethodInterface
{
    public const LABEL  = 'label';
    public const VALUE = 'value';

    public function getLabel(): string
    {
        return (string) $this->getData(self::LABEL);
    }

    public function setLabel(string $label): PaymentMethod
    {
        return $this->setData(self::LABEL, $label);
    }

    public function getValue(): string
    {
        return (string) $this->getData(self::VALUE);
    }

    public function setValue(string $value): PaymentMethod
    {
        return $this->setData(self::VALUE, $value);
    }
}
