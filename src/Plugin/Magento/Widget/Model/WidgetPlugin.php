<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Plugin\Magento\Widget\Model;

use Magento\Framework\Serialize\Serializer\Base64Json;
use Magento\Widget\Model\Widget;

class WidgetPlugin
{
    private Base64Json $base64Json;

    public function __construct(Base64Json $base64Json)
    {
        $this->base64Json = $base64Json;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeGetWidgetDeclaration(Widget $subject, $type, $params = [], $asIs = true)
    {
        if (isset($params['widget_list'])) {
            $params['widget_list'] = $this->base64Json->serialize($params['widget_list']);
        }

        return [$type, $params, $asIs];
    }

    public function afterGetWidgetsArray(Widget $subject, $result, $filters = [])
    {
        return array_filter($result, function ($widgetData) {
            return !preg_match('/_hidden$/is', $widgetData['code']);
        });
    }
}
