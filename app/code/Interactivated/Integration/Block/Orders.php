<?php

namespace Interactivated\Integration\Block;

use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\View\Asset\NotationResolver\Variable;
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
    public $customOrderCollectionFactory;


    public function __construct(
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Model\OrderRepository $orderRepository,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        ResourceConnection $resourceConnection,
        \Interactivated\Integration\Model\CustomOrderCollectionFactory $customOrderCollectionFactory
    )
    {
        parent::__construct($context);
        $this->customOrderCollectionFactory = $customOrderCollectionFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->orderRepository = $orderRepository;
        $this->resourceConnection = $resourceConnection;
        $this->_objectManager = $objectManager;

    }

    public function sayHello()
    {

        return ('hello world');
    }

    public  function getCustomOrderCollectionFactory(){
        return $this->customOrderCollectionFactory;
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
            $price_unit= $item->getBaseOriginalPrice();
            $base_row_total_incl_tax= $item['base_row_total_incl_tax'];
            $qty= $item['product_options']['info_buyRequest']['qty'];


        }


        $getCustomerInformation = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID);


        $increment = $getCustomerInformation->getIncrementId();//incriment ID

        $connection = $this->resourceConnection->getConnection('custom');


        $setToDbOrderItem =  $connection->query( "UPDATE `orders_items` SET `increment_id`='$increment',`product_sku`='$sku',`size`='$size',`color`='$color',`line`='$line',`qty`='$qty',`price_unit`='$price_unit',`discount_1`='$discount_amount',`total_amount_line`='$base_row_total_incl_tax' WHERE `orders_items`.`id` = 1;")->execute();


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


            $setToDb =  $connection->query( "UPDATE `orders_customers` SET `customer_id`='$customer_id',`increment_id`='$increment',`name`='$name',`dni`='$dni',`telf`='$telf',`address`='$adress' WHERE `orders_customers`.`id` = '2';")->execute();

        return $setToDb;



        }

    public function getGuestOrderCollection()
    {

        $orderCollecion = $this->orderCollectionFactory
            ->create()
            ->addFieldToSelect('*');

        $orderCollecion->addAttributeToFilter('store_id', ['eq'=>1]);


        foreach ($orderCollecion as $order){
            //  var_dump(get_class_methods($order));
//            var_dump($order->getId());
//            var_dump($order->getShippingAddress()->getEmail());
//            var_dump($order->getId());
//            var_dump(get_class_methods($order));


        }
//        var_dump(get_class_methods($order->getAllItems()));//get all order collection

//foreach ($order->getAllItems() as $item){
//    var_dump( $item['sku']);
//    $qty= $item['product_optfquest']['qty'];
//    $price_unit= $item->getBaseOriginalPrice();
//    var_dump($price_unit);
////die();
//}


//        foreach ($order->getAllItems() as $item) {
//            $sku= $item['sku'];
//            $size= $item['size'];
//
//            $color= $item['color'];
//            $line= $item['line'];
//            $discount_amount= $item['discount_amount'];
//            $price_unit= $item->getBaseOriginalPrice();
//            $base_row_total_incl_tax= $item['base_row_total_incl_tax']; //            link for old method
//            $qty= $item['product_options']['info_buyRequest']['qty'];
//
//
//        }



//var_dump($order->getAllItems()->getQtyToShip());


//        var_dump(get_class_methods($order->getShippingAddress())); //get collection for shipping adress
//
//        var_dump($order->getShippingAddress()->getPostcode());//  how get data for order_customers



//        var_dump($order->getIncrementId());                   //orders table
//        var_dump($order->getBaseSubtotal());//total amount
//        var_dump($order->getCustomerId());
//        var_dump($order->getUpdatedAt());//order date






//        var_dump($order->getCustomerId());//                  orders_customers
//        var_dump($order->getIncrementId());

//        var_dump($order->getCustomerName());// Dolia Dolia
////        var_dump($order->getShippingAddress()->getEmail());
////        var_dump($order->getShippingAddress()->getTelephone());

//        var_dump($order->getShippingAddress()->getPostcode());//  how get data for order_customers





        //        var_dump($order->getIncrementId());           //orders_items
        foreach ($order->getAllItems() as $item){
//            var_dump( $item['sku']);                             sku in orders_items
            $some_value = $item->getProductOptions();
//            var_dump($some_value['info_buyRequest']['qty']);        // qty in order
//            var_dump($item->getProductOptions());
//            var_dump(($item->getQtyToShip()));
//            var_dump($item->getQtyToInvoice());
//            $qty= $item['product_optfquest']['qty'];
//            $price_unit= $item->getBaseOriginalPrice();  //price unit in orders_items
//            var_dump($price_unit);
//            var_dump($item->getBaseDiscountAmount());//discount_1 in orders_items

//            var_dump(get_class_methods($item));
////            DIE();
//            die();
//die();
        }




//        echo "<pre>";
//        var_dump($order->getState());     //for status
//        echo "<pre>";
//        var_dump($order->getStatus());



//
//        var_dump($order[$output]);
//        die('text for detect my die()');





//        $output =count($orderCollecion->getData());
//
//        return $output;

    }

    public function connectionToNewTable(){

        $orderCollecion = $this->orderCollectionFactory
            ->create()
            ->addFieldToSelect('*');

        $orderCollecion->addAttributeToFilter('store_id', ['eq'=>1]);

        $data = $orderCollecion->getData();


//        $increment_id = $data[$asd]['increment_id'];
//
//
//        $customer_id = $data[$asd]['customer_id'];
//        $total_amount = $data[$asd]['base_total_due'];
//        $status = $data[$asd]['status'];
//        $updated_at = $data[$asd]['updated_at'];


       // return $data;
        $status = $this->updateCustomOrderCollection($data);
        return $status;


 //       $some = $connection->query("UPDATE `orders` SET `increment_id` = '$increment_id', `customer_id` = '$customer_id', `total_amount` = '$total_amount',`status` = '$status',`order_date` = '$updated_at'  WHERE `orders`.`id` = 1;")->execute();

       // return $data;

    }
    public function updateCustomOrderCollection($data){



        $customOrderCollection = $this->getCustomOrderCollectionFactory()->create();

        $status = $customOrderCollection->update($data);

        return $status;

    }
}