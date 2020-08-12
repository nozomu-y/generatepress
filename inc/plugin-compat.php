<?php
/**
 * Add compatibility for some popular third party plugins.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'after_setup_theme', 'generate_setup_woocommerce' );
/**
 * Set up WooCommerce
 *
 * @since 1.3.47
 */
function generate_setup_woocommerce() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	// Add support for WC features.
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Remove default WooCommerce wrappers.
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	add_action( 'woocommerce_sidebar', 'generate_construct_sidebars' );
}

if ( ! function_exists( 'generate_woocommerce_start' ) ) {
	add_action( 'woocommerce_before_main_content', 'generate_woocommerce_start', 10 );
	/**
	 * Add WooCommerce starting wrappers
	 *
	 * @since 1.3.22
	 */
	function generate_woocommerce_start() {
		?>
		<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
			<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
				<?php
				/**
				 * generate_before_main_content hook.
				 *
				 * @since 0.1
				 */
				do_action( 'generate_before_main_content' );
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_do_microdata( 'article' ); ?>>
					<div class="inside-article">
						<?php
						/**
						 * generate_before_content hook.
						 *
						 * @since 0.1
						 *
						 * @hooked generate_featured_page_header_inside_single - 10
						 */
						do_action( 'generate_before_content' );

						$itemprop = '';

						if ( 'microdata' === generate_get_schema_type() ) {
							$itemprop = ' itemprop="text"';
						}
						?>
						<div class="entry-content"<?php echo esc_html( $itemprop ); ?>>
		<?php
	}
}

if ( ! function_exists( 'generate_woocommerce_end' ) ) {
	add_action( 'woocommerce_after_main_content', 'generate_woocommerce_end', 10 );
	/**
	 * Add WooCommerce ending wrappers
	 *
	 * @since 1.3.22
	 */
	function generate_woocommerce_end() {
		?>
						</div>
						<?php
						/**
						 * generate_after_content hook.
						 *
						 * @since 0.1
						 */
						do_action( 'generate_after_content' );
						?>
					</div>
				</article>
				<?php
				/**
				 * generate_after_main_content hook.
				 *
				 * @since 0.1
				 */
				do_action( 'generate_after_main_content' );
				?>
			</main>
		</div>
		<?php
	}
}

if ( ! function_exists( 'generate_woocommerce_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'generate_woocommerce_css', 100 );
	/**
	 * Add WooCommerce CSS
	 *
	 * @since 1.3.45
	 */
	function generate_woocommerce_css() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$mobile = generate_get_media_query( 'mobile' );

		$css = '.woocommerce .page-header-image-single {
			display: none;
		}

		.woocommerce .entry-content,
		.woocommerce .product .entry-summary {
			margin-top: 0;
		}

		.related.products {
			clear: both;
		}

		.checkout-subscribe-prompt.clear {
			visibility: visible;
			height: initial;
			width: initial;
		}

		@media ' . esc_attr( $mobile ) . ' {
			.woocommerce .woocommerce-ordering,
			.woocommerce-page .woocommerce-ordering {
				float: none;
			}

			.woocommerce .woocommerce-ordering select {
				max-width: 100%;
			}

			.woocommerce ul.products li.product,
			.woocommerce-page ul.products li.product,
			.woocommerce-page[class*=columns-] ul.products li.product,
			.woocommerce[class*=columns-] ul.products li.product {
				width: 100%;
				float: none;
			}
		}';

		$css = str_replace( array( "\r", "\n", "\t" ), '', $css );
		wp_add_inline_style( 'woocommerce-general', $css );
	}
}

if ( ! function_exists( 'generate_bbpress_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'generate_bbpress_css', 100 );
	/**
	 * Add bbPress CSS
	 *
	 * @since 1.3.45
	 */
	function generate_bbpress_css() {
		if ( ! class_exists( 'bbPress' ) ) {
			return;
		}

		$css = '#bbpress-forums ul.bbp-lead-topic,
		#bbpress-forums ul.bbp-topics,
		#bbpress-forums ul.bbp-forums,
		#bbpress-forums ul.bbp-replies,
		#bbpress-forums ul.bbp-search-results,
		#bbpress-forums,
		div.bbp-breadcrumb,
		div.bbp-topic-tags {
			font-size: inherit;
		}

		.single-forum #subscription-toggle {
			display: block;
			margin: 1em 0;
			clear: left;
		}

		#bbpress-forums .bbp-search-form {
			margin-bottom: 10px;
		}

		.bbp-login-form fieldset {
			border: 0;
			padding: 0;
		}';

		$css = str_replace( array( "\r", "\n", "\t" ), '', $css );
		wp_add_inline_style( 'bbp-default', $css );
	}
}

