<?php
/*
Template Name: Homepage
*/
?>

<?php get_header(); ?>
            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
            ?>

            <div id="content" class="">
                <h1><?php echo get_bloginfo('name'); ?></h1>
                <div class="featured-image"><?php the_post_thumbnail('full'); ?></div>
                <div class="clearfix">
                    <div class="post_content col-sm-6"><?php the_content(); ?></div>
                    <div class="cartinhas col-sm-6"></div>
                </div>
            </div>

            <?php endwhile; ?>
            <?php endif; ?>
<?php get_footer(); ?>
