<?php

/**
 * Copyright Christoph M. Becker
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

use Plib\Request;
use Plib\Response;
use Plib\View;

class Main
{
    /** @var string */
    private $pluginFolder;

    /** @var array<string,string> */
    private $config;

    /** @var View */
    private $view;

    /** @param array<string,string> $config */
    public function __construct(
        string $pluginFolder,
        array $config,
        View $view
    ) {
        $this->pluginFolder = $pluginFolder;
        $this->config = $config;
        $this->view = $view;
    }

    public function __invoke(Request $request): Response
    {
        return Response::create()->withBjs($this->view->render("main", [
            "script" => $request->url()->path($this->script())->with("v", Plugin::VERSION)->relative(),
            "config" => $this->config($request),
        ]));
    }

    private function script(): string
    {
        if (is_file($this->pluginFolder . "tablesorter.min.js")) {
            return $this->pluginFolder . "tablesorter.min.js";
        }
        return $this->pluginFolder . "tablesorter.js";
    }

    /** @return array<string,mixed> */
    private function config(Request $request): array
    {
        return [
            "sortable" => (bool) $this->config["sortable"],
            "maxPages" => (int) $this->config["pagination_max"],
            "widthLarge" => (int) $this->config["width_large"],
            "widthMedium" => (int) $this->config["width_medium"],
            "widthSmall" => (int) $this->config["width_small"],
            "widthXSmall" => (int) $this->config["width_x_small"],
            "locale" => $request->language(),
            "columns" => $this->view->plain("label_columns"),
            "show" => $this->view->plain("label_show"),
            "hide" => $this->view->plain("label_hide"),
        ];
    }
}
