<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Giftlist_Model {

	public $id;
	public $title = '';
	public $date = '';
	public $location = '';
	public $message = '';

	public $user;

	public $items = array ();

	function __construct($id, $title){
		$this->id=$id;
		$this->title=$title;
		$this->date = get_post_meta($this->id, '_event_date',true);
		$this->location = get_post_meta($this->id, '_event_location',true);
		$this->message = get_post_meta($this->id, '_event_message',true);

		$this->get_all_items();
	}
	
	function get_all_items() {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$tbl = "{$prefix}giftlist_item";
		
		$user_id = get_current_user_id ();
        $sql = 'SELECT * FROM '.$tbl.' WHERE giftlist_id='.$this->id;//' ORDER BY priority ASC'
		$rows = $wpdb->get_results($sql, ARRAY_A);
		
		if ($rows) {
			foreach($rows as $row){
				array_push($this->items, new Giftlist_Item_Model($row));
			}
		}
	}
	// function find($id){
	// 	$giftlist = get_post($id);
	// 	if($giftlist){
	// 		$this->id = $giftlist->ID;
	// 		$this->title = $giftlist->title;
	// 	}

	// 	return self;
	// }
}
