<?php

use PHPUnit\Framework\TestCase;
use Tablesorter\Main;
use Tablesorter\Plugin;
use Tablesorter\PluginInfo;

class PluginTest extends TestCase
{
    public function testMakesMain(): void
    {
        $this->assertInstanceOf(Main::class, Plugin::makeMain());
    }

    public function testMakesPluginInfo(): void
    {
        $this->assertInstanceOf(PluginInfo::class, Plugin::makePluginInfo());
    }
}
