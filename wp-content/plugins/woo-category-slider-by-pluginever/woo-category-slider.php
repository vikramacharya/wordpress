<?php
/**
 * @package     WooCategorySlider
 * @author      MD Sultan Nasir Uddin
 * @copyright   2017 PluginEver
 *
 *
 * Plugin Name: Woo Category Slider By PluginEver
 * Description: Showcase Your WooCommerce powered Shop's category in a more appealing way to expand your sell.
 * Plugin URI: https://pluginever.com/woo-category-slider-by-pluginever
 * Author: PluginEver
 * Author URI: https://pluginever.com
 * Version: 2.0.3
 * License: GPL2
 * Text Domain: woocatlider
 * Domain Path: /i18n/languages/
 *
 * Copyright (c) 2017 PluginEver (email: support@pluginever.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class WOO_Cat_Slider{

	public $version;

	public $min_php;

	public function __construct() {

		$this->version = '2.0.3';
		$this->min_php = '5.6';
		// dry check on older PHP versions, if found deactivate itself with an error
		register_activation_hook( __FILE__, array( $this, 'auto_deactivate' ) );


		if ( ! $this->is_supported() ) {
			return;
		}

		// Define constants
		$this->define_constants();

		// Include required files
		$this->includes();


		// Initialize the action hooks
		$this->init_actions();


	}


	public function is_supported() {

		if ( version_compare( PHP_VERSION, $this->min_php, '<=' ) ) {
			return false;
		}

		return true;
	}



	function auto_deactivate() {
		if ( $this->is_supported() ) {
			return;
		}

		deactivate_plugins( basename( __FILE__ ) );

		$error = __( '<h1>An Error Occured</h1>', 'woocatlider' );
		$error .= __( '<h2>Your installed PHP Version is: ', 'woocatlider' ) . PHP_VERSION . '</h2>';
		$error .= __( '<p>The <strong>Woo Category Slider By PluginEver</strong> plugin requires PHP version <strong>', 'woocatlider' ) . $this->min_php . __( '</strong> or greater', 'woocatlider' );
		$error .= __( '<p>The version of your PHP is ', 'woocatlider' ) . '<a href="http://php.net/supported-versions.php" target="_blank"><strong>' . __( 'unsupported and old', 'woocatlider' ) . '</strong></a>.';
		$error .= __( 'You should update your PHP software or contact your host regarding this matter.</p>', 'woocatlider' );
		wp_die( $error, __( 'Plugin Activation Error', 'woocatlider' ), array( 'response' => 200, 'back_link' => true ) );
	}



	private function define_constants() {

		define( 'WOO_CAT_SLIDER_VERSION', $this->version );
		define( 'WOO_CAT_SLIDER_FILE', __FILE__ );
		define( 'WOO_CAT_SLIDER_PATH', dirname( WOO_CAT_SLIDER_FILE ) );
		define( 'WOO_CAT_SLIDER_INCLUDES', WOO_CAT_SLIDER_PATH . '/includes' );
		define( 'WOO_CAT_SLIDER_URL', plugins_url( '', WOO_CAT_SLIDER_FILE ) );
	}



	private function includes() {
		require_once (WOO_CAT_SLIDER_INCLUDES . '/scripts.php');
	}



	public function init_actions(){
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( __CLASS__, 'plugin_action_links' ) );
		add_filter( 'plugin_row_meta', array($this, 'show_upgrade_link'), 10, 2 );
		add_shortcode( 'woo_category_slider', array($this, 'woo_cat_slider_callback') );

	}


	public static function plugin_action_links($links){
		$action_links = array(
			'Documentation' => '<a target="_blank" href="https://www.pluginever.com/docs/woo-category-slider-plugin-documentation/" title="' . esc_attr( __( 'View WooCommerce Settings', 'woocatlider' ) ) . '">' . __( 'Documentation', 'woocatlider' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}

	function show_upgrade_link( $links, $file ) {
		$plugin = plugin_basename(__FILE__);
		// create link
		if ( $file == $plugin ) {
			return array_merge(
				$links,
				array( '<a style="color:red;" target="_blank" href="https://www.pluginever.com/plugins/woo-category-slider-pro/" title="' . esc_attr( __( 'Buy Pro version', 'woocatlider' ) ) . '">' . __( 'Buy Pro Version', 'woocatlider' ) . '</a>' )
			);
		}
		return $links;
	}



	public function woo_cat_slider_callback($attr){
		$params = shortcode_atts(
			array(
				'show_content'  => 'true',
				'show_button'  => 'true',
				'show_nav'  => 'true',
				'border'  => 'true',
				'show_count'  => 'true',
				'show_name'  => 'true',
				'nav_position'  => 'top-right',
				'button_text'  => 'Browse',
				'categories'  => 'all',
				'parent_only'  => 'true',
				'has_image_hover'  => 'true',
				'autoplay'  => 'true',
				'include_children'  => 'true',
				'responsive'  => 'true',
				'rtl'  => 'false',
				'hide_empty'  => 'false',
				'hide_no_image'  => 'false',
				'cols'  => '4',
			)
			,$attr
		);






		$args = array();
		$terms = array();
		$dummy_image = WOO_CAT_SLIDER_URL.'/images/dummy.jpg';

		$args['order'] = 'ASC';
		$args['orderby'] = 'title';
		$args['hide_empty'] = ( $params['hide_empty'] == "true" ) ? true : false;


		if ( $params['categories'] == 'all' ) {
			$terms = get_terms( 'product_cat', $args );

			if ( $params['parent_only'] == "true" ) {
				$terms = array_filter( $terms, function ( $terms ) {
					if ( ! $terms->parent ) {
						return $terms;
					}

					return false;
				} );
			}
		}else{
			$categories = explode(',', $params['categories']);

			if ( ! is_array( $categories ) ) {
				return;
			}

			foreach ( $categories as $cat ) {
					$term             = get_term_by( 'slug', trim($cat), 'product_cat', OBJECT );
					$terms[]          = $term;

				if ( $params['include_children'] == 'true') {
					$temp_args = $args;
					$temp_args['child_of'] = $term->term_id;
					$children = get_terms( 'product_cat', $temp_args );

					if ( $children ) {
						foreach ( $children as $child ) {
							$terms[] = $child;
						}
					}



				}





			}



		}

		if ( $params['hide_no_image'] == "true" ) {
			$terms = array_filter( $terms, function ( $terms ) {
				$thumbnail_id = get_term_meta( $terms->term_id, 'thumbnail_id', true );
				if ( $thumbnail_id ) {
					return $terms;
				}

				return false;
			} );
		}


		if($params['show_content'] =='false'){
			$classes[] = 'no-content';
		}
		if($params['border'] == 'true'){
			$classes[] = 'has-border';
		}
		if($params['show_button'] == 'false'){
			$classes[] = 'no-btn';
		}
		if($params['show_count'] == 'false'){
			$classes[] = 'no-count';
		}
		if($params['show_name'] == 'false'){
			$classes[] = 'no-name';
		}
		if(in_array($params['nav_position'], array('top-left','top-right', 'bottom-left', 'bottom-right'))){
			$classes[] = 'nav-'.esc_attr($params['nav_position']);
		}

		if($params['has_image_hover'] == 'true'){
			$classes[] = 'has-hover-effect';
		}

		$id = 'woo-cat-slider-' . strtolower( wp_generate_password( 5, false, false ) );



		ob_start();
		if(count($terms)>0):

			?>
			<div class="<?php echo implode(' ', $classes);?> plvr-slider plvr-category-slider has-padding" id="<?php echo $id; ?>">
				<?php foreach ( $terms as $product_category ) : ?>
					<div>
						<?php

						$thumbnail_id = get_term_meta( $product_category->term_id, 'thumbnail_id', true );
						$shop_catalog_img = wp_get_attachment_image_src( $thumbnail_id, 'shop_single' );
						$image_url = $shop_catalog_img[0]? $shop_catalog_img[0] : $dummy_image;
						echo '<img src="' . $image_url . '"  alt="' . $product_category->name . '">';
						?>
						<a href="<?php echo get_term_link( $product_category->term_id ) ?>" class="abs-link"></a>
						<div class="slider-caption">
							<h3 class="slider-caption-title"><?php echo $product_category->name ?></h3>
							<span class="slider-caption-sub-header product-count"><?php _e( $product_category->count . ' Product(s)', 'woocatslider' ) ?></span>
							<a href="<?php echo get_term_link( $product_category->term_id ) ?>" class="slider-btn"><?php echo esc_html($params['button_text']); ?> <?php echo $product_category->name ?></a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<script type="text/javascript">
                jQuery(document).on('ready', function() {

                    jQuery("#<?php echo $id;?>").slick({
                        dots: false,
                        arrows: <?php echo ($params['show_nav'] == 'true')? 'true': 'false'; ?>,
                        slidesToShow: <?php echo (is_numeric($params['cols']))? $params['cols']: 4; ?>,
                        slidesToScroll: 1,
						<?php if($params['autoplay'] == "true"): ?>
                        autoplay: true,
                        autoplaySpeed: 3000,
                        pauseOnHover: false,
						<?php endif; ?>

						<?php if($params['responsive'] == "true"): ?>
                        responsive: [
                            {
                                breakpoint: 1024,
                                settings: {
                                    slidesToShow: <?php echo (is_numeric($params['cols']))? $params['cols']: 4; ?>,
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 2
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            }
                        ]
						<?php endif; ?>
                    });
                });
			</script>

			<?php
		else:
			echo "<p style='text-align: center'>".__('No Category Found', 'woocatlider').'</p>';

		endif;
		$output = ob_get_contents();
		ob_get_clean();


		return $output;


	}





}


new WOO_Cat_Slider();



