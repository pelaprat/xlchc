<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class json_rpc extends CI_Controller{

    function __construct(){
    
        parent::__construct();
        $this->load->helper('url');
    }

    function index(){
        $this->load->view("view_xmca/view_json_rpc", null);
    }


    function getPartnerProjectsSimple(){
    
        $this->load->model('partner_projects_model', '', TRUE);
        $data['ret'] = $this->partner_projects_model->getProjectsSimple()->result();
        $this->load->view("view_xmca/view_json_rpc", $data);
    }

    function getPartnerProjects(){
        $this->load->model('partner_projects_model', '', TRUE);
        $data['ret'] = $this->partner_projects_model->getProjects()->result();
        $this->load->view("view_xmca/view_json_rpc", $data);
    }
    

    function getPartnerProjectData($id){
        $this->load->model('partner_projects_model', '', TRUE);
        $data['ret'] = $this->partner_projects_model->getProjectData($id)->result();
        $this->load->view("view_xmca/view_json_rpc", $data);
    }
    
    function getRandomSpotlight(){
    
        $this->load->model('spotlight_model', '', TRUE);
        $data['ret'] = $this->spotlight_model->getRandomSpotlight();
        $data['doHTMLEntityDecode'] = true;
        $this->load->view("view_xmca/view_json_rpc", $data);
        
    }
    
    function getAllSpotlights(){
    
        $this->load->model('spotlight_model', '', TRUE);
        $data['ret'] = $this->spotlight_model->getAllSpotlights();
        $data['doHTMLEntityDecode'] = true;
        $this->load->view("view_xmca/view_json_rpc", $data);   
    }
    
    function getSpotlight($id){
        $this->load->model('spotlight_model', '', TRUE);
        $data['ret'] = $this->spotlight_model->getSpotlight($id);
        $data['doHTMLEntityDecode'] = true;
        $this->load->view("view_xmca/view_json_rpc", $data);           
    }
    
    function getTableData(){
        //echo current_url();
        $this->load->view("phprestsql/index.php");
        
    }
    
    function getThreadsTimeLine(){
    
        $this->load->model('xmca_model', '', TRUE);
        $data['ret'] = array('dateTimeFormat'=>'iso8601', 'events'=>$this->xmca_model->getThreadsTimelineJSON());
        $this->load->view("view_xmca/view_json_rpc", $data);
    }
    
    function getSearchThreadsTimeLine(){

        $words = isset($_GET['words']) ? preg_replace('/%20|\+/', ' ', $_GET['words']) : "";
        $words = preg_replace('/[^a-zA-Z 0-9]/', '', $words);
        $words = trim($words);
        
        $index_start = isset($_GET['index_start']) ? 1*$_GET['index_start']:0;
        $mode = isset($_GET['mode']) ? $_GET['mode']:"any";
        $startDateInt = isset($_GET['startDateInt']) ? $_GET['startDateInt']:-1;
        $endDateInt = isset($_GET['endDateInt']) ? $_GET['endDateInt']:-1;
    
        $this->load->model('Xmca_sphinx_model', '', TRUE);
        $this->load->model('Xmca_model', '', TRUE);
        
        $xmcaModel = $this->Xmca_model;
        $sphinxModel = $this->Xmca_sphinx_model;
        
        ///The following function allows the view to echo out the data without overly burdening
        ///memory usage or mysql
        
        $echoJSON = function() use (&$xmcaModel, &$sphinxModel, &$words, &$index_start, &$mode, &$startDateInt, &$endDateInt){

            echo '{"dateTimeFormat":"iso8601","events":[';
            $threads = $sphinxModel->searchMessageBodies($words, $index_start, $mode, $startDateInt, $endDateInt);
            
            while(isset($threads['matches'])){
            
                $str = json_encode($xmcaModel->getThreadsTimelineJSON(array_keys($threads['matches'])));
                $str = substr($str, 1, strlen($str) - 2) . ",";
                $index_start += count($threads['matches']);
                
                $threads = $sphinxModel->searchMessageBodies($words, $index_start, $mode, $startDateInt, $endDateInt);
                
                if(isset($threads['matches'])){
                    echo $str;
                }
                else{
                    echo substr($str, 0, -1);
                }
            }
            echo "]}";
        }; 
        
        $data['echoJSON'] = $echoJSON;
        $data['xmcatimeline'] = true;
        
        $this->load->view("view_xmca/view_json_rpc", $data);
    
    }
    
    function debugStuff(){

        $this->load->model('Xmca_sphinx_model', '', TRUE);
        $this->load->model('Xmca_model', '', TRUE);

        $index_start = 0;
        $threads = $this->Xmca_sphinx_model->searchMessageBodies("vygotsky", $index_start, "any");
        
        $hiId = -1;
        $data['ret'] = array();
        
        $count = 1;
        
        while(isset($threads['matches'])){
        
            $tkeys = array_keys($threads['matches']);
            echo "<br>-----" . count($tkeys) . "<br>";
            foreach($tkeys as $key){
                $t = $this->Xmca_model->getThreadsTimelineJSON(array($key));
                $t = $t[0];
                echo ($count . "|" . $t->title . ", " . $t->start . ", " . $t->description . "<br>");
                $count += 1;
            }
            $index_start += 20;
            $threads = $this->Xmca_sphinx_model->searchMessageBodies("vygotsky", $index_start, "any");
        }
        
        //$t = $this->Xmca_model->getThread($hiId);
       // $data['ret'] = ($t->name . ", at " . $t->created_at . ", updated at " . $t->updated_at);

                        
        $this->load->view("view_xmca/view_json_rpc", $data);   
    }

}


?>