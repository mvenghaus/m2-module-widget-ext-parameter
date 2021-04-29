<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Block\Widget;

use Magento\Framework\Serialize\Serializer\Base64Json;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;

class WidgetList extends Template implements BlockInterface
{
    private Base64Json $base64Json;

    public function __construct(
        Context $context,
        Base64Json $base64Json,
        array $data = []
    ) {
        $this->base64Json = $base64Json;
        parent::__construct($context, $data);
    }

    public function getItems(string $group): array
    {
        $widgetListValues = $this->base64Json->unserialize($this->getData('widget_list'));
        return  $widgetListValues[$group] ?? [];
    }
}
