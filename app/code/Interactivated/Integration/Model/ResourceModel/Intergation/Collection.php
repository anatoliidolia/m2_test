<?php

namespace Interactivated\Integration\Model\ResourceModel\Intergation;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Contact Resource Model Collection
 *
 * @author      Pierre FAY
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Interactivated\Integration\Model\Integration', 'Interactivated\Integration\Model\ResourceModel\Integration');
    }
}