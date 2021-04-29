# Magento 2 - Widget Extension Parameter

## Installation

```bash
composer require inkl/m2-module-widget-ext-parameter
bin/magento module:enable Inkl_WidgetExtParameter
```

## Usage

### etc/widget.xml
```xml
<widgets xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Widget:etc/widget.xsd">

    <widget id="example_list" class="Vendor\Module\Block\Widget\ExampleList">
        <label>Example List</label>
        <description>Example List</description>
        <parameters>
            <parameter name="widget_name" xsi:type="text" required="true" visible="true" sort_order="10">
                <label>Widget Name</label>
            </parameter>
            <parameter name="items" xsi:type="block" required="true" visible="true" sort_order="30">
                <label translate="true">Items</label>
                <block class="Inkl\WidgetExtParameter\Block\Adminhtml\Widget\WidgetList">
                    <data>
                        <item name="group" xsi:type="string">example_item</item>
                        <item name="widget_class" xsi:type="string">Vendor\Module\Block\Widget\ExampleItem</item>
                    </data>
                </block>
            </parameter>
        </parameters>
    </widget>

    <widget id="example_item" class="Vendor\Module\Block\Widget\ExampleItem">
        <label>Example Item</label>
        <description>Example Item</description>
        <parameters>
            <parameter name="name" xsi:type="text" required="true" visible="true" sort_order="10">
                <label>Name</label>
            </parameter>
            <parameter name="description" xsi:type="block" required="true" visible="true" sort_order="20">
                <label translate="true">Description</label>
                <block class="Inkl\WidgetExtParameter\Block\Adminhtml\Widget\Textarea" />
            </parameter>
            <parameter name="image" xsi:type="block" required="true" visible="true" sort_order="30">
                <label translate="true">image</label>
                <block class="Inkl\WidgetExtParameter\Block\Adminhtml\Widget\ImageChooser">
                    <data>
                        <item name="button" xsi:type="array">
                            <item name="open" xsi:type="string">Choose Image...</item>
                        </item>
                    </data>
                </block>
            </parameter>
        </parameters>
    </widget>
</widgets>
```

### Block/Widget/ExampleList.php
```php
<?php

declare(strict_types=1);

namespace Vendor\Module\Block\Widget;

use Inkl\WidgetExtParameter\Block\Widget\WidgetList;

class ExampleList extends WidgetList
{
    protected $_template = 'Vendor_Module::widget/example-list.phtml';
}
```

### Block/Widget/ExampleItem.php
```php
<?php

declare(strict_types=1);

namespace Vendor\Module\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class ExampleItem extends Template implements BlockInterface
{
}
```

### view/frontend/templates/widget/example-list.phtml
```php
<?php /** @var \Vendor\Module\Block\Widget\ExampleList $block */ ?>
<h1>Example List</h1>

<?php foreach ($block->getItems('example_item') as $exampleItem): ?>
    <div>
        <?= $exampleItem['name'] ?>
    </div>
<?php endforeach; ?>
```

