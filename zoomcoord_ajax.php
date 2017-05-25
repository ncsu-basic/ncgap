<?php
/**
 * porcesses x,y coordinates to change projection from plane to lat/lon
 * 
 * To convert to geographic coordinates, save x,y to csv file. Next, load vrt file into simplexml, and run 
 * ogr2ogr with csv data and output as GML. Use xpath to get x,y in new projection.
 * 
 * @package ncgap
 */
//get data
require('nc_config.php');
$proj = $_POST['projection'];
$x= $_POST['user_x'];
$y = $_POST['user_y'];

//if state plane return
if ($proj == "plane") {
	echo json_encode(array("x"=>$x, "y"=>$y)); die();
}

//create layer name, file name of input csv file
$csvlayer = "zoomdata".rand(1000,9999);
$csvfilename = "{$mspath}{$csvlayer}.csv";

//create input csv file
$fp = fopen("$csvfilename", "w");
$csvfile[] = "x,y";
$csvfile[] = "{$x},{$y}";
foreach ($csvfile as $line){
	fputcsv($fp, explode(",", $line));
}
fclose($fp );

//load vrt file and update values, remove first line of xml file
$xml1 = simplexml_load_file("grass/geocs.vrt");
$xml1->OGRVRTLayer[0]->SrcDataSource = $csvfilename;
$xml1->OGRVRTLayer[0]->SrcLayer = $csvlayer;
$xml1str = $xml1->asXML();
$xml1str = trim(strstr($xml1str,"\n"));

//create ogr command and run
$xmlfilename = "xml".rand(1000,9999);
$ogrcmd1 = "/usr/local/bin/ogr2ogr -f \"GML\" -t_srs \"epsg:32119\" {$mspath}{$xmlfilename}   '{$xml1str}'";
//echo $ogrcmd1; die();
system($ogrcmd1);

//load gml file and get coords as array
$xml2 = simplexml_load_file("{$mspath}{$xmlfilename}");
$val = $xml2->xpath('/ogr:FeatureCollection/gml:featureMember/ogr:zoom/ogr:geometryProperty/gml:Point/gml:coordinates');
$planecoords = explode(",", $val[0]);
echo json_encode(array("x"=>$planecoords[0], "y"=>$planecoords[1]));
?>