<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace KO\Demo\Controller\Adminhtml\Index;
use Magento\Backend\App\Action;

/**
 * Adminhtml demo controller
 *
 * @author      Katalyst <katalystech.com>
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'KO_Demo::demo';
    /*
     * @param Action\Context $context
     *  @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    protected $resultPageFactory;
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Init layout, menu and breadcrumb
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('KO_Demo::demo');
        $resultPage->addBreadcrumb(__('KO'), __('KO'));
        $resultPage->addBreadcrumb(__('Demo'), __('Demo'));
        return $resultPage;
    }

    /**
     * Order grid
     *
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('KO Demo'));
        return $resultPage;
    }
}
