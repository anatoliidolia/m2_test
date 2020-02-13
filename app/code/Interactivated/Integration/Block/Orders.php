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
    private $orderRepository;

    /**
     * @var AdapterInterface
     */
    private $connection;

    private $_objectManager;


    public function __construct(
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Model\OrderRepository $orderRepository,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        ResourceConnection $resourceConnection
    )
    {
        parent::__construct($context);
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->orderRepository = $orderRepository;
        $this->resourceConnection = $resourceConnection;
        $this->_objectManager = $objectManager;

    }

    public function sayHello()
    {

        return ('hello world');
    }


    public  function ordersItem(){

        $orderID = $this->getGuestOrderCollection();

        $order = $this->orderRepository->get($orderID);


        foreach ($order->getAllItems() as $item) {
            $sku= $item['sku'];
            $size= $item['size'];
            $color= $item['color'];
            $line= $item['line'];
            $discount_amount= $item['discount_amount'];
            $price_unit= $item['price'];
            $base_row_total_incl_tax= $item['base_row_total_incl_tax'];
            $qty= $item['product_options']['info_buyRequest']['qty'];

        }

        $getCustomerInformation = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID);


        $increment = $getCustomerInformation->getIncrementId();//incriment ID


        $connection = $this->resourceConnection->getConnection('custom');


        $setToDbOrderItem =  $connection->query( "UPDATE `orders_items` SET `increment_id`='$increment',`product_sku`='$sku',`size`='$size',`color`='$color',`line`='$line',`qty`='$qty',`price_unit`='$price_unit',`discount_1`='$discount_amount',`total_amount_line`='$base_row_total_incl_tax' WHERE `orders_items`.`id` = 1;")->fetch();

        return $setToDbOrderItem;

    }

    public function orderInformation(){


        $orderID = $this->getGuestOrderCollection();


        $getCustomerInformation = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID);



        $getShippingInformation = $getCustomerInformation->getShippingAddress();


        $customer_id = $getCustomerInformation->getCustomerId();//customer_ID


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

        return $setToDb;



        }

    public function getGuestOrderCollection()
    {
        $orderCollecion = $this->orderCollectionFactory
            ->create()
            ->addFieldToSelect('*');

        $orderCollecion->addAttributeToFilter('store_id', ['eq'=>1]);

        $output =count($orderCollecion->getData());

        return $output;



    }

    public function connectionToNewTable(){

        $connection = $this->resourceConnection->getConnection('custom');

        $orderCollecion = $this->orderCollectionFactory
            ->create()
            ->addFieldToSelect('*');

        $orderCollecion->addAttributeToFilter('store_id', ['eq'=>1]);

        $data = $orderCollecion->getData();
        $asd = $this->getGuestOrderCollection()-1;



        $increment_id = $data[$asd]['increment_id'];


        $customer_id = $data[$asd]['customer_id'];
        $total_amount = $data[$asd]['base_total_due'];
        $status = $data[$asd]['status'];
        $updated_at = $data[$asd]['updated_at'];




        $some = $connection->query("UPDATE `orders` SET `increment_id` = '$increment_id', `customer_id` = '$customer_id', `total_amount` = '$total_amount',`status` = '$status',`order_date` = '$updated_at'  WHERE `orders`.`id` = 1;")->execute();

        return $some;

    }
}