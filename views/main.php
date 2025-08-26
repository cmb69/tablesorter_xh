<?php

use Plib\View;

/**
 * @var View $this
 * @var string $script
 * @var array<string,mixed> $config
 */
?>

<script type="module" src="<?=$this->esc($script)?>" data-tablesorter-config='<?=$this->json($config)?>'></script>
