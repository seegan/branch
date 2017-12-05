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

	function instruction($exam_id = 0, $instruction_id = 1) {
		$data['candidate_data'] = $this->candidate_data;
		$data['current_exams'] = getBatchCurrentExams($this->candidate_data->batch_id, date('Y-m-d H:i:s'));

		$page_content = $this->load->view('exam/instruction/instruction', $data, TRUE);

		echo $this->load->view('exam/common/header', $data, TRUE);
		echo $page_content;
		echo $this->load->view('exam/common/footer', '', TRUE);
	}

	function schedule(){
		$data['candidate_data'] = $this->candidate_data;
		$data['current_exams'] = getBatchCurrentExams($this->candidate_data->batch_id, date('Y-m-d H:i:s'));

		$page_content = $this->load->view('exam/schedule/schedule', $data, TRUE);
		$left_sidebar = $this->load->view('exam/common/left_sidebar', '', TRUE);
		$right_sidebar = $this->load->view('exam/common/right_sidebar', '', TRUE);

		echo $this->load->view('exam/common/header', $data, TRUE);
		echo $left_sidebar;
		echo $page_content;
		echo $right_sidebar;
		echo $this->load->view('exam/common/footer', '', TRUE);
	}


}