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

use Plib\View;

class PluginInfo
{
    /** @var string */
    private $pluginFolder;

    /** @var View */
    private $view;

    public function __construct(string $pluginFolder, View $view)
    {
        $this->pluginFolder = $pluginFolder;
        $this->view = $view;
    }

    public function render(): string
    {
        $o = '<h1>Tablesorter ' . Plugin::VERSION . '</h1>' . "\n"
            . '<h4>' . $this->view->text("syscheck_title") . '</h4>' . "\n"
            . $this->checkPhpVersion("7.4.0");
        foreach (array('config/', 'css/', 'languages/') as $folder) {
            $folders[] = $this->pluginFolder . $folder;
        }
        foreach ($folders as $folder) {
            $o .= $this->checkWritability($folder);
        }
        return $o;
    }

    private function checkPhpVersion(string $version): string
    {
        $status = version_compare(PHP_VERSION, $version) >= 0 ? "success" : "fail";
        return $this->view->message($status, "syscheck_phpversion", $version);
    }

    private function checkWritability(string $folder): string
    {
        $status = is_writable($folder) ? "success" : "warning";
        return $this->view->message($status, "syscheck_writable", $folder);
    }
}
