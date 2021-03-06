# LibReTo: Hinweise für Anwender und Entwickler

*Stand: 14.03.2018*
*Autor: Hartmut Beyer (beyer@hab.de)*

## Anforderungen
Die Anwendung erfordert einen Server mit PHP (getestet mit Version 7.1.1) und schreibenden Zugriff auf Dateien und Ordner innerhalb des Programmordners.

## Installation
Kopieren Sie alle Dateien in einen Ordner auf dem Server.
Benennen Sie die Datei **settings.php.template** um in **settings.php** und tragen Sie darin die folgenden Angaben ein:
- Unter `$userGeoNames` der Login Ihres Accounts bei geoNames (http://www.geonames.org/login)
- Unter `$userAgentHTTP` Ihren Namen in beliebiger Form
- Unter `$impressum` die URL des Impressums, das für die Publikation der Seite gültig ist
Rufen Sie **load.php** im Browser auf und folgen Sie den Anweisungen des Programms

## Funktionsweise des Programms

### Allgemeine Ressourcen

- **classDefinition.php**: Enthält gebündelt alle Objektdefinitionen (ausgenommen die für Geodaten und externe Referenzen, vgl. **class_geoDataArchive.php** und **class_reference.php**). Die Klasse *catalogue* enthält Metadaten zur Sammlung. Die Klasse *item* bündelt die Daten für die bibliographischen Metadaten, hinzu kommen *person* und *place* für die vorkommenden Personen und Orte. Die Klasse *section* definiert Listen von Einträgen mit Überschrift.
- **encode.php**: Funktionen, die sich mit dem Übersetzen und Umformen von Texten und anderen Strings befassen.
- **auxiliaryFunctions.php**: Allgemeine Hilfsfunktionen
- **fieldList.php**: Verwaltung der Felder und Facetten, legt u. a. fest, welche Felder in welcher Form visualisiert werden können
- **beaconSources.php**: Die Liste der ausgewerteten BEACON-Dateien
- **class_geoDataArchive**  und **class_geoDataArchiveEntry**: Dienen der Sammlung und Zwischenspeicherung von Geodaten zu den verwendeten Publikationsorten.
- **class_reference**: Zum Bilden von externen Links auf bibliographische Nachweissysteme, die auf Erfassungsebene mit einer Sigle wie "GND" und dem dazugehörigen Identifier bezeichnet sind


### Ablauf

#### Laden der Daten
Die Datei **load.php** lädt die Daten im CSV-, XML oder MODS-Format. Die Daten werden als serialisierte Objekte in einer Datei unter `upload/files` zwischengespeichert.
Verwendete Dateien und Funktionen:
- Datei **loadCSV.php**
    - validateCSV()
	- loadCSV()
- Datei **loadXML.php**
    - validateXML()
	- loadXML()
	- transformMODS()
- Datei **makeCSV.php**
    - makeCSV()
- Datei **encode.php**
    - makeUploadName()

#### Aufnahme von Metadaten
Die Datei **annotate.php** enthält ein Formular zur Aufnahme von Metadaten zur Sammlung und zum Altkatalog. Diese werden in der Variable `$_SESSION` als Objekt der Klasse *catalogue* gespeichert. Dann wird unter user ein projektspezifischer Ordner angelegt und in diesem die Rohdaten in CSV, XML und TEI gespeichert. 
Verwendete Dateien und Funktionen:
- Datei **makeXML.php**
    - saveXML()
- Datei **makeCSV.php**
    - makeCSV()
- Datei **makeTEI.php**
    - makeTEI()

#### Anreichern mit Geodaten
Die Datei **geodata.php** reichert die Ortsdaten (die in jedem *item* unter `$places` abgespeichert sind) mit Geodaten an. Bei Einträgen, die bereits einen Identifier (geoNames oder GND) haben, werden zunächst die bereits erhobenen Daten unter `geoDataArchive` durchsucht. Ist der Identifier dort nicht vorhanden, werden die Daten aus dem Netz geladen. Orte ohne Identifier werden in einem Formular angezeigt, wo diese nachgetragen werden können.
Verwendete Dateien und Funktionen:
- Datei **geodata.php**
    - makeGeoDataForm()
	- makeGeoDataFormRow()
	- addPostedDataToArchive()
- Datei **class_GeoDataArchive.php**
- Datei **class_geoDataArchiveEntry**
	
#### Datenexport in den GeoBrowser
Die Datei **geoBrowser.php** erstellt die Dateien **printingPlaces.kml** und **printingPlaces.csv** im Projektordner, die sich für den Upload in den DARIAH GeoBrowser eignen. Nach erfolgtem manuellem Upload muss die Storage ID des Datensets eingegeben werden.
Verwendete Dateien und Funktionen:
- Datei **makeGeoDataSheet.php**
    - makeGeoDataSheet()
- Datei **makePage.php**
    - makeGeoBrowserLink()

#### Anreicherung mit biographischen Links, RDF-Export
Die Datei **beacon.php** lädt und durchsucht BEACON-Dateien auf Vorkommen der erfassten GND-Nummern für Personen. Danach werden die Daten nach RDF exportiert und in RDF/XML und Turtle im Projektordner abgespeichert
Verwendete Dateien und Funktionen:
- Datei **storeBeacon.php**
    - cacheBeacon()
	- storeBeacon()
	- addBeacon()
- Datei **makeRDF.php**
    - saveRDF()
	
#### Feldauswahl
Die Datei **select.php** erlaubt es dem Benutzer, Felder für die Darstellung als eigene Seite, Wortwolke oder Kreisdiagramm auszuwählen. Anschließend werden sämtliche Dateien generiert und im Projektordner abgespeichert.
Verwendete Dateien und Funktionen:
- Datei **select.php**
    - makeSelectForm()
	- insertFacetsToCatalogue()
	- makeStartPage()
	- zipFolderContent()
- Datei **addToSolr.php**
    - makeSOLRArray()
	- addMetaDataSOLR()
	- saveSOLRXML()
- Datei **makeSection.php**
    - makeSections()
	- joinVolumes()
	- makeList() - ruft **templates/list.phtml** auf
- Datei **makeNavigation.php**
    - makeToC()
- Datei **makePage.php**
    - makePage() - ruft **templates/page.phtml** auf
- Datei **encode.php**
    - fileNameTrans()
- Datei **makeCloudList.php**
    - makeCloudPageContent()
- Datei **makeDoughnutList.php**
    - makeDoughnutPageContent()
