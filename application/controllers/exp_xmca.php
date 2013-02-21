<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exp_Xmca extends CI_Controller{

    function __construct(){
    
        parent::__construct();
        $this->load->helper('url');
        
    }


    function index(){
    
        $data['body_id'] = "xmca";
        $data['body_content_class'] = 'inside_content';
        $simplehtml = (isset($_GET['simplehtml']) && "true" == $_GET['simplehtml']);
        $data['simplehtml'] = $simplehtml;
    
        $this->load->view(($simplehtml ? "view_xmca/view_simple_header" : "view_xmca/view_header"), $data);
        $this->load->view("view_xmca/view_xmca_top");
    
        $data['getMessage'] = function($id){return Xmca_model::staticGetMessage($id);};
        $data['getTotalThreads'] = function(){return Xmca_model::staticGetTotalThreadActivityResults();};
        $data['getThreadMessages'] = function($threadId){return Xmca_model::staticGetThreadMessages($threadId);};
    
        $this->load->model('Xmca_sphinx_model', '', TRUE);
        $this->load->model('Xmca_model', '', TRUE);
        
        //index_start is used for both searching, and simply paging through recent threads.  Only the 
        //presence of "words" in the url parameters distinguishes between these two uses.
        $data['words'] = isset($_GET['words']) ? preg_replace('/%20|\+/', ' ', $_GET['words']) : "";
        $data['words'] = preg_replace('/[^a-zA-Z 0-9]/', '', $data['words']);
        $data['words'] = trim($data['words']);
        
        $data['index_start'] = isset($_GET['index_start']) ? 1*$_GET['index_start']:0;
        $data['mode'] = isset($_GET['mode']) ? $_GET['mode']:"any";
        $data['date_start'] = isset($_GET['date_start']) ? $_GET['date_start']:"";
        $data['date_end'] = isset($_GET['date_end']) ? $_GET['date_end']:"";
        
        $data['threadId'] = isset($_GET['threadId']) ? $_GET['threadId']:"";        
        
        if("" != $data['threadId']){
            $this->load->view("view_xmca/view_xmca_single_thread", $data);            
        }
        else if("" === $data['words']){
            ///If not searching for anything, just display the latest thread activity (20 rows)
            $data['recent_threads'] = $this->Xmca_model->getRecentThreadActivity($data['index_start'], 30);
            $this->load->view("view_xmca/view_xmca_threads", $data);
        }
        else{                        
            $startDateInt = -1;
            $endDateInt = -1;
            
            try {$startDateInt = strtotime($data['date_start']);} catch (Exception $e) {}
            try {$endDateInt = strtotime($data['date_end']);} catch (Exception $e) {}
            
            $startDateInt = $startDateInt ? $startDateInt:-1;
            $endDateInt = $endDateInt ? $endDateInt:-1;

            
            if(isset($_GET['submit_timeline'])){
                $data['startDateInt'] = $startDateInt;
                $data['endDateInt'] = $endDateInt;
                $data['startTimeLineDate'] = "1995-01-01T00:00:00";
                $data['endTimeLineDate'] = "2012-01-01T00:00:00";
                $this->load->view("view_xmca/view_xmca_timeline", $data);
            }
            else{
                $data['xmca_search'] = $this->Xmca_sphinx_model->searchMessageBodies($data['words'],
                                                                                     $data['index_start'],
                                                                                     $data['mode'], 
                                                                                     $startDateInt, 
                                                                                     $endDateInt);
                $this->load->view("view_xmca/view_xmca_search", $data);
            }
        }
        
        $this->load->view("view_xmca/view_xmca_bottom", $data);
        $this->load->view(($simplehtml ? "view_xmca/view_simple_footer" : "view_xmca/view_footer"), $data);
        
    }
    
    function timeline(){
    
        $data['body_id'] = "xmca";
        $data['body_content_class'] = 'inside_content';
        $simplehtml = (isset($_GET['simplehtml']) && "true" == $_GET['simplehtml']);
        $data['simplehtml'] = $simplehtml;
        $this->load->view(($simplehtml ? "view_xmca/view_simple_header" : "view_xmca/view_header"), $data);
        $this->load->view("view_xmca/view_xmca_top");
        $this->load->view("view_xmca/view_xmca_timeline");
        $this->load->view("view_xmca/view_xmca_bottom", $data);
        $this->load->view(($simplehtml ? "view_xmca/view_simple_footer" : "view_xmca/view_footer"), $data);        
        
    }
    
}
?>
