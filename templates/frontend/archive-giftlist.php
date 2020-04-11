<?php 
	get_header();
	global $wp_query;
	$wp_query = $giftlists = new WP_Query(array(
		'post_type'			=>		'giftlist',
		's'					=>		$_GET['s'],
		'post_per_page'		=>		'1',
		'orderby' 			=> 		'title',
		'order' 			=> 		'ASC',
		'posts_per_page'	=>		5
	));
    ?>


<section class="archive-page">
	<div class="container">
		<?=do_shortcode('[tecnossauro_giftlist_search_page]');?>
		<!-- Pega as Listas -->
	</div>
</section>
<section class="giftlist-list container">
	<div class="list-result">
		<?php
			if($_GET['s'] != null){
				if($giftlists->have_posts()){
					?>
						<div class="col-12 search-result">Resultados da busca por: <?=$_GET['s']?></div>
						<div class="results column-4">
					<?php
					while($giftlists->have_posts()){
						$giftlists->the_post();
						$giftlist = new Giftlist_Model(get_the_ID(), get_the_title(), get_the_author());
						?>
							<div class="giftlist">
							<a href="<?=get_the_permalink()?>"> 
								<div class="thumb">
									<img src="<?=PLUGIN_URL.'assets/images/archive.jpg'?>"/>
								</div>
								<div class="description">
									<p class="name">
										<?=$giftlist->title?>
									</p>
									<p class="date">
										<?=date("d/m/Y", strtotime($giftlist->date))  ?>
									</p>
									</div>
							</a>
							</div>
						<?php
					}
					?>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="row archive--pagination justify-content-center">	
					<?php clik_pagination(); 
				}else{
					?>
						<div class="col-12 search-result">Nenhuma lista encontrada !</div>
					<?php
				}
			}
			?>
	</div>
	
</section>
<?php
    get_footer();
