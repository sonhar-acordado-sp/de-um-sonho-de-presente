<?php get_header(); ?>

            <div id="content" class="clearfix row">

                <div id="main" role="main">

                    <div class="page-header"><h1><span>Resultados:</span> <?php echo esc_attr(get_search_query()); ?></h1></div>
                    <p>Se você não encontrou a cartinha que estava procurando, tente buscá-la novamente utilizando 4 números, como no exemplo: XX<b>0123</b></p>

                    <?php if (have_posts()) :?>

                    <div class="clearfix">
                        <?php while (have_posts()) : the_post(); ?>
                        <div id="post-<?php the_ID(); ?>" <?php post_class('col-sm-3'); ?> role="article">
                            <a href="<?php the_permalink() ?>" class="thumbnail text-center" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail(); ?>
                                <small><?php the_title();?></small>
                            </a>
                        </div> <!-- end article -->
                        <?php endwhile; ?>
                    </div>

                    <?php if (function_exists('page_navi')) { // if expirimental feature is active ?>
                    <div class="text-center">
                        <?php page_navi(); // use the page navi function ?>
                    </div>

                    <?php } else { // if it is disabled, display regular wp prev & next links ?>
                        <nav class="wp-prev-next">
                            <ul class="clearfix">
                                <li class="prev-link"><?php next_posts_link(_e('&laquo; Older Entries', "wpbootstrap")) ?></li>
                                <li class="next-link"><?php previous_posts_link(_e('Newer Entries &raquo;', "wpbootstrap")) ?></li>
                            </ul>
                        </nav>
                    <?php } ?>

                    <?php else : ?>

                    <!-- this area shows up if there are no results -->

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

            </div> <!-- end #content -->

<?php get_footer(); ?>
