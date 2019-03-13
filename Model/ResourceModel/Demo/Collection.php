<?php
namespace KO\Demo\Model\ResourceModel\Demo;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('KO\Demo\Model\Demo', 'KO\Demo\Model\ResourceModel\Demo');
    }
}