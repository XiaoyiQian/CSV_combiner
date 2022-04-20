<?php
/**
 * Merge multiple CSV files into one master CSV file 
 * Remove header line from individual file
 * Given that all the files are going to have the same numner of columns 
 */
class Combiner {
// Properties
  public $inputFiles;
  public $newCol = "filename";
  public $saveHeader = true;

// Methods
  function __construct($inputFiles) {
    $this->inputFiles = $inputFiles;
  }

// printRow prints the given row of csv data and prints that out in the csv format
  function printRow($numOfCols, $row, $data){

    for($c = 0; $c < $numOfCols; $c++) {
        if($row == 0 && !$this->saveHeader){
            continue;
        }
        echo $data[$c];
        echo ",";
        // create a new line aftr the last col of current row
        if($c == $numOfCols - 1){
            echo "\n";
        }
    }
  }

//   read and print out a given file
  function printFile($filehandler, $fileName)
  {
    $row = 0;
    while (($dataValue = fgetcsv($filehandler, 1000)) !== false) {
        $newColnum = count($dataValue) + 1;
        $data = $dataValue;
        if($row == 0){
            $data = array_merge($dataValue, array($this->newCol));
        } else{
            $data = array_merge($dataValue, array(substr($fileName, 11)));
        }
        
        $this->printRow($newColnum, $row, $data);
    
        $row++;
    }
  }
// output all the given files into the given output file
  function outputFiles(){
    //   iterate through all the provided files
    foreach($this->inputFiles as $file) {
        // all the files needs to have extention csv
        if (strpos($file, '.csv') !== false) {
            // Open and Read individual CSV file
            $handle = fopen($file, 'r');
            if($handle == false){
              echo 'given file is invalid';
            }else{
              if ($handle !== false) {
                $row = 0;
                $this->printFile($handle, $file);
              }
              // Close individual CSV file 
              fclose($handle); 
            }
    
        } else {
            echo "[$file] is not a CSV file.";
        }

        // set it to false so only the first file's hearder would be printed in the output file
        $this->saveHeader = false;
    
    }
  }
}



$inputFiles = [];
for($i = 1; $i < count($argv); $i++){
    $inputFiles[] = $argv[$i];
}

// create an new object
$combiner = new Combiner($inputFiles);
$combiner->outputFiles();

?>
