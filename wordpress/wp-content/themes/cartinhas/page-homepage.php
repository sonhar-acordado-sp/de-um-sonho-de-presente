<?php
/*
Template Name: Homepage
*/
?>

<?php get_header(); ?>

            <div id="content" class="clearfix row">

                <div id="main" class="col-sm-12 clearfix" role="main">

                    <?php
                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                    ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

                        <header>
                            <?php
                                $post_thumbnail_id = get_post_thumbnail_id();
                                $featured_src = wp_get_attachment_image_src( $post_thumbnail_id, 'wpbs-featured-home' );
                            ?>
                        </header>

                        <div id="post_medias_carousel" class="carousel slide post_medias" data-ride="carousel">
                              <ol class="carousel-indicators">
                              <?php
                                // pegar imagens tipo attachments
                                $carousel_images = array_values(get_attached_media('image')); ?>

                              <?php foreach ($carousel_images as $i => $image): ?>
                                <li data-target="#post_medias_carousel"
                                    data-slide-to="<?php echo $i;?>"
                                    class="<?php echo $i===0?' active':''; ?>"></li>

                              <?php endforeach; ?>
                              </ol>

                              <div class="carousel-inner">
                              <?php foreach ($carousel_images as $i => $image): ?>
                                <div class="item<?php echo $i===0?' active':''; ?>">
                                  <img alt="Foto <?php echo $i;?> da festa de Natal"
                                       src="<?php echo $image->guid; ?>"/>
                                </div>

                              <?php endforeach; ?>
                              </div>

                              <a class="left carousel-control" href="#post_medias_carousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                              </a>
                              <a class="right carousel-control" href="#post_medias_carousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                              </a>
                        </div>

                        <section class="post_content">
                            <?php the_content(); ?>
                        </section> <!-- end article header -->

                        <footer>
                            <p class="clearfix"><?php the_tags('<span class="tags">' . __("Tags","wpbootstrap") . ': ', ', ', '</span>'); ?></p>
                        </footer> <!-- end article footer -->

                    </article> <!-- end article -->

                    <?php endwhile; ?>

                    <?php else : ?>

                    <article id="post-not-found">
                        <header>
                            <h1><?php _e("Not Found", "wpbootstrap"); ?></h1>
                        </header>
                        <section class="post_content">
                            <p><?php _e("Sorry, but the requested resource was not found on this site.", "wpbootstrap"); ?></p>
                        </section>
                        <footer>
                        </footer>
                    </article>

                    <?php endif; ?>

                </div> <!-- end #main -->

                <?php //get_sidebar(); // sidebar 1 ?>

            </div> <!-- end #content -->

<?php get_footer(); ?>
