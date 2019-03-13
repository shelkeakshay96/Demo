<?php
/**
 * @author Kaytalyst Technogies
 * Copyright © 2018 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace KO\Demo\Controller\Adminhtml\Ajax;

class GetSubcategories extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \KO\Demo\Model\SubCategoryFactory $subCategory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory)
    {
        $this->request = $request;
        $this->subCategory = $subCategory;
        $this->resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        if($this->getRequest()->isAjax()){

            $arr = array();
            $model = $this->subCategory->create()->getCollection();
            $model->addFieldToFilter('category_id', array('in' => $this->getId()));

            $arr = $model->getData();
            $result = $this->resultJsonFactory->create();
            return $result->setData($arr);
        }
    }
    public function getId() {
        return $this->request->getParam('id');
    }
    public function getBaseUrl()
    {
        return 1;
    }
}
