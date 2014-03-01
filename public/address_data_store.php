<?php
require_once 'File_store.php';
class AddressDataStore extends Filestore{

    public $filename = '';

    function __construct($filename = '') {
       $this->filename = $filename;
    }
   
        // specific for adddress that extends this
    

}



