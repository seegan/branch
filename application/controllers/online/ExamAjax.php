<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ExamAjax extends MY_Controller {

	private $action_val;

	public function __construct()
	{
    	parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->candidate_data = hasBranchAccess($this->config->item('branch_id'), $this->auth_user_id);
        
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


    private function activeTimeSubmit() {
        $user_id = $this->auth_user_id;
        $hash_code = $this->input->post('hash_code');
        $schedule_status = $this->input->post('schedule_status');
        $schedule_id = $this->input->post('schedule_id');
        $update_time = date("Y-m-d H:i:s", time() + 10);

        $time_to_finish = timeAvailToTakeExam($schedule_id, $user_id);
        $previous_data = getCandidatePreviousScheduledData($schedule_id, $user_id, $hash_code);
        $last_update_time = ( $previous_data && isset($previous_data->last_update)) ? $previous_data->last_update : date('Y-m-d H:i:s');
        $seconds_diff_from_last_update = strtotime($update_time) - strtotime($last_update_time);
        $previous_time_remain = $time_to_finish->time_remain;
        $remain_time = $previous_time_remain - $seconds_diff_from_last_update;

        if( $previous_data ) {

            if($remain_time > 0) {

                $schedule_data1 = array('last_update' => $update_time);
                $this->db->where( array('user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash_code));
                $this->db->update('xtra_candidate_attended_schedule', $schedule_data1);

                $schedule_data2 = array('taken_to' => $update_time);
                $this->db->where( array('user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash_code));
                $this->db->update('xtra_candidate_attended_data', $schedule_data2);

            }
        }

        die();
    }


	private function examDataSubmit() {

        $user_id = $this->auth_user_id;
        $hash_code = $this->input->post('hash_code');
        $schedule_status = $this->input->post('schedule_status');
        $schedule_id = $this->input->post('schedule_id');
        $update_time = date('Y-m-d H:i:s');

        $time_to_finish = timeAvailToTakeExam($schedule_id, $user_id);
        $exam_schedule_data = canTakeExam($schedule_id, $user_id, $update_time);
        $previous_data = getCandidatePreviousScheduledData($schedule_id, $user_id, $hash_code);

        $last_update_time = ( $previous_data && isset($previous_data->last_update)) ? $previous_data->last_update : date('Y-m-d H:i:s');
        $seconds_diff_from_last_update = strtotime($update_time) - strtotime($last_update_time);
        $previous_time_remain = $time_to_finish->time_remain;
        $remain_time = $previous_time_remain - $seconds_diff_from_last_update;

        if( $exam_schedule_data && $remain_time > 0 && $previous_data) {

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
                    $n_value['question_id'] = $question_id;
            		$updated_data[] = $n_value;
            	}
            }

            $schedule_data1 = array('schedule_status' => $schedule_status, 'answer_data' => serialize($updated_data), 'last_update' => $update_time);
    		$this->db->where( array('user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash_code));
    		$this->db->update('xtra_candidate_attended_schedule', $schedule_data1);

            $schedule_data2 = array('taken_to' => $update_time, 'schedule_status' => $schedule_status, 'answer_data' => serialize($updated_data));
    		$this->db->where( array('user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash_code));
    		$this->db->update('xtra_candidate_attended_data', $schedule_data2);

            die();
        }
	}


}