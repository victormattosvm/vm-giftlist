<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Giftlist_Item_Model {

    public $id;
    
	public $qty;
	
    public $qty_bought;

	public $product;
	
	public $variation;
	
	public $variation_id;
	
	public $add_to_cart_url;

    public $add_at;
    
    function __construct($row){
        $this->id = $row['id'];
        $this->qty = $row['qty'];
        $this->qty_bought = $row['received_qty'];
        $this->add_at = $row['add_at'];
        $this->product = $row['product_id'];
        $this->variation_id = $row['variation_id'];
        $this->variation = unserialize($row['variation']);
        $this->add_to_cart_url = $this->set_add_to_cart_url();//$this->set_add_to_cart_url();

	}
	
	public function set_add_to_cart_url(){
					   
		$url='';
		if($this->variation_id){
			//é variável
			$url='add-to-cart='.$this->variation_id;
			$url.='&'.http_build_query($this->variation);
		}else{
			//é simple
			$url='add-to-cart='.$this->product;
		}
		return $url;
	}

	public static function update($id, $qty) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$tbl = "{$prefix}giftlist_item";
		$wpdb->update($tbl, array('quantity'=>$qty) , array('id'=>$id));
		
	}

	public static function delete($id) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$tbl = "{$prefix}giftlist_item";
		$wpdb->delete($tbl, array('id' => $id));
	}
	
	public static function get_all($giftlist_id) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$tbl = "{$prefix}giftlist_item";
		
		$user_id = get_current_user_id ();
        $sql = 'SELECT * FROM '.$tbl.' WHERE wishlist_id='.$wishlist_id;//' ORDER BY priority ASC'
		$rows = $wpdb->get_results($sql, ARRAY_A);
		
		if ($rows) {
			return $rows;
		}
    }
    
    public function get_product(){
        return $this->product;
    }
	
}
