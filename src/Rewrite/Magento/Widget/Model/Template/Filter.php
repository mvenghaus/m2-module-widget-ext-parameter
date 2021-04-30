<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Rewrite\Magento\Widget\Model\Template;

use Inkl\WidgetExtParameter\Model\Service\Base64Service;

class Filter extends \Magento\Widget\Model\Template\Filter
{
    private Base64Service $base64Service;

    public function __construct(
        \Magento\Framework\Stdlib\StringUtils $string,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Escaper $escaper,
        \Magento\Framework\View\Asset\Repository $assetRepo,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Variable\Model\VariableFactory $coreVariableFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\LayoutInterface $layout,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magento\Framework\App\State $appState,
        \Magento\Framework\UrlInterface $urlModel,
        \Pelago\Emogrifier $emogrifier,
        \Magento\Variable\Model\Source\Variables $configVariables,
        \Magento\Widget\Model\ResourceModel\Widget $widgetResource,
        \Magento\Widget\Model\Widget $widget,
        Base64Service $base64Service
    ) {
        $this->base64Service = $base64Service;
        parent::__construct(
            $string,
            $logger,
            $escaper,
            $assetRepo,
            $scopeConfig,
            $coreVariableFactory,
            $storeManager,
            $layout,
            $layoutFactory,
            $appState,
            $urlModel,
            $emogrifier,
            $configVariables,
            $widgetResource,
            $widget
        );
    }


    protected function getParameters($value)
    {
        $parameters = parent::getParameters($value);
        foreach ($parameters as $key => $value) {
            $parameters[$key] = $this->base64Service->unserialize($value);
            $parameters[$key . '--base64'] = $this->base64Service->unserialize($value);
        }

        return $parameters;
    }
}
