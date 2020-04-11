
<form action="<?=esc_url(get_post_type_archive_link( 'giftlist' ));?>" method="get" role="search" class="search-form-giftlist">
    <!-- <input type="hidden" name="post_cat" value="product"> -->
    <input type="text" name="s" class="by-name" placeholder="Insira o nome do noivo ou da noiva...">
    <!-- <div class="col-6"><input type="text" name="email" class="by-email" placeholder="E-mail..."></div> -->
    <!-- <input placeholder="Pesquisar por lista..." type="text" name="s" value=""> -->
    <input type="hidden" name="post_type" value="giftlist" />
    <button type="submit">
        <i class="fas fa-search"></i>
    </button>
</form>