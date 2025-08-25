<?php

use ApprovalTests\Approvals;
use PHPUnit\Framework\TestCase;
use Plib\View;
use Tablesorter\PluginInfo;

class PluginInfoTest extends TestCase
{
    private View $view;

    protected function setUp(): void
    {
        $this->view = new View("./views/", XH_includeVar("./languages/en.php", "plugin_tx")["tablesorter"]);
    }

    private function sut(): PluginInfo
    {
        return new PluginInfo(".", $this->view);
    }

    public function testInfo(): void
    {
        Approvals::verifyHtml($this->sut()->render());
    }
}
