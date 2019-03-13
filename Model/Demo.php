<?php
namespace KO\Demo\Model;
class Demo extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('KO\Demo\Model\ResourceModel\Demo');
    }
}