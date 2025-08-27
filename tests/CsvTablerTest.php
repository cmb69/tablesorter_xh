<?php

namespace Tablesorter;

use ApprovalTests\Approvals;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use Plib\View;

class CsvTablerTest extends TestCase
{
    private string $downloadFolder;
    private View $view;

    protected function setUp(): void
    {
        vfsStream::setup("root");
        file_put_contents(vfsStream::url("root/test.csv"), <<<'CSV'
            heading1,heading2
            cell A1,cell B1

            cell A2,cell B2
            CSV);
        $this->downloadFolder = vfsStream::url("root/");
        $this->view = new View("./views/", XH_includeVar("./languages/en.php", "plugin_tx")["tablesorter"]);
    }

    private function sut(): CsvTabler
    {
        return new CsvTabler($this->downloadFolder, $this->view);
    }

    public function testRendersTable(): void
    {
        $response = $this->sut()("test.csv");
        Approvals::verifyHtml($response->output());
    }

    public function testReportsMissingFile(): void
    {
        $response = $this->sut()("missing.csv");
        $this->assertStringContainsString("File missing.csv not found!", $response->output());
    }
}
