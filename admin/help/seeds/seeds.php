<?php

$codegen_seeds=array(
	'listview'=>array('name'=>'Base Record','desc'=>'A base record can be directly created by the user','icon'=>'base'),
	'subrecord'=>array('name'=>'Sub Record','desc'=>'A sub record has a detail view and a side list that is subordinate to a base record;<br>it can only be created within the context of a base record','icon'=>'sub'),
	'directlist'=>array('name'=>'Direct List','desc'=>'A direct list allows 1-N editing within a master view<br>without opening another tab or bridging to another base- or sub-record','icon'=>'direct'),
	'bridgelist'=>array('name'=>'Record Bridge','desc'=>'A record bridge connects the side list in a base record to another base record.<br>Record Bridge is an advanced case of Direct List','icon'=>'bridge'),
	'lookup'=>array('name'=>'Lookup List','desc'=>'Any field in a record can be linked to another entity.<br>The Lookup List ensures the proper ID resolution.','icon'=>'lookup'),
	'report'=>array('name'=>'Date-Range Report','desc'=>'','icon'=>''),
	'break1'=>array('type'=>'break'),
	'profile'=>array('name'=>'1-1 Image Uploader','desc'=>'','icon'=>''),
	'album'=>array('name'=>'1-N Image Uploader','desc'=>'','icon'=>''),
	'uploader'=>array('name'=>'1-N File Uploader','desc'=>'A file uploader uses a data table to assign unique IDs to each upload;<br>The files will be renamed to have a generic extension.','icon'=>'upload'),
	'break2'=>array('type'=>'break'),
	'tinymce'=>array('name'=>'Rich Text Editor','desc'=>'','icon'=>''),
	'sortlists'=>array('name'=>'Drag & Drop Sort List','icon'=>'','package'=>1,
		'items'=>array(
			'sortlist'=>array('name'=>'List View','desc'=>'','icon'=>''),
			'dsortlist'=>array('name'=>'Direct List (1-N)','desc'=>'','icon'=>'')
		)
	),
	
	'fnav'=>array('name'=>'Faceted navigation','icon'=>'','package'=>1,
		'items'=>array(
			'gnav'=>array('name'=>'Frontend - Standard','desc'=>'Classic front-end faceted navigation','icon'=>''),
			'gnavi'=>array('name'=>'Frontend - Multicore','desc'=>'High-performance front-end navigation; specific server hardware and setup required','icon'=>''),
			'navfilter'=>array('name'=>'Gyroscope Backend','desc'=>'Faceted navigation for list view. Make a standard list view first','icon'=>'')
		)
	),
	'asyncd'=>array('name'=>'AsyncD','desc'=>'The Distributed Asynchronous Data Processor forks a long-running process in the background while updating the web frontend its completion process.','icon'=>''),
	'digisign'=>array('name'=>'Digital Signing','desc'=>'','icon'=>'')

);