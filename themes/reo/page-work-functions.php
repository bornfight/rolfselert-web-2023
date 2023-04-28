<?php

function get_projects(): array {
	$args = [
		'post_type'      => 'project',
		'post_status'    => 'publish',
		'posts_per_page' => -1
	];

	$query = new WP_Query( $args );

	return $query->posts ?? [];
}

function get_project_image( $project ) {
	$page_hero = get_field( 'page_hero', $project );
	$image_url = '';

	if ( ! empty( $page_hero ) && isset( $page_hero[0]['image']['url'] ) ) {
		$image_url = $page_hero[0]['image']['url'] ?? '';
	}

	return $image_url;
}