<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include WPSD_PATH . 'front/view/template/header.php';

if ( 'classic' === $template ) {
    include WPSD_PATH . 'front/view/template/classic.php';
}

if ( 'modern' === $template ) {
    include WPSD_PATH . 'front/view/template/modern.php';
}
?>