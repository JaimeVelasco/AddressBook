<?php

class Filestore {

    public $filename = '';

    public $is_csv = FALSE;

    public function __construct($filename = ''){ 
        $this->filename = $filename;
        if (substr($filename, -3) == 'csv') {
            $this->is_csv = TRUE;
        }
    }


    public function read(){
        if ($this->is_csv == TRUE) {
            return $this->read_csv();
        } else {
            return $this->read_lines();
        }
    }

    public function save($contents) {
        if ($this->is_csv == TRUE) {
            $this->write_csv($contents);
        } else {
            $this->write_lines($contents);
        }
    }





    /**
     * Returns array of lines in $this->filename
     */
    private function read_lines(){
        $handle = fopen($this->filename, "r");
        $size = filesize($this->filename);
        $contents = fread($handle, $size);

        fclose($handle);
        return explode("\n", $contents);
    }       
    

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    private function write_lines($array){
        $handle = fopen($this->filename, "w");
        $item = implode("\n", $array);
        fwrite($handle, $item);
        fclose($handle);
    }




    /**
     * Reads contents of csv $this->filename, returns an array
     */
    private function read_csv(){
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
     * //Writes contents of $array to csv $this->filename
     */
    private function write_csv($array){
         // Code to write $addresses_array to file $this->filename
        $handle = fopen($this->filename, "w");
        foreach($array as $fields) {
            fputcsv($handle, $fields);
        }
        fclose($handle);
    }

    
}
