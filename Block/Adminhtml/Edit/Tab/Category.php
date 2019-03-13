<?php
namespace KO\Demo\Block\Adminhtml\Edit\Tab;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Category extends Template
{
	public function __construct(
		Context $context,
		\Magento\Framework\App\Request\Http $request, 
		\KO\Demo\Model\DemoFactory $demoFactory
	) {
		$this->request = $request;
		$this->demoFactory = $demoFactory;
        parent::__construct($context);
    }

    public function getModel() {
    	return $this->demoFactory->create()->load($this->getId());
    }

    public function getId() {
    	return $this->request->getParam('id');
    }

    public function setCategoryValue() {
    	return $this->getModel()->getcategory();
    }

    public function setSubcategoryValue() {
        // echo "<pre>"; print_r($this->getModel()->getsubcategory()); die;
    	return $this->getModel()->getsubcategory();
    }
}
