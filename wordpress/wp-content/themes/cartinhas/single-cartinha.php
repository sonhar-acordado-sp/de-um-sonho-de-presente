<?php get_header(); ?>

            <div id="content" class="clearfix">

                <header>
                    <div class="page-header"><h1 class="single-title" itemprop="headline">Doar para esta cartinha</h1></div>
                </header>

                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div id="main" class="col-sm-8" role="main">


                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">


                        <section class="post_content clearfix" itemprop="articleBody">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </section> <!-- end article section -->


                    </article> <!-- end article -->

                </div> <!-- end #main -->

                <div class="col-sm-4 donation-forms" role="main">
                    <h3 class="text-center">Total desta cartinha</h3>
                    <input type="hidden" name="codigo-cartinha" value="<?php the_title(); ?>" />
                    <div class="clearfix">
                        <div class="col-sm-11">
                            <div class="progress">
                                <?php $achieved = calculate_achieved_for_cartinha();
                                      $desired = intval(get_option('doacao_meta_por_carta'));
                                      $percent = $desired > 0 ? intval($achieved/$desired * 100) : 0;?>
                                <div class="progress-bar" role="progressbar"
                                     aria-valuenow="<?php echo calculate_achieved_for_cartinha(); ?>"
                                     aria-valuemin="0" aria-valuemax="100"
                                     style="width: <?php echo $percent;?>%;">
                                </div>
                            </div>
                            <div class="text-center"><?php echo sprintf('R$ %0.2f', $achieved); ?></div>
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
                        <button class="btn btn-info pull-right donation btn-AL-<?php the_title(); ?>"
                                name="<?php the_title(); ?>"
                                data-value="<?php echo get_option('doacao_alimentacao'); ?>"
                                value="doacao_alimentacao">Ajudar</button>
                      </div>
                    </div>


                    <div class="clearfix item">
                      <a class="media-left col-sm-2 pull-left" href="#">
                        <img width="60" height="60" src="/wp-content/themes/cartinhas/imgs/free-60-icons-17.png" alt="Transporte"/>
                      </a>
                      <div class="col-sm-9 pull-right">
                        <h4>Transporte até o local</h4>
                        <span>R$ <?php echo get_option('doacao_transporte'); ?></span>
                        <button class="btn btn-info pull-right donation btn-TR-<?php the_title(); ?>"
                                name="<?php the_title(); ?>"
                                data-value="<?php echo get_option('doacao_transporte'); ?>"
                                value="doacao_transporte">Ajudar</button>
                      </div>
                    </div>

                    <div class="clearfix item">
                      <a class="media-left col-sm-2 pull-left" href="#">
                        <img width="60" height="60" src="/wp-content/themes/cartinhas/imgs/free-60-icons-04.png" alt="Camiseta de identificação"/>
                      </a>
                      <div class="col-sm-9 pull-right">
                        <h4>Camiseta de identificação</h4>
                        <span>R$ <?php echo get_option('doacao_camiseta'); ?></span>
                        <button class="btn btn-info pull-right donation btn-CA-<?php the_title(); ?>"
                                name="<?php the_title(); ?>"
                                data-value="<?php echo get_option('doacao_camiseta'); ?>"
                                value="doacao_camiseta">Ajudar</button>
                      </div>
                    </div>

                    <hr/>

                    <div class="clearfix text-center"><button class="btn btn-info">Ler outra cartinha</button></div>
                    <hr/>

                    <div class="clearfix text-center">
                        <button class="btn btn-success bcash-conclude">Concluir doação</button>
                        <p class="text-info"><small>Você será redirecionado ao site<br><b>BCash</b> para concluir a doação.</small></p>
                    </div>

                    <hr/>
                    <div class="clearfix">
                        <div class="text-center">
                            <h3>Ajuda total</h3>
                            <big class="bcash-total">R$ 0,00</big>
                        </div>
                    </div>

                    <hr/>
                    <div class="clearfix">
                        <div class="text-center">
                            <h3>Resumo</h3>
                            <p><small class="text-danger">Abaixo, a sua lista de doações.<br/>
                            Você pode remover itens desta lista.</small></p>
                        </div>
                        <br />
                        <ul class="bcash-list">

                        </ul>
                    </div>
                </div>

                <?php endwhile; ?>

                <?php else : ?>
                    <div id="main" class="clearfix">
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
                    </div>
                <?php endif; ?>
            </div> <!-- end #content -->

<?php get_footer(); ?>
