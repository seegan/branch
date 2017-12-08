<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ExamAjax extends MY_Controller {

	private $action_val;

	public function __construct()
	{
    	parent::__construct();
		$this->load->helper('url');
        if(!$this->input->is_ajax_request() || !$this->input->post('action')) {
            die('You are not Allowed To Access This Page!!');
        }
	}

	public function index() {
		$this->action_val = ( $this->input->post('action') ) ? $this->input->post('action') : $this->input->get('action')  ;
		$function = $this->action_val;
		echo $this->$function();
		die();
	}

	private function examDataSubmit() {

		$navigator_data = array();
        parse_str($this->input->post('navigator_data'), $navigator_data);

		$board_data = array();
        parse_str($this->input->post('board_data'), $board_data);


        $ans_data = ( isset($board_data['single_option']) && is_array($board_data['single_option']) && count($board_data['single_option']) ) ? $board_data['single_option'] : false; 

        $updated_data = [];
        if(isset($navigator_data['question_status']) && is_array($navigator_data['question_status']) && count($navigator_data['question_status'])) {
        	foreach ($navigator_data['question_status'] as $question_id => $n_value) {
        		$ans = ( $ans_data && isset($ans_data[$question_id]) ) ? $ans_data[$question_id] : 0;
        		$n_value['candidate_answer'] = $ans;
        		$updated_data[] = $n_value;
        	}
        }





echo "<pre>";
var_dump($updated_data);

		die();
	}


}