<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Model\Service;

class NameModifierService
{
    public function hasHidden(string $name): bool
    {
        return $this->hasModifier($name, 'hidden');
    }

    public function hasBase64(string $name): bool
    {
        return $this->hasModifier($name, 'base64');
    }

    public function hasModifier(string $name, string $modifier): bool
    {
        return (bool)preg_match('/--' . $modifier . '/is', $name);
    }

    public function removeModifier(string $name): string
    {
        return preg_replace('/(--.*?)$/is', '', $name);
    }
}