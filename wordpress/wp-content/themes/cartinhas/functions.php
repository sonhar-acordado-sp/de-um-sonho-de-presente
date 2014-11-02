<?php

// esconde barra de admin
add_filter('show_admin_bar', '__return_false');

// registra post type
add_action('init', 'register_cartinha_post_type');
function register_cartinha_post_type() {
    register_post_type('cartinha', array(
        'label' => 'Cartinhas',
        'public' => true,
        'show_ui' => true,
        'rewrite' => true,
        'has_archive' => true,
        'supports' => array( 'title', 'author', 'custom-fields', 'thumbnail' ),
    ));
}

// cuida da herança de estilos do tema pai
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
function enqueue_child_theme_styles() {
    wp_register_style('lato-font', 'http://fonts.googleapis.com/css?family=Lato:300,400,700', array(), '1.0', 'all' );
    wp_register_style('ubuntu-font', 'http://fonts.googleapis.com/css?family=Ubuntu:400,500,700', array(), '1.0', 'all' );
    wp_enqueue_style('lato-font');
    wp_enqueue_style('ubuntu-font');

    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style('child-style', get_stylesheet_uri(), array('parent-style')  );

    if(is_single()){
        wp_enqueue_script('bcash-simple-cart', get_stylesheet_directory_uri() . '/js/bcash-simple-cart.js', array('jquery'), '1.0.0', true );
    }
}


// remove the standard shortcode
remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'gallery_shortcode_sa');

function gallery_shortcode_sa($attr) {
    global $post, $wp_locale;

    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if (!$attr['orderby'] ) {
            unset( $attr['orderby'] );
        }
    }

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) ) {
            $attr['orderby'] = 'post__in';
        }
        $attr['include'] = $attr['ids'];
    }

    $output = "";

    $atts = shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'size'       => 'large',
        'include'    => '',
        'exclude'    => '',
        'link'       => '',
        'indicators' => false
    ), $attr, 'gallery' );

    $id = intval( $atts['id'] );
    $atts['indicators'] = $atts['indicators'] === 'true';

    if ( !empty( $atts['include'] ) ) {
        $_attachments = get_posts(array(
            'include' => $atts['include'],
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby']
        ));

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( ! empty( $atts['exclude'] ) ) {
        $attachments = get_children(array(
            'post_parent' => $id,
            'exclude' => $atts['exclude'],
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby']
        ));
    } else {
        $attachments = get_children(array(
            'post_parent' => $id,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby']
        ));
    }

    $carousel_id = "carousel-for-post-{$id}";

    $output = '<div id="' . $carousel_id . '" class="carousel slide" data-ride="carousel">';
    if ($attachments) {
        $i = 0;

        if($atts['indicators']) {
            $output .= '<ol class="carousel-indicators">';
            foreach ( $attachments as $attachment ) {
                $output .= "<li data-target=\"#{$carousel_id}\" data-slide-to=\"{$i}\"";
                $output .= $i === 0 ? " class=\"active\">" : ">";
                $output .= "</li>";
                $i = $i + 1;
            }
            $output .= '</ol>';
        }

        $i = 0;
        $output .= '<div class="carousel-inner">';
        foreach ( $attachments as $attachment ) {
            $active_class = $i === 0 ? ' active' : '';

            $output .= "<div class=\"item{$active_class}\">";
            $output .= wp_get_attachment_image($attachment->ID, $atts['size']);
            //$output .= "<div class=\"carousel-caption\">{$attachment->post_title}</div>";
            $output .= '</div>'; // item
            $i = $i + 1;
        }
        $output .= '</div>'; // carousel-inner

        $output .= "<a class=\"left carousel-control\" href=\"#{$carousel_id}\" role=\"button\" data-slide=\"prev\">";
        $output .= "<span class=\"glyphicon glyphicon-chevron-left\"></span>";
        $output .= "</a>";
        $output .= "<a class=\"right carousel-control\" href=\"#{$carousel_id}\" role=\"button\" data-slide=\"next\">";
        $output .= "<span class=\"glyphicon glyphicon-chevron-right\"></span>";
        $output .= "</a>";

    }
    $output .= '</div>'; // carousel

    return $output;
}


add_action( 'admin_menu', 'theme_options' );
add_action( 'admin_init', 'register_cartinhas_settings' );

function register_cartinhas_settings() {
    register_setting( 'cartinhas_options', 'doacao_alimentacao' );
    register_setting( 'cartinhas_options', 'doacao_transporte' );
    register_setting( 'cartinhas_options', 'doacao_camiseta' );
    register_setting( 'cartinhas_options', 'doacao_meta_por_carta' );
    register_setting( 'cartinhas_options', 'email_da_loja' );
    register_setting( 'cartinhas_options', 'url_retorno_bcash' );
}

function theme_options() {
    add_options_page( 'Opções do Sonhador', 'Cartinhas', 'manage_options', 'theme-cartinhas', 'cartinhas_options' );
}