if ( ! function_exists( 'generate_buddypress_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'generate_buddypress_css', 100 );
	/**
	 * Add BuddyPress CSS
	 *
	 * @since 1.3.45
	 */
	function generate_buddypress_css() {
		if ( ! class_exists( 'BuddyPress' ) ) {
			return;
		}

		$css = '#buddypress form#whats-new-form #whats-new-options[style] {
			min-height: 6rem;
			overflow: visible;
		}';

		$css = str_replace( array( "\r", "\n", "\t" ), '', $css );
		wp_add_inline_style( 'bp-legacy-css', $css );
	}
}

if ( ! function_exists( 'generate_beaver_builder_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'generate_beaver_builder_css', 100 );
	/**
	 * Add Beaver Builder CSS
	 *
	 * Beaver Builder pages set to no sidebar used to automatically be full width, however
	 * now that we have the Page Builder Container meta box, we want to give the user
	 * the option to set the page to full width or contained.
	 *
	 * We can't remove this CSS as people who are depending on it will lose their full
	 * width layout when they update.
	 *
	 * So instead, we only apply this CSS to posts older than the date of this update.
	 *
	 * @since 1.3.45
	 */
	function generate_beaver_builder_css() {
		if ( generate_is_using_flexbox() ) {
			return;
		}

		$body_classes = get_body_class();

		// Check is Beaver Builder is active
		// If we have the full-width-content class, we don't need to do anything else.
		if ( in_array( 'fl-builder', $body_classes ) && ! in_array( 'full-width-content', $body_classes ) && ! in_array( 'contained-content', $body_classes ) ) {
			global $post;

			if ( ! isset( $post ) ) {
				return;
			}

			$compare_date = strtotime( '2017-03-14' );
			$post_date    = strtotime( $post->post_date );
			if ( $post_date < $compare_date ) {
				$css = '.fl-builder.no-sidebar .container.grid-container {
					max-width: 100%;
				}

				.fl-builder.one-container.no-sidebar .site-content {
					padding:0;
				}';
				$css = str_replace( array( "\r", "\n", "\t" ), '', $css );
				wp_add_inline_style( 'generate-style', $css );
			}
		}
	}
}

add_action( 'wp_enqueue_scripts', 'generate_do_pro_compatibility' );
/**
 * Add CSS to ensure compatibility with GP Premium.
 *
 * @since 3.0.0
 */
function generate_do_pro_compatibility() {
	if ( ! defined( 'GP_PREMIUM_VERSION' ) ) {
		return;
	}

	$css = new GeneratePress_CSS();

	if ( generate_is_using_flexbox() && version_compare( GP_PREMIUM_VERSION, '1.11.0-alpha.1', '<' ) ) {
		if ( defined( 'GENERATE_SECONDARY_NAV_VERSION' ) ) {
			$css->set_selector( '.secondary-navigation .inside-navigation:before, .secondary-navigation .inside-navigation:after' );
			$css->add_property( 'content', '"."' );
			$css->add_property( 'display', 'block' );
			$css->add_property( 'overflow', 'hidden' );
			$css->add_property( 'visibility', 'hidden' );
			$css->add_property( 'font-size', '0px' );
			$css->add_property( 'line-height', '0px' );
			$css->add_property( 'width', '0px' );
			$css->add_property( 'height', '0px' );

			$css->set_selector( '.secondary-navigation .inside-navigation:after' );
			$css->add_property( 'clear', 'both' );
		}
	}

	if ( defined( 'GENERATE_MENU_PLUS_VERSION' ) ) {
		if ( 'font' === generate_get_option( 'icons' ) ) {
			$css->set_selector( '.main-navigation .slideout-toggle a:before,.slide-opened .slideout-overlay .slideout-exit:before' );
			$css->add_property( 'font-family', 'GeneratePress' );

			$css->set_selector( '.slideout-navigation .dropdown-menu-toggle:before' );
			$css->add_property( 'content', '"\f107" !important' );

			$css->set_selector( '.slideout-navigation .sfHover > a .dropdown-menu-toggle:before' );
			$css->add_property( 'content', '"\f106" !important' );
		}

		if ( generate_has_inline_mobile_toggle() && version_compare( GP_PREMIUM_VERSION, '1.12.0-alpha.1', '<' ) ) {
			$menu_plus_settings = wp_parse_args(
				get_option( 'generate_menu_plus_settings', array() ),
				generate_menu_plus_get_defaults()
			);

			if ( 'true' === $menu_plus_settings['sticky_menu'] || 'mobile' === $menu_plus_settings['sticky_menu'] || 'enable' === $menu_plus_settings['mobile_header_sticky'] ) {
				$css->start_media_query( generate_get_media_query( 'mobile' ) );

				$css->set_selector( '#sticky-placeholder' );
				$css->add_property( 'height', '0' );
				$css->add_property( 'overflow', 'hidden' );

				$css->set_selector( '.has-inline-mobile-toggle #site-navigation.toggled' );
				$css->add_property( 'margin-top', '0' );

				$css->set_selector( '.has-inline-mobile-menu #site-navigation.toggled .main-nav > ul' );
				$css->add_property( 'top', '1.5em' );

				$css->stop_media_query();
			}

			if ( 'false' !== $menu_plus_settings['slideout_menu'] ) {
				$css->set_selector( '.slideout-mobile .has-inline-mobile-toggle #site-navigation.toggled,.slideout-both .has-inline-mobile-toggle #site-navigation.toggled' );
				$css->add_property( 'margin-top', '0' );
			}
		}
	}

	if ( $css->css_output() ) {
		wp_add_inline_style( 'generate-style', $css->css_output() );
	}
}

