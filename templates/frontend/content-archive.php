<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 item-listagem-lista">
	
<div class="row">
	<div class="col-4 thumbnail-listagem-lista">
	<?php the_post_thumbnail( 'thumbnail' ); ?>
			<!-- <a href="/Content/Images/no-image.jpg">
				<img src="/Content/Images/no-image.jpg" class="" width="150" height="150">
			</a> -->
			<img src="<?=PLUGIN_URL . '/assets/images/archive.jpg';?>"/>
	</div>
	<div class="col-8">
			<h5 class="lista-nome-anfitriao"><?=$giftlist->title?></h5>
		<p class="event-date"><i class="far fa-calendar-alt"></i><?=$giftlist->date?></p>
		<a href="<?=get_permalink()?>" class="button bordered-button" role="button"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; Ver lista</a>
	</div>
</div>
</div>