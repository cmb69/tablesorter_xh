<?php

use ApprovalTests\Approvals;
use PHPUnit\Framework\TestCase;
use Plib\FakeSystemChecker;
use Plib\SystemChecker;
use Plib\View;
use Tablesorter\PluginInfo;

class PluginInfoTest extends TestCase
{
    private SystemChecker $systemChecker;
    private View $view;

    protected function setUp(): void
    {
        $this->systemChecker = new FakeSystemChecker();
        $this->view = new View("./views/", XH_includeVar("./languages/en.php", "plugin_tx")["tablesorter"]);
    }

    private function sut(): PluginInfo
    {
        return new PluginInfo(".", $this->systemChecker, $this->view);
    }

    public function testInfo(): void
    {
        Approvals::verifyHtml($this->sut()->render());
    }
}
