<?php

namespace Interactivated\Integration\Model;


    class CustomOrderCollection
    {

        private $connectionFactory;
        private $connection;
        private $connectionConfig= array(
    'host' => 'localhost',
    'dbname' => 'erp_end',
    'username' => 'root',
    'password' => 'q1w2e3r4'
    );
        private $logger;
        public function __construct(
            \Magento\Framework\App\ResourceConnection\ConnectionFactory $connectionFactory,
            \Psr\Log\LoggerInterface $logger
        )
        {

            $this->connectionFactory = $connectionFactory;
            $this->connection = $this->connectionFactory->create($this->connectionConfig);
            $this->logger = $logger;

        }


        public function update($orders){



            foreach ($orders as $order)  {


                if ($this->checkData($order) == true){
                    $this->importNewOrder($order);
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

            $getIncrement = $this->connection->fetchRow("select `increment_id` from `orders` where `increment_id`='$check';");
//            var_dump($getIncrement);
//
//            if($getIncrement == true){
//                die('wqeqwe');
//            }else {
//                die('что произошло');
//            }
//
//            die('I wont live');

           if( $getIncrement == false){
          return true;
           }else{
               $this->logger->info('Already in DB '.$check);
               return false;
           }

//            var_dump(get_class_methods($check));


        }

        public function importNewOrder($order){

//            var_dump($order);
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
            $table = $this->connection->getTableName('orders');

            $arguments = [
                'id'=> NULL,
                'increment_id' => $increment_id,
                'customer_id' => $customer_id,
                'total_amount' =>$total_amount,
                'status' => $status,
                'order_date' => $updated_at
            ];

            $query = $this->connection->insert($table, $arguments)->execute();
//                die('stop, please, stop');
//           $status = $this->connection->query("UPDATE `orders` SET `increment_id` = '$increment_id', `customer_id` = '$customer_id', `total_amount` = '$total_amount',`status` = '$status',`order_date` = '$updated_at'  WHERE `orders`.`id` = 1;")->execute();
//            INSERT INTO `orders` (`id`, `increment_id`, `customer_id`, `total_amount`, `status`, `order_date`) VALUES (NULL, NULL, NULL, NULL, NULL, NULL);

        }




    }
