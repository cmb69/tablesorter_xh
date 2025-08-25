# Tablesorter_XH

Tablesorter_XH ermöglicht die halbautomatische Verbesserung von
Tabellen in Browsern, die einigermaßen zeitgemäßes JavaScript
unterstützen. Sortieren nach einzelnen Spalten in auf- und absteigender
Reihenfolge, verstecken vordefinierter Spalten, die erweitert werden
können, sowie Paginierung sind möglich.

## Inhaltsverzeichnis

  - [Voraussetzungen](#voraussetzungen)
  - [Download](#download)
  - [Installation](#installation)
  - [Einstellungen](#einstellungen)
  - [Verwendung](#verwendung)
  - [Fehlerbehebung](#fehlerbehebung)
  - [Lizenz](#lizenz)
  - [Danksagung](#danksagung)

## Voraussetzungen

Tablesorter_XH ist ein Plugin für CMSimple_XH ≥ 1.7.0. Es benötigt PHP ≥
7.4.0 mit der JSON Extension.

## Download

Das [aktuelle Release](https://github.com/cmb69/tablesorter_xh/releases/latest)
kann von Github herunter geladen werden.

## Installation

Die Installation erfolgt wie bei vielen anderen CMSimple_XH-Plugins
auch. Im
[CMSimple_XH-Wiki](https://wiki.cmsimple-xh.org/doku.php/de:installation#plugins)
sind weitere Details zu finden.

1.  Sichern Sie die Daten auf Ihrem Server.
2.  Entpacken Sie die ZIP-Datei auf Ihrem Rechner.
3.  Laden Sie das ganze Verzeichnis tablesorter/ auf Ihren Server in
    CMSimple_XHs Plugin-Verzeichnis hoch.
4.  Machen Sie die Unterverzeichnisse config/, css/ und languages/
    beschreibbar.
5.  Gehen Sie im Administrationsbereich zu *Plugins*→*Tablesorter* , um
    zu prüfen ob alle Voraussetzungen erfüllt sind.

## Einstellungen

Die Plugin-Konfiguration erfolgt wie bei vielen anderen
CMSimple_XH-Plugins auch im Administrationsbereich der Website. Wählen
Sie *Plugins*→*Tablesorter*.

Sie können die Voreinstellungen von Tablesorter_XH unter
*Konfiguration* ändern. Hinweise zu den Optionen werden beim Überfahren
der Hilfe-Icons mit der Maus angezeigt.

Die Lokalisierung wird unter *Sprache* vorgenommen. Sie können die
Sprachtexte in Ihre eigene Sprache übersetzen, falls keine entsprechende
Sprachdatei zur Verfügung steht, oder diese Ihren Wünschen gemäß
anpassen.

Das Aussehen von Tablesorter_XH kann unter *Stylesheet* angepasst
werden.

## Verwendung

Um eine Tabelle in eine verbesserte Tabelle zu wandeln, muss ihr die
CSS-Klasse `tablesorter` gegeben werden. Weiterhin ist es erforderlich,
dass die Tabelle einen `<thead>` Abschnitt mit `<th>` Zellen, und einen
`<tbody>` Abschnitt hat.

Um breite Tabellen besser lesbar zu gestalten, können weniger wichtige
Spalten ausgewählt werden, die nicht gezeigt werden; allerdings wird der
Besucher in der Lage sein, jede Zeile zu erweitern, um den Inhalt der
versteckten Spalten einzusehen. Um eine Spalte als versteckt zu
markieren, muss das entsprechende `<th>` die CSS-Klasse
`tablesorter_hide` erhalten. Alternativ können auch die CSS-Klassen
`tablesorter_x_small`, `tablesorter_small`, `tablesorter_medium` oder
`tablesorter_large` verwendet werden, um die Spalte in unpassenden
Viewports auszublenden. Beispielsweise wird `tablesorter_medium` die
Spalte in mittleren und großen Viewports anzeigen, sie aber in schmalen
Viewports ausblenden.

Die Sortierung der Zeilen erfolgt gemäß des Zeichenkettenvergleichs
unter Berücksichtung der im Browser gültigen Regionaleinstellungen;
Groß-/Kleinschreibung spielt dabei keine Rolle. Dies liefert bei
numerischen Spalten falsche Resultate, so dass es möglich ist,
numerische Spalten als solche auszuzeichnen indem dem zugehöhrigen
`<th>` die CSS-Klasse `tablesorter_numeric` zugewiesen wird. Es ist zu
beachten, dass Tausendertrennzeichen nicht unterstützt werden, und dass
nur Punkte (`.`) als Dezimaltrennzeichen erlaubt sind. Das Sortieren von
beliebigen Datums- und/oder Zeitangaben wird ebenfalls nicht
unterstützt; wird dies benötigt, sollten ISO 8601 Datums-/Zeitformate
wie `2017-03-15` und `08:12` verwendet werden, für die
Zeichenkettenvergleiche wie gewünscht funktionieren.

Um die Tabellenverbesserungen wirklich zu aktivieren, muss der folgende
Pluginaufruf irgendwo auf der Seite eingefügt werden:

    {{{tablesorter();}}}

Alternative kann die *auto* Option in der Pluginkonfiguration aktiviert
werden.

## Fehlerbehebung

Melden Sie Programmfehler und stellen Sie Supportanfragen entweder auf
[Github](https://github.com/cmb69/tablesorter_xh/issues) oder im
[CMSimple_XH Forum](https://cmsimpleforum.com/).

## Lizenz

Tablesorter_XH ist freie Software. Sie können es unter den Bedingungen der
GNU General Public License, wie von der Free Software Foundation
veröffentlicht, weitergeben und/oder modifizieren, entweder gemäß
Version 3 der Lizenz oder (nach Ihrer Option) jeder späteren Version.

Die Veröffentlichung von Tablesorter_XH erfolgt in der Hoffnung, daß es
Ihnen von Nutzen sein wird, aber ohne irgendeine Garantie, sogar ohne
die implizite Garantie der Marktreife oder der Verwendbarkeit für einen
bestimmten Zweck. Details finden Sie in der GNU General Public License.

Sie sollten ein Exemplar der GNU General Public License zusammen mit
Tablesorter_XH erhalten haben. Falls nicht, siehe
http://www.gnu.org/licenses/.

Copyright © 2012-2019 Christoph M. Becker

## Danksagung

Das Pluginlogo wurde von [New Mooon](http://code.google.com/u/newmooon/)
gestaltet. Vielen Dank für die Veröffentlichung unter GPL.

Diese Plugin verwendet Free-Application-Icons von
[Aha-Soft](http://www.aha-soft.com/). Vielen Dank für die freie
Bereitstellung dieser Icons.

Vielen Dank an die Community im [CMSimple_XH
Forum](http://www.cmsimpleforum.com/) für Hinweise, Anregungen und das
Testen. Besonders möchte ich lck für hilfreiche Tipps bezüglich der
Gestaltung danken.

Und zu guter letzt vielen Dank an [Peter Harteg](http://www.harteg.dk/),
den "Vater" von CMSimple, und allen Entwicklern von
[CMSimple_XH](http://www.cmsimple-xh.org/de/) ohne die es dieses
phantastische CMS nicht gäbe.
