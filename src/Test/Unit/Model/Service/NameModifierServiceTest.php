<?php

declare(strict_types=1);

namespace Inkl\WidgetExtParameter\Test\Unit\Model\Service;

use Inkl\WidgetExtParameter\Model\Service\NameModifierService;
use PHPUnit\Framework\TestCase;

class NameModifierServiceTest extends TestCase
{
    private NameModifierService $nameModifierService;

    protected function setUp(): void
    {
        $this->nameModifierService = new NameModifierService();
    }

    /**
     * @dataProvider dataProviderTestHasModifier
     */
    public function testHasModifier(string $name, string $modifier, bool $expected): void
    {
        $actual = $this->nameModifierService->hasModifier($name, $modifier);

        $this->assertSame($expected, $actual);
    }

    public function dataProviderTestHasModifier(): array
    {
        return [
            ['name--hidden', 'hidden', true],
            ['name--nothing', 'hidden', false],
            ['name', 'hidden', false],
        ];
    }

    /**
     * @dataProvider dataProviderTestRemoveModifier
     */
    public function testRemoveModifier(string $name, string $expected): void
    {
        $actual = $this->nameModifierService->removeModifier($name);

        $this->assertSame($expected, $actual);
    }

    public function dataProviderTestRemoveModifier(): array
    {
        return [
            ['name--modifier', 'name'],
            ['name--mod1--mod2', 'name']
        ];
    }
}
