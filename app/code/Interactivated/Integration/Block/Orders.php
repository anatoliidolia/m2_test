<?php

namespace Interactivated\Integration\Block;

use Magento\Catalog\Model\Product\Attribute\Source\Status;
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


        $orderID = $this->getGuestOrderCollection();

//        var_dump($getter);
//        die();
//
//      $orderID = count($getter);


        $getCustomerInformation = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID);
//        var_dump($getCustomerInformation);
//        die('hello world');


        $getShippingInformation = $getCustomerInformation->getShippingAddress();
//        var_dump($getShippingInformation->getCustomerId());
//            ->getShippingAddress();

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getStoreName();

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getCustomerName();//customer name

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getStreet();//array(2) { [0]=> string(10) "karazina 1" [1]=> string(7) "Florida" }

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getLastName();//lastname

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getFirstName();//firstname

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getCity();//city

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getRegion();//region

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getCountryId();//US country id

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getPostCode();//postCode

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getTelephone();//telephome

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getEmail();//email

        $customer_id = $getCustomerInformation->getCustomerId();//customer_ID

//        $increment = $this->getGuestOrderCollection()['increment_id'];//incriment ID

        $increment = $getCustomerInformation->getIncrementId();//incriment ID


        $lastname = $getShippingInformation->getLastName();

        $firstname = $getShippingInformation->getFirstName();

        $name = $firstname." ".$lastname;


        $telf =  $getShippingInformation->getTelephone();//telephome

        $city =  $getShippingInformation->getCity();//city

        $region =  $getShippingInformation->getRegion();//region

        $countryid =  $getShippingInformation->getCountryId();//US country id

        $postCode =  $getShippingInformation->getPostCode();//postCode

        $email =  $getShippingInformation->getEmail();//email

        $dni = 0;


        $adress = $city.", ".$region.", ".$countryid.", ".$postCode.", ".$telf.", ".$email;

        $string = $customer_id.", ".$increment.", ".$name.", ".$telf.", ". $adress;

        echo $string."<br>";




        $connection = $this->resourceConnection->getConnection('custom');


            $setToDb =  $connection->query( "UPDATE `orders_customers` SET `customer_id`='$customer_id',`increment_id`='$increment',`name`='$name',`dni`='$dni',`telf`='$telf',`address`='$adress' WHERE `orders_customers`.`id` = 2;")->fetch();
//


//
return $setToDb;

//            die('use concatenation, firstname and lastname');


//        var_dump($customer_id);
//        die('get customer ID');


//        var_dump($increment);
//        die('increment_die');


//        var_dump($orderObj);
//            die('some text');


            //            ->getBaseShippingInvoiced();
//        ->getShippingAddress();
//        ->getEmailCustomerNote();

//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getTelephone();
//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getTelephone();
//        $orderObj =  $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID)->getShippingAddress()->getTelephone();


//        var_dump($orderObj);
//        die('_______________');

//            var_dump(get_class_methods($orderObj));
//            die('qweqwewqewqeqweqwe');
//
//            $shippingAddressObj = $orderObj->getShippingAddress();
//
//            $shippingAddressArray = $shippingAddressObj->getData();
//
//            $firstname = $shippingAddressArray['firstname'];
//
//            var_dump($firstname);
//            die('21321321');

        }

    public function getGuestOrderCollection()
    {
        $orderCollecion = $this->orderCollectionFactory
            ->create()
            ->addFieldToSelect('*');

        $orderCollecion->addAttributeToFilter('store_id', ['eq'=>1]);

        $output =count($orderCollecion->getData());

        return $output;

//        var_dump($data);
//        die('fdsrgfdsg');
//
//        $lastname = end($data); // return last element of array
//
//        var_dump($lastname);
//
//
//        return $lastname;


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

        $orderCollecion = $this->orderCollectionFactory
            ->create()
            ->addFieldToSelect('*');

        $orderCollecion->addAttributeToFilter('store_id', ['eq'=>1]);



        $data = $orderCollecion->getData();
        $asd = $this->getGuestOrderCollection()-1;


//var_dump($data[$asd]['increment_id']);
//die('some');





        $increment_id = $data[$asd]['increment_id'];




        $customer_id = $data[$asd]['customer_id'];
        $total_amount = $data[$asd]['base_total_due'];
        $status = $data[$asd]['status'];
//        $status = 1;
        $updated_at = $data[$asd]['updated_at'];




//        var_dump($variable);

//        echo $total_amount;

//        $some = $connection->query("UPDATE `table_for_data` SET `lastname` = '$variable' WHERE `table_for_data`.`id` = 1;");




        $some = $connection->query("UPDATE `orders` SET `increment_id` = '$increment_id', `customer_id` = '$customer_id', `total_amount` = '$total_amount',`status` = '$status',`order_date` = '$updated_at'  WHERE `orders`.`id` = 1;")->execute();

        return $some;

    }
}