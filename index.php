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

// phpcs:disable PSR1.Files.SideEffects

use Plib\Request;
use Tablesorter\Plugin;

/**
 * @var string $o
 * @var array<string,array<string,string>> $plugin_cf
 */

if ($plugin_cf['tablesorter']['auto']) {
    $o .= Plugin::makeMain()(Request::current())();
}

function tablesorter(): string
{
    return Plugin::makeMain()(Request::current())();
}
