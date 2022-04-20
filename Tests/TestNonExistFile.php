<?php
include_once('csv-combiner.php');
$inputFiles = explode(" ", './household_cleaners.csv');
$C1 = new Combiner($inputFiles);
$C1->outputFiles();
?>