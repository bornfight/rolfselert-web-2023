<?php
function get_number_of_projects_per_page(): int {
	return 9;
}

function get_number_of_page_links(): int {
	return 5;
}

function get_all_projects(): array {
	$query_data = get_custom_query( '-1' );

	return $query_data->posts ?? [];
}

function is_available( $cur, $max, $i ): bool {
	$cur = intval( $cur );
	$max = intval( $max );
	$i   = intval( $i );

	if ( $max > get_number_of_page_links() ) {
		if ( $i === 1  || $i === $cur || $i === $max ) {
			return true;
		}

		if ( ( $cur + get_number_of_page_links() ) <= $i ) {
			var_dump( $cur + get_number_of_page_links() );
			var_dump( $i );
			return true;
		}
	}

	return false;
}

function get_paged_projects(): array {
	$query_data = get_custom_query( get_number_of_projects_per_page() );

	return $query_data->posts ?? [];
}

function max_projects(): int {
	$args = [
		'post_type'      => 'project',
		'post_status'    => 'publish',
		'posts_per_page' => -1
	];

	$query_data = new WP_Query( $args );

	return count( $query_data->posts );
}

function max_pages(): int {
	$per_page       = intval( get_number_of_projects_per_page() );
	$total_projects = intval( max_projects() );

	return intval( ceil( $total_projects / $per_page ) );
}

function get_project_image( $project ) {
	$page_hero = get_field( 'page_hero', $project );
	$image_url = '';

	if ( ! empty( $page_hero ) && isset( $page_hero[0]['image']['url'] ) ) {
		$image_url = $page_hero[0]['image']['url'] ?? '';
	}

	return $image_url;
}

function get_custom_query( $nr ): WP_Query {
	$args = [
		'post_type'      => 'project',
		'post_status'    => 'publish',
		'posts_per_page' => $nr
	];

	if ( $nr !== '-1' ) {
		$paged         = strval( $_GET['page'] ?? '1' );
		$args['paged'] = $paged;
	}

	return new WP_Query( $args );
}
