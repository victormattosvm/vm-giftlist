<section class="tab-control">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a href="javascript:void()" class="nav-link nav-dados active">Dados da lista</a>
        </li>
        <li class="nav-item">
            <a href="javascript:void()" class="nav-link nav-lista">Lista de presentes</a>
        </li>
    </ul>
    <?php remove_giftlist(); 
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
    ?>
    
    <div class="content">
        <div class="content-dados">
            <?php include_once(PLUGIN_PATH . '/templates/frontend/create-change-giftlist.php'); ?>
        </div>
        <div class="content-lista" style="display:none;">
            <div class="table-responsive woocommerce">
                <table class="table shop_table">
                    <thead>
                        <tr>
                            <th class="product-thumbnail">&nbsp;</th>
                            <th class="product-name">Produto</th>
                            <th class="product-price">Preço</th>
                            <th class="product-quantity">Quantidade desejada</th>
                            <th class="product-quantity">Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        
                        if($giftlist): 
                            if($giftlist->items):
                                    foreach($giftlist->items as $item):
                                        $product = wc_get_product( $item->product );
                                        if($product):
                                    ?>
                            
                                <tr>
                                <td><a href="<?=$product->get_permalink();?>"><img src="<?php echo get_the_post_thumbnail_url($item->product); ?>" width="50" height="50" class="img-responsive" alt=""/></a></td>
                                <td><a href="<?=$product->get_permalink();?>"><?=get_the_title( $item->product ); ?></a></td>
                                <td><?= $product->get_price_html() ?></td>
                                <td><?= $item->qty ?></td>
                                
                                <td class="product-quantity"><?= woocommerce_quantity_input(
                                                array(
                                                    'max_value'=>$item->qty,
                                                    'min_value'=>1,
                                                    ),
                                                    $product) ?></td>
                                <td>
                                    <a href="<?=$product->get_permalink();?>" class="button" style="width: 150px; text-align:center;">Ver produto</a>
                                    <form action="" method="POST" class="form-remove">
                                        <input type="hidden" name="product-name" value="<?=get_the_title( $item->product ); ?>">
                                        <input type="hidden" name="item-id" value="<?= $item->id ?>">
                                        <input type="hidden" name="giftlist-id" value="<?= $giftlist->id ?>">
                                        <button type="submit" name="remove-giftlist" value="remove-giftlist" class="button remove-giftlist" style="width: 150px; text-align:center;margin-top:5px;">Remover</button>
                                    </form>
                                </td>
                                </tr>
                                        <?php endif;
                                        endforeach;
                            endif;
                        endif; 
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>