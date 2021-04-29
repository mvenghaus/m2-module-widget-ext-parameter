<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Block\Adminhtml\Widget;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Button as WidgetButton;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory as ElementFactory;

class ImageChooser extends Template
{
    private ElementFactory $elementFactory;

    public function __construct(
        Context $context,
        ElementFactory $elementFactory,
        array $data = []
    ) {
        $this->elementFactory = $elementFactory;
        parent::__construct($context, $data);
    }

    public function prepareElementHtml(AbstractElement $element)
    {
        $config = $this->_getData('config');

        $sourceUrl = $this->getUrl(
            'cms/wysiwyg_images/index',
            [
                'target_element_id' => $element->getId(), 'type' => 'file'
            ]
        );

        $chooser = $this->getLayout()
            ->createBlock(WidgetButton::class)
            ->setType('button')
            ->setClass('btn-chooser')
            ->setLabel($config['button']['open'])
            ->setOnClick('MediabrowserUtility.openDialog(\'' . $sourceUrl . '\')')
            ->setDisabled($element->getReadonly());

        $input = $this->elementFactory->create("text", ['data' => $element->getData()]);
        $input->setId($element->getId());
        $input->setForm($element->getForm());
        $input->setClass("widget-option input-text admin__control-text");
        $input->addCustomAttribute('data-force_static_path', '1');

        if ($element->getRequired()) {
            $input->addClass('required-entry');
        }

        $element->setData('after_element_html', $input->getElementHtml() . $chooser->toHtml());
        return $element;
    }
}
