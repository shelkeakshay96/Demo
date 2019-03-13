<?php

namespace KO\Demo\Ui\Component\Listing;

class CustomerDataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
   protected function _initSelect()
   {
	     parent::_initSelect();

      	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();  
		$request = $objectManager->get('Magento\Framework\App\Request\Http');  
		$search = $request->getParam('search');
		
		if($search != null) {
		     $this->getSelect()->joinLeft(
		        ['secondTable' => $this->getTable('test')],
		        'main_table.entity_id = secondTable.customer_id',
		        ['my_custom_column']
		    )->where('my_custom_column LIKE "%' .$search. '%"');
			
		    return $this->getData();

		} else {
			$this->getSelect()->joinLeft(
		        ['secondTable' => $this->getTable('test')],
		        'main_table.entity_id = secondTable.customer_id',
		        ['my_custom_column']
		    );
		    return $this;
		}

      // echo "<pre>"; print_r($this->getData()); die;
      
  }
}