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

class Main
{
    /** @var View */
    private $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function __invoke(): void
    {
        global $bjs, $pth;
        static $again = false;

        if ($again) {
            return;
        }
        $again = true;
        $bjs .= $this->view->render("main", [
            "script" => "{$pth['folder']['plugins']}tablesorter/tablesorter.min.js",
            "config" => $this->config(),
        ]);
    }

    /** @return array<string,mixed> */
    private function config(): array
    {
        global $plugin_cf, $plugin_tx;
        $pcf = $plugin_cf['tablesorter'];
        $ptx = $plugin_tx['tablesorter'];
        return [
            'sortable' => (bool) $pcf['sortable'],
            'maxPages' => (int) $pcf['pagination_max'],
            'show' => $ptx['label_show'],
            'hide' => $ptx['label_hide']
        ];
    }
}
