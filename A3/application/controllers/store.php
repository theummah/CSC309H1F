<?php

session_start(); 

class Store extends CI_Controller {
       
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	
	    	
	    	$config['upload_path'] = './images/product/';
	    	$config['allowed_types'] = 'gif|jpg|png';
/*	    	$config['max_size'] = '100';
	    	$config['max_width'] = '1024';
	    	$config['max_height'] = '768';
*/
	 
	    	// CSS and Javascript files
	    	$this->data = array();
	    	$this->data['css'] = $this->config->item('css');
	    	$this->data['js'] = $this->config->item('js');

	    	$this->load->helper('html');
    		$this->load->helper('url');
	    	$this->load->library('upload', $config);
	    	
	    	$this->load->model("Customer_model","customer");
    }

    // function index() {
    // 		$this->load->model('product_model');
    // 		$products = $this->product_model->getAll();
    // 		$data['products']=$products;
    // 		$this->load->view('product/list.php',$data);
    // }

    function index(){
	   if($this->session->userdata('logged_in'))
	   {
	     $session_data = $this->session->userdata('logged_in');
	     $this->data['username'] = $session_data['login'];
	   }

       $this->data['content'] = $this->load->view('landing.php', $this->data, true);
       $this->load->view('main_template.php', $this->data);
    }
   

    function newForm() {
	    	$this->load->view('product/newForm.php');
    }


    function register(){
    	
    	$form_data = $this->input->post();
    	
    	if ($form_data){
	    	$retval = $this->customer->registerCustomer($form_data);

	    	if ($retval["status"] == "GOOD"){
	    		redirect("/");
	    	}
	    	else{
	    		$this->data['registration_errors'] = $retval;
    			
    			$this->data['content'] = $this->load->view('user_accounts/user_register.php', $this->data, true);
    			$this->load->view('main_template.php', $this->data);
	    	}    		
    	}
    	else{
    		$this->data['content'] = $this->load->view('user_accounts/user_register.php', '', true);
    		$this->load->view('main_template.php', $this->data);
    	}

    }
    
    function login(){
    	$form_data = $this->input->post();

    	if ($form_data){
    		$retval = $this->customer->loginCustomer($form_data);

    		if ($retval['status'] == "GOOD"){
    			$this->session->set_userdata('logged_in', $retval['message']);
    			redirect('/');
    		}
    		else
    		{
    		echo "HELO";

    			$this->data['errors'] = $retval['message'];
	    		$this->data['content'] = $this->load->view('user_accounts/user_login.php', '', true);
	    		$this->load->view('main_template.php', $this->data);    			
    		}

    	}
    	else{
    		echo "HELLO";

    		$this->data['content'] = $this->load->view('user_accounts/user_login.php', '', true);
    		$this->load->view('main_template.php', $this->data);
    	}

    }

	function logout()
	 {
	   $this->session->unset_userdata('logged_in');
	   session_destroy();
	   redirect("/");
	 }



	function create() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[products.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		$fileUploadSuccess = $this->upload->do_upload();
		
		if ($this->form_validation->run() == true && $fileUploadSuccess) {
			$this->load->model('product_model');

			$product = new Product();
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$data = $this->upload->data();
			$product->photo_url = $data['file_name'];
			
			$this->product_model->insert($product);

			//Then we redirect to the index page again
			redirect('store/index', 'refresh');
		}
		else {
			if ( !$fileUploadSuccess) {
				$data['fileerror'] = $this->upload->display_errors();
				$this->load->view('product/newForm.php',$data);
				return;
			}
			
			$this->load->view('product/newForm.php');
		}	
	}
	
	function read($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/read.php',$data);
	}
	
	function editForm($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/editForm.php',$data);
	}
	
	function update($id) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		if ($this->form_validation->run() == true) {
			$product = new Product();
			$product->id = $id;
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$this->load->model('product_model');
			$this->product_model->update($product);
			//Then we redirect to the index page again
			redirect('store/index', 'refresh');
		}
		else {
			$product = new Product();
			$product->id = $id;
			$product->name = set_value('name');
			$product->description = set_value('description');
			$product->price = set_value('price');
			$data['product']=$product;
			$this->load->view('product/editForm.php',$data);
		}
	}
    	
	function delete($id) {
		$this->load->model('product_model');
		
		if (isset($id)) 
			$this->product_model->delete($id);
		
		//Then we redirect to the index page again
		redirect('store/index', 'refresh');
	}
      
   
    
    
    
}

