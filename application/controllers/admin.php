<?php

/**
 * 
 */
class Admin extends MY_Controller
{
	public function dashboard()
	{
		$this->load->library('pagination');

		$config = [
			'base_url'   	=>  base_url('admin/dashboard'),
			'per_page'   	=>  5,
			'total_rows' 	=>  $this->articles->num_rows(),
			
		];

		$this->pagination->initialize($config);
		$articles = $this->articles->articles_list( $config['per_page'], $this->uri->segment(3) );

		$this->load->view('admin/dashboard', ['articles'=>$articles]);
	}

	public function add_article()
	{
		$this->load->view('admin/add_article');
	}

	public function store_article(){

		$config = [
				'upload_path'	=>	'./uploads',
				'allowed_types'	=>	'jpg|png|gif|jpeg',
		];
		$this->load->library('upload',$config);
		$this->load->library('form_validation');
		if( $this->form_validation->run('add_article_rules') && $this->upload->do_upload('image') ){
			$post = $this->input->post();                                       //receive the data
			unset($post['submit']);
			$data = $this->upload->data();
			//echo "<pre>";
			//print_r($data); exit;
			$image_path = base_url("uploads/". $data['raw_name']. $data['file_ext']);
			//echo $image_path; exit;
			$post['image_path'] = $image_path;

			return $this->_flashAndRedirect(
					$this->articles->add_article($post),
					"Article Added Successfully",
					"Article Failed To Add, Please Try Again"
			);
		
		} else{
			$upload_error = $this->upload->display_errors();
			$this->load->view('admin/add_article', compact('upload_error'));
		}
	}

	public function edit_article($article_id)
	{
		$article = $this->articles->find_article($article_id);

		$this->load->view('admin/edit_article', ['article'=>$article]);

	}

	public function update_article($article_id){
		 
		$this->load->library('form_validation');
		if( $this->form_validation->run('add_article_rules') ){
			$post = $this->input->post();                                       //receive the data
			unset($post['submit']);

			return $this->_flashAndRedirect(
					 $this->articles->update_article($article_id, $post),
					 "Article Updated Successfully",
					 "Article Failed To Update, Please Try Again"
			);

		} else{
			$this->load->view('admin/edit_article');
		}
	}

	public function delete_article()
	{
		$article_id = $this->input->post('article_id');

		return $this->_flashAndRedirect(
				$this->articles->delete_article($article_id),
				"Article Deleted Successfully.",
				"Article Failed To Delete, Please Try Again"
		);
 
	}

	public function __construct()
	{
		parent::__construct();
		if( ! $this->session->userdata('user_id') )
			return redirect('login');
		$this->load->model('articlesmodel','articles');  //2nd parameter act as an alias name for the 1st parameter
		$this->load->helper('form');
	}

	private function _flashAndRedirect( $successful, $successMessage, $failureMessage)
	{
		if( $successful ) {
			$this->session->set_flashdata('feedback',$successMessage);
			$this->session->set_flashdata('feedback_class', 'alert-success');
		} else {
			$this->session->set_flashdata('feedback',$failureMessage);
			$this->session->set_flashdata('feedback_class', 'alert-danger');
		}
		return redirect('admin/dashboard');
	}
	
}