<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class WidgetList extends Template implements BlockInterface
{
    public function getItems(string $group): array
    {
        return  $this->getData('widget_list')[$group] ?? [];
    }
}
