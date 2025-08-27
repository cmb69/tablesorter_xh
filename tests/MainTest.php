<?php

namespace Tablesorter;

use ApprovalTests\Approvals;
use PHPUnit\Framework\TestCase;
use Plib\FakeRequest;
use Plib\View;

class MainTest extends TestCase
{
    /** @var array<string,string> */
    private array $config;

    private View $view;

    protected function setUp(): void
    {
        $this->config = XH_includeVar("./config/config.php", "plugin_cf")["tablesorter"];
        $this->view = new View("./views/", XH_includeVar("./languages/en.php", "plugin_tx")["tablesorter"]);
    }

    private function sut(): Main
    {
        return new Main("./plugins/tablesorter/", $this->config, $this->view);
    }

    public function testRendersScript(): void
    {
        $request = new FakeRequest();
        $response = $this->sut()($request);
        Approvals::verifyHtml($response->bjs());
    }
}
