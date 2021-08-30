<?php

/**
 * This class generates custom CSS into static CSS file in uploads folder
 * and enqueue it in the frontend
 *
 * CSS is generated only when theme options is saved (changed)
 * Works with LESS (for unlimited color schemes)
 *
 *
 */
require_once( TP_FRAMEWORK_LIBS_DIR . "less/lessc.inc.php" );
require_once( TP_THEME_DIR . "inc/admin/theme-options-to-css.php" );

function generate( $fileout, $theme_option_variations ) {
	$css = "";
	WP_Filesystem();
	global $wp_filesystem;

	$compiler = new lessc;
	$compiler->setFormatter( 'compressed' );
	$css .= $compiler->compileFile( TP_THEME_DIR . 'less/theme-options.less' );
	$css .= customcss();
	// Determine whether Multisite support is enabled
	if ( !$wp_filesystem->put_contents( $fileout, $css, FS_CHMOD_FILE ) ) {
		$wp_filesystem->put_contents( $fileout, $css, LOCK_EX, FS_CHMOD_FILE );
	}
}

function exist_in_array( $array, $string ) {
	if ( count( $array ) > 0 ) {
		foreach ( $array as $item ) {
			if ( $item == $string ) {
				return true;
			}
		}
	}

	return false;
}