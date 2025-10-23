<?php

namespace Tablesorter;

use ApprovalTests\Approvals;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Plib\FakeRequest;
use Plib\JavaScript;
use Plib\View;

class MainTest extends TestCase
{
    /** @var array<string,string> */
    private array $config;

    /** @var JavaScript&MockObject */
    private $javaScript;

    private View $view;

    protected function setUp(): void
    {
        $this->config = XH_includeVar("./config/config.php", "plugin_cf")["tablesorter"];
        $this->javaScript = $this->createMock(JavaScript::class);
        $this->view = new View("./views/", XH_includeVar("./languages/en.php", "plugin_tx")["tablesorter"]);
    }

    private function sut(): Main
    {
        return new Main("./plugins/tablesorter/", $this->config, $this->javaScript, $this->view);
    }

    public function testRendersScript(): void
    {
        $this->javaScript->expects($this->once())->method("includePolyfills");
        $this->javaScript->expects($this->once())->method("include")->with("./plugins/tablesorter/tablesorter");
        $request = new FakeRequest();
        $response = $this->sut()($request);
        Approvals::verifyHtml($response->bjs());
    }
}
