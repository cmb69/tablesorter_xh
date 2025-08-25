# Tablesorter\_XH

Tablesorter\_XH facilitates semi-automatic enhancement of tables in
browsers which support somewhat contemporary JavaScript. Sorting by
single columns in ascending and descending order, hiding of predefined
columns which can be expanded, and pagination are supported.

## Table of Contents

  - [Requirements](#requirements)
  - [Download](#download)
  - [Installation](#installation)
  - [Settings](#settings)
  - [Usage](#usage)
  - [Troubleshooting](#troubleshooting)
  - [License](#license)
  - [Credits](#credits)

## Requirements

Tablesorter\_XH is a plugin for CMSimple\_XH ≥ 1.7.0. It requires PHP ≥
7.4.0.

## Download

The [lastest release](https://github.com/cmb69/tablesorter_xh/releases/latest)
is available for download on Github.

## Installation

The installation is done as with many other CMSimple\_XH plugins. See
the [CMSimple\_XH
wiki](https://wiki.cmsimple-xh.org/doku.php/installation#plugins) for further
details.

1.  Backup the data on your server.
2.  Unzip the distribution on your computer.
3.  Upload the whole directory tablesorter/ to your server into
    CMSimple\_XH's plugins directory.
4.  Set write permissions for the subdirectories config/, css/ and
    languages/.
5.  Switch to *Plugins*→*Tablesorter* in the back-end to check if all
    requirements are fulfilled.

## Settings

The plugin's configuration is done as with many other CMSimple\_XH
plugins in the website's back-end. Select Plugins→Tablesorter.

You can change the default settings of Tablesorter\_XH under *Config*.
Hints for the options will be displayed when hovering over the help icon
with your mouse.

Localization is done under *Language*. You can translate the character
strings to your own language if there is no appropriate language file
available, or customize them according to your needs.

The look of Tablesorter\_XH can be customized under *Stylesheet*.

## Usage

To turn a table into an enhanced table, you have to give it the CSS
class `tablesorter`. Furthermore it is mandatory that the table has a
`<thead>` with `<th>` cells and a `<tbody>` section.

To make wide tables better viewable, you can select less important
columns which will not be shown, but the visitor will be able to expand
each row to view the hidden column contents. To mark a column as hidden,
just add the CSS class `tablesorter_hide` to the respective `<th>`.
Alternatively, you can add the CSS class `tablesorter_x_small`,
`tablesorter_small`, `tablesorter_medium` and `tablesorter_large`,
respectively, to hide the column in inappropriate viewports. For
instance, `tablesorter_medium` will show the column in medium and large
viewports, but will hide it in small viewports.

The sorting of the rows works by case-insensitive string comparison
according to the browser's locale. This does not work well for numeric
columns, so it is possible to mark a numeric column as such by adding
the CSS class `tablesorter_numeric` to the column's `<th>`. Note that
thousands separators are not supported, and that only dots (`.`) are
supported as decimal separator. Sorting arbitrary dates and/or times is
also unsupported; if you need this, just use ISO 8601 date/time formats,
such as `2017-03-15` and `08:12` in which case string comparison works
fine.

To actually enable the table enhancements, you have to add the following
plugin call somewhere on the page:

    {{{tablesorter();}}}

Alternatively, you can enable the *auto* option in the plugin
configuration.

## Troubleshooting

Report bugs and ask for support either on [Github](https://github.com/cmb69/tablesorter_xh/issues)
or in the [CMSimple_XH Forum](https://cmsimpleforum.com/).

## License

Tablesorter\_XH is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Tablesorter\_XH is distributed in the hope that it will be useful,
but *without any warranty*; without even the implied warranty of
*merchantibility* or *fitness for a particular purpose*. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Tablesorter\_XH.  If not, see <http://www.gnu.org/licenses/>.

Copyright © 2012-2019 Christoph M. Becker

## Credits

The plugin logo is designed by [New
Mooon](http://code.google.com/u/newmooon/). Many thanks for publishing
this icon under GPL.

This plugin uses free applications icons from
[Aha-Soft](http://www.aha-soft.com/). Many thanks for making these icons
freely available.

Many thanks to the community at the [CMSimple\_XH
forum](http://www.cmsimpleforum.com) for tips, suggestions and testing.
Particularly, I want to thank lck for helpful hints regarding the
design.

And last but not least many thanks to [Peter Harteg](http://harteg.dk/),
the father of CMSimple, and all developers of
[CMSimple\_XH](http://www.cmsimple-xh.org) without whom this amazing CMS
wouldn't exist.
