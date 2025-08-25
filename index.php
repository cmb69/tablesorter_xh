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

function tablesorter(): void
{
    global $bjs, $pth, $plugin_cf, $plugin_tx;
    static $again = false;

    if ($again) {
        return;
    }
    $again = true;
    $pcf = $plugin_cf['tablesorter'];
    $ptx = $plugin_tx['tablesorter'];
    $config = array(
        'sortable' => (bool) $pcf['sortable'],
        'maxPages' => (int) $pcf['pagination_max'],
        'show' => $ptx['label_show'],
        'hide' => $ptx['label_hide']
    );
    $json = json_encode($config);
    $bjs .= <<<HTML
<script>var TABLESORTER = $json;</script>
<script async src="{$pth['folder']['plugins']}tablesorter/tablesorter.min.js"></script>
HTML;
}

(new Tablesorter\Plugin())->run();
