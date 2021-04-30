<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Plugin\Magento\Widget\Block\Adminhtml\Widget;

use Inkl\WidgetExtParameter\Model\Service\Base64Service;
use Magento\Widget\Block\Adminhtml\Widget\Options;

class OptionsPlugin
{
    private Base64Service $base64Service;

    public function __construct(Base64Service $base64Service)
    {
        $this->base64Service = $base64Service;
    }

    public function beforeAddFields(Options $subject): array
    {
        $widgetValues = $subject->getData('widget_values');

        foreach ($widgetValues as $key => $value) {
            $widgetValues[$key] = $this->base64Service->unserialize($value);
            $widgetValues[$key . '--base64'] = $this->base64Service->unserialize($value);
        }

        $subject->setData('widget_values', $widgetValues);

        return [];
    }
}