function cartinhas_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    ?>

    <style type="text/css">
        #cartinhas-config-form table td {
            min-width: 5em;
        }
        #cartinhas-config-form table td:last-child {
            text-align: center;
        }

        #cartinhas-config-form table td span:before {
            content: 'R$ ';
        }
    </style>

    <div id="cartinhas-config-form" class="wrap">
        <form method="post" action="options.php">
            <?php
                settings_fields( 'cartinhas_options' );
                do_settings_sections( 'cartinhas_options' );
            ?>

            <h1>Configuração do tema Cartinhas</h1>
            <hr />
            <h2><!-- O status do save vem depois do primeiro H2 --></h2>


            <h2>Valores para doação</h2>
            <p>
                O valor para doação de <b>transporte</b>,
                <b>alimentação</b> ea <b>camiseta</b> é único e
                deve ser fornecido abaixo.
            </p>

            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Novo</th>
                        <th>Atual</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label for="doacao_alimentacao">Valor para alimentação:</label></td>
                        <td><input name="doacao_alimentacao" id="doacao_alimentacao" type="number"
                                   value="<?php echo get_option('doacao_alimentacao'); ?>"/></td>
                        <td><span><?php echo get_option('doacao_alimentacao'); ?></span></td>
                    </tr>
                    <tr>
                        <td><label for="doacao_transporte">Valor para transporte:</label></td>
                        <td><input name="doacao_transporte" id="doacao_transporte" type="number"
                                   value="<?php echo get_option('doacao_transporte'); ?>"/></td>
                        <td><span><?php echo get_option('doacao_transporte'); ?></span></td>
                    </tr>
                    <tr>
                        <td><label for="doacao_camiseta">Valor para camiseta:</label></td>
                        <td><input name="doacao_camiseta" id="doacao_camiseta" type="number"
                                   value="<?php echo get_option('doacao_camiseta'); ?>"/></td>
                        <td><span><?php echo get_option('doacao_camiseta'); ?></span></td>
                    </tr>
                    <tr>
                        <td><label for="doacao_meta_por_carta">Valor meta por carta:</label></td>
                        <td><input name="doacao_meta_por_carta" id="doacao_meta_por_carta" type="number"
                                   value="<?php echo get_option('doacao_meta_por_carta'); ?>"/></td>
                        <td><span><?php echo get_option('doacao_meta_por_carta'); ?></span></td>
                    </tr>
                </tbody>
            </table>
            <hr />

            <h2>Configurações do BCash</h2>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Novo</th>
                        <th>Atual</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label for="email_da_loja">Email da loja:</label></td>
                        <td><input name="email_da_loja" id="email_da_loja" type="email"
                                   value="<?php echo get_option('email_da_loja'); ?>"/></td>
                        <td><?php echo get_option('email_da_loja'); ?></td>
                    </tr>
                    <tr>
                        <td><label for="url_retorno_bcash">URL de retorno:</label></td>
                        <td><input name="url_retorno_bcash" id="url_retorno_bcash" type="text"
                                   value="<?php echo get_option('url_retorno_bcash'); ?>"/></td>
                        <td><?php echo get_option('url_retorno_bcash'); ?></td>
                    </tr>
                </tbody>
            </table>
            <hr />

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function __add_settings_control($wp_customize, $label, $key, $default) {
    $wp_customize->add_setting($key, array(
        'default' => $default, 'type' => 'option', 'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, array(
        'label'    => $label, 'section'  => 'colors',
    )));
}

function cartinhas_customize_register($wp_customize){
    __add_settings_control($wp_customize, __('Menu text color'), 'cartinhas_header_menu_color', '#000000');
    __add_settings_control($wp_customize, __('Menu text hover color'), 'cartinhas_header_menu_color_hover', '#000000');
    __add_settings_control($wp_customize, __('Menu text shadow'), 'cartinhas_header_menu_text_shadow', '#FFFFFF');
}
add_action('customize_register', 'cartinhas_customize_register');


function cartinhas_custom_css()
{
    ?>
         <style type="text/css">
             .navbar-default .navbar-nav > li > a {
                color: <?php echo get_option('cartinhas_header_menu_color', '#000000'); ?>;
                text-shadow: 0 0 3px <?php echo get_option('cartinhas_header_menu_text_shadow', '#FFF'); ?>;
            }
             .navbar-default .navbar-nav > li > a:hover {
                color: <?php echo get_option('cartinhas_header_menu_color_hover', '#000000'); ?>;
            }
         </style>
    <?php
}
add_action( 'wp_head', 'cartinhas_custom_css');


/*
 * Funções do nosso negócio
 */

function list_cartinhas() {
    $args = array(
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'post_type'        => 'cartinha',
        'post_status'      => 'publish'
    );
    return get_posts($args);
}

function calculate_achieved($subject) {
    global $wpdb;

    $dict = array(
        'Alimentação' => 'alimentacao',
        'Transporte' => 'transporte',
        'Camiseta' => 'camiseta'
    );
    $single_key = 'doacao_' . $dict[$subject];

    $query = "SELECT SUM(meta_value) FROM $wpdb->postmeta WHERE meta_key=%s;";
    $query = $wpdb->prepare($query, $subject);

    $single = get_option($single_key);
    $sum = $wpdb->get_var($query);

    $single = intval($single);
    $sum = intval($sum);

    if($single > 0) {
        return intval($sum / $single);
    }
    return 0;
}
