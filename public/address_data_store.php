<?php
require_once 'File_store.php';


class AddressDataStore extends Filestore{

public $filename = '';


    public function __construct($filename = '') {
     }    
        parent::__construct(strtolower($filename));
    
}

