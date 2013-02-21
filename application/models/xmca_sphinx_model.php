<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require("sphinxapi.php");

class Xmca_sphinx_model extends CI_Model {

/*
4.1. Matching modes

SPH_MATCH_ALL, matches all query words (default mode);
SPH_MATCH_ANY, matches any of the query words;
SPH_MATCH_PHRASE, matches query as a phrase, requiring perfect match;
SPH_MATCH_BOOLEAN, matches query as a boolean expression (see Section 4.2, Boolean query syntax);
SPH_MATCH_EXTENDED, matches query as an expression in Sphinx internal query language (see Section 4.3, Extended query syntax).

*/
    function __construct()
    {
        parent::__construct();
        // Create Sphinx client
        $this->cl = new SphinxClient();
        $this->cl->SetServer("localhost", 9312);
        
        $this->load->model('Xmca_model', '', TRUE);

    }

    function searchMessageBodies($terms, $start=0, $matchMode='all', $startDate = -1, $endDate = -1){
        $mode = SPH_MATCH_ALL;
        switch($matchMode){
            case "all": $mode = SPH_MATCH_ALL; break;
            case "any": $mode = SPH_MATCH_ANY; break;
            case "phrase": $mode = SPH_MATCH_PHRASE; break;
            case "boolean": $mode = SPH_MATCH_BOOLEAN; break;
            case "extended": $mode = SPH_MATCH_EXTENDED; break;
            
        }

        if(-1 != $startDate || -1 != $endDate){
            $startDate = $startDate == -1 ? 0:$startDate;
            $endDate = $endDate     == -1 ? time():$endDate;
            
            $max = max($startDate, $endDate);
            $min = min($startDate, $endDate);
            $endDate = $max;
            $startDate = $min;
            
            $this->cl->setFilterRange('updated_at', $startDate, $endDate);
        }
        
        $this->cl->SetMatchMode($mode);
        $this->cl->setLimits($start, 20);
        return $this->cl->query($terms, "message_core");
    }
}