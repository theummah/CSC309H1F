<?php
class Order_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('orders');
		return $query->result('Order');
	}  
	
	function get($id)
	{
		$query = $this->db->get_where('orders',array('id' => $id));
		
		return $query->row(0,'Order');
	}
	
	function delete($id) {
		return $this->db->delete("orders",array('id' => $id ));
	}
	
	function insert($product) {
		return $this->db->insert("orders", array('name' => $product->name,
				                                  'description' => $product->description,
											      'price' => $product->price,
												  'photo_url' => $product->photo_url));
	}
	 
	function update($product) {
		$this->db->where('id', $product->id);
		return $this->db->update("orders", array('name' => $product->name,
				                                  'description' => $product->description,
											      'price' => $product->price));
	}
	
	
}
?>
