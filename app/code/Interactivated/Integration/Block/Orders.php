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


    public function __construct(
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        ResourceConnection $resourceConnection
    )
    {
        parent::__construct($context);
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->resourceConnection = $resourceConnection;

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
//        return $orderCollecion;
        $data = $orderCollecion->getData();
        var_dump($data[0]['entity_id']);

        $lastname = $data[0]['entity_id'];
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

//        var_dump($data[1]);
//        die();


        $some = $connection->query("UPDATE `table_for_data` SET `lastname` = `123123` WHERE `table_for_data`.`id` = 1;");

        return $some;

        die();



//        var_dump($connection->query('select * from "table_for_data"'));
//        die();
//        return  $connection->query("select * from table_for_data;")->execute();
    }
}