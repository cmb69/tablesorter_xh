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
        $phpVersion =  '7.4.0';
        $imgdir = $this->pluginFolder . 'images/';
        $ok = '<img src="' . $imgdir . 'ok.png" alt="ok">';
        $warn = '<img src="' . $imgdir . 'warn.png" alt="warning">';
        $fail = '<img src="' . $imgdir . 'fail.png" alt="failure">';
        $o = '<h1>Tablesorter ' . Plugin::VERSION . '</h1>'
            . '<h4>' . $this->view->text("syscheck_title") . '</h4>'
            . (version_compare(PHP_VERSION, $phpVersion) >= 0 ? $ok : $fail)
            . '&nbsp;&nbsp;'
            . $this->view->text("syscheck_phpversion", $phpVersion)
            . '<br><br>';
        foreach (array('config/', 'css/', 'languages/') as $folder) {
            $folders[] = $this->pluginFolder . $folder;
        }
        foreach ($folders as $folder) {
            $o .= (is_writable($folder) ? $ok : $warn)
                . '&nbsp;&nbsp;' . $this->view->text("syscheck_writable", $folder)
                . '<br>';
        }
        return $o;
    }
}
