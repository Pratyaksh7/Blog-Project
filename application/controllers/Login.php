<?php

/**
 * 
 */
Class Login extends MY_Controller 
{
	
	public function index(){
		if($this->session->userdata('user_id') )
			return redirect('admin/dashboard');

		$this->load->helper('form');
		$this->load->view('public/admin_login');
	}

	public function admin_login(){
		$this->load->library('form_validation');
		//$this->form_validation->set_rules('username','User Name','required|alpha|trim');
		//$this->form_validation->set_rules('password','Password','required');
 		

 		$this->form_validation->set_error_delimiters("<small class='text-danger'>","</small>");
		if( $this->form_validation->run('admin_login') ) { //if validation passes
			//Success
			$username= $this->input->post('username');
			$password= $this->input->post('password');

			$this->load->model('loginmodel');

		    $login_id = $this->loginmodel->login_valid($username, $password);
			if( $login_id) {
				//credentials valid, login user.

			  $this->session->set_userdata('user_id', $login_id );              //when we need to set anythig on session then we use set_userdata function
			  return redirect('admin/dashboard');

			} else{
				$this->session->set_flashdata('login_failed','Invalid Username/Password.');
				return redirect('login');
			}

		} else{
			//Failed
			

			$this->load->view('public/admin_login');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('user_id');
		return redirect('login');
	}
}
