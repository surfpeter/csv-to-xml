<?php

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('auto_detect_line_endings', 1);
	libxml_use_internal_errors(true);

function csv_to_xml($filename=' ', $delimiter=',')
{
	
	if(!file_exists($filename) || is_readable($filename))
		return FALSE;
	


	$inputFilename_dirty    = '$filename';
	//$inputFilename    =  str_replace("\r\n \r\n", "\r\n", $inputFilename_dirty);
	$inputFilename    =  str_replace("&#13;", "\r\n", $inputFilename_dirty);


	//$inputFilename    = 'uk-500.csv';
	$outputFilename   = 'exportedxml.xml';

	// Open csv to read
	$inputFile  = fopen($inputFilename, 'r');

	// Get the headers of the file
	$headers = fgetcsv($inputFile, 0,$delimiter);

	// Create a new dom document with pretty formatting
	//$doc  = new DomDocument("1.0", "ISO-8859-15");
	$doc  = new DomDocument("1.0", "utf-8");
	$doc->formatOutput = true;

	// Add a root node to the document
	$root = $doc->createElement('products');
	$root = $doc->appendChild($root);

	// Loop through each row creating a <row> node with the correct data
	/*
	for($r=0; $r < count($headers); $r++){
		echo "$headers[$r] <br>";
	}
	*/
	while (($product = fgetcsv($inputFile,0,$delimiter)) !== FALSE)
	{

	 $container = $doc->createElement('product');


	 foreach ($headers as $i => $header)
	 {
	 

	  $child = $doc->createElement($header);

	  $child = $container->appendChild($child);
	  $value = $doc->createTextNode($product[$i]);
	  $value = $child->appendChild($value);
	  
	 
	 }

	 $root->appendChild($container);
	}

	return $doc->saveXML();

		$handle = fopen($outputFilename, "w") or die("Unable to open file");
		fwrite($handle, $doc->saveXML());
		
	/*
		$xml = simplexml_load_string($doc->saveXML());
		if ($xml === false) {
		     echo "Failed loading XML: ";
		     foreach(libxml_get_errors() as $error) {
		         echo "<br>", $error->message;
		     }
		} else {
		     print_r($xml);
		}
		*/

		fclose($handle);
}

function test($text){
	reutrn $text;
}

 $a = test("test2");
 echo $a;

$data = csv_to_xml('export_all_products-prod_server.csv',';');
echo $data;

?>
