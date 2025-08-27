<?php

use Plib\View;

/**
 * @var View $this
 * @var array<string> $headers
 * @var array<array<string>> $rows
 */
?>

<table class="tablesorter tablesorter_columns">
  <thead>
    <tr>
<?foreach ($headers as $header):?>
      <th><?=$this->esc($header)?></th>
<?endforeach?>
   </tr>
  </thead>
  <tbody>
<?foreach ($rows as $row):?>
    <tr>
<?  foreach ($row as $cell):?>
      <td><?=$this->esc($cell)?></td>
<?  endforeach?>
    </tr>
<?endforeach?>
  </tbody>
</table>
