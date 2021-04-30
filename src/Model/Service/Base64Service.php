<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Model\Service;

use Magento\Framework\Serialize\Serializer\Base64Json;

class Base64Service
{
    private Base64Json $base64Json;

    public function __construct(Base64Json $base64Json)
    {
        $this->base64Json = $base64Json;
    }

    public function serialize($data): string
    {
        if (empty($data)) {
            return '';
        }

        return 'base64::' . $this->base64Json->serialize($data);
    }

    public function unserialize(string $data)
    {
        if (preg_match('/^base64::/is', $data)) {
            $data = preg_replace('/^base64::/is', '', $data);
            $data = $this->base64Json->unserialize($data);
        }

        return $data;
    }

}