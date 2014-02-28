<?php

class Filestore {

    public $filename = '';

    function __construct($filename = '') 
    {
        // Sets 
        $this->filename=$filename;
    }

    /**
     * Returns array of lines in $this->filename
     */
    function read_lines(){
        $handle = fopen($this->filename, "r");
                $contents = fread($handle, filesize($filename));
                fclose($handle);
                return explode("\n", $contents);
    }       
    

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    function write_lines($array){
         $handle = fopen($this->filename, "w");
            $item = implode("\n", $items);
            fwrite($handle, $item);
            fclose($handle);
    }




    /**
     * Reads contents of csv $this->filename, returns an array
     */
    function read_csv()
    {
        // Code to read file $this->filename
        $handle = fopen($this->filename, "r");
        if (filesize($this->filename) == 0) {
            $contents = [];
        } else {
            while (!feof($handle)) {
                $contents[] = fgetcsv($handle);
            }
            foreach ($contents as $key => $value) {
                if ($value == false) {
                    unset($contents[$key]);
                }
            }
        }
        fclose($handle);
        return $contents;
    }

    

    /**
     * Writes contents of $array to csv $this->filename
     */
    function write_csv($array)
    {
         // Code to write $addresses_array to file $this->filename
        $handle = fopen($this->filename, "w+");
        foreach($array as $fields) {
            fputcsv($handle, $fields);
        }
        fclose($handle);
    }

    
}
