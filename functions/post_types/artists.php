<?php
//
// artists post type related functions.
//
add_action( 'init', 'ci_create_cpt_artists' );

if( !function_exists('ci_create_cpt_artists') ):
function ci_create_cpt_artists()
{
	$labels = array(
		'name'               => _x( 'Sports Teams', 'post type general name', 'ci_theme' ),
		'singular_name'      => _x( 'Sports Team', 'post type singular name', 'ci_theme' ),
		'add_new'            => __( 'Add New', 'ci_theme' ),
		'add_new_item'       => __( 'Add New Sports Team', 'ci_theme' ),
		'edit_item'          => __( 'Edit Sports Team', 'ci_theme' ),
		'new_item'           => __( 'New Sports Team', 'ci_theme' ),
		'view_item'          => __( 'View Sports Team', 'ci_theme' ),
		'search_items'       => __( 'Search Sports Team', 'ci_theme' ),
		'not_found'          => __( 'No Sports Teams found', 'ci_theme' ),
		'not_found_in_trash' => __( 'No Sports Teams found in the trash', 'ci_theme' ),
		'parent_item_colon'  => __( 'Parent Sports Teams Item:', 'ci_theme' )
	);

	$args = array(
		'labels'          => $labels,
		'singular_label'  => __( 'Sports Team Item', 'ci_theme' ),
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'has_archive'     => _x( 'Sports Team', 'post type archive slug', 'ci_theme' ),
		'rewrite'         => array( 'slug' => _x( 'artists', 'post type slug', 'ci_theme' ) ),
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'       => 'dashicons-admin-users',
	);

	register_post_type( 'cpt_artists' , $args );

}
endif;
