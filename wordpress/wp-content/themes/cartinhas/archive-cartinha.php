<?php get_header(); ?>

            <div id="content" class="clearfix row">

                <div id="main" role="main">

                    <div class="page-header">
                        <h1 class="page-title">
                            <span>Cartinhas</span>
                        </h1>
                    </div>

                    <!-- Carrossel -->
                    <div id="archive-cartinhas" class="carousel slide" data-ride="carousel">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                        <?php if (have_posts()) : $i=0; while (have_posts()) : the_post(); ?>
                            <div class="item <?php echo $i===0?'active':''; ?>">
                                <?php the_post_thumbnail('large'); ?>
                                <div class="carousel-caption"></div>
                            </div>
                            <?php $i++; ?>
                        <?php endwhile; ?>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#archive-cartinhas" role="button" data-slide="prev">
                          <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#archive-cartinhas" role="button" data-slide="next">
                          <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                    <!-- /Carrossel -->





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
