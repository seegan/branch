<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Exam extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');

		$this->candidate_data = hasBranchAccess($this->config->item('branch_id'), $this->auth_user_id);
	}

	function instruction($schedule_id = 0, $instruction_id = 1) {
		$data['candidate_data'] = $this->candidate_data;
		$data['current_exams'] = getBatchCurrentExams($this->candidate_data->batch_id, date('Y-m-d H:i:s'));

		if( $schedule_data = canTakeExam($schedule_id, $this->auth_user_id, date('Y-m-d H:i:s')) ) {
			$page_content = $this->load->view('exam/instruction/instruction', $data, TRUE);
		} else {
			$page_content = 'Not Available';
		}
		echo $this->load->view('exam/common/header', $data, TRUE);
		echo $page_content;
		echo $this->load->view('exam/common/footer', '', TRUE);
	}

	function schedule($schedule_id = 0){
		$data['candidate_data'] = $this->candidate_data;

		$page_content = 'Not Available';

		$time_to_finish = timeAvailToTakeExam($schedule_id, $this->auth_user_id);
		$exam_schedule_data = canTakeExam($schedule_id, $this->auth_user_id, date('Y-m-d H:i:s'));


		if( $exam_schedule_data && $time_to_finish && $time_to_finish->time_remain > 0  ) {

			$data['schedule_data'] = $exam_schedule_data;
			$exam_id = ( isset($exam_schedule_data->exam_id) && $exam_schedule_data->exam_id ) ? $exam_schedule_data->exam_id : 0;

			$data['hash_code'] = setCandidateAttendSchedule($schedule_id, $this->auth_user_id, date('Y-m-d H:i:s'));
			$data['time_remain'] = $time_to_finish->time_remain;
			$data['questions'] = getExamQuestions($exam_id);
			$data['attended_data'] = getCandidateQuestionData($schedule_id, $this->auth_user_id, $data['hash_code']);

			list($hour, $min, $sec) = explode(":", gmdate("H:i:s", $data['time_remain'])); 
			$data['final_foot'] = "<script type='text/javascript'>var questions =".json_encode($data['questions'])."; var candidate_data=".json_encode($data['attended_data'])."; var time_remain = {hour:".$hour.",min:".$min.",sec:".$sec."}</script>";


			$page_content = $this->load->view('exam/schedule/schedule', $data, TRUE);
		} else {


			if( !$exam_schedule_data ) {
				$redirect       = base_url('online/exam/info').'/'.$schedule_id;
            	redirect($redirect);
			} else {
            	$redirect       = base_url('online/exam/result').'/'.$schedule_id;
            	redirect($redirect);	
			}
		}

		$left_sidebar = $this->load->view('exam/common/left_sidebar', $data, TRUE);
		$right_sidebar = $this->load->view('exam/common/right_sidebar', '', TRUE);

		echo $this->load->view('exam/common/header', $data, TRUE);
		echo $left_sidebar;
		echo $page_content;
		echo $right_sidebar;
		echo $this->load->view('exam/common/footer', $data, TRUE);
	}


	function result($schedule_id = 0){
		
		$current_time = date('Y-m-d H:i:s');

		$data['main_content'] = 'Exam Not Avail!';
		$data['info_box'] = false;
		$data['result_box'] = false;

		if( $data['schedule_data'] = getScheduleDetail($schedule_id) ) {
			$schedule_to = $data['schedule_data']->schedule_to;
			
			$data['main_content'] = 'Exam Not Avail To You!';


			if( scheduleAvailToCandidate($schedule_id, $this->auth_user_id, $schedule_to) ) {
				
				$data['info_box'] = 'partial';
				$data['main_content'] = 'Can Not Publish Result Now! Please Try Later';


				if( canSchedulePublishResult($schedule_id, $current_time) ) {

					$data['info_box'] = 'partial';
					$data['main_content'] = 'Please Submit Your Test To See Result!';


					if( !timeAvailToTakeExam($schedule_id, $this->auth_user_id) ) {

						$data['info_box'] = 'full';
						$data['main_content'] = 'Here is Your Result!';
						$data['result_box'] = true;


					}
				}


				$data['info_data'] = getScheduleCandidateData($schedule_id, $this->auth_user_id);
			}
		}

		$page_content = $this->load->view('exam/result/result', $data, TRUE);

		$left_sidebar = $this->load->view('candidate/common/left_sidebar', '', TRUE);
		$right_sidebar = $this->load->view('candidate/common/right_sidebar', '', TRUE);

		echo $this->load->view('candidate/common/header', $data, TRUE);
		echo $left_sidebar;
		echo $page_content;
		echo $right_sidebar;
		echo $this->load->view('candidate/common/footer', '', TRUE);

	}


	function info($schedule_id = 0){
		var_dump("info");
	}

}