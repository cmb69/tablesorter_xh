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

class Plugin
{
    const VERSION = '1.0';

    public static function makeMain(): Main
    {
        return new Main();
    }

    public static function makePluginInfo(): PluginInfo
    {
        global $pth, $plugin_tx;
        return new PluginInfo(
            $pth["folder"]["plugins"] . "tablesorter/",
            new View($pth["folder"]["plugins"] . "tablesorter/views/", $plugin_tx["tablesorter"])
        );
    }
}
