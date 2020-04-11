<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
?>


<div class="table-responsive">
  <table class="table">
  <thead>
		<tr>
			<th>Imagem</th>
			<th>Nome</th>
			<th>Quantidade desejada</th>
			<th>Ação</th>
		</tr>
	</thead>
	<tbody>
	<?php if($giftlist): 
			if($giftlist->items):
				foreach($giftlist->items as $item):?>
					
					<tr>
						<td><img src="<?php echo get_the_post_thumbnail_url($item->product); ?>" width="50" height="50" class="img-responsive" alt=""/></td>
						<td><?=get_the_title( $item->product ); ?></td>
						<td><?= $item->qty ?></td>
						<td>
							<input type="hidden" value="<?= $item->id ?>" name="item-id-remove[]">
                            <a href="javascript:void()" class="button remove-giftlist-adm" style="width: 150px; text-align:center;margin-top:5px;">Remover</a>
						</td>
					</tr>
			<?php endforeach;
				endif;
			endif; ?>
	</tbody>
  </table>
</div>

