<?php

/**
 * 
 */
class User extends MY_Controller
{
	public function index(){
		
		$this->load->helper('form');
		$this->load->model('articlesmodel','articles');
		$this->load->library('pagination');

		$config = [
			'base_url'   	=>  base_url('user/index'),
			'per_page'   	=>  5,
			'total_rows' 	=>  $this->articles->count_all_articles(),
			
		];

		$this->pagination->initialize($config);
		$articles = $this->articles->all_articles_list($config['per_page'], $this->uri->segment(3));

		$this->load->view('public/articles_list',compact('articles')); // compact('articles') = ['articles'=>$articles]
	}

	public function search(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('query','Query','required');

		if( ! $this->form_validation->run() )
			return $this->index();

		$query = $this->input->post('query');
		return redirect("user/search_results/$query");

		
	}

	public function search_results( $query)
	{
		$this->load->helper('form');
		$this->load->model('articlesmodel','articles');
		$this->load->library('pagination');

		$config = [
			'base_url'   	=>  base_url("user/search_results/$query"),
			'per_page'   	=>  5,
			'total_rows' 	=>  $this->articles->count_search_results( $query),
			'uri_segment'	=>	4,
			
		];

		$this->pagination->initialize($config);
		$articles = $this->articles->search($query, $config['per_page'], $this->uri->segment(4));

		 $this->load->view('public/search_results',compact('articles'));
	}

	public function article( $id )
	{
		$this->load->helper('form');
		$this->load->model('articlesmodel','articles');

		$article = $this->articles->find( $id);
		$this->load->view('public/article_detail',compact('article') );
	}
	
}