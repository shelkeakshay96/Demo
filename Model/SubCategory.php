<?php
namespace KO\Demo\Model;
class SubCategory extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('KO\Demo\Model\ResourceModel\SubCategory');
    }
}