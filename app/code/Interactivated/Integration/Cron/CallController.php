<?php

namespace Interactivated\Integration\Cron;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\Cache\Manager as CacheManager;
use Magento\Framework\App\Cache\TypeListInterface as CacheTypeListInterface;


class CallController{

    protected $logger;


    protected $index;


    public function __construct(
        LoggerInterface $logger,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
         \Interactivated\Integration\Controller\Index\Index $index

    ) {
        $this->logger = $logger;
        $this->index = $index;
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheFrontendPool = $cacheFrontendPool;
    }


    public function execute()
    {
        $this->logger->info('C444444444444444ron Works123123123');
        $this->index->execute();

    }

    public function cacheFlush()
    {
        $cache_types = array('config','layout','block_html','collections','reflection','db_ddl','eav','config_integration','config_integration_api','full_page','translate','config_webservice');
        foreach ($cache_types as $type) {
            $this->_cacheTypeList->cleanType($type);
        }
        foreach ($this->_cacheFrontendPool as $cache_clean_flush) {
            $cache_clean_flush->getBackend()->clean();
        }
    }


}
