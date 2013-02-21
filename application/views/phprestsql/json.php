<?php

/**
 * PHP REST SQL plain text renderer class
 * This class renders the REST response data as plain text.
 */
class PHPRestSQLRenderer {
   
    /**
     * @var PHPRestSQL PHPRestSQL
     */
    var $PHPRestSQL;
   
    /**
     * Constructor. Takes an output array and calls the appropriate handler.
     * @param PHPRestSQL PHPRestSQL
     */
    function render($PHPRestSQL) {
        $this->PHPRestSQL = $PHPRestSQL;
        switch($PHPRestSQL->display) {
            case 'database':
                $this->database();
                break;
            case 'table':
                $this->table();
                break;
            case 'row':
                $this->row();
                break;
        }
    }

    
    /**
     * Output the top level table listing.
     */
    function database() {
        header('Content-Type: application/json');
        if (isset($this->PHPRestSQL->output['database'])) {
            $str = '{"tables":[' . "\n";
            foreach ($this->PHPRestSQL->output['database'] as $table) {
                $str .= '"' . $table['value'] . '"' . ",\n";
            }
            $str = substr($str, 0, -2);
            $str .= ']}';
            echo $str;
        }
    }
    
    /**
     * Output the rows within a table.
     */
    function table() {
        header('Content-Type: text/plain');
        if (isset($this->PHPRestSQL->output['table'])) {
            $str = '{"ids":[' . "\n";
            foreach ($this->PHPRestSQL->output['table'] as $row) {
                $str .= $row['value'] . ",\n";
            }
            $str = substr($str, 0, -2);
            $str .= ']}';
            echo $str;
        }
    }
    
    /**
     * Output the entry in a table row.
     */
    function row() {
        header('Content-Type: text/plain');
        if (isset($this->PHPRestSQL->output['row'])) {
            $str = "{\n";
            foreach ($this->PHPRestSQL->output['row'] as $field) {
                $str .= '"' . $field['field'] . '":' . json_encode($field['value']) . ",\n";
            }
            $str = substr($str, 0, -2);
            $str .= '}';
            echo $str;
        }
    }

}
