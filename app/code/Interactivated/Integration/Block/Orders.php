<?php

namespace Interactivated\Integration\Block;

use Magento\Framework\View\Element\Template;

class Orders extends \Magento\Framework\View\Element\Template
{

    protected $_orderCollectionFactory;

    public function __construct(
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context
    )
    {
        parent::__construct($context);
        $this->orderCollectionFactory = $orderCollectionFactory;

    }

    public function sayHello()
    {

        return ('hello world');
    }


    public function getGuestOrderCollection()
    {
        $orderCollecion = $this->orderCollectionFactory
            ->create()
            ->addFieldToSelect('*');

        $orderCollecion->addAttributeToFilter('customer_is_guest', ['eq'=>1]);

        print_r($orderCollecion->getData());
        exit;
        return $orderCollecion;
        echo "<br>";
    }
}