<?php

use Plib\View;

/**
 * @var View $this
 * @var string $script
 * @var array<string,mixed> $config
 */
?>

<script type="module" src="<?=$this->esc($script)?>"></script>
<meta name="tablesorter_config" content='<?=$this->json($config)?>'>
