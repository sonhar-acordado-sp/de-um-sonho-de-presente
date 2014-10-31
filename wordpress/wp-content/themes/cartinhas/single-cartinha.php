<?php get_header(); ?>

            <div id="content" class="clearfix">

                <header>
                    <div class="page-header"><h1 class="single-title" itemprop="headline">Doar para esta cartinha</h1></div>
                </header>

                <div id="main" class="col-sm-8" role="main">

                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">


                        <section class="post_content clearfix" itemprop="articleBody">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </section> <!-- end article section -->


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

                <div class="col-sm-4 donation-forms" role="main">
                    <h3>Total desta cartinha</h3>
                    <div class="clearfix">
                        <div class="col-sm-11">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                    60%
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>

                    <div class="clearfix item">
                      <a class="media-left col-sm-2 pull-left" href="#">
                        <img width="60" height="60" src="/wp-content/themes/cartinhas/imgs/free-60-icons-38.png" alt="Alimentação"/>
                      </a>
                      <div class="col-sm-9 pull-right">
                        <h4>Alimentação para o dia</h4>
                        <span>R$ <?php echo get_option('doacao_alimentacao'); ?></span>
                        <button class="btn btn-info pull-right"
                                data-value="<?php echo get_option('doacao_alimentacao'); ?>"
                                data-item="AL-<?php the_title(); ?>"
                                data-desc="Doação para alimentação da festa de Natal">Ajudar</button>
                      </div>
                    </div>


                    <div class="clearfix item">
                      <a class="media-left col-sm-2 pull-left" href="#">
                        <img width="60" height="60" src="/wp-content/themes/cartinhas/imgs/free-60-icons-17.png" alt="Transporte"/>
                      </a>
                      <div class="col-sm-9 pull-right">
                        <h4>Transporte até o local</h4>
                        <span>R$ <?php echo get_option('doacao_transporte'); ?></span>
                        <button class="btn btn-info pull-right"
                                data-value="<?php echo get_option('doacao_transporte'); ?>"
                                data-item="TR-<?php the_title(); ?>"
                                data-desc="Doação para o transporte na festa de Natal">Ajudar</button>
                      </div>
                    </div>

                    <div class="clearfix item">
                      <a class="media-left col-sm-2 pull-left" href="#">
                        <img width="60" height="60" src="/wp-content/themes/cartinhas/imgs/free-60-icons-04.png" alt="Camiseta de identificação"/>
                      </a>
                      <div class="col-sm-9 pull-right">
                        <h4>Camiseta de identificação</h4>
                        <span>R$ <?php echo get_option('doacao_camiseta'); ?></span>
                        <button class="btn btn-info pull-right"
                                data-value="<?php echo get_option('doacao_camiseta'); ?>"
                                data-item="CA-<?php the_title(); ?>"
                                data-desc="Doação para camiseta na festa de Natal">Ajudar</button>
                      </div>
                    </div>

                    <hr/>

                    <div class="clearfix text-center"><button class="btn btn-info">Ler outra cartinha</button></div>
                    <hr/>

                    <div class="clearfix text-center">
                        <button class="btn btn-success">Concluir do doação</button>
                        <p><small>Você será redirecionado ao site<br><b>BCash</b> para concluir a doação.</small></p>
                    </div>

                    <hr/>
                    <div class="clearfix text-center">
                        <h3>Ajuda total</h3>
                        <big data-total="0">R$ 33,00</big>
                    </div>
                </div>

            </div> <!-- end #content -->

<?php get_footer(); ?>
