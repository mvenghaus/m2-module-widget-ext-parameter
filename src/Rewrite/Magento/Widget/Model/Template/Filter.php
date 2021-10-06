<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Rewrite\Magento\Widget\Model\Template;

use Inkl\WidgetExtParameter\Model\Service\Base64Service;
use Magento\Cms\Model\Template\FilterProvider;

class Filter extends \Magento\Widget\Model\Template\Filter
{
    private Base64Service $base64Service;
    private FilterProvider $filterProvider;

    private bool $recursiveCheck = false;

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
        \Magento\Variable\Model\Source\Variables $configVariables,
        \Magento\Widget\Model\ResourceModel\Widget $widgetResource,
        \Magento\Widget\Model\Widget $widget,
        \Magento\Framework\Filter\VariableResolverInterface $variableResolver,
        \Magento\Framework\Css\PreProcessor\Adapter\CssInliner $cssInliner,
        \Magento\Email\Model\Template\Css\Processor $cssProcessor,
        \Magento\Framework\Filesystem $pubDirectory,
        Base64Service $base64Service,
        FilterProvider $filterProvider,
        $variables = [],
        array $directiveProcessors = []
    ) {
        $this->base64Service = $base64Service;
        $this->filterProvider = $filterProvider;

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
            $configVariables,
            $variableResolver,
            $cssProcessor,
            $pubDirectory,
            $cssInliner,
            $widgetResource,
            $widget,
            $variables,
            $directiveProcessors
        );
    }

    protected function getParameters($value)
    {
        $parameters = parent::getParameters($value);
        foreach ($parameters as $key => $value) {
            $parameters[$key] = $this->base64Service->unserialize($value);
        }

        if (!$this->recursiveCheck) {
            $this->recursiveCheck = true;
            $parameters = $this->arrayMapRecursive([$this->filterProvider->getBlockFilter(), 'filter'], $parameters);
            $this->recursiveCheck = false;
        }

        return $parameters;
    }

    private function arrayMapRecursive(callable $callback, array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->arrayMapRecursive($callback, $value);
            } else {
                $array[$key] = $callback($value);
            }
        }
        return $array;
    }
}
