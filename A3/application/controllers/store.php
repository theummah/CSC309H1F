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
			$this->load->helper('cart'); 
			$this->load->helper('literate'); 			
	    	$this->load->library('upload', $config);
	    	
	    	$this->load->model("Customer_model","customer");

		   if($this->session->userdata('logged_in'))
		   {


		     $session_data = $this->session->userdata('logged_in');
		     $this->data['username'] = $session_data['login'];
		   }	    	
    }

    function index(){


       $this->data['content'] = $this->load->view('landing.php', $this->data, true);
       $this->load->view('main_template.php', $this->data);
    }
    
    function listView() {
    		$this->load->model('product_model');
    		$products = $this->product_model->getAll();
    		$data['products']=$products;

    		// is_admin is to enable admin only behaviour on the product list
    		// view. Consider making this a helper function to be used anywhere?
    		if ($this->session->userdata['logged_in']['login'] == 'admin'){
    			$data['is_admin'] = true;
    		}
    		else{
    			$data['is_admin'] = false;
    		}

	    	$this->data['content'] = $this->load->view('product/list.php', $data, true);


	    	$this->load->view('main_template.php', $this->data);    	
    }

    function checkout() {
    		$this->load->model('product_model');
    		$products = $this->product_model->getAll();
    		$data['products']=$products;
    		$data['shopping_cart'] = $this->session->userdata('cart');
	    	$this->data['content'] = $this->load->view('product/checkout.php', $data, true);
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
    			$this->session->unset_userdata('cart');
    			redirect('/');
    		}
    		else
    		{
    			$this->data['errors'] = $retval['message'];
	    		$this->data['content'] = $this->load->view('user_accounts/user_login.php', '', true);
	    		$this->load->view('main_template.php', $this->data);    			
    		}

    	}
    	else{
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
	
	// Add to cart places saves items as ids of Product in the Session object
	function add_to_cart() {
		$this->load->model('product_model');		
		
		$to_add = $this->input->get("add");
		$quantity = $this->input->get("quantity");

		$temp = new stdClass();
		$temp->id = $to_add;
		$temp->quantity = $quantity;


		if (!isset($this->session->userdata['cart'])){
			$this->session->set_userdata('cart',array($temp));
			$this->output->set_output(json_encode(format_return('GOOD',$this->session->userdata('cart'))));
		}
		else{

			if (!in_array($temp, $this->session->userdata('cart')))
			{
				$cart_list = $this->session->userdata('cart');
				$cart_list[] = $temp;
				$this->session->set_userdata('cart', $cart_list);
				$this->output->set_output(json_encode(format_return('GOOD',$this->session->userdata('cart'))));
			}
			else{
				$this->output->set_output(json_encode(format_return('DUPLICATE',$this->session->userdata('cart'))));
			}
		}
	}


	function remove_from_cart(){
		$this->load->model('product_model');

		$remove = $this->input->post("remove");

		$cart_items = $this->session->userdata('cart');
	

		foreach($cart_items as $key => $item){
		  	if ($item->id == $remove){
		  		unset($cart_items[$key]);

		  		$this->session->set_userdata('cart', $cart_items);
		 		$this->output->set_output(json_encode(format_return('GOOD',$this->session->userdata('cart'))));
		  	}
		}

		// Didn't find product in the cart, we should never reach this case!!
		$this->output->set_output(json_encode(format_return('BAD',$this->session->userdata('cart'))));		 		
	}

	function change_quantity(){
		$this->load->model('product_model');
		$pid = $this->input->post('pid');
		$quantity = $this->input->post('quantity');
		update_quantity_from_cart($pid, $quantity);
		$this->output->set_output(json_encode(format_return('GOOD',$this->session->userdata('cart'))));
	} 

	function logOrder(){
		$this->load->model('product_model');
		$products = $this->product_model->getAll();
    	$data['products']=$products;
		$data['shopping_cart'] = $this->session->userdata('cart');
	    $this->data['content'] = $this->load->view('product/confirm_order.php', $data, true);
	    $this->load->view('main_template.php', $this->data);
	}

	function editForm($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		
		//$this->load->view('product/editForm.php',$data);

		$this->data['content'] = $this->load->view('product/editForm.php', $data, true);
		$this->load->view('main_template.php',$this->data);
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
			redirect('store/listView', 'refresh');
		}
		else {
			$product = new Product();
			$product->id = $id;
			$product->name = set_value('name');
			$product->description = set_value('description');
			$product->price = set_value('price');
			$data['product']=$product;
			$this->data['content'] = $this->load->view('product/editForm.php', $data, true);
			$this->load->view('main_template.php',$this->data);
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

