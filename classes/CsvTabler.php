<?php

/**
 * Copyright (c) Christoph M. Becker
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

use Plib\Response;
use Plib\View;

class CsvTabler
{
    /** @var string */
    private $downloadFolder;

    /** @var View */
    private $view;

    public function __construct(string $downloadFolder, View $view)
    {
        $this->downloadFolder = $downloadFolder;
        $this->view = $view;
    }

    public function __invoke(string $filename): Response
    {
        $data = $this->readData($this->downloadFolder . $filename);
        if ($data === null) {
            return Response::create($this->view->message("fail", "error_not_found", $filename));
        }
        $headers = array_shift($data);
        return Response::create($this->view->render("table", [
            "headers" => $headers,
            "rows" => $data,
        ]));
    }

    /** @return ?array<array<string>> */
    private function readData(string $filename): ?array
    {
        $stream = @fopen($filename, "r");
        if (!$stream) {
            return null;
        }
        $separator = $this->separator($stream);
        $res = [];
        while (($record = fgetcsv($stream, 0, $separator, '"', "\0"))) {
            if ($this->validateRecord($record)) {
                $res[] = $record;
            }
        }
        return $res;
    }

    /** @param resource $stream */
    private function separator($stream): string
    {
        $line = fgets($stream) ?: "";
        rewind($stream);
        return substr_count($line, ",") >= substr_count($line, "\t") ? "," : "\t";
    }

    /**
     * @param ?list<?string> $record
     * @phpstan-assert-if-true list<string> $record
     */
    private function validateRecord(?array $record): bool
    {
        if ($record === null) {
            return false;
        }
        foreach ($record as $field) {
            if (!is_string($field)) {
                return false;
            }
        }
        return true;
    }
}
