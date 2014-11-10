<?php
class Customer_model extends CI_Model{

  	function __construct() {
        parent::__construct();
        $this->load->helper('literate');
    }

	//registerCustomer expects an array like this
	// $Customer = array(
	//     "first" => "firstName",
	//     "last" => "lastName",
	//     "login" => "userName",
	//     "password" => "password"
	//	   "email" =>  "email"
	// );
	function registerCustomer($customer){

		$login = $customer['login'];
		$email = $customer['email'];

		$query = $this->db->get_where('customers', array('login' => $login));
		if ($query->num_rows() > 0){
			return format_return('BAD','Username already exists');
		}

		$query = $this->db->get_where('customers', array('email' => $email));
		if ($query->num_rows() > 0){
			// Existing email on account
			return format_return('BAD','Email associated with existing account');
		}

		$this->db->insert('customers', $customer); 
		if ($this->db->affected_rows() > 0){
			return format_return('GOOD');
		}
		else{
			return format_return('BAD',"Uhhh WTF, couldn't insert into database!");
		}

	}

	function loginCustomer($customer){

		$login = $customer['login'];
		$password = $customer['password'];

		$query = $this->db->get_where('customers', 
			array('login' => $login, 'password' => $password));

		if ($query->num_rows() > 0){
			return format_return('GOOD', $customer);
		}
		else{
			return format_return('BAD',"Incorrect username or password");	
		}

	}

}
?>