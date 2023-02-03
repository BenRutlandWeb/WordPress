<?php

/**
 * HTTP API: WP_Http class
 *
 * @package WordPress
 * @subpackage HTTP
 * @since 2.7.0
 */

if (!class_exists('Requests')) {
    require ABSPATH . WPINC . '/class-requests.php';

    Requests::register_autoloader();
    Requests::set_certificate_path(ABSPATH . WPINC . '/certificates/ca-bundle.crt');
}
