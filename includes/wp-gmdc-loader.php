<?php
// load scripts and styles
function clx_gmdc_load_res() {
	wp_enqueue_style( 'clx-gmdc-style', plugins_url( 'css/material.min.css', __FILE__ ) );
	wp_enqueue_style( 'clx-gmdc-fonts', 'https://fonts.googleapis.com/icon?family=Material+Icons' );
	wp_enqueue_script( 'clx-gmdc-script', plugins_url( 'js/material.min.js', __FILE__ ) );
}