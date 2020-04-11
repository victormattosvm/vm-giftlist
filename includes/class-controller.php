<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tecnossauro_Giftlist_Controller {

    function __construct() {
        
       $this->includes();
       
        //update information after a guest buy gift registry
       // add_action('woocommerce_checkout_order_processed', array($this,'after_buy_product'), 5 );
       // add_action('woocommerce_after_add_to_cart_button', array($this,'add_casamento'), 10, 1);
        add_action( 'init', array($this,'process_new_giftlist') );
        //add_filter( 'woocommerce_add_to_cart_validation', array($this,'add_to_giftList') );
        add_filter( 'woocommerce_add_to_cart_validation', array($this,'add_to_giftlist_variation') );
        add_action( 'template_redirect', array($this,'add_to_giftList_simple') );
        add_action('remove_giftlist', array($this,'remove_item'));

        
        function remove_giftlist() {
            do_action('remove_giftlist');
        }
            
           
    }

    public function includes() {
        include_once 'front/class-front.php';
        include_once 'front/class-shortcode.php';
        include_once 'models/giftlist-model.php';
        include_once 'models/giftlist-item-model.php';
    }

   

    function remove_item() {
        if($_POST['remove-giftlist'] == 'remove-giftlist'){
            global $wpdb;
            $item = $wpdb -> get_results("SELECT * FROM {$wpdb->prefix}giftlist_item WHERE id = ". $_POST['item-id']." AND giftlist_id = ".$_POST['giftlist-id']);
            if($item['received_order'] == null && $item["received_qty"] == null){
                if($wpdb -> delete('wp_giftlist_item', array(
                    'id' =>$_POST['item-id'],
                    'giftlist_id' =>$_POST['giftlist-id']

                )) == false){
                    echo '<div class="woocommerce-error" role="alert"> Não foi possui remover o produto, pois o mesmo já foi comprado.</div>';
                }else{
                    echo '<div class="woocommerce-message" role="alert"> Removido com sucesso!</div>';
                }
            }
            else{
                echo '<div class="woocommerce-error" role="alert"> Não foi possui remover o produto, pois o mesmo já foi comprado.</div>';
            }
        }
    }

    function add_to_giftList_simple(){

        if($_POST['add-giftlist'] == 'add-giftlist'){
            $args = array(
                'post_type' => 'giftlist',
                'author'        =>   wp_get_current_user()->ID,
                'orderby'       =>  'post_date',
                'order'         =>  'DESC',
                'posts_per_page' => 1
                );
                $giftlists = get_posts( $args );
            if($giftlists){
                $giftlist = new Giftlist_Model($giftlists[0]->ID, $giftlists[0]->post_title, $giftlists[0]->post_author);
                if(!isset($_POST['variation_id'])){
                    global $wpdb;
                    $data = array(
                        'giftlist_Id'   =>  $giftlist->id,
                        'product_id'    =>  $_POST['id-giftlist'],
                        'qty'           =>  $qty = $_POST['quantity'],
                        'add_at'        =>  (new DateTime('now'))->format('Y-m-d H:i:s'),
                    );
                    $wpdb -> insert('wp_giftlist_item', $data);
                 
                    wc_add_notice ( 'Você adicionou este produto a sua lista de presentes!', 'success' );
                    return false;
                }
            }else{
                wc_add_notice ( 'Você não possui uma lista de presente ativa!', 'fail' );
                return false;
            }
        }
    }

    function add_to_giftlist_variation($cart_item){
        if($_POST['add-giftlist'] == 'add-giftlist'){
            // var_dump($_POST);
            //         
            
            $args = array(
                'post_type' => 'giftlist',
                'author'        =>   wp_get_current_user()->ID,
                'orderby'       =>  'post_date',
                'order'         =>  'DESC',
                'posts_per_page' => 1
                );
            // add na lista de presente 
            $giftlists = get_posts( $args );
            if($giftlists){
                $giftlist = new Giftlist_Model($giftlists[0]->ID, $giftlists[0]->post_title, $giftlists[0]->post_author);
                global $wpdb;
               
                if(isset($_POST['variation_id'])){
                    //é variável
                    if($_POST['variation_id']){

                        //recebe os atributos da variação
                        foreach($_POST as $key => $value){
                            $exp_key = explode('_', $key);
                            if($exp_key[0] == 'attribute'){
                                $attributes[$key] = $value;
                            }
                        }
                        
                        
                        $data = array(
                            'giftlist_Id'   =>  $giftlist->id,
                            'product_id'    =>  $_POST['id-giftlist'],
                            'qty'           =>  $qty = $_POST['quantity'],
                            'variation_id' =>   $_POST['variation_id'],
                            'variation'     =>  serialize($attributes),
                            'add_at'        =>  (new DateTime('now'))->format('Y-m-d H:i:s'),
                        );
                        $wpdb -> insert('wp_giftlist_item', $data);
                 
                        wc_add_notice ( 'Você adicionou este produto a sua lista de presentes!', 'success' );
                        return false;
                    }   
    
                }
            }else{
                wc_add_notice ( 'Você não possui uma lista de presente ativa!', 'fail' );
                return false;
            }
        }
        return $cart_item;
    }
    
    /*function add_to_giftList($cart_item_data){ 
        if($_POST['add-giftlist'] == 'add-giftlist'){
            // var_dump($_POST);
            //         
            
            $args = array(
                'post_type' => 'giftlist',
                'author'        =>   wp_get_current_user()->ID,
                'orderby'       =>  'post_date',
                'order'         =>  'DESC',
                'posts_per_page' => 1
                );
            // add na lista de presente 
            $giftlists = get_posts( $args );
            if($giftlists){
                $giftlist = new Giftlist_Model($giftlists[0]->ID, $giftlists[0]->post_title, $giftlists[0]->post_author);
                global $wpdb;
               
                if(isset($_POST['variation_id'])){
                    //é variável
                    if($_POST['variation_id']){

                        //recebe os atributos da variação
                        foreach($_POST as $key => $value){
                            $exp_key = explode('_', $key);
                            if($exp_key[0] == 'attribute'){
                                $attributes[$key] = $value;
                            }
                        }
                        
                        
                        $data = array(
                            'giftlist_Id'   =>  $giftlist->id,
                            'product_id'    =>  $_POST['id-giftlist'],
                            'qty'           =>  $qty = $_POST['quantity'],
                            'variation_id' =>   $_POST['variation_id'],
                            'variation'     =>  serialize($attributes),
                            'add_at'        =>  (new DateTime('now'))->format('Y-m-d H:i:s'),
                        );
                    }   
    
                }else{
                    //é simples
                    $data = array(
                        'giftlist_Id'   =>  $giftlist->id,
                        'product_id'    =>  $_POST['id-giftlist'],
                        'qty'           =>  $qty = $_POST['quantity'],
                        'add_at'        =>  (new DateTime('now'))->format('Y-m-d H:i:s'),
                    );
    

                }

               
                 $wpdb -> insert('wp_giftlist_item', $data);
                 
                 wc_add_notice ( 'Você adicionou este produto a sua lista de presentes!', 'success' );
                return false;
            }
            //verificar se usuario possui lista de presente ativa???
            
            
            

        }
        return $cart_item_data;
        
    }*/
    
    
    function process_new_giftlist() {
        if ( wp_verify_nonce( $_POST['_wpnonce'], 'process-giftlist' ) ) {
            $noiva = sanitize_text_field($_POST['nome-noiva']);
            $noivo = sanitize_text_field($_POST['nome-noivo']);
            if($_POST['giftlist-id'] == ''){
                $post = array(
                    'post_title'    => $noiva . ' & ' . $noivo,
                    'post_type'     => 'giftlist',
                    'post_status'   => 'publish'
                );
                $post_id = wp_insert_post($post);
            }else{
                $post_id = $_POST['giftlist-id'];
            }


            /*Salvar os post metas */
            $event_date = sanitize_text_field($_POST['data-evento']);
            $event_location = sanitize_text_field($_POST['endereco-evento']);
            $phone = sanitize_text_field($_POST['phone']);
            $credito = sanitize_text_field($_POST['credito']);
            $entrega = sanitize_text_field($_POST['entrega']);

                update_post_meta($post_id, '_event_date', $event_date);
                update_post_meta($post_id, '_event_location', $event_location);
                update_post_meta($post_id, '_noiva', $noiva);
                update_post_meta($post_id, '_noivo', $noivo);
                update_post_meta($post_id, '_phone', $phone);
            if($credito == 'sim'){
                /* grava sem entrega */
                echo $credito;
                update_post_meta($post_id, '_credito', $credito);
                update_post_meta($post_id, '_entrega', 'nao');
                update_post_meta($post_id, '_endereco_entrega', '');
                update_post_meta($post_id, '_numero', '');
                update_post_meta($post_id, '_bairro', '');
                update_post_meta($post_id, '_cidade', '');
                update_post_meta($post_id, '_cep', '');
            }else{
                $credito = 'nao';
                
                if($entrega == 'sim'){
                    $endereco_entrega = sanitize_text_field($_POST['endereco-entrega']);
                    $numero = sanitize_text_field($_POST['numero']);
                    $bairro = sanitize_text_field($_POST['bairro']);
                    $cidade = sanitize_text_field($_POST['cidade']);
                    $cep = sanitize_text_field($_POST['cep']);

                    update_post_meta($post_id, '_entrega', $entrega);
                    update_post_meta($post_id, '_credito', $credito);
                    update_post_meta($post_id, '_endereco_entrega', $endereco_entrega);
                    update_post_meta($post_id, '_numero', $numero);
                    update_post_meta($post_id, '_bairro', $bairro);
                    update_post_meta($post_id, '_cidade', $cidade);
                    update_post_meta($post_id, '_cep', $cep);
                }else{
                    $entrega = 'nao';
                    $credito = 'nao';
                    update_post_meta($post_id, '_credito', $credito);
                    update_post_meta($post_id, '_entrega', $entrega);
                    update_post_meta($post_id, '_credito', $credito);
                    update_post_meta($post_id, '_credito', '');
                    update_post_meta($post_id, '_endereco_entrega', '');
                    update_post_meta($post_id, '_numero', '');
                    update_post_meta($post_id, '_bairro', '');
                    update_post_meta($post_id, '_cidade', '');
                    update_post_meta($post_id, '_cep', '');
                }
            }
        }
    }
    


}

new Tecnossauro_Giftlist_Controller();