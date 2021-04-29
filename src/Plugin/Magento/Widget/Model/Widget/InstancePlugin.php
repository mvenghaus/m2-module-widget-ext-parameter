<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Plugin\Magento\Widget\Model\Widget;

use Inkl\WidgetExtParameter\Block\Adminhtml\Widget\WidgetList;
use Magento\Widget\Model\Widget;
use Magento\Widget\Model\Widget\Instance;

class InstancePlugin
{
    private Widget $widget;

    public function __construct(Widget $widget)
    {
        $this->widget = $widget;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundGetWidgetsOptionArray(Instance $subject, callable $proceed, $value = 'code')
    {
        $widgets = [];
        foreach ($this->widget->getWidgets() as $widgetCode => $widgetData) {
            if (preg_match('/_hidden$/is', $widgetCode) ||
                substr_count(serialize($widgetData), WidgetList::class) // phpcs:ignore
            ) {
                continue;
            }

            $widgetData['code'] = $widgetCode;
            
            $widgets[] = ['value' => $widgetData[$value], 'label' => $widgetData['name']];
        }

        return $widgets;
    }
}
