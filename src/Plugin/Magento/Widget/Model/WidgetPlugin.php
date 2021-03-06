<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Plugin\Magento\Widget\Model;

use Inkl\WidgetExtParameter\Model\Service\Base64Service;
use Magento\Framework\DataObject;
use Magento\Widget\Model\Widget;

class WidgetPlugin
{
    private Base64Service $base64Service;

    public function __construct(Base64Service $base64Service)
    {
        $this->base64Service = $base64Service;
    }

    public function beforeGetWidgetDeclaration(Widget $subject, $type, $params = [], $asIs = true): array
    {
        $widgetConfig = $subject->getConfigAsObject($type);

        $newParams = [];
        foreach ($params as $name => $data) {
            if ($this->isBase64($name, $widgetConfig)) {
                $data = $this->base64Service->serialize($data);
            }

            $newParams[$name] = $data;
        }

        return [$type, $newParams, $asIs];
    }

    private function isBase64(string $parameterName, DataObject $widgetConfig): bool
    {
        if ($parameterName === 'widget_list') {
            return true;
        }

        foreach ($widgetConfig->getData('parameters') as $parameter) {
            if ($parameter->getData('key') === $parameterName &&
                ($parameter->getData('extra')['base64'] ?? 'false') === 'true'
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetWidgetsArray(Widget $subject, $result, $filters = [])
    {
        $widgets = $subject->getWidgets($filters);
        foreach ($result as &$data) {
            $data['extra'] = $widgets[$data['code']]['extra'] ?? [];
        }

        return array_filter($result, function ($widgetData) {
            return ($widgetData['extra']['hidden'] ?? 'false') === 'false';
        });
    }
}
