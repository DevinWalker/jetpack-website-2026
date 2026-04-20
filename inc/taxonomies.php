<?php
declare( strict_types=1 );

/**
 * Register the 'topics' taxonomy for posts
 * 
 * @return void
 */
function jetpackme_register_topics_taxonomy() {
	$labels = array(
		'name'              => _x( 'Topics', 'taxonomy general name', 'jetpackme' ),
		'singular_name'     => _x( 'Topic', 'taxonomy singular name', 'jetpackme' ),
		'search_items'      => __( 'Search Topics', 'jetpackme' ),
		'all_items'         => __( 'All Topics', 'jetpackme' ),
		'parent_item'       => __( 'Parent Topic', 'jetpackme' ),
		'parent_item_colon' => __( 'Parent Topic:', 'jetpackme' ),
		'edit_item'         => __( 'Edit Topic', 'jetpackme' ),
		'update_item'       => __( 'Update Topic', 'jetpackme' ),
		'add_new_item'      => __( 'Add New Topic', 'jetpackme' ),
		'new_item_name'     => __( 'New Topic Name', 'jetpackme' ),
		'menu_name'         => __( 'Topics', 'jetpackme' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'topic' ),
	);

	register_taxonomy( 'topics', array( 'post' ), $args );
}
add_action( 'init', 'jetpackme_register_topics_taxonomy' );
