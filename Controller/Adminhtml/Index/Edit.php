<?php
namespace KO\Demo\Controller\Adminhtml\Index;
use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry = null;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;
    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \KO\Demo\Model\DemoFactory $demoFactory,
        \Magento\Backend\Model\SessionFactory $sessionFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        $this->demoFactory = $demoFactory;
        $this->sessionFactory = $sessionFactory;
        parent::__construct($context);
    }
    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('KO_Demo::demo');
    }
    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    private function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('KO_Demo::test1')
            ->addBreadcrumb(__('Demo'), __('Demo'))
            ->addBreadcrumb(__('Manage Demo'), __('Manage Demo'));
        return $resultPage;
    }
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->demoFactory->create();
        if ($id) {
            $model->load($id);
            
            if (!$model->getId()) {
                $this->messageManager->addError(__('This record no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->sessionFactory->create()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        
        $this->coreRegistry->register('ko_demo', $model);
        
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Demo') : __('New Demo'),
            $id ? __('Edit Demo') : __('New Demo')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Demo'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? __('Edit Demo') : __('Add New Demo'));
        
        return $resultPage;
    }
}
