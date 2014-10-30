<?php get_header(); ?>

            <div id="content" class="clearfix row">

                <div id="main" class="col-sm-8 clearfix" role="main">

                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

                        <header>
                            <div class="page-header"><h1 class="single-title" itemprop="headline">Doar para esta cartinha</h1></div>
                        </header> <!-- end article header -->

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

                <div class="col-sm-4 clearfix" role="main">
                    <form name="bcash-al" action="https://www.bcash.com.br/checkout/pay/" method="post">
                        <input name="email_loja" type="hidden" value="<?php echo get_option('email_da_loja'); ?>">

                        <input name="produto_codigo_1" type="hidden" value="AL-<?php the_title(); ?>">
                        <input name="produto_descricao_1" type="hidden" value="Contribuição para alimentação (<?php the_title(); ?>)">
                        <input name="produto_qtde_1" type="hidden" value="1">
                        <input name="produto_valor_1" type="hidden"
                               value="<?php echo get_option('doacao_alimentacao'); ?>">
                        <input name="url_retorno" type="hidden"
                               value="<?php echo get_option('url_retorno_bcash'); ?>">

                        <button>Contribuir com a alimentação</button>
                    </form>

                    <form name="bcash-tr" action="https://www.bcash.com.br/checkout/pay/" method="post">
                        <input name="email_loja" type="hidden" value="<?php echo get_option('email_da_loja'); ?>">

                        <input name="produto_codigo_1" type="hidden" value="TR-<?php the_title(); ?>">
                        <input name="produto_descricao_1" type="hidden" value="Contribuição para o transporte (<?php the_title(); ?>)">
                        <input name="produto_qtde_1" type="hidden" value="1">
                        <input name="produto_valor_1" type="hidden"
                               value="<?php echo get_option('doacao_transporte'); ?>">
                        <input name="url_retorno" type="hidden"
                               value="<?php echo get_option('url_retorno_bcash'); ?>">

                        <button>Contribuir com o transporte</button>
                    </form>

                    <form name="bcash-ca" action="https://www.bcash.com.br/checkout/pay/" method="post">
                        <input name="email_loja" type="hidden" value="<?php echo get_option('email_da_loja'); ?>">

                        <input name="produto_codigo_1" type="hidden" value="AL-<?php the_title(); ?>">
                        <input name="produto_descricao_1" type="hidden" value="Contribuição para a camiseta (<?php the_title(); ?>)">
                        <input name="produto_qtde_1" type="hidden" value="1">
                        <input name="produto_valor_1" type="hidden"
                               value="<?php echo get_option('doacao_camiseta'); ?>">
                        <input name="url_retorno" type="hidden"
                               value="<?php echo get_option('url_retorno_bcash'); ?>">

                        <button>Contribuir com a camiseta</button>
                    </form>
                </div>

            </div> <!-- end #content -->

<?php get_footer(); ?>
