
 <section class="products">
    <div class="container">
        <div class="row">
            <?php
            
                if($giftlist): 
                    if($giftlist->items):
                        foreach($giftlist->items as $item):
                            $product = wc_get_product( $item->product );
                            if($product):
            ?>
                
                                <div class="col-12 col-md-3 <?=$item->variation? 'product-type-variable' : 'product-type-simple' ?>">
                                    <div class="img">
                                    <?php 
                                        echo $product->get_image();
                                    ?>
                                    </div>
                                    <?php $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($loop->post->ID)); ?>
                                    <?php if($featured_image) : ?>
                                    <div class="img">
                                        <img src="<?php $featured_image[0]; ?>" data-id="<?php echo $loop->post->ID; ?>">
                                    </div>
                                    <?php endif;?>
                                    
                                    <span><?=get_the_title( $item->product ); ?></span>
                                    <?= $product->get_price_html() ?>
                                    <p>
                                    Quantidade desejada: <?= $item->qty ?></p>

                                        <?php 
                                        if($product->is_in_stock()):
                                            if( $item->qty != $item->qty_bought):
                                        ?>
                                            
                                            <form action="<?php //$item->add_to_cart_url?>" class="cart <?php if($item->variation_id != null) echo 'variations_form';?>" method="post" enctype="multipart/form-data" data-product_id="<?=$item->product?>">
                                            <input type="hidden" name="giftlist_id" value="<?=$giftlist->id?>" />
                                            <input type="hidden" name="add-to-cart" value="<?=$item->product?>" />
                                            <input type="hidden" name="product_id" value="<?=$item->product?>" />
                                            <input type="hidden" name="variation_id" class="variation_id" value="<?=$item->variation_id?>" />
                                            
                                            <?php
                                            if($item->variation_id != null){ 
                                                foreach($item->variation as $key => $value){
                                                    echo '<input type="hidden" name="'.$key.'" class="variation_id" value="'.$value.'" />';

                                                }
                                            }
                                        
                                                    // Displays the quantity box.
                                                    woocommerce_quantity_input(
                                                                        array(
                                                                            'max_value'=>$item->qty,
                                                                            'min_value'=>1,
                                                                            ),
                                                                            $product);
                                                    
                                                    // Display the submit button.
                                                    if($giftlist->date <= date ("Y-m-d")){
                                                        echo sprintf('<button type="submit" class="single_add_to_cart_button button alt wc-variation-selection-needed disabled" disabled>Comprar</button>');
                                                    }else{
                                                        if($item->variation_id == null){                               
                                                            echo sprintf( '<button type="submit" data-product_id="%s" data-product_sku="%s" data-quantity="1" class="%s button">%s</button>', esc_attr( $product->id ), esc_attr( $product->get_sku() ), esc_attr( 'single_add_to_cart_button' ), esc_html('Comprar' ) );
                                                        }else{
                                                            echo sprintf('<button type="submit" class="single_add_to_cart_button button alt wc-variation-selection-needed">Comprar</button>');
                                                        }
                                                    }
                                                ?>
                                            </form>
                                         <?php endif;
                                         else: 
                                            echo 'Fora de estoque!';
                                         endif;?>
                                </div>
            <?php 
                            endif;
                        endforeach;
                    endif;
                endif;
            ?>
        </div>
    </div>
</section>