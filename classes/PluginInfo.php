<?php

/**
 * Copyright 2012-2019 Christoph M. Becker
 *
 * This file is part of Tablesorter_XH.
 *
 * Tablesorter_XH is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Tablesorter_XH is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tablesorter_XH.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Tablesorter;

use Plib\SystemChecker;
use Plib\View;

class PluginInfo
{
    /** @var string */
    private $pluginFolder;

    /** @var SystemChecker */
    private $systemChecker;

    /** @var View */
    private $view;

    public function __construct(string $pluginFolder, SystemChecker $systemChecker, View $view)
    {
        $this->pluginFolder = $pluginFolder;
        $this->systemChecker = $systemChecker;
        $this->view = $view;
    }

    public function render(): string
    {
        return $this->view->render("info", [
            "version" => Plugin::VERSION,
            "checks" => [
                $this->checkPhpVersion("7.4.0"),
                $this->checkWritability($this->pluginFolder . "config/"),
                $this->checkWritability($this->pluginFolder . "css/"),
                $this->checkWritability($this->pluginFolder . "languages/"),
            ],
        ]);
    }

    private function checkPhpVersion(string $version): string
    {
        $status = $this->systemChecker->checkVersion(PHP_VERSION, $version) ? "success" : "fail";
        return $this->view->message($status, "syscheck_phpversion", $version);
    }

    private function checkWritability(string $folder): string
    {
        $status = $this->systemChecker->checkWritability($folder) ? "success" : "warning";
        return $this->view->message($status, "syscheck_writable", $folder);
    }
}
