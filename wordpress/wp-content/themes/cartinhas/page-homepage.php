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
                <div class="featured-image">
                    <?php the_post_thumbnail('full'); ?>
                </div>

                <div id="status-da-festa" class="col-sm-6">
                    <div class="clearfix item">
                      <a class="media-left col-sm-1" href="#">
                        <img width="60" height="60" src="/wp-content/themes/cartinhas/imgs/free-60-icons-38.png" alt="Alimentação"/>
                      </a>
                      <div class="col-sm-10 pull-right">
                        <h4>Alimentação</h4>
                        <span>Já temos <u>30</u> lanchinhos garantidos!</span>
                      </div>
                    </div>
                    <div class="clearfix item">
                      <a class="media-left col-sm-1" href="#">
                        <img width="60" height="60" src="/wp-content/themes/cartinhas/imgs/free-60-icons-17.png" alt="Transporte"/>
                      </a>
                      <div class="col-sm-10 pull-right">
                        <h4>Transporte</h4>
                        <span>Já conseguiremos transportar <u>100</u> crianças!</span>
                      </div>
                    </div>
                    <div class="clearfix item">
                      <a class="media-left col-sm-1" href="#">
                        <img width="60" height="60" src="/wp-content/themes/cartinhas/imgs/free-60-icons-20.png" alt="Presentes"/>
                      </a>
                      <div class="col-sm-10 pull-right">
                        <h4 class="text-error">Presentes</h4>
                        <span>Já conseguimos <u>90</u> presentes!</span>
                      </div>
                    </div>
                    <div class="clearfix item">
                      <a class="media-left col-sm-1" href="#">
                        <img width="60" height="60" src="/wp-content/themes/cartinhas/imgs/free-60-icons-04.png" alt="Camisetas"/>
                      </a>
                      <div class="col-sm-10 pull-right">
                        <h4>Camisetas</h4>
                        <span>Já conseguimos <u>45</u> camisetas!</span>
                      </div>
                    </div>
                </div>

                <div class="clearfix">
                    <div class="post_content col-sm-6"><?php the_content(); ?></div>
                    <div class="cartinhas col-sm-5 pull-right">
                        <!-- bootstrap carrossel -->
                        <h2>Leia uma cartinha</h2>
                        <div id="home-galeria-cartinhas" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                            <?php $i =0; foreach(list_cartinhas() as $cartinha): ?>
                                <div class="item <?php echo $i===0?'active':''; ?>">
                                    <a href="<?php echo get_permalink($cartinha->ID); ?>">
                                        <?php echo get_the_post_thumbnail($cartinha->ID, 'large'); ?>
                                    </a>
                                    <div class="carousel-caption"></div>
                                </div>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="#home-galeria-cartinhas" role="button" data-slide="prev">
                              <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#home-galeria-cartinhas" role="button" data-slide="next">
                              <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                        <!-- /bootstrap carrossel -->
                    </div>
                </div>
            </div>

            <?php endwhile; ?>
            <?php endif; ?>
<?php get_footer(); ?>
