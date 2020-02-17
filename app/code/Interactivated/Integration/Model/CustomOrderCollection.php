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

//                if ($this->checkData($order) == true){
//                    $this->importNewOrder($order);
//                }
                if ($order == '6'){
                    $this->importNewOrder($orders);
                }

            }


        }
        public function checkData($order){



            if($this->connection->query("select * from orders where id=".$order['increment_id'])->execute()==false) {

                return true;
            }
            $this->logger->info('Already in DB '.$order['increment_id']);
            return false;
        }

        public function importNewOrder($orders){
//            var_dump($orders);
//            die('its variable == 6, please, die()');

            $increment_id = $orders['increment_id'];


            $customer_id = $orders['customer_id'];
            $total_amount = $orders['base_total_due'];
            $status = $orders['status'];
            $updated_at = $orders['updated_at'];
           $status = $this->connection->query("UPDATE `orders` SET `increment_id` = '$increment_id', `customer_id` = '$customer_id', `total_amount` = '$total_amount',`status` = '$status',`order_date` = '$updated_at'  WHERE `orders`.`id` = 1;")->execute();
            return  $status;
        }




    }
