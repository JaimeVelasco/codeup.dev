<?php
class AddressDataStore {

    public $filename = '';

    function __construct($filename = 'Data/address_book.csv') {
    	$this->filename = $filename;
    }

    function read_address_book()
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

    function write_address_book($addresses_array) 
    {
        // Code to write $addresses_array to file $this->filename
        $handle = fopen($this->filename, "w+");
        foreach($addresses_array as $fields) {
        	fputcsv($handle, $fields);
        }
        fclose($handle);
    }

}

