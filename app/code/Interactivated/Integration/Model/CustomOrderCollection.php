<?php

namespace Interactivated\Integration\Model;


    class CustomOrderCollection
    {

        private $connectionFactory;
        private $connection;

        private $_objectManager;
        private $resourceConnection;
        private $logger;
        public function __construct(
            \Magento\Framework\App\ResourceConnection\ConnectionFactory $connectionFactory,
            \Psr\Log\LoggerInterface $logger,
            \Magento\Framework\ObjectManagerInterface $objectManager,
            \Magento\Framework\App\ResourceConnection $resourceConnection
        )
        {

            $this->connectionFactory = $connectionFactory;
            $this->logger = $logger;
            $this->resourceConnection = $resourceConnection;
            $this->_objectManager = $objectManager;

        }


        public function update($orders){

            foreach ($orders as $order)  {

                if ($this->checkData($order) == true){
//                    if ($this->importNewOrder($order) == true) {
                        $this->orderInformation($order);
                        $this->importNewOrder($order);
//                    }



                }
//                $some = $this->checkData($order);
//                var_dump($some);
//                die('check first step');
//                if ($this->checkData($order)==true){
////                    $checkdata = $this->checkData($order);
////                    var_dump($checkdata);
//                    die('hello woodi');
//                    $this->importNewOrder($orders);
//                }

            }

        }
        public function checkData($order){

//var_dump($order);
//            die('popup woodi');
//           $orseg =  $order['increment_id'];
//           var_dump($order);
//           die('defect in front');
//            $order=7;

            $check = $order['increment_id'];

            $connection = $this->resourceConnection->getConnection('custom');



            $table = $connection->getTableName('orders');
//            die('свобода слова');

            $getIncrement = $connection->select()->from($table)->where('increment_id=?',$check);
            $asdasd=$connection->fetchRow($getIncrement);

//            var_dump($asdasd);
//            die('як умру то поховайте');
//            ("select `increment_id` from `orders` where `increment_id`='$check';");
//            var_dump($getIncrement);
//
//            if($getIncrement == true){
//                die('wqeqwe');
//            }else {
//                die('что произошло');
//            }
//
//            die('I wont live');

           if( $asdasd == false){
          return true;
           }else{
               $this->logger->info('Already in DB '.$check);
               return false;
           }

//            var_dump(get_class_methods($check));


        }

        public function importNewOrder($order){


//            $orderID = $order['entity_id'];
//
////            var_dump($orderID);
////            die('die die die');
//
//            $getCustomerInformation = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderID);
//            var_dump(get_class_methods($getCustomerInformation));
//            die('local host');

//            var_dump($orders);
//            die('its variable == 6, please, die()');

            $increment_id = $order['increment_id'];



            $customer_id = $order['customer_id'];
            $total_amount = $order['base_total_due'];
//            var_dump($total_amount);
//            die('start to import files');
            $status = $order['status'];
            $updated_at = $order['updated_at'];

            $connection = $this->resourceConnection->getConnection('custom');




            $orders = $connection->getTableName('orders');



            $argumentsOrders = [
                'id'=> NULL,
                'increment_id' => $increment_id,
                'customer_id' => $customer_id,
                'total_amount' =>$total_amount,
                'status' => $status,
                'order_date' => $updated_at
            ];
//            $argumentsOrders= [
//                'id' => NULL,
//                'customer_id' => $customer_id,
//                'increment_id' => $increment_id
//            ];




            $query = $connection->insert($orders, $argumentsOrders);
   if($query == true){
       return true;
   }else {
       return true;
   }

//return $query;



//                die('stop, please, stop');
//           $status = $this->connection->query("UPDATE `orders` SET `increment_id` = '$increment_id', `customer_id` = '$customer_id', `total_amount` = '$total_amount',`status` = '$status',`order_date` = '$updated_at'  WHERE `orders`.`id` = 1;")->execute();
//            INSERT INTO `orders` (`id`, `increment_id`, `customer_id`, `total_amount`, `status`, `order_date`) VALUES (NULL, NULL, NULL, NULL, NULL, NULL);

        }

        public function orderInformation($order){



            $orderID =$order['entity_id']->;
//            var_dump($orderID);
//            die('some texe for detect connection');


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

            $connection = $this->resourceConnection->getConnection('custom');


            $ordersCustomers = $connection->getTableName('orders_customers');

            $argumentsOrdersCustomer = [
                'id' => NULL,
                'customer_id' => $customer_id,
                'increment_id' => $increment,
                'name' => $name,
                'dni' => $dni,
                'telf' => $telf,
                'address' => $adress
            ];


            $query = $connection->insert($ordersCustomers, $argumentsOrdersCustomer)->execute();


            return $query;


        }




    }
