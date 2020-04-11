<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tecnossauro_Giftlist_Frontend {
	
	public function __construct() {
	
    add_filter('single_template', array($this,'single_giftlist_template'));
    add_filter('archive_template', array($this,'archive_giftlist_template'));
	add_filter('template_include', array($this,'template_chooser')); 
	// 	add_action('woocommerce_before_cart', array($this,'casamento'));
	// 	add_action('woocommerce_add_to_cart', array($this, 'set_casamento_cart'));
	// 	add_action('woocommerce_before_checkout_shipping_form',  array($this, 'set_shipping_address_for_casamento'));
	add_filter( 'woocommerce_account_menu_items', array($this,'my_custom_my_account_menu_items') );
	
	add_action( 'init', array($this,'my_custom_endpoints') );
	add_filter( 'query_vars',array($this, 'my_custom_query_vars'), 0 );
	add_action( 'woocommerce_account_giftlist_endpoint',array($this,'my_custom_endpoint_content') );

	
	add_filter( 'get_giftlist_searchform', array($this,'get_giftlist_search_form'), 0);
	add_action( 'woocommerce_after_add_to_cart_button', array($this,'add_giftlist_button'), 80);

	//adiciona no carrinho 
	//add_filter( 'woocommerce_add_cart_item_data', array($this, 'add_giftlist_cart_item'), 10, 3 );
	//add_filter( 'woocommerce_get_item_data', array($this,'show_giftlist_cart'), 10, 2 );

	//adiciona no pedido
	add_filter( 'woocommerce_add_order_item_meta', array($this,'add_giftlist_order'), 10, 3 );

	}



	function show_giftlist_cart( $item_data, $cart_item ) {
		if ( empty( $cart_item['giftlist'] ) ) {
		 	return $item_data;
		 }
		
	 
		$item_data[] = array(
			'key'     => 'Lista de casamento',
			'value'   => wc_clean( $cart_item['giftlist'] ),
			'display' => $cart_item['giftlist']['name'] ,
		);
		//var_dump($item_data);
		return $item_data;
	}

	/**
 * Add giftlist to cart item
 *
 * @param array $cart_item_data
 * @param int   $product_id
 * @param int   $variation_id
 *
 * @return array
 */
function add_giftlist_cart_item( $cart_item_data, $product_id, $variation_id ) {
	// $engraving_text = filter_input( INPUT_POST, 'iconic-engraving' );

	// if ( empty( $engraving_text ) ) {
	// 	return $cart_item_data;
	// }
	
	if($_POST['giftlist_id']){

		$cart_item_data['giftlist'] = array(
			'id'=>173,
			'name'=>'Maria & João'
		);
	}
	//var_dump($cart_item_data);

	return $cart_item_data;
}



function add_giftlist_order( $item_id, $values ) {
    if (  $values[ 'giftlist' ] ) {
		wc_add_order_item_meta( $item_id, 'Casamento', '<a href="' . get_edit_post_link($values['giftlist']['id']) . '">'.$values[ 'giftlist' ]['name'].'</a>'  );
    }
}


	/*adiciona botao de add gift list no single product */
    function add_giftlist_button() {
		global $post;
		echo '<div class="add-gift-list" style="margin-top:10px; width:90%; display:flex; justify-content: flex-end;">
				<input type="hidden" name="id-giftlist" value="'.$post->ID.'">
				<button class="submit button" value="add-giftlist" type="submit" name="add-giftlist" style="margin: 0 auto; display: block; width:50%;">Adicionar a lista de presentes</button>
			</div>';
    }

	function template_chooser($template)   
	{    
		if( $_GET['post_type'] == 'giftlist' )   
		{
			return PLUGIN_PATH . '/templates/frontend/archive-giftlist.php';  
		}   
		return $template;
	}


	function get_giftlist_search_form() {
		// Maybe modify $example in some way.
		ob_start();
		include_once(PLUGIN_PATH . '/templates/frontend/giftlist-searchform.php');
		return ob_get_clean();
	}

	function my_custom_endpoint_content() {
		echo do_shortcode('[tecnossauro_giftlist]');
	}
		 
		
	function my_custom_endpoints() {
		add_rewrite_endpoint( 'giftlist', EP_ROOT | EP_PAGES );
	}

	function my_custom_query_vars( $vars ) {
		$vars[] = 'giftlist';
		 
		return $vars;
	}

	function my_custom_my_account_menu_items( $items ) {
		// Remove the logout menu item.
		$logout = $items['customer-logout'];
		unset( $items['customer-logout'] );
		 
		// Insert your custom endpoint.
		$items['giftlist'] = 'Lista de presentes';
		 
		// Insert back the logout item.
		$items['customer-logout'] = $logout;
		 
		return $items;
		}

    
    function single_giftlist_template($single) {

        global $post, $giftlist;

        
        /* Checks for single template by post type */
        if ( $post->post_type == 'giftlist' ) {
			$giftlist = new Giftlist_Model($post->ID, $post->post_title, $post->post_author);
            if ( file_exists( PLUGIN_PATH . '/templates/frontend/single-giftlist.php' ) ) {
                return PLUGIN_PATH . '/templates/frontend/single-giftlist.php';
            }
        }

        return $single;

    }

    function archive_giftlist_template($archive) {
	
        global $post;
        /* Checks for single template by post type */
        if ( $post->post_type == 'giftlist' ) {
            if ( is_post_type_archive ( 'giftlist' ) ) {
                if ( file_exists(TEMPLATES_URL.'frontend/archive-giftlist.php' ) ) {
                   return TEMPLATES_URL.'frontend/archive-giftlist.php';
                }
                
            }
        }

        return $archive;

    }


	public function set_shipping_address_for_casamento() {
		if (isset ( $_SESSION ['buy_for_casamento_id'] )) {
			
			echo "<span id='note_shipping_casamento'>". __('All items is shipped to gift registry address', CASAMENTO_TEXT_DOMAIN) ." </span>";
			$w_id = $_SESSION ['buy_for_casamento_id'];
			$wishlist = Clik_Casamento_Model::get_wishlist ( $w_id );
			$customer_id = $wishlist->user_id ;
			
			$name = 'shipping';
			$address = array(
					'first_name'  => get_user_meta( $customer_id, $name . '_first_name', true ),
					'last_name'   => get_user_meta( $customer_id, $name . '_last_name', true ),
					'company'     => get_user_meta( $customer_id, $name . '_company', true ),
					'address_1'   => get_user_meta( $customer_id, $name . '_address_1', true ),
					'address_2'   => get_user_meta( $customer_id, $name . '_address_2', true ),
					'city'        => get_user_meta( $customer_id, $name . '_city', true ),
					'state'       => get_user_meta( $customer_id, $name . '_state', true ),
					'postcode'    => get_user_meta( $customer_id, $name . '_postcode', true ),
					'country'     => get_user_meta( $customer_id, $name . '_country', true )
			);
			
		?>
<script type="text/javascript">
jQuery(document).ready(function() {
	   jQuery('#ship-to-different-address-checkbox').prop('checked', true);
	   jQuery('#shipping_first_name').val('<?php echo $address['first_name'] ?>');
	   jQuery('#shipping_last_name').val('<?php echo $address['last_name'] ?>');
	   jQuery('#shipping_company').val('<?php echo $address['company']  ?>');
	   
	   jQuery('#shipping_address_1').val('<?php echo $address['address_1'] ?>');
	   jQuery('#shipping_address_2').val('<?php echo $address['address_2'] ?>');
	   jQuery('#shipping_city').val('<?php echo $address['city']  ?>');
	   jQuery('#shipping_state').val('<?php echo  $address['state']  ?>');
	   jQuery('#shipping_postcode').val('<?php echo $address['postcode']  ?>');
	   jQuery('#shipping_country').val('<?php echo $address['country']  ?>');

	   //shipping_state
      }
	) ;

</script>
<?php 
		}
	}
	public function casamento() {
		global $post;
		//
		$http_schema = 'http://';
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'])  {
			$http_schema = 'https://';
		}
			
		$request_link  = $http_schema. $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ;
			
		
		//
		if (isset($_SESSION['buy_for_casamento_id'])) {
			
			$wishlist_id = $_SESSION['buy_for_casamento_id'];
			$wishlist = Clik_Casamento_Model::get_wishlist($wishlist_id);

			$registrantname = $wishlist->registrant_firstname . ' '. $wishlist->registrant_lastname;
			$coregistrantname = $wishlist->coregistrant_firstname . ' '. $wishlist->coregistrant_lastname;
			
			$registry_name = $registrantname;
			
			$casamento_page = get_permalink( get_option('follow_up_emailcasamento_page_id'));
			//
			if (strpos($request_link, '?') > 0)  {
				$casamento_link = $casamento_page . '&casamento_id='. $wishlist_id;
				$casamento_end_purchase = $casamento_page . '&end_buy_casamento='. $wishlist_id;
			} else {
				$casamento_link = $casamento_page . '?casamento_id='. $wishlist_id;
				$casamento_end_purchase = $casamento_page . '?end_buy_casamento='. $wishlist_id;
			}
			//
			
			
			if ($coregistrantname !=' ') $registry_name .= __(' and' , CASAMENTO_TEXT_DOMAIN) . " ". $coregistrantname;
				
		    
		    
		}
	}
	
	public function set_casamento_cart($cart_item_key) {
		error_log('buy gift');
		if (isset($_REQUEST['buy_for_casamento_id']) && isset($_REQUEST['add-to-cart'])) {
			error_log('buy gift 1');
			$_SESSION['message'] = $_REQUEST['message'];
			$_SESSION['buy_for_casamento_id'] = $_REQUEST['buy_for_casamento_id'];
			wc_add_notice ( __ ( 'You have add items for gift regisry', CASAMENTO_TEXT_DOMAIN ), 'success' );
				
		}
	}
}

new Tecnossauro_Giftlist_Frontend();