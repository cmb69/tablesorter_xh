# Tablesorter_XH

Tablesorter_XH facilitates semi-automatic enhancement of tables in modern browsers.
Sorting by single columns in ascending and descending order, hiding of predefined
columns which can be expanded, and pagination are supported.  Furthermore, CSV files
can be displayed directly.

## Table of Contents

  - [Requirements](#requirements)
  - [Download](#download)
  - [Installation](#installation)
  - [Settings](#settings)
  - [Usage](#usage)
    - [Displaying CSV Files](#displaying-csv-files)
  - [Limitations](#limitations)
  - [Troubleshooting](#troubleshooting)
  - [License](#license)
  - [Credits](#credits)

## Requirements

Tablesorter_XH is a plugin for [CMSimple_XH](https://cmsimple-xh.org/).
It requires CMSimple_XH ≥ 1.7.0, and PHP ≥ 7.4.0.
Tablesorter_XH also requires [Plib_XH](https://github.com/cmb69/plib_xh) ≥ 1.11;
if that is not already installed (see *Settings*→*Info*),
get the [lastest release](https://github.com/cmb69/plib_xh/releases/latest),
and install it.

## Download

The [lastest release](https://github.com/cmb69/tablesorter_xh/releases/latest)
is available for download on Github.

## Installation

The installation is done as with many other CMSimple_XH plugins. See
the [CMSimple_XH
wiki](https://wiki.cmsimple-xh.org/doku.php/installation#plugins) for further
details.

1.  Backup the data on your server.
2.  Unzip the distribution on your computer.
3.  Upload the whole directory tablesorter/ to your server into
    CMSimple_XH's plugins directory.
4.  Set write permissions for the subdirectories config/, css/ and
    languages/.
5.  Switch to *Plugins*→*Tablesorter* in the back-end to check if all
    requirements are fulfilled.

## Settings

The plugin's configuration is done as with many other CMSimple_XH
plugins in the website's back-end. Select Plugins→Tablesorter.

You can change the default settings of Tablesorter_XH under *Config*.
Hints for the options will be displayed when hovering over the help icon
with your mouse.

Localization is done under *Language*. You can translate the character
strings to your own language if there is no appropriate language file
available, or customize them according to your needs.

The look of Tablesorter_XH can be customized under *Stylesheet*.

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

If you also assign the CSS class `tablesorter_columns` on the table,
users can select which columns are shown.

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

    {{{tablesorter()}}}

Alternatively, you can enable the *auto* option in the plugin
configuration.

### Displaying CSV Files

You can also display CSV files as sortable tables directly, instead of manually
embedding the data on your pages.  If you want to do this, put the CSV files
in your downloads folder (`userfiles/downloads/`), or a subfolder thereof.
Then embed them on a page with the following plugin call:

    {{{tablesorter_csv('%FILENAME%')}}}

For instace, to display `userfiles/downloads/subfolder/data.csv`, use

    {{{tablesorter_csv('subfolder/data.csv)}}}

The generated table will have the CSS classes `tablesorter` and `tablesorter_columns`;
further customization like for manually created tables is not supported.

## Limitations

Tablesorter_XH does not support “complex” table markup, e.g. colspans, rowspans,
table footers, etc.

## Troubleshooting

Report bugs and ask for support either on [Github](https://github.com/cmb69/tablesorter_xh/issues)
or in the [CMSimple_XH Forum](https://cmsimpleforum.com/).

## License

Tablesorter_XH is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Tablesorter_XH is distributed in the hope that it will be useful,
but *without any warranty*; without even the implied warranty of
*merchantibility* or *fitness for a particular purpose*. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Tablesorter_XH.  If not, see <http://www.gnu.org/licenses/>.

Copyright © Christoph M. Becker

## Credits

The plugin logo is designed by [New
Mooon](http://code.google.com/u/newmooon/). Many thanks for publishing
this icon under GPL.

Many thanks to the community at the [CMSimple_XH
forum](http://www.cmsimpleforum.com) for tips, suggestions and testing.
Particularly, I want to thank lck for helpful hints regarding the
design.

And last but not least many thanks to [Peter Harteg](http://harteg.dk/),
the father of CMSimple, and all developers of
[CMSimple_XH](http://www.cmsimple-xh.org) without whom this amazing CMS
wouldn't exist.
