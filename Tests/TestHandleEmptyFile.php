<?php
include_once('csv-combiner.php');
$inputFiles = explode(" ", './fixtures/emptyFile.csv');
$C1 = new Combiner($inputFiles);
$C1->outputFiles();
?>