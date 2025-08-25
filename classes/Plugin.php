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

class Plugin
{
    const VERSION = '1.0';

    public function run()
    {
        global $plugin_cf;

        if ($plugin_cf['tablesorter']['auto']) {
            tablesorter();
        }
        if (defined('XH_ADM') && XH_ADM) {
            XH_registerStandardPluginMenuItems(false);
            if (XH_wantsPluginAdministration('tablesorter')) {
                $this->handleAdministration();
            }
        }
    }

    protected function handleAdministration()
    {
        global $admin, $action, $o;

        $o .= print_plugin_admin('off');
        switch ($admin) {
            case '':
                $o .= '<h1>Tablesorter ' . self::VERSION . '</h1>'
                    . $this->renderSystemCheck();
                break;
            default:
                $o .= plugin_admin_common($action, $admin, 'tablesorter');
        }
    }

    /**
     * @return string
     */
    protected function renderSystemCheck()
    {
        global $pth, $plugin_tx;
    
        $phpVersion =  '7.4.0';
        $ptx = $plugin_tx['tablesorter'];
        $imgdir = $pth['folder']['plugins'] . 'tablesorter/images/';
        $ok = '<img src="' . $imgdir . 'ok.png" alt="ok">';
        $warn = '<img src="' . $imgdir . 'warn.png" alt="warning">';
        $fail = '<img src="' . $imgdir . 'fail.png" alt="failure">';
        $o = '<h4>' . $ptx['syscheck_title'] . '</h4>'
            . (version_compare(PHP_VERSION, $phpVersion) >= 0 ? $ok : $fail)
            . '&nbsp;&nbsp;'
            . sprintf($ptx['syscheck_phpversion'], $phpVersion)
            . '<br><br>';
        foreach (array('config/', 'css/', 'languages/') as $folder) {
            $folders[] = $pth['folder']['plugins'] . 'tablesorter/' . $folder;
        }
        foreach ($folders as $folder) {
            $o .= (is_writable($folder) ? $ok : $warn)
                . '&nbsp;&nbsp;' . sprintf($ptx['syscheck_writable'], $folder)
                . '<br>';
        }
        return $o;
    }
}
