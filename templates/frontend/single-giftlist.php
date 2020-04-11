<?php
get_header();
?>

<?= title_template(get_the_title()); ?>

<main class="single-page">
    <div class="container">
        <div class="row">
            <div class="col-12">

              
            <?php
            
            wc_print_notices();
            if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); 
                include_once(TEMPLATES_URL . 'frontend/single-giftlist/giftlist-info.php');
                include_once(TEMPLATES_URL . 'frontend/single-giftlist/giftlist-items.php');
            endwhile; 
        endif
    ?>
    </div>
    </div>
    </div>
</main>
<?php get_footer();