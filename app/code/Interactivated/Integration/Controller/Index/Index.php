<?php

namespace Interactivated\Integration\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $resultBlockFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Interactivated\Integration\Block\OrdersFactory $resultBlockFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->resultBlockFactory = $resultBlockFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultBlock = $this->resultBlockFactory->create();
        $status = $resultBlock->connectionToNewTable();
       // $resultPage = $this->resultPageFactory->create();
        return $status;

    }
}
