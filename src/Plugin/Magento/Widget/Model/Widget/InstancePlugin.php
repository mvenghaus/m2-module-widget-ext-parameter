<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Plugin\Magento\Widget\Model\Widget;

use Inkl\WidgetExtParameter\Block\Adminhtml\Widget\WidgetList;
use Inkl\WidgetExtParameter\Model\Service\NameModifierService;
use Magento\Widget\Model\Widget;
use Magento\Widget\Model\Widget\Instance;

class InstancePlugin
{
    private Widget $widget;
    private NameModifierService $nameModifierService;

    public function __construct(
        Widget $widget,
        NameModifierService $nameModifierService
    ) {
        $this->widget = $widget;
        $this->nameModifierService = $nameModifierService;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundGetWidgetsOptionArray(Instance $subject, callable $proceed, $value = 'code')
    {
        $widgets = [];
        foreach ($this->widget->getWidgets() as $widgetCode => $widgetData) {
            if ($this->nameModifierService->hasHidden($widgetCode) ||
                substr_count(serialize($widgetData), WidgetList::class) // phpcs:ignore
            ) {
                continue;
            }

            $widgetData = [
                'name' => __((string)$widgetData['name']),
                'code' => $widgetCode,
                'type' => $widgetData['@']['type'],
                'description' => __((string)$widgetData['description'])
            ];

            $widgets[] = ['value' => $widgetData[$value], 'label' => $widgetData['name']];
        }

        return $widgets;
    }
}
