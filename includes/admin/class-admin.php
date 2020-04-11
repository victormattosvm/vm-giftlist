<?php
/**
* Clik_Webservice
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tecnossauro_Giftlist_Admin {

function __construct() {
     add_action( 'init', array($this,'create_post_type'));
     add_action( 'save_post', array($this,'giftlist_save' )); 

     //Custom columns
     add_filter('manage_giftlist_posts_columns' , array($this, 'custom_columns'));
     add_action( 'manage_giftlist_posts_custom_column' , array($this,'custom_columns_data'), 10, 2 ); 
     

 }


// register custom post type
function create_post_type() {

    register_post_type("giftlist", array(
        "labels" => array(
            "name" => __("Lista de presentes"),
            "singular_name" => __("Lista de presente"),
            'search_items' =>  'Pesquisar lista',
            'all_items' => 'Todas as listas',
            'edit_item' => __( 'Editar lista' ), 
            'update_item' => __( 'Atualizar lista' ),
            'add_new_item' => __( 'Adicionar nova lista' ),
            'new_item_name' => __( 'Nova lista' ),
            'menu_name' => __( 'Lista de presentes' ),
        ),
        "public" => true,
        "has_archive" => true,
        "supports" => array('title'),
        "rewrite" => array("slug" => "lista-de-presentes"),
        //'show_in_rest'       => true,
    ));

}

function giftlist_save( $post_id ) {
   
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! isset( $_POST['giftlist_nonce'] ) || ! wp_verify_nonce( $_POST['giftlist_nonce'], '_giftlist_nonce' ) ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['event_date'] ) )
    update_post_meta( $post_id, '_event_date', esc_attr( $_POST['event_date'] ) );

    if ( isset( $_POST['event_location'] ) )
    update_post_meta( $post_id, '_event_location', esc_attr( $_POST['event_location'] ) );

    if ( isset( $_POST['event_message'] ) )
    update_post_meta( $post_id, '_event_message', esc_attr( $_POST['event_message'] ) );

    if( isset( $_POST['item-id-remove'] ) ){
        global $wpdb;
        $items = $wpdb -> get_results("SELECT * FROM {$wpdb->prefix}giftlist_item WHERE giftlist_id = ".$_POST['post_ID']);

        $to_remove = $_POST['item-id-remove'];
        var_dump($to_remove);
        if(is_array($to_remove)){
            foreach($to_remove as $remove){
                $percorre_items = 0;
                while($percorre_items <= count($items)){
                    if($items[$percorre_items]->id == $remove){
                        $items[$percorre_items] = null;
                    }
                        
                    $percorre_items++;
                }
            }
        }else{
            $percorre_items = 0;
                while($percorre_items <= $count($items)){
                    if($items[$percorre_items]->id == $to_remove)
                        $items[$percorre_items] = null;
                    $percorre_items++;
                }
        }
        $to_remove = array();
        foreach($items as $item){
            if($item != null)
                array_push($to_remove, $item->id);
        }

        $ids = implode( ',', array_map( 'absint', $to_remove ) );
        $wpdb->query( "DELETE FROM {$wpdb->prefix}giftlist_item WHERE id IN($ids)" );
    }

}

function custom_columns_output($columns, $move, $before, $title){
    $n_columns = array();
    foreach($columns as $key => $value) {
        if ($key==$before){
            $n_columns[$move] = $title;
        }
            $n_columns[$key] = $value;
        }
    return $n_columns;
}

function custom_columns( $columns ) {

    $columns = $this->custom_columns_output($columns, 'msg','date','Mensagem');
    

    return $this->custom_columns_output($columns, 'dtevento','msg','Data Evento');

}

function custom_columns_data( $column, $post_id ) {
    switch ( $column ) {
    case 'msg':
        echo '<div>'.get_post_meta($post_id, '_event_message', true).'</div>';
    break;
    case 'dtevento':
        echo '<div>'.get_post_meta($post_id, '_event_date', true).'</div>';
    break;
    }
}



    
}

new Tecnossauro_Giftlist_Admin();