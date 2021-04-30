<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Plugin\Magento\Widget\Model;

use Inkl\WidgetExtParameter\Model\Service\Base64Service;
use Inkl\WidgetExtParameter\Model\Service\NameModifierService;
use Magento\Widget\Model\Widget;

class WidgetPlugin
{
    private Base64Service $base64Service;
    private NameModifierService $nameModifierService;

    public function __construct(
        Base64Service $base64Service,
        NameModifierService $nameModifierService
    ) {
        $this->base64Service = $base64Service;
        $this->nameModifierService = $nameModifierService;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeGetWidgetDeclaration(Widget $subject, $type, $params = [], $asIs = true): array
    {
        $newParams = [];
        foreach ($params as $name => $data) {
            if ($this->isBase64($name)) {
                $data = $this->base64Service->serialize($data);
            }

            $name = $this->nameModifierService->removeModifier($name);
            $newParams[$name] = $data;
        }

        return [$type, $newParams, $asIs];
    }

    private function isBase64(string $name): bool
    {
        return (
            $name === 'widget_list' ||
            $this->nameModifierService->hasBase64($name)
        );
    }

    public function afterGetWidgetsArray(Widget $subject, $result, $filters = [])
    {
        return array_filter($result, function ($widgetData) {
            return !$this->nameModifierService->hasHidden($widgetData['code']);
        });
    }
}
