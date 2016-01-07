﻿<?php
	class catalogue {
		public $key; //A file name extension to specify the catalogue represented
		public $database; //Name of the database under localhost, which contains the data in MySQL format.
		public $base; //The string to be put before the image number of a digitized catalogue page
		public $heading;
		public $title;
		public $place;
		public $printer;
		public $year;
		public $copy = array('institution' => '', 'shelfmark' => ''); //The copy used for the reconstruction of the catalogue
	}
	
	class item	{ //Refers to an item (book, manuscript, etc.) listed in the catalogue
			public $id;
			public $pageCat; //Page in the catalogue where the item was found
			public $imageCat; //Image number of the page in the digitized catalogue
			public $numberCat; //Number of the item as found in catalogue
			public $itemInVolume = 0; //If the item is part of a volume, the number indicates its position, otherwise it is 0.
			public $work = array('title' => '', 'system' => '', 'id' => ''); //Entry for the work in a public database.
			public $quality;
			public $titleCat; //The title as found in the catalogue
			public $titleBib;	//The title as copied from a bibliographic database (cf. $manifestation)
			public $persons = array(); //Objects of the class person
			public $places = array(); //Objects of the class place
			public $publisher;
			public $year;
			public $format;
			public $histSubject;
			public $subject;
			public $genre;
			public $mediaType; //Book, Manuscript, Physical Object, etc.
			public $language = array(); //One or more language codes according to ISO 639.2
			public $manifestation = array('system' => '', 'id' => ''); //Entry in a bibliographic database or library catalogue
			public $originalItem =  array('institution' => '', 'shelfmark' => '', 'provenanceAttribute' => '', 'digitalCopy' => '');			
			public $bound = 1;
			public $comment;
			public $digitalCopy;
		}
		
	class person {
		public $name;
		public $gnd;
		public $role; //author, contributor, etc.
		public $beacon = array(); //Presence in databases is denoted by keys from class beaconData
	}
		
	class place {
		public $name;
		public $getty;
		public $geoData = array('lat' => '', 'long' => '');
	}

	class section { //A list of items with a title to be displayed as a chapter of a web page
		public $label;
		public $level = 1;
		public $authority = array('system' => '', 'id' => ''); //An authority which describes the content of the section, especially a persons's GND identifier, cf. class indexEntry
		public $content = array(); //Objects of the class item
	}
		
	class indexEntry {
		public $label;
		public $type;
		public $authority = array('system' => '', 'id' => ''); //An authority which describes the content of the index entry, especially a persons's GND identifier, cf. class section
		public $geoData = array('lat' => '', 'long' => ''); //For if the entry corresponds to a place
		public $content = array(); //Indices from an array which contains objects of the class item
	}
	
	class beaconData { //A collection of extracts from BEACON files, based on the set of authors present in the catalogue
		public $date;
		public $content = array(); //Objects of the class beaconExtract
	}
	
	class beaconExtract { //A collection of GND identifiers extracted from a certain BEACON file 
		public $label;
		public $key; //An index from the associative array $beaconSources
		public $target;
		public $content = array(); //The GND identifiers
	}	
	
?>	
