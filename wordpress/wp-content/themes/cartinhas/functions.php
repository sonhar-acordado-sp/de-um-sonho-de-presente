<?php

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
    wp_enqueue_style('lato-font' );

    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style('child-style', get_stylesheet_uri(), array('parent-style')  );
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
            $output .= wp_get_attachment_link($attachment->ID, $atts['size'], true, false );
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
