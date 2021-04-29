<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Controller\Adminhtml\Widget\WidgetList;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\View\LayoutInterface;
use Magento\Framework\Data\Form\Element\Factory as ElementFactory;
use Inkl\WidgetExtParameter\Block\Adminhtml\Widget\WidgetList;

class Add extends Action implements HttpPostActionInterface
{
    private LayoutInterface $layout;
    private FormFactory $formFactory;
    private ElementFactory $elementFactory;

    public function __construct(
        Context $context,
        LayoutInterface $layout,
        FormFactory $formFactory,
        ElementFactory $elementFactory
    ) {
        $this->layout = $layout;
        $this->formFactory = $formFactory;
        $this->elementFactory = $elementFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $widgetListBlock = $this->layout->createBlock(WidgetList::class);
        $rootElement = $this->elementFactory->create('text');
        $rootElement->setForm($this->formFactory->create());

        $html = $widgetListBlock->renderItem(
            $rootElement,
            $this->_request->getPost('group'),
            uniqid(),
            $this->_request->getPost('widget_class')
        );

        $this->getResponse()->setBody($html);
    }
}
