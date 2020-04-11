<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tecnossauro_Giftlist_Shortcode {
	
	public function __construct() {

        add_shortcode('tecnossauro_giftlist', array($this,'giftlist_shortcode'));
        add_shortcode('tecnossauro_giftlist_search_page', array($this,'giftlist_search_page'));

	}

    function giftlist_search_page(){
        ob_start();
        ?>
        <div class="row justify-content-center giftlist-div">
            <h1 class="col-12 title-list-first">Lista de</h1>
            <h1 class="col-12 title-list-second">
                Presentes
            </h1>
            <div class="col-12 search">
                <h1 class="search-giftlist-title">Buscar lista</h1>
                <div  class="search-form col-12">

                        <!-- <div class="col-6"><input type="text" class="by-name" placeholder="Nome..."></div>
                        <div class="col-6"><input type="text" class="by-email" placeholder="E-mail..."></div> -->
                    <?= apply_filters( 'get_giftlist_searchform', 0); ?>
            </div>
            </div>
            <div class="col-12 manage-giftlist">
                <div class="row justify-content-center">
                    <h1 class="search-giftlist-title col-12">OU</h1>

                    <div class="col-6"><a href="#" class="button create-list">CRIAR MINHA LISTA</a></div>
                    <div class="col-6"><a href="#" class="button manage-list">GERENCIAR LISTA</a></div>

                </div>

            </div>
        </div>

        <?php
        // end output buffering, grab the buffer contents, and empty the buffer
        return ob_get_clean();
    }


    function  giftlist_shortcode($atts){

        
        // $atts = array_change_key_case((array)$atts, CASE_LOWER);

        // extract( shortcode_atts( array(
        //     'id' => null,
        // ), $atts, 'tecnossauro_giftlist' ) );



        $args = array(
            'post_type' => 'giftlist',
            'author'        =>  $current_user->ID,
            'orderby'       =>  'post_date',
            'order'         =>  'DESC',
            'posts_per_page' => 1
            );
            
        $giftlists = get_posts( $args );
        if($giftlists){
            $giftlist = new Giftlist_Model($giftlists[0]->ID, $giftlists[0]->post_title, $giftlists[0]->post_author);
        }
        ob_start();
        ?>

        <div class="actions">
        </div>
        <div class="list">
            <ul>
                <?php if($giftlist){
                            
                            include_once(TEMPLATES_URL . 'frontend/single-myaccount.php');
                        ?>
                <?php   
                    }else{
                        ?>
                            <h1>Criar Lista de Presente</h1>
                            
                        <?php
                            include_once(TEMPLATES_URL . 'frontend/create-change-giftlist.php');
                    }   
                ?>
            </ul>
        </div>
        
    <?php
        // end output buffering, grab the buffer contents, and empty the buffer
        return ob_get_clean();
    }

}

new Tecnossauro_Giftlist_Shortcode();