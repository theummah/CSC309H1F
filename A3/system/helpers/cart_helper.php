<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * In Cart
 *
 * Returns true if item is in cart
 *
 * @access	public
 * @param	string
 * @return	array
 */
if ( ! function_exists('in_cart'))
{
	function in_cart($product_id)
	{
		$CI = & get_instance();

		if ($CI->session->userdata('cart')){
			$cart_items = $CI->session->userdata('cart');
			
			foreach($cart_items as $item){
				if ($item->id == $product_id){
					return true;
				}
			}
			return false;
		}
		else{
			return false;
		}
	}
}

if ( ! function_exists('update_quantity_from_cart'))
{
	function update_quantity_from_cart($product_id, $new_quantity)
	{
		$CI = & get_instance();

		if ($CI->session->userdata('cart')){
			$cart_items = $CI->session->userdata('cart');
			
			foreach($cart_items as $item){
				if ($item->id == $product_id){
					$item->quantity = $new_quantity;
				}
			}


			$CI->session->set_userdata('cart', $cart_items);
			return true;
		}
		else{
			return false;
		}
	}
}

if ( ! function_exists('get_quantity_from_cart'))
{
	function get_quantity_from_cart($product_id)
	{
		$CI = & get_instance();

		if ($CI->session->userdata('cart')){
			$cart_items = $CI->session->userdata('cart');
			
			foreach($cart_items as $item){
				if ($item->id == $product_id){
					return $item->quantity;
				}
			}
			return false;
		}
		else{
			return false;
		}
	}
}



/* End of file url_helper.php */
/* Location: ./system/helpers/url_helper.php */