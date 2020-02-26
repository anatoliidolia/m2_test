<?php

namespace Interactivated\Integration\Model;


    class CustomOrderCollection
    {

        private $connectionFactory;
        private $orderRepository;
        private $_objectManager;
        private $resourceConnection;
        private $logger;

        public function __construct(
            \Magento\Framework\App\ResourceConnection\ConnectionFactory $connectionFactory,
            \Psr\Log\LoggerInterface $logger,
            \Magento\Sales\Model\OrderRepository $orderRepository,
            \Magento\Framework\ObjectManagerInterface $objectManager,
            \Magento\Framework\App\ResourceConnection $resourceConnection
        )
        {

            $this->connectionFactory = $connectionFactory;
            $this->logger = $logger;
            $this->orderRepository = $orderRepository;
            $this->resourceConnection = $resourceConnection;
            $this->_objectManager = $objectManager;

        }

        public function update($orders)
        {
//                                       $order = $orders[6];
            foreach ($orders as $order) {
                if ($this->checkData($order) == true) {
                    if ($this->importNewOrder($order) == true) {
                        if ($this->orderInformation($order) == true) {
                            $this->importToOrdersItems($order);
//                        $this->productsTyc($order);

                        }
//
                    }
//                }
//            }
                }
            }
        }


        public function returnType($order){

            $orderId = $order['entity_id'];


            $orderqw = $this->orderRepository->get($orderId);
//            var_dump($orderqw->getProductType());
//            var_dump($order);

            foreach ($orderqw->getAllItems() as $item) {
                $type = $item->getProductType();
//                if($type == 'simple'){
//                    var_dump($type);
//                }else{
//                    var_dump($type);
//                    die('qweqwewqeqweqw');
//                }
            }
            return $type;
        }

        public function checkData($order)
        {


            $check = $order['increment_id'];


            $connection = $this->resourceConnection->getConnection('custom');

            $table = $connection->getTableName('orders');

            $getIncrement = $connection->select()->from($table)->where('increment_id=?', $check);
            $asdasd = $connection->fetchRow($getIncrement);

            if ($asdasd == false) {
                return true;
            } else {
                $this->logger->info('Already in DB ' . $check);
                return false;
            }


        }

        public function importNewOrder($order)
        {
            $increment_id = $order['increment_id'];


            $customer_id = $order['customer_id'];
            $total_amount = $order['base_total_due'];
            $status = $order['status'];
            $updated_at = $order['updated_at'];

            $connection = $this->resourceConnection->getConnection('custom');

            $orders = $connection->getTableName('orders');

            $argumentsOrders = [
                'id' => NULL,
                'increment_id' => $increment_id,
                'customer_id' => $customer_id,
                'total_amount' => $total_amount,
                'status' => $status,
                'order_date' => $updated_at
            ];


            $query = $connection->insert($orders, $argumentsOrders);

            if ($query == true) {
                return true;
            } else {
                return true;
            }
        }

        public function orderInformation($order)
        {


            $orderID = $order['entity_id'];

            $getCustomerInformation = $this->_objectManager->get('Magento\Sales\Model\Order')->load($orderID);
          $getShippingInformation =    $getCustomerInformation->getBillingAddress();

//         for new method
//                 var_dump(get_class_methods($getShippingInformation));
//                 die();



//
//            var_dump(get_class_methods($getCustomerInformation));
//            die('fdsg');
//                ->getShippingAdress();

//$dasss= $getCustomerInformation->getCustomerEmail();
////       var_dump(get_class_methods($getCustomerInformation));
//       var_dump($dasss);
//       die('die in orderInformation');


            $increment = $order['increment_id'];

            $customer_id = $order['customer_id'];

            $name = $getCustomerInformation->getCustomerName();



//            var_dump(get_class_methods($getCustomerInformation));
//            die('asdasd');



//            var_dump(get_class_methods($getCustomerInformation));
//            var_dump($getCustomerInformation->());
//die('asdasd');



            $telf =  $getShippingInformation->getTelephone();//telephome

            $city =  $getShippingInformation->getCity();//city

            $region =  $getShippingInformation->getRegion();//region

            $countryid = $getShippingInformation->getCountryId();//US country id

            $postCode = $getShippingInformation->getPostCode();//postCode

            $email = $getShippingInformation->getCustomerEmail();//email



            $dni = 0;

            $adress = $city . ", " . $region . ", " . $countryid . ", " . $postCode . ", " . $telf . ", " . $email;

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

//            var_dump($argumentsOrdersCustomer);
//
//            die('die dsddddddd');


            $query = $connection->insert($ordersCustomers, $argumentsOrdersCustomer);

            if ($query == true) {
                return true;
            } else {
                return true;
            }
        }

        public function productsTyc($order)
        {
//            $orderId = $order['entity_id'];
//            $orderqw = $this->orderRepository->get($orderId);
//
//            var_dump(get_class_methods($orderqw->getData()));
//            die('get cm');

//            foreach ($orderqw->getAllItems() as $item) {
//
//
////var_dump($item->getProductType());
////die();
//
////                var_dump(get_class_methods($item->getProduct()));
////                var_dump($item->getProduct()->getSku());
////                die('fdg');
//
////if($item->getProductType() === "virtual"){
////    $skuSimple = $item->getProduct()->getSku()."1111111111111";
////}else{
//
//    $skuSimple = $item['sku']."00000";
//
////}
//
//
////        $skuSimple = $item->getProduct()->getSku();
//        echo "<pre>";
////        var_dump($skuSimple);
////        die('detect my die()');
//
//
//                $skuConfigur = $item['sku'];
//
//
//            }

//            var_dump($skuSimple);

//            die('hello world');
//            die('some text , detect meeee');




//            $productsTyc = [
//                'sku_simple' => '12',
//                'sku_configurable' => '111111111111'
//            ];
//            var_dump($productsTyc);
//            die('qweqwe');
//            die('');

            $connection = $this->resourceConnection->getConnection('custom');

//            $productsTycConnection = $connection->getTableName('products_tyc');


            $query = $connection->query("INSERT INTO `products_tyc` (`sku_simple`, `sku_configurable`) VALUES ('2222222', '111111111111');")->execute();
            var_dump($query);
            die('');




        }
        public function importToOrdersItems($order)
        {

            $orderId = $order['entity_id'];
            $base_row_total_incl_tax = $order['total_due'];
            $increment = $order['increment_id'];
            $price_unit = $order['base_subtotal'];
            $orderqw = $this->orderRepository->get($orderId);


            foreach ($orderqw->getAllItems() as $item) {
                $skuConfigur= $item['sku'];
                $size= $item['size'];
                $color= $item['color'];
                $line= $item['line'];
                $discount_amount= $item['discount_amount'];
                $qty= $item['product_options']['info_buyRequest']['qty'];
            }

            $argumentsOrdersItems = [
                'id' => NULL,
                'increment_id' => $increment,
                'product_sku' => $skuConfigur,
                'size' => $size,
                'color' => $color,
                'line' => $line,
                'qty' => $qty,
                'price_unit' => $price_unit,
                'discount_1' => $discount_amount,
                'total_amount_line' => $base_row_total_incl_tax
            ];


            $connection = $this->resourceConnection->getConnection('custom');

            $ordersItems = $connection->getTableName('orders_items');

            $query = $connection->insert($ordersItems, $argumentsOrdersItems);

            if ($query == true) {
                return true;
            } else {
                return true;
            }

        }
    }
