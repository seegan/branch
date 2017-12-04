<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');

		$this->candidate_data = hasBranchAccess($this->config->item('branch_id'), $this->auth_user_id);
	}

	public function index() {

		$data['candidate_data'] = $this->candidate_data;

var_dump($this->candidate_data);

		$page_content = $this->load->view('candidate/dashboard/dashboard', $data, TRUE);
		$left_sidebar = $this->load->view('candidate/common/left_sidebar', '', TRUE);
		$right_sidebar = $this->load->view('candidate/common/right_sidebar', '', TRUE);

		echo $this->load->view('candidate/common/header', $data, TRUE);
		echo $left_sidebar;
		echo $page_content;
		echo $right_sidebar;
		echo $this->load->view('candidate/common/footer', '', TRUE);

		die();
	}
}

?>