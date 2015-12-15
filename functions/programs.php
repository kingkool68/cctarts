<?php
function ccta_register_program_types() {

	$labels = array(
		'name'                  => 'Programs',
		'singular_name'         => 'Program',
		'menu_name'             => 'Programs',
		'name_admin_bar'        => 'Programs',
		'parent_item_colon'     => 'Parent Program:',
		'all_items'             => 'All Programs',
		'add_new_item'          => 'Add New Program',
		'add_new'               => 'Add New',
		'new_item'              => 'New Program',
		'edit_item'             => 'Edit Program',
		'update_item'           => 'Update Program',
		'view_item'             => 'View Program',
		'search_items'          => 'Search Program',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'items_list'            => 'Programs list',
		'items_list_navigation' => 'Programs list navigation',
		'filter_items_list'     => 'Filter programs list',
	);
	$args = array(
		'label'                 => 'Program',
		'description'           => 'CCTA Programs',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-clipboard',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'program', $args );

	$labels = array(
		'name'                       => 'Programs',
		'singular_name'              => 'Program',
		'menu_name'                  => 'Programs',
		'all_items'                  => 'All Programs',
		'parent_item'                => 'Parent Program',
		'parent_item_colon'          => 'Parent Program:',
		'new_item_name'              => 'New Program Name',
		'add_new_item'               => 'Add New Program',
		'edit_item'                  => 'Edit Program',
		'update_item'                => 'Update Program',
		'view_item'                  => 'View Program',
		'separate_items_with_commas' => 'Separate programs with commas',
		'add_or_remove_items'        => 'Add or remove programs',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Programs',
		'search_items'               => 'Search Programs',
		'not_found'                  => 'Not Found',
		'items_list'                 => 'Programs list',
		'items_list_navigation'      => 'Programs list navigation',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'programs', array( 'program' ), $args );

}
add_action( 'init', 'ccta_register_program_types', 0 );

function ccta_programs_enqueue_scripts( $hook ) {
	if( $hook != 'post.php' && $hook != 'post-new.php' ) {
		return;
	}

	$post = get_post();
	$post_type = $post->post_type;
	if( $post_type != 'program' ) {
		return;
	}

	wp_enqueue_style( 'ccta-program-admin', get_template_directory_uri() . '/css/admin-programs.css', array(), null, 'all' );
}
add_action( 'admin_enqueue_scripts', 'ccta_programs_enqueue_scripts' );


function ccta_program_options_add_metabox( $post_type ) {
	if( $post_type != 'program' ) {
		return;
	}
	add_meta_box( 'ccta-program-options' , 'Program Details', 'ccta_program_options_metabox', $post_type, 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'ccta_program_options_add_metabox' );

function ccta_program_options_save_metabox($post_id) {
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	}
	if( defined('DOING_AJAX') && DOING_AJAX ) {
		return $post_id;
	}
	if( strstr( $_SERVER['REQUEST_URI'], 'edit.php' ) ) { //Detects if the save action is coming from a quick edit/batch edit.
		return $post_id;
	}

	if( isset($_REQUEST['ccta_program_options_nonce']) && wp_verify_nonce( $_REQUEST['ccta_program_options_nonce'], 'ccta-program-options' ) ) {
		update_post_meta( $post_id, 'ccta-program-options', $_REQUEST['ccta-program-options'] );
	}
}
add_action( 'save_post', 'ccta_program_options_save_metabox', 10, 2 );

function ccta_program_options_metabox($post, $box) {
	$old_data = get_ccta_program_options();
	// echo '<pre>';
	// var_dump( $old_data );
	// echo '</pre>';
	?>
		<h3 class="programs-heading">Date & Time</h3>
		<p class="programs-half-width">
			<label for="program-options-start-date">Start Date</label>
			<input type="date" name="ccta-program-options[start-date]" id="program-options-start-date" class="widefat" value="<?php echo esc_attr( date( 'Y-m-d', strtotime( $old_data['start-date'] ) ) ); ?>">
		</p>

		<p class="programs-half-width">
			<label for="program-options-end-date">End Date</label>
			<input type="date" name="ccta-program-options[end-date]" id="program-options-end-date" class="widefat" value="<?php echo esc_attr( date( 'Y-m-d', strtotime( $old_data['end-date'] ) ) ); ?>">
		</p>

		<p class="programs-half-width">
			<label for="program-options-start-time">Start Time</label>
			<input type="time" name="ccta-program-options[start-time]" id="program-options-start-time" class="widefat" value="<?php echo esc_attr( $old_data['start-time'] ); ?>">
		</p>

		<p class="programs-half-width">
			<label for="program-options-end-time">End Time</label>
			<input type="time" name="ccta-program-options[end-time]" id="program-options-end-time" class="widefat" value="<?php echo esc_attr( $old_data['end-time'] ); ?>">
		</p>

		<p class="programs-day-of-the-week">
			Day(s) of the Week
			<?php
				$days = array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' );
				foreach( $days as $day ) {
					$val = strtolower( $day );
					$checked = '';
					if( is_array( $old_data['day-of-the-week'] )  ) {
						if( in_array( $val, $old_data['day-of-the-week'] ) ) {
							$checked = 'checked';
						}
					}
					?>
					<label><input type="checkbox" name="ccta-program-options[day-of-the-week][]" value="<?php echo $val; ?>" <?php echo $checked; ?>><?php echo $day; ?></label>
					<?php
				}
			?>
		</p>

		<h3 class="programs-heading">Location</h3>
		<p>
			<label for="program-options-location-name">Location Name</label>
			<input type="text" name="ccta-program-options[location-name]" id="program-options-location-name" class="widefat" value="<?php echo esc_attr( $old_data['location-name'] ); ?>">
		</p>

		<p>
			<label for="program-options-location-street-address">Street Address</label>
			<input type="text" name="ccta-program-options[street-address]" id="program-options-location-street-address" class="widefat" value="<?php echo esc_attr( $old_data['street-address'] ); ?>">
		</p>

		<p>
			<label for="program-options-location-city">Location City</label>
			<input type="text" name="ccta-program-options[location-city]" id="program-options-location-city" class="widefat" value="<?php echo esc_attr( $old_data['location-city'] ); ?>">
		</p>

		<p class="programs-half-width">
			<label for="program-options-location-state">Location State</label>
			<input type="text" name="ccta-program-options[location-state]" id="program-options-location-state" class="widefat" value="<?php echo esc_attr( $old_data['location-state'] ); ?>">
		</p>

		<p class="programs-half-width">
			<label for="program-options-location-zip-code">Location Zip Code</label>
			<input type="text" name="ccta-program-options[location-zip-code]" id="program-options-location-zip-code" class="widefat" value="<?php echo esc_attr( $old_data['location-zip-code'] ); ?>">
		</p>


		<h3 class="programs-heading">Other Information</h3>
		<p>
			<label for="program-options-registration-link">Registration Link</label>
			<input type="url" name="ccta-program-options[registration-link]" id="program-options-registration-link" class="widefat" value="<?php echo esc_attr( $old_data['registration-link'] ); ?>">
		</p>

		<p class="programs-half-width">
			<label for="program-options-min-age">Minimum Age</label>
			<input type="number" name="ccta-program-options[min-age]" id="program-options-min-age" class="widefat" value="<?php echo esc_attr( $old_data['min-age'] ); ?>">
		</p>

		<p class="programs-half-width">
			<label for="program-options-max-age">Maximum Age</label>
			<input type="number" size="3" name="ccta-program-options[max-age]" id="program-options-max-age" class="widefat" value="<?php echo esc_attr( $old_data['max-age'] ); ?>">
		</p>

		<p style="clear:left;">
			<label for="program-options-price">Price</label>
			<input type="text" size="3" name="ccta-program-options[price]" id="program-options-price" class="widefat" value="<?php echo esc_attr( $old_data['price'] ); ?>">
		</p>

		<input type="hidden" name="ccta_program_options_nonce" value="<?php echo wp_create_nonce( 'ccta-program-options' );?>">

<?php
}

function ccta_programs_pre_get_posts( $query ) {
	if ( $query->is_tax('programs') && $query->is_main_query() ) {
		$query->set( 'posts_per_page', -1 );
	}
}
add_action( 'pre_get_posts', 'ccta_programs_pre_get_posts' );


/* Helper Functions */
function get_ccta_program_options( $post_id = FALSE ) {
	if( !$post_id ) {
		$post = get_post();
		$post_id = $post->ID;
	}

	$data = get_post_meta( $post_id, 'ccta-program-options', true );
	if( !$data ) {
		$data = array();
	}
	$whitelisted = array( 'start-date', 'end-date', 'start-time', 'end-time', 'day-of-the-week', 'min-age', 'max-age', 'registration-link', 'price', 'location-name', 'street-address', 'location-city', 'location-state', 'location-zip-code' );
	foreach( $whitelisted as $key ) {
		if( !isset( $data[ $key ] ) ) {
			$data[ $key ] = '';
		}
	}

	return $data;
}

function get_ccta_program_details( $post_id = FALSE ) {
	if( !$post_id ) {
		$post = get_post();
		$post_id = $post->ID;
	}
	$deets = get_ccta_program_options( $post_id );
	// echo '<pre>';
	// var_dump($deets);
	// echo '</pre>';

	$start_date = date( 'F j<\s\up>S</\s\up>', strtotime( $deets['start-date'] ) );
	$end_date = date( 'F j<\s\u\p>S</\s\up>', strtotime( $deets['end-date'] ) );

	$start_time = date( 'g:ia', strtotime( $deets['start-time'] ) );
	$end_time = date( 'g:ia', strtotime( $deets['end-time'] ) );

	$day_of_the_week = '';
	if( isset( $deets['day-of-the-week'] ) && is_array($deets['day-of-the-week']) ) {
		foreach( $deets['day-of-the-week'] as $index => $day ) {
			$day_of_the_week .= ucfirst($day) . 's ';
		}

		$day_of_the_week = trim( $day_of_the_week ) . ', ';
	}

	$ages = '';
	$min_age = intval( $deets['min-age'] );
	$max_age = intval( $deets['max-age'] );
	if( !$max_age && $min_age ) {
		$ages = $min_age . ' and up';
	}
	if( !$min_age && $max_age ) {
		$ages = $max_age . ' and under';
	}
	if( $min_age && $max_age ) {
		$ages = $min_age . '-' . $max_age;
	}

	$times = $day_of_the_week;
	if( $start_time != $end_time ) {
		$times .= $start_time . ' to ' . $end_time;
	}

	$li = array();
	if( isset( $deets['price'] ) ) {
		$li[] = $deets['price'];
	}
	if( $ages ) {
		$li[] = 'Ages ' . $ages;
	}

	$li[] = $start_date . ' - ' . $end_date;
	if( $times ) {
		$li[] = $times;
	}

	$output = '<ul class="details">';
	$output .= '<li>' . implode( '</li><li>', $li ) . '</li>';
	$output .= '</ul>';

	$location = array();
	if( isset( $deets['location-name'] ) && $deets['location-name'] ) {
		$location[] = $deets['location-name'];
	}
	if( isset( $deets['street-address'] ) && $deets['street-address'] ) {
		$location[] = $deets['street-address'];
	}

	$location_city_state_zip = '';
	if( isset( $deets['location-city'] ) && $deets['location-city'] ) {
		$location_city_state_zip .= $deets['location-city'];
	}

	if( isset( $deets['location-state'] ) && $deets['location-state'] ) {
		$location_city_state_zip .= ', ' . $deets['location-state'];
	}

	if( isset( $deets['location-zip-code'] ) && $deets['location-zip-code'] ) {
		$location_city_state_zip .= ' ' . $deets['location-zip-code'];
	}

	if( $location_city_state_zip ) {
		$location[] = $location_city_state_zip;
	}

	if( $location ) {
		$direction_url = add_query_arg( 'q', urlencode( implode( ' ', $location ) ), 'https://www.google.com/maps/' );
		$location[] = '<a href="' . esc_url( $direction_url ) . '" target="_blank">Get Directions</a>';
		$output .= '<ul class="details">';
		$output .= '<li>' . implode( '</li><li>', $location ) . '</li>';
		$output .= '</ul>';
	}

	if( isset( $deets['registration-link'] ) && $deets['registration-link'] ) {
		$output .= '<a href="' . esc_url( $deets['registration-link'] ) . '" class="register">Register Now</a>';
	}

	return $output;
}
