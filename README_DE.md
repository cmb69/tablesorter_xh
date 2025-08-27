# Tablesorter_XH

Tablesorter_XH ermöglicht die halbautomatische Verbesserung von Tabellen in
modernen Browsern. Sortieren nach einzelnen Spalten in auf- und absteigender
Reihenfolge, verstecken vordefinierter Spalten, die erweitert werden
können, sowie Paginierung sind möglich. Weiterhin können CSV-Dateien direkt
dargestellt werden.

## Inhaltsverzeichnis

  - [Voraussetzungen](#voraussetzungen)
  - [Download](#download)
  - [Installation](#installation)
  - [Einstellungen](#einstellungen)
  - [Verwendung](#verwendung)
    - [Anzeigen von CSV-Dateien](#anzeigen-von-csv-dateien)
  - [Fehlerbehebung](#fehlerbehebung)
  - [Lizenz](#lizenz)
  - [Danksagung](#danksagung)

## Voraussetzungen

Tablesorter_XH ist ein Plugin für [CMSimple_XH](https://cmsimple-xh.org/de/).
Es benötigt CMSimple_XH ≥ 1.7.0 und PHP ≥ 7.4.0.
Tablesorter_XH benötigt weiterhin [Plib_XH](https://github.com/cmb69/plib_xh) ≥ 1.11;
ist dieses noch nicht installiert (see *Einstellungen*→*Info*),
laden Sie das [aktuelle Release](https://github.com/cmb69/plib_xh/releases/latest)
herunter, und installieren Sie es.

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

Wird der Tabelle ebenfalls die CSS-Klasse `tablesorter_columns` zugewiesen,
können Nutzer selbst auswählen, welche Spalten angezeigt werden.

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

    {{{tablesorter()}}}

Alternativ kann die *auto* Option in der Pluginkonfiguration aktiviert
werden.

### Anzeigen von CSV-Dateien

Es ist ebenfalls möglich CSV-Dateien direkt als sortierbare Tabellen anzuzeigen,
anstatt die Daten manuell auf den Seiten einzubinden. Dazu müssen die CSV-Dateien
in den Downloads-Ordner (`userfiles/downloads/`) oder einen Unterordner von diesem
hoch geladen werden. Dann können sie auf einer Seite mit dem folgenden Pluginaufruf
eingebettet werden:

    {{{tablesorter_csv('%DATEINAME%')}}}

Um beispielsweise `userfiles/downloads/unterordner/daten.csv` anzuzeigen, schreibt
man

    {{{tablesorter_csv('unterordner/daten.csv)}}}

Die erzeugte Tabelle hat die CSS-Klassen `tablesorter` und `tablesorter_columns`;
weitere Anpassung wie bei manuell erzeugten Tabellen werden nicht unterstützt.

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

Copyright © Christoph M. Becker

## Danksagung

Das Pluginlogo wurde von [New Mooon](http://code.google.com/u/newmooon/)
gestaltet. Vielen Dank für die Veröffentlichung unter GPL.

Vielen Dank an die Community im [CMSimple_XH
Forum](http://www.cmsimpleforum.com/) für Hinweise, Anregungen und das
Testen. Besonders möchte ich lck für hilfreiche Tipps bezüglich der
Gestaltung danken.

Und zu guter letzt vielen Dank an [Peter Harteg](http://www.harteg.dk/),
den "Vater" von CMSimple, und allen Entwicklern von
[CMSimple_XH](http://www.cmsimple-xh.org/de/) ohne die es dieses
phantastische CMS nicht gäbe.
