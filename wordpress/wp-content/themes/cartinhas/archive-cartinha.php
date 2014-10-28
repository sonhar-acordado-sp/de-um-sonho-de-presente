<?php get_header(); ?>

            <div id="content" class="clearfix row">

                <div id="main" role="main">

                    <div class="page-header">
                        <h1 class="page-title">
                            <span>Cartinhas</span>
                        </h1>
                    </div>

                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <div class="col-sm-4 cartinha" id="post-<?php the_ID(); ?>">
                        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    </div>

                    <?php endwhile; ?>


                    <?php else : ?>
                        <article id="post-not-found">
                            <header>
                                <h1><?php _e("No Posts Yet", "wpbootstrap"); ?></h1>
                            </header>
                            <section class="post_content">
                                <p><?php _e("Sorry, What you were looking for is not here.", "wpbootstrap"); ?></p>
                            </section>
                            <footer>
                            </footer>
                        </article>
                    <?php endif; ?>

                </div> <!-- end #main -->
            </div> <!-- end #content -->

<?php get_footer(); ?>
