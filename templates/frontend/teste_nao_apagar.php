


<section class="tab-control">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link nav-dados active" href="#">Dados da lista</a>
    </li>
    <li class="nav-item">
      <a class="nav-link nav-lista" href="#">Lista de produtos</a>
    </li>
  </ul>
  <div class="content">
      <div class="content-dados">
        <form action="" method='POST'>

        </form>
        <div class="details">
          <div class="table-responsive">
            <table class="table-detail">
            <?php 
              $data_evento = get_post_meta($giftlist->id, '_data_evento', false);
              $endereco_evento = get_post_meta($giftlist->id, '_endereco_evento', false);
              $telefone = get_post_meta($giftlist->id, '_telefone', false);
            ?>

            <tbody>
                  <tr>
                      <td>Data: </td>
                      <td><?= date('d/m/Y',strtotime($data_evento[0])) ?></td>
                  </tr>
                  <tr>
                      <td>Localização: </td>
                      <td><?= $endereco_evento[0] ?></td>
                  </tr>
                  <tr>
                      <td>Telefone: </td>
                      <td class="mask-phone"><?= $telefone[0] ?></td>
                  </tr>
            </tbody>
            </table>
          </div>
        </div>
      </div>    
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
    <?php if($giftlist): 
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
                <a href="<?=$product->get_permalink();?>" class="button">Ver produto</a>
              </td>
            </tr>
                      <?php endif;
                      endforeach;
          endif;
        endif; ?>
    </tbody>
    </table>
  </div>

  </div>
</section>      
