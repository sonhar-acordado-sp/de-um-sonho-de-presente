<?php

define('ROOT_PATH', dirname(dirname(__FILE__)) . '/');

include(ROOT_PATH . 'wordpress/wp-load.php');

require_once ABSPATH . 'wp-admin/includes/import.php';
require_once ABSPATH . 'wp-admin/includes/image.php';


global $url_remap;
$url_remap = array();

global $wpdb;

$SITEURL = 'http://cartinhas.dev/';
$DIR = "/home/fabio/devel/cartinhas/wordpress/wp-content/uploads/Cartinhas/";

$handler = opendir($DIR);

while ($file = readdir($handler)) { // $i = URL da imagem

    $splited = split('\.', $file);

    $file_path = $DIR . $file;
    $file_name = $splited[0];
    $file_ext = $splited[1];
    $file_type = wp_check_filetype(basename( $file_path ), null);

    if($file_ext !== 'jpg') {
        continue;
    }

    // Cria um post
    $postID = wp_insert_post(
        array(
            'post_type'     => 'cartinha',
            'post_title'    => strtoupper($file_name),
            'post_status'   => 'publish',
            'post_author'   => 1
        )
    );

    add_post_meta($postID, 'Alimentação', 0);
    add_post_meta($postID, 'Transporte', 0);
    add_post_meta($postID, 'Camiseta', 0);

    $wp_upload_dir = wp_upload_dir();
    $file_url = 'Cartinhas/' . $file;

    $attachment = array(
        'guid' => $wp_upload_dir['url'],
        'post_mime_type' => $file_type['type'],
        'post_title' => strtoupper($file_name),
        'post_status' => 'publish',
    );

    $attachment_id = wp_insert_attachment($attachment, $file_url, $postID);

    $attach_data = wp_generate_attachment_metadata( $attachment_id, $file_path );
    wp_update_attachment_metadata( $attachment_id, $attach_data );

    set_post_thumbnail($postID, $attachment_id);
}

