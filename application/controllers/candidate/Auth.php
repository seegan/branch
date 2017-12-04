<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
	}

	public function login()
	{
	    // Method should not be directly accessible
	    if( $this->uri->uri_string() == 'examples/login')
	    {
	        show_404();
	    }

		if( $this->require_min_level(1) &&  $this->verify_role('superadmin, admin, candidate') )
		{
			if( $this->is_role('superadmin, admin') ) {
				redirect('admin/dashboard');
				die();
			}

			redirect('candidate/dashboard');
			
		    
		}
		elseif( $this->tokens->match && $this->optional_login() )
		{
			var_dump("login token matter"); die();
		}
		else
		{
			// Notice parameter set to TRUE, which designates this as an optional login
			$this->setup_login_form(TRUE);
			// Form helper needed
			$this->load->helper('form');
			$page_content = $this->load->view('candidate/login_form', '', TRUE);
		}

		echo $this->load->view('candidate/login_header', '', TRUE);
		echo $page_content;
		echo $this->load->view('candidate/login_footer', '', TRUE);
	}




	public function logout()
	{
		$this->authentication->logout();

		// Set redirect protocol
		$redirect_protocol = USE_SSL ? 'https' : NULL;

		redirect( site_url( LOGIN_PAGE . '?' . AUTH_LOGOUT_PARAM . '=1', $redirect_protocol ) );
	}



	public function change_password() {
		$this->load->helper('auth');
		$this->load->model('examples/examples_model');
		$this->load->model('examples/validation_callables');
		$this->load->library('form_validation');


		$pass = $this->authentication->hash_passwd('22221111');
		var_dump($pass);
	}
}
?>