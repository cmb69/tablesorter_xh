<?php

/**
 * Front-end of Tablesorter_XH.
 *
 * PHP version 4 and 5
 *
 * @category  CMSimple_XH
 * @package   Tablesorter
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2012-2015 Christoph M. Becker <http://3-magi.net/>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Tablesorter_XH
 */

if (!defined('CMSIMPLE_XH_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * The plugin version.
 */
define('TABLESORTER_VERSION', '1beta1');

/**
 * Makes all <table class="sortable"> sortable.
 *
 * @return void
 *
 * @global string The (X)HTML fragment to insert into the head element.
 * @global array  The paths of system files and folders.
 * @global array  The configuration of the plugins.
 *
 * @staticvar bool $again Whether the function has already been executed.
 */
function tablesorter()
{
    global $hjs, $pth, $plugin_cf;
    static $again = false;

    if ($again) {
        return;
    }
    $again = true;
    $pcf = $plugin_cf['tablesorter'];

    include_once $pth['folder']['plugins'] . 'jquery/jquery.inc.php';
    include_jQuery();
    include_jQueryPlugin(
        'tablesorter',
        $pth['folder']['plugins']
        . 'tablesorter/tablesorter/js/jquery.tablesorter.js'
    );
    $theme = $pcf['theme'];
    $filename = $pth['folder']['plugins'] . 'tablesorter/tablesorter/css/theme.'
        . $pcf['theme'] . '.css';
    if (!is_readable($filename)) {
        $theme = 'default';
        $filename = $pth['folder']['plugins']
            . 'tablesorter/tablesorter/css/theme.default.css';
    }
    $widgets = $pcf['zebra'] ? ', widgets: ["zebra"]' : '';
    $hjs .= tag('link rel="stylesheet" href="' . $filename . '" type="text/css"')
        . '<script type="text/javascript">/* <![CDATA[ */jQuery(function()'
        . ' {jQuery("table.sortable").tablesorter({theme: "' . $theme
        . '", sortLocaleCompare: true' . $widgets . '})})/* ]]> */</script>';
}

/*
 * Handle auto mode.
 */
if ($plugin_cf['tablesorter']['auto']) {
    Tablesorter();
}

?>
