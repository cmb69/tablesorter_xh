<?php

namespace Tablesorter;

use PHPUnit\Framework\TestCase;

class PluginTest extends TestCase
{
    public function testMakesMain(): void
    {
        global $pth, $plugin_cf, $plugin_tx;
        $pth = ["folder" => ["plugins" => ""]];
        $plugin_cf = ["tablesorter" => []];
        $plugin_tx = ["tablesorter" => []];
        $this->assertInstanceOf(Main::class, Plugin::makeMain());
    }

    public function testMakesCsvTabler(): void
    {
        global $pth, $plugin_tx;
        $pth = ["folder" => ["downloads" => "", "plugins" => ""]];
        $plugin_tx = ["tablesorter" => []];
        $this->assertInstanceOf(CsvTabler::class, Plugin::makeCsvTabler());
    }

    public function testMakesPluginInfo(): void
    {
        global $pth, $plugin_tx;
        $pth = ["folder" => ["plugins" => ""]];
        $plugin_tx = ["tablesorter" => []];
        $this->assertInstanceOf(PluginInfo::class, Plugin::makePluginInfo());
    }
}
