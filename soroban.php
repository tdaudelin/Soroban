<?php
/*
Plugin Name: Soroban
Plugin URI: http://#.com
Description: A plugin that renders an interactive soroban abacus on the page
Author: Travis Daudelin
Author URI: 
version: 1.0
*/

add_action('init','soroban_init');

function soroban_init() {

  $plugin_dir = plugin_dir_path( __FILE__ );

  // enqueue the Vue app styles
  wp_enqueue_style( 'soroban-style', plugins_url( 'dist/css/app.bda90eea.css', __FILE__ ) );

  // register the Vue app script.
  wp_register_script( // the app build script generated by Webpack.
    'vue_soroban_app',
    plugins_url( 'dist/js/app.6da687ab.js', __FILE__ ), //*/ 'http://localhost:8080/js/app.js',
    array(),
    false,
    true
  );
  // register the Vue chunk-vendor script.
  wp_register_script( // the app build script generated by Webpack.
    'vue_soroban_chunk_vendors',
    plugins_url( 'dist/js/chunk-vendors.80a7c639.js', __FILE__ ) , //*/ 'http://localhost:8080/js/chunk-vendors.js',
    array(),
    false,
    true
  );
          
  // enqueue the Vue app script with localized data.
  wp_enqueue_script( 'vue_soroban_app' );
  wp_enqueue_script( 'vue_soroban_chunk_vendors' );
}