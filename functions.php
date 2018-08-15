<?php

// Used at stabekkino.no

// Include Beans. Do not remove the line below.
require_once( get_template_directory() . '/lib/init.php' );

/*
 * Remove this action and callback function if you do not whish to use LESS to style your site or overwrite UIkit variables.
 * If you are using LESS, make sure to enable development mode via the Admin->Appearance->Settings option. LESS will then be processed on the fly.
 */
/*
add_action( 'beans_uikit_enqueue_scripts', 'beans_child_enqueue_uikit_assets' );
function beans_child_enqueue_uikit_assets() {
	beans_compiler_add_fragment( 'uikit', get_stylesheet_directory_uri() . '/style.less', 'less' );
}*/

// Remove this action and callback function if you are not adding CSS in the style.css file.
add_action( 'wp_enqueue_scripts', 'beans_child_enqueue_assets' );
function beans_child_enqueue_assets() {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );
}

/* --------- Custom code for Stabekkino.no ----*/
 

/* ----- Remove all page titles, but do not remove post titles.
 https://community.getbeans.io/discussion/remov-title-and-change-archive-h1/ ----*/
 add_action( 'wp', 'setup_document_remove_pagetitle' );
 	function setup_document_remove_pagetitle() {
 		if ( false === is_single() and !is_home() ) {
 		beans_remove_action( 'beans_post_title' );
 		}
 	}
 
 	
 // Remove breadcrumbs.
 beans_remove_action( 'beans_breadcrumb' );	

// Removes featured image from all pages (posts and pages) except the blog page.
add_action( 'wp', 'beans_child_setup_document' );
function beans_child_setup_document() {
 if ( is_single() or is_page() ) { 
 beans_remove_action( 'beans_post_image' );
 }
}


 add_action( 'widgets_init', 'footer_widgets_init' );
 function footer_widgets_init() {
 
 // Create 3 widget area.
 for( $i = 1; $i <= 3; $i++ ) {
 	beans_register_widget_area( array(
 		'name' => "Footer Widget {$i}",
 		'id' => "footer_widget_area_{$i}",
 		) );
 	}
 }
 
 // Output widget area above the footer.
 add_action( 'beans_footer_before_markup', 'footer_widget_area' );
 function footer_widget_area() {
 
 ?>
 	<div class="footer-widget uk-block">
 			<div class="uk-container uk-container-center">
 					<div class="uk-grid uk-grid-width-medium-1-3" data-uk-grid-margin>
 	<?php for( $i = 1; $i <= 3; $i++ ) : ?>
 	<div><?php echo beans_widget_area( "footer_widget_area_{$i}" ); ?></div>
 	<?php endfor; ?>
 					</div>
 			</div>
 	</div>
 <?php
 }
 
 
 /*----- Copyright information bottom left and right ----*/
 
 // LEFT text
 add_filter( 'beans_footer_credit_text_output', 'modify_left_copyright' );
 function modify_left_copyright() {
 	// Add your copyright html, text, Dynamic date and times etc.
 	 ?><p>© <?php echo date('Y'); ?> Kulturhuset Stabekkino. <a href="<?php echo admin_url();?>" title="Log inn i baksiden av WordPress." />Log inn.</a></p>
 	<?php
 }
 
 // RIGHT text 
 add_action( 'beans_footer_credit_right_text_output', 'modify_right_copyright' );
 function modify_right_copyright() {
  	?> Bygget av <a href="http://easywebdesigntutorials.com/" target="_blank" title="Easy Web Design Tutorials"> Paal Joachim</a> med <a href="http://www.getbeans.io/" title="Beans Framework for WordPress" target="_blank">Beans WordPress Framework</a>.
  	<?php
 }

/* 
beans_add_attribute( 'beans_main_before_markup', 'class', 'main-image-banner' );

/***** Add full screen header image. ******
add_action( 'wp_head', 'banner_image' );

function banner_image() {
$image_url = get_the_post_thumbnail_url( null, 'full' );

// Set a default image if no feature image is found.
if ( false === $image_url ) {
$image_url = 'https://getuikit.com/v2/docs/images/placeholder_800x400_1.jpg';
}

?><style type="text/css">
.home .main-image-banner {
background-image: url(<?php echo esc_url( $image_url ); ?>);
background-position: 50% 0;
/*background-size: cover; 
background-size: 100% 150px;
background-repeat: no-repeat;
/* min-height: 200px; /* modified */
/*border: 0px; /* Added */
/*
}
</style><?php
}

/* ----- Responsive Menu ---- */
add_filter( 'beans_offcanvas_menu_button_output', 'responsive_offcancas_menu_button_text' );
function responsive_offcancas_menu_button_text() {
   return '';
}
