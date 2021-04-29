<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Plugin\Magento\Widget\Model\Widget;

use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Widget\Model\Widget\Config;

class ConfigPlugin
{
    private AssetRepository $assetRepository;

    public function __construct(AssetRepository $assetRepository)
    {
        $this->assetRepository = $assetRepository;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundGetWysiwygJsPluginSrc(Config $subject, callable $proceed)
    {
        return $this->assetRepository->getUrl('Inkl_WidgetExtParameter::js/editor_plugin.js');
    }
}
