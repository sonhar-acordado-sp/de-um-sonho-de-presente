<?php
/*
Template Name: Homepage
*/
?>

<?php get_header(); ?>

            <div id="content" class="clearfix row">

                <img class="placa-da-festa" alt="Título da festa" title="Festa de Natal no Reino da Dignidade"
                     src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/placa.png" />
                <?php
                if (have_posts()):
                    while (have_posts()):
                        the_post();
                ?>
                <?php the_content(); ?>

                <div class="col-sm-12 placas clearfix">
                    <div class="col-sm-6 text-center pull-left">
                        <a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/placa-facebook.png" /></a>
                    </div>
                    <div class="col-sm-6 text-center pull-right">
                        <a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/placa-site-oficial.png" /></a>
                    </div>
                </div>


                <?php endwhile; ?>
                <?php endif; ?>
            </div> <!-- end #content -->

<?php get_footer(); ?>
