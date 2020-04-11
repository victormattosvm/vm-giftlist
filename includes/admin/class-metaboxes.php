<?php
/**
* Clik_Metaboxes
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tecnossauro_Giftlist_Metaboxes {
    
    function __construct() {
        add_action( 'add_meta_boxes', array($this,'add_metaboxes') );  
    }


    function add_metaboxes() {
        
        add_meta_box(
            'giftlist_info',
            'Dados da lista',
            array($this,'giftlist_html'),
            'giftlist'
        );

        add_meta_box(
            'giftlist_item_info',
            'Produtos',
            array($this,'giftlist_item_html'),
            'giftlist'
        );
    }
    
    
   

    function giftlist_html( $post) {
		global $post,$giftlist;
        wp_nonce_field( '_giftlist_nonce', 'giftlist_nonce' ); 
        $giftlist = new Giftlist_Model($post->ID, $post->post_title, $post->post_author);
        //chama as tabs
        include 'metaboxes/html-giftlist.php';
    }

    function giftlist_item_html( $post) {
        wp_nonce_field( '_giftlist_item_nonce', 'giftlist_item_nonce' );
        global $post, $giftlist; 
        
        //chama as tabs
        include 'metaboxes/html-giftlist-item.php';
    }



   

    



}

new Tecnossauro_Giftlist_Metaboxes();