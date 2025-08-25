<?php

use PHPUnit\Framework\TestCase;
use Tablesorter\Main;
use Tablesorter\Plugin;

class PluginTest extends TestCase
{
    public function testMakesMain(): void
    {
        $this->assertInstanceOf(Main::class, Plugin::makeMain());
    }
}
