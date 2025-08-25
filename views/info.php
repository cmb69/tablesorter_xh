<?php

use Plib\View;

/**
 * @var View $this
 * @var string $version
 * @var array<string> $checks
 */
?>

<h1>Tablesorter <?=$this->esc($version)?></h1>
<h4><?=$this->text("syscheck_title")?></h4>
<?foreach ($checks as $check):?>
<?=$this->raw($check)?>
<?endforeach?>
