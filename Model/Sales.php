<?php
namespace Commerce365\MagentoApiExtensions\Model;

use Commerce365\MagentoApiExtensions\Api\SalesManagementInterface;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\StatusFactory;
use Magento\Sales\Model\ResourceModel\Order\StatusFactory as StatusResourceFactory;

class Sales implements SalesManagementInterface
{
    protected StatusFactory $statusFactory;
    protected StatusResourceFactory $statusResourceFactory;

    public function __construct(StatusFactory $statusFactory, StatusResourceFactory $statusResourceFactory)
    {
        $this->statusFactory = $statusFactory;
        $this->statusResourceFactory = $statusResourceFactory;
    }

    /**
    * Post a new order status to make sure Magento knows the status NAV/BC is using
    *
    * @api
    * @param string $statusCode
    * @param string $statusLabel
    * @return boolean
    */
    public function createOrderStatus($statusCode, $statusLabel)
    {
        $statusResource = $this->statusResourceFactory->create();
        $status = $this->statusFactory->create();
        $status->setData([
            'status' => $statusCode,
            'label' => $statusLabel,
        ]);

        try {
            $statusResource->save($status);
        } catch (AlreadyExistsException $exception) {
            return;
        }

        $status->assignState(Order::STATE_PROCESSING, false, true);

        return true;
    }
}
