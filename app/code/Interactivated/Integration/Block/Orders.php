<?php

namespace Interactivated\Integration\Block;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\ResourceConnection;

class Orders extends \Magento\Framework\View\Element\Template
{

    protected $_orderCollectionFactory;
    private $resourceConnection;

    /**
     * @var AdapterInterface
     */
    private $connection;

    private $_objectManager;


    public function __construct(
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        ResourceConnection $resourceConnection
    )
    {
        parent::__construct($context);
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->resourceConnection = $resourceConnection;
        $this->_objectManager = $objectManager;

    }

    public function sayHello()
    {

        return ('hello world');
    }

    public function orderInformation(){


        $orderID = 2;

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getStoreName();

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getCustomerName();//customer name

        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress();
            //            ->getBaseShippingInvoiced();
//        ->getShippingAddress();
//        ->getEmailCustomerNote();

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getTelephone();
//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getTelephone();
//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getTelephone();




//        var_dump($orderObj);
//        die('_______________');

        var_dump(get_class_methods($orderObj));
        die('qweqwewqewqeqweqwe');

        $shippingAddressObj = $orderObj->getShippingAddress();

        $shippingAddressArray = $shippingAddressObj->getData();

        $firstname = $shippingAddressArray['firstname'];

        var_dump($firstname);die('21321321');
    }


    public function getGuestOrderCollection()
    {
        $orderCollecion = $this->orderCollectionFactory
            ->create()
            ->addFieldToSelect('*');

        $orderCollecion->addAttributeToFilter('customer_is_guest', ['eq'=>1]);

        $data = $orderCollecion->getData();

        $lastname = end($data); // return last element of array

//        var_dump($lastname);
        echo "__________________";

        return $lastname;


//        echo count($data[])

//        $connection = $this->resourceConnection->getConnection('custom');

//        var_dump($data[1]);
//        die();


//        $some = $connection->query("UPDATE `table_for_data` SET `lastname` = `123123` WHERE `table_for_data`.`id` = 1;");
//
//        return $some;

    }

    public function connectionToNewTable(){

        $connection = $this->resourceConnection->getConnection('custom');


        $increment_id = $this->getGuestOrderCollection()['increment_id'];
        $customer_id = $this->getGuestOrderCollection()['customer_id'];
        $total_amount = $this->getGuestOrderCollection()['base_total_due'];
        $status = $this->getGuestOrderCollection()['status'];
//        $status = 1;
        $updated_at = $this->getGuestOrderCollection()['updated_at'];

         $variable =  '123';

         echo "<br>";
//        var_dump($variable);

//        echo $total_amount;

//        $some = $connection->query("UPDATE `table_for_data` SET `lastname` = '$variable' WHERE `table_for_data`.`id` = 1;");




        $some = $connection->query("UPDATE `orders` SET `increment_id` = '$increment_id', `customer_id` = '$customer_id', `total_amount` = '$total_amount',`status` = '$status',`order_date` = '$updated_at'  WHERE `orders`.`id` = 1;")->execute();

        return $some;





    }
}