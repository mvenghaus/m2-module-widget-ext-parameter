<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Block\Adminhtml\Widget;

use Magento\Backend\Block\Template;
use Magento\Framework\Data\Form\Element\AbstractElement;

class GroupLabel extends Template
{
    public function prepareElementHtml(AbstractElement $element)
    {
        $element->setData(
            'after_element_html',
            $this->getLayout()->createBlock(Template::class)
                ->setTemplate('Inkl_WidgetExtParameter::widget/group-label.phtml')
                ->setData('label', $this->getData('label'))
                ->toHtml()
        );

        return $element;
    }
}
