<?php
//////////////////////////////////////////////////////////////////
/////////// Import demo data
//////////////////////////////////////////////////////////////////
function resca_importer_demo_data() {
	define( 'DATA_DEMO_DIR', trailingslashit( get_template_directory() ) . 'inc/admin/data/' );
	define( 'DATA_DEMO_URL', trailingslashit( get_template_directory_uri() ) . 'inc/admin/data/' );

	return array(
		array(
			'import_file_name'             => 'Home Restaurant',
			'local_import_file'            => DATA_DEMO_DIR . 'demodata.xml',
			'local_import_widget_file'     => DATA_DEMO_DIR . 'widgets.wie',
			'local_import_customizer_file' => DATA_DEMO_DIR . 'setting.json',
  		),
		array(
			'import_file_name'             => 'Home Coffee',
			'local_import_file'            => DATA_DEMO_DIR . 'demodata.xml',
			'local_import_widget_file'     => DATA_DEMO_DIR . 'widgets.wie',
			'local_import_customizer_file' => DATA_DEMO_DIR . 'setting.json',
			'import_preview_image_url'     => DATA_DEMO_URL . 'home-coffee.jpg',
 		),
		array(
			'import_file_name'             => 'Home Seafood',
			'local_import_file'            => DATA_DEMO_DIR . 'demodata.xml',
			'local_import_widget_file'     => DATA_DEMO_DIR . 'widgets.wie',
			'local_import_customizer_file' => DATA_DEMO_DIR . 'setting.json',
			'import_preview_image_url'     => DATA_DEMO_URL . 'home-seafood.jpg',
 		),
		array(
			'import_file_name'             => 'Home Winery',
			'local_import_file'            => DATA_DEMO_DIR . 'demodata.xml',
			'local_import_widget_file'     => DATA_DEMO_DIR . 'widgets.wie',
			'local_import_customizer_file' => DATA_DEMO_DIR . 'setting.json',
			'import_preview_image_url'     => DATA_DEMO_URL . 'home-winery.jpg',
 		),
		array(
			'import_file_name'             => 'One Page',
			'local_import_file'            => DATA_DEMO_DIR . 'demodata.xml',
			'local_import_widget_file'     => DATA_DEMO_DIR . 'widgets.wie',
			'local_import_customizer_file' => DATA_DEMO_DIR . 'setting.json',
			'import_preview_image_url'     => DATA_DEMO_URL . 'home-onepage.jpg',
 		),
		array(
			'import_file_name'             => 'Home Full Screen Video',
			'local_import_file'            => DATA_DEMO_DIR . 'demodata.xml',
			'local_import_widget_file'     => DATA_DEMO_DIR . 'widgets.wie',
			'local_import_customizer_file' => DATA_DEMO_DIR . 'setting.json',
  		),
 	);
}

add_filter( 'pt-ocdi/import_files', 'resca_importer_demo_data' );
function resca_after_import_setup( $selected_import ) {
	// Assign menus to their locations.
	$main_menu = get_term_by( 'name', 'Main Menu', 'primary' );
	set_theme_mod( 'nav_menu_locations', array(
			'primary' => $main_menu->term_id,
		)
	);

	if ( 'Home Restaurant' === $selected_import['import_file_name'] ) {
		$front_page_id = get_page_by_title( 'Home Page' );
		if ( class_exists( 'RevSlider' ) ) {
			$slider = new RevSlider();
			$slider->importSliderFromPost( true, true, DATA_DEMO_DIR . "/revslider/parallax_scroll_slider.zip" );
		}
	} elseif ( 'Home Coffee' === $selected_import['import_file_name'] ) {
		$front_page_id = get_page_by_title( 'Home Coffee');
		if ( class_exists( 'RevSlider' ) ) {
			$slider = new RevSlider();
			$slider->importSliderFromPost( true, true, DATA_DEMO_DIR . "/revslider/home-winery.zip" );
		}
	} elseif ( 'Home Seafood' === $selected_import['import_file_name'] ) {
		$front_page_id = get_page_by_title( 'Home Seafood' );
		if ( class_exists( 'RevSlider' ) ) {
			$slider = new RevSlider();
			$slider->importSliderFromPost( true, true, DATA_DEMO_DIR . "/revslider/home-seafood.zip" );
		}
	} elseif ( 'Home Winery' === $selected_import['import_file_name'] ) {
		$front_page_id = get_page_by_title( 'Home Winery' );
		if ( class_exists( 'RevSlider' ) ) {
			$slider = new RevSlider();
			$slider->importSliderFromPost( true, true, DATA_DEMO_DIR . "/revslider/home-winery.zip" );
		}
	} elseif ( 'One Page' === $selected_import['import_file_name'] ) {
		$front_page_id = get_page_by_title( 'One Page' );
		if ( class_exists( 'RevSlider' ) ) {
			$slider = new RevSlider();
			$slider->importSliderFromPost( true, true, DATA_DEMO_DIR . "/revslider/one-page.zip" );
		}
	} elseif ( 'Home Full Screen Video' === $selected_import['import_file_name'] ) {
		$front_page_id = get_page_by_title( 'Home Full Video' );
		if ( class_exists( 'RevSlider' ) ) {
			$slider = new RevSlider();
			$slider->importSliderFromPost( true, true, DATA_DEMO_DIR . "/revslider/home-full-video.zip" );
		}
	}
	$blog_page_id = get_page_by_title( 'Blog' );
	$shop_id      = get_page_by_title( 'Shop' );
	$cart_id      = get_page_by_title( 'Cart' );
	$checkout_id  = get_page_by_title( 'Checkout' );
	$account_id   = get_page_by_title( 'My account' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );
	update_option( 'woocommerce_shop_page_id', $shop_id->ID );
	update_option( 'woocommerce_cart_page_id', $cart_id->ID );
	update_option( 'woocommerce_checkout_page_id', $checkout_id->ID );
	update_option( 'woocommerce_myaccount_page_id', $account_id->ID );
}

add_action( 'pt-ocdi/after_import', 'resca_after_import_setup' );

function ocdi_plugin_page_setup( $default_settings ) {
	$default_settings['menu_slug'] = 'resca-onclick-demo-import';

	return $default_settings;
}

add_filter( 'pt-ocdi/plugin_page_setup', 'ocdi_plugin_page_setup' );