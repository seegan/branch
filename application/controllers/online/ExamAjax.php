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

    private function candidate_image() {
        $data['success']       = false;

        $user_id = $this->auth_user_id;
        $schedule_id = $this->input->post('schedule_id');
        $hash_code = $this->input->post('hash_code');
        $img = $this->input->post('file');

        $config['upload_path']          = './uploads/onlinecandidate/';
        //$config['allowed_types']        = 'xlsx|xls';
        $config['allowed_types']        = '*';
        $config['max_size']             = 5120;

        $this->load->library('upload', $config);


        if (preg_match('/^data:image\/(\w+);base64,/', $img, $type)) {
            $img = substr($img, strpos($img, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
               $data['success']       = false;
               echo json_encode($data);
               die(); 
            }

            $img = base64_decode($img);

            if ($img === false) {
                $data['success']       = false;
                echo json_encode($data);
                die();
            }
        } else {
            $data['success']       = false;
            echo json_encode($data);
            die();
        }



        $temp_file_path = tempnam(sys_get_temp_dir(), 'xtr');
        file_put_contents($temp_file_path, $img);
        $image_info = getimagesize($temp_file_path); 


        $_FILES['userfile'] = array(
            'name' => uniqid().'.'.preg_replace('!\w+/!', '', $image_info['mime']),
            'tmp_name' => $temp_file_path,
            'size'  => filesize($temp_file_path),
            'error' => UPLOAD_ERR_OK,
            'type'  => $image_info['mime'],
        );


        if ( !$this->upload->do_upload('userfile', true)) {

            $data['error'] = $this->upload->display_errors();
            $data['success'] = false;
        } else {
            $file_data = $this->upload->data();
            $data['upload_name'] = $file_data['file_name'];
            if( $upload_id = createCandidateImageDatabase($schedule_id, $this->auth_user_id, $data['upload_name'], $hash_code )) {
                $data['success'] = true;
                $data['upload_id'] = $upload_id;
            }
        }

        echo json_encode($data);
        die();
    }

    private function activeTimeSubmit() {

        $data['page_action']    = '';
        $data['redirect']       = false;
        $data['window_close']   = false;

        $user_id = $this->auth_user_id;
        $hash_code = $this->input->post('hash_code');
        $schedule_status = $this->input->post('schedule_status');
        $schedule_id = $this->input->post('schedule_id');
        $update_time = date("Y-m-d H:i:s", time() + 10);

        $time_to_finish = timeAvailToTakeExam($schedule_id, $user_id);
        $previous_data = getCandidatePreviousScheduledData($schedule_id, $user_id, $hash_code);
        $last_update_time = ( $previous_data && isset($previous_data->last_update)) ? $previous_data->last_update : date('Y-m-d H:i:s');
        $seconds_diff_from_last_update = strtotime($update_time) - strtotime($last_update_time);
        $previous_time_remain = ($time_to_finish) ? $time_to_finish->time_remain : 0;
        $remain_time = $previous_time_remain - $seconds_diff_from_last_update;

        if( $previous_data ) {

                $schedule_data1 = array('last_update' => $update_time);
                $this->db->where( array('user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash_code));
                $this->db->update('xtra_candidate_attended_schedule', $schedule_data1);

                $schedule_data2 = array('taken_to' => $update_time);
                $this->db->where( array('user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash_code));
                $this->db->update('xtra_candidate_attended_data', $schedule_data2);

            if($remain_time < 0) {

                $submit_update = array('schedule_status' => 'submit', );
                $this->db->where( array('user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash_code));
                $this->db->update('xtra_candidate_attended_schedule', $submit_update);

                $data['page_action']    = 'Time Out!';
                $data['redirect']       = base_url('online/exam/result').'/'.$schedule_id;
            }
        } else {
            $data['page_action'] = 'No Previous Data Found!';
            $data['redirect']       = base_url('online/exam/info').'/'.$schedule_id;            
        }

        return json_encode($data);
    }


	private function examDataSubmit() {

        $schedule_action =  ( $this->input->post('schedule_action') && $this->input->post('schedule_action')!= '' ) ? $this->input->post('schedule_action') : 'stay';

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

        $previous_time_remain = ($time_to_finish) ? $time_to_finish->time_remain : 0;
        $remain_time = $previous_time_remain - $seconds_diff_from_last_update;

        $data['page_action']    = 'stay';
        $data['redirect']       = false;
        $data['window_close']   = false;

        if( $exam_schedule_data && $previous_data && $remain_time > 0) {

    		$navigator_data = array();
            parse_str($this->input->post('navigator_data'), $navigator_data);

    		$board_data = array();
            parse_str($this->input->post('board_data'), $board_data);


            $ans_data = ( isset($board_data['single_option']) && is_array($board_data['single_option']) && count($board_data['single_option']) ) ? $board_data['single_option'] : false; 


            $updated_data = [];
            if(isset($navigator_data['question_status']) && is_array($navigator_data['question_status']) && count($navigator_data['question_status'])) {


                $question_ids = implode(",", array_keys($navigator_data['question_status']));
                $answers = combainQuestionAnswers($question_ids);

                $positive_mark = 0;
                $negative_mark = 0;

            	foreach ($navigator_data['question_status'] as $question_id => $n_value) {
            		$ans = ( $ans_data && isset($ans_data[$question_id]) ) ? $ans_data[$question_id] : 0;
            		$n_value['candidate_answer'] = $ans;
                    $n_value['question_id'] = $question_id;


                    if( $n_value['attend_status'] == 'answered' ) {
                        if($ans == $answers[$question_id]['answer_option']) {
                            $positive_mark += $answers[$question_id]['right_mark'];
                        } else {
                            $negative_mark += $answers[$question_id]['negative_mark'];
                        }
                    }

            		$updated_data[] = $n_value;
            	}
            }
            $total_mark = ($positive_mark - $negative_mark);


            $schedule_data1 = array('positive_marks' => $positive_mark, 'negative_marks'=> $negative_mark, 'total_marks'=> $total_mark, 'schedule_status' => $schedule_status, 'answer_data' => json_encode($updated_data), 'last_update' => $update_time);
    		$this->db->where( array('user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash_code));
    		$this->db->update('xtra_candidate_attended_schedule', $schedule_data1);

            $schedule_data2 = array('taken_to' => $update_time, 'schedule_status' => $schedule_status, 'answer_data' => json_encode($updated_data));
    		$this->db->where( array('user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash_code));
    		$this->db->update('xtra_candidate_attended_data', $schedule_data2);


            if( $schedule_action == 'submit' ) {
                
                $submit_update = array('schedule_status' => 'submit', );
                $this->db->where( array('user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash_code));
                $this->db->update('xtra_candidate_attended_schedule', $submit_update);

                $data['page_action'] = 'Exam Data Saved And Exam Submitted!!';
                $data['redirect']       = base_url('online/exam/result').'/'.$schedule_id;

            } else if( $schedule_action == 'continue_later' ) {
                $data['page_action'] = 'Exam Data Saved!';
                $data['window_close']   = true;
            } else {
                $data['page_action'] = 'Exam Data Saved!';
            }

        } else {

            if(!$exam_schedule_data) {

                $data['page_action'] = 'You Are Not Allowed To Take This Exam!';
                $data['redirect']       = base_url('online/exam/info').'/'.$schedule_id;

            } else if (!$previous_data) {

                $data['page_action'] = 'No Previous Data Found!';
                $data['redirect']       = base_url('online/exam/info').'/'.$schedule_id;

            } else {

                $submit_update = array('schedule_status' => 'submit', );
                $this->db->where( array('user_id' => $user_id, 'schedule_id' => $schedule_id, 'schedule_hash' => $hash_code));
                $this->db->update('xtra_candidate_attended_schedule', $submit_update);

                $data['page_action']    = 'Time Out!';
                $data['redirect']       = base_url('online/exam/result').'/'.$schedule_id;
            }
        }

        return json_encode($data);
	}


}