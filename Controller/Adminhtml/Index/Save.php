<?php
/**
 * @author Kaytalyst Technogies
 * Copyright © 2018 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace KO\Demo\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use KO\Demo\Model\Demo;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    public $dataPersistor;
    public $inlineTranslation;
    
    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        \Magento\Framework\FilesystemFactory $filesystem,
        \KO\Demo\Model\DemoFactory $demoFactory,
        \Magento\Framework\App\ResourceConnectionFactory $resourceConnection
    ) {
       
        $this->dataPersistor = $dataPersistor;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->filesystem = $filesystem;
        $this->resourceConnection = $resourceConnection;
        $this->demoFactory = $demoFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        
        $post = $this->getRequest()->getParams();
        // echo "<pre>"; print_r($post); die;
        if ($data) {
            $id = $this->getRequest()->getParam('id');
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            $data['category'] = (isset($data['category'])) ? implode(',', $data['category']): "";
            
            $data['subcategory'] = (isset($data['subcategory'])) ? implode(',', $data['subcategory']) : "";
            /** @var \Magento\Cms\Model\Block $model */
            $model = $this->demoFactory->create()->load($id);

            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This record no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);
             
            $this->inlineTranslation->suspend();
            try {
                $model->save();
                
                $this->messageManager->addSuccess(__('Record Saved successfully'));
                $this->dataPersistor->clear('ko_demo');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, 'Something went wrong while saving the record.'.$e);
            }

            $this->dataPersistor->set('ko_demo', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
