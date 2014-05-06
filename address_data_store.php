<?php
require_once 'file_store.php';


class AddressDataStore extends Filestore{

public $filename = '';


    public function __construct($filename = '') {
     }    
        parent::__construct(strtolower($filename));
    
}

