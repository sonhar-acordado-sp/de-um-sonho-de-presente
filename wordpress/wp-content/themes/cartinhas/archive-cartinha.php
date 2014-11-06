<?php get_header(); ?>

            <div id="content" class="clearfix row">

                <div id="main" role="main">

                    <div class="page-header">
                        <h1 class="page-title">
                            <span>Cartinhas</span>
                        </h1>
                    </div>
                    <?php if (have_posts()) :?>

                    <div class="clearfix">
                        <?php while (have_posts()) : the_post(); ?>
                        <div id="post-<?php the_ID(); ?>" <?php post_class('col-sm-3'); ?> role="article">
                            <a href="<?php the_permalink() ?>" class="thumbnail text-center" title="<?php the_title_attribute(); ?>"
                               style="background-color: <?php echo get_background_color_for_cartinha(get_the_ID()); ?>">
                                <?php the_post_thumbnail(); ?>
                                <small><?php the_title();?></small>

                                <?php if(get_post_meta(get_the_ID(), 'Camiseta', true )): ?>
                                <span class="camiseta"></span>
                                <?php endif;?>

                                <?php if(get_post_meta(get_the_ID(), 'Alimentação', true )): ?>
                                <span class="alimentacao"></span>
                                <?php endif;?>

                                <?php if(get_post_meta(get_the_ID(), 'Transporte', true )): ?>
                                <span class="transporte"></span>
                                <?php endif;?>
                            </a>
                        </div> <!-- end article -->
                        <?php endwhile; ?>
                    </div>

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