add_filter( 'generate_menu_item_dropdown_arrow_direction', 'generate_set_pro_menu_item_arrow_directions', 10, 3 );
/**
 * Set the menu item arrow directions for Secondary and Slideout navs.
 *
 * @since 3.0.0
 * @param string $arrow_direction The current direction.
 * @param object $args The args for the current menu.
 * @param int    $depth The current depth of the menu item.
 */
function generate_set_pro_menu_item_arrow_directions( $arrow_direction, $args, $depth ) {
	if ( function_exists( 'generate_secondary_nav_get_defaults' ) && 'secondary' === $args->theme_location ) {
		$settings = wp_parse_args(
			get_option( 'generate_secondary_nav_settings', array() ),
			generate_secondary_nav_get_defaults()
		);

		if ( 0 !== $depth ) {
			$arrow_direction = 'right';

			if ( 'left' === $settings['secondary_nav_dropdown_direction'] ) {
				$arrow_direction = 'left';
			}
		}

		if ( 'secondary-nav-left-sidebar' === $settings['secondary_nav_position_setting'] ) {
			$arrow_direction = 'right';

			if ( 'both-right' === generate_get_layout() ) {
				$arrow_direction = 'left';
			}
		}

		if ( 'secondary-nav-right-sidebar' === $settings['secondary_nav_position_setting'] ) {
			$arrow_direction = 'left';

			if ( 'both-left' === generate_get_layout() ) {
				$arrow_direction = 'right';
			}
		}

		if ( 'hover' !== generate_get_option( 'nav_dropdown_type' ) ) {
			$arrow_direction = 'down';
		}
	}

	return $arrow_direction;
}

add_filter( 'generate_menu_plus_option_defaults', 'generate_set_menu_plus_compat_defaults' );
/**
 * Set defaults in our pro Menu Plus module.
 *
 * @since 3.0.0
 * @param array $defaults The existing defaults.
 */
function generate_set_menu_plus_compat_defaults( $defaults ) {
	if ( generate_has_inline_mobile_toggle() ) {
		$defaults['mobile_menu_label'] = '';
	}

	return $defaults;
}

add_filter( 'generate_spacing_option_defaults', 'generate_set_spacing_compat_defaults', 20 );
/**
 * Set defaults in our pro Spacing module.
 *
 * @since 3.0.0
 * @param array $defaults The existing defaults.
 */
function generate_set_spacing_compat_defaults( $defaults ) {
	$defaults['mobile_header_top'] = '';
	$defaults['mobile_header_bottom'] = '';
	$defaults['mobile_header_right'] = '30';
	$defaults['mobile_header_left'] = '30';

	$defaults['mobile_widget_top'] = '30';
	$defaults['mobile_widget_right'] = '30';
	$defaults['mobile_widget_bottom'] = '30';
	$defaults['mobile_widget_left'] = '30';

	$defaults['mobile_footer_widget_container_top'] = '30';
	$defaults['mobile_footer_widget_container_right'] = '30';
	$defaults['mobile_footer_widget_container_bottom'] = '30';
	$defaults['mobile_footer_widget_container_left'] = '30';

	return $defaults;
}
