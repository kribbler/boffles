<?php
/**
 * WooCommerce Tab Manager
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@foxrunsoftware.net so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Tab Manager to newer
 * versions in the future. If you wish to customize WooCommerce Tab Manager for your
 * needs please refer to http://wcdocs.woothemes.com/user-guide/extensions/tab-manager/
 *
 * @package     WC-Tab-Manager/Admin
 * @author      Justin Stern
 * @copyright   Copyright (c) 2012-2013, Justin Stern
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

/**
 * WooCommerce Tab Manager admin helper functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Helper function to render the sortable tabs admin UI used both on the product
 * edit pages, as well as the custom Default Tab Layout admin page
 *
 * @access public
 * @param array $tabs tab data
 */
function wc_tab_manager_sortable_product_tabs( $tabs ) {

	global $woocommerce, $wc_tab_manager, $typenow;

	$tab_icon = $wc_tab_manager->plugin_url() . '/assets/images/product-data-icon.png';

	if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
		$style = 'padding:5px 5px 5px 28px;background-image:url(' . $tab_icon . ');background-repeat:no-repeat;background-position:5px 7px;';
		$active_style = '';
	} else {
		$style = 'padding:9px 9px 9px 34px;line-height:16px;border-bottom:1px solid #d5d5d5;text-shadow:0 1px 1px #fff;color:#555555;background-image:url(' . $tab_icon . ');background-repeat:no-repeat;background-position:9px 9px;';
		$active_style = '#woocommerce-product-data ul.product_data_tabs li.product_tabs_tab.active a { border-bottom: 1px solid #F8F8F8; }';
	}

	?>
	<style type="text/css">
		#woocommerce-product-data ul.product_data_tabs li.product_tabs_tab a { <?php echo $style; ?> }
		<?php echo $active_style; ?>
		.wc-metaboxes-wrapper .wc-metabox table.woocommerce_product_tab_data td label { display: inline; line-height: inherit; }
		.woocommerce_product_tabs .options_group label { float: left; padding: 0; width: 150px; }
		.woocommerce_product_tabs .options_group p { font-size: 12px; line-height: 24px; }
		.wc-metaboxes-wrapper .woocommerce_product_tabs .wc-metabox table td input { font-size: inherit; }
		.woocommerce_product_tabs .description { margin: 0 0 0 7px; padding: 0; }
		.woocommerce_product_tabs .options_group .form-field label { font-weight:bold; }
		.wc-metaboxes-wrapper .toolbar label { line-height:22px; }
		.wc-metaboxes-wrapper .toolbar input { margin-top:0; }
		.wc-metaboxes-wrapper .toolbar input { margin-top:0; }

		#woocommerce_product_tabs .quicktags-toolbar input {
			background-color: #EEEEEE;
			background-image: -moz-linear-gradient(center bottom , #E3E3E3, #FFFFFF);
			border: 1px solid #C3C3C3;
			border-radius: 3px 3px 3px 3px;
			color: #464646;
			display: inline-block;
			font: 12px/18px Arial,Helvetica,sans-serif normal;
			margin: 2px 1px 4px;
			width:auto;
			min-width: 26px;
			padding: 2px 4px;
	   }

	   #woocommerce_product_tabs .wp-editor-area {
			-moz-box-sizing: border-box;
			border: 0 none;
			font-family: Consolas,Monaco,monospace;
			line-height: 150%;
			outline: medium none;
			padding: 10px;
			resize: vertical;
			font-size:inherit;
			color:#333333;
		}

		#wc_tab_manager_block {
		    background-color: white;
		    height: 100%;
		    left: 0;
		    opacity: 0.6;
		    position: absolute;
		    top: 0;
		    width: 100%;
		    display:none;
		}
	</style>
	<div id="woocommerce_product_tabs" class="panel wc-metaboxes-wrapper">
		<p class="toolbar">
			<?php if ( 'product' == $typenow ) :
				global $post;
				$override_tab_layout = get_post_meta( $post->ID, '_override_tab_layout', true );
				?>
				<label for="_override_tab_layout"><?php _e( 'Override default tab layout:', WC_Tab_Manager::TEXT_DOMAIN ); ?></label> <input type="checkbox" name="_override_tab_layout" id="_override_tab_layout" <?php checked( $override_tab_layout, "yes" ); ?> />
			<?php endif; ?>
			<a href="#" class="close_all"><?php _e( 'Close all', WC_Tab_Manager::TEXT_DOMAIN ); ?></a><a href="#" class="expand_all"><?php _e( 'Expand all', WC_Tab_Manager::TEXT_DOMAIN ); ?></a>
		</p>

		<div style="position:relative;">
		<div class="woocommerce_product_tabs wc-metaboxes">

			<?php

				// the core woocommerce tabs
				$core_tabs = $wc_tab_manager->get_core_tabs();

				// get any global tabs
				$global_tabs = array();
				$posts = get_posts( array( 'numberposts' => -1, 'post_type' => 'wc_product_tab', 'post_parent' => 0, 'post_status' => 'publish' ) );
				foreach ( $posts as $_post ) {

					$tab = array( 'id' => $_post->ID, 'position' => 0, 'type' => 'global', 'title' => $_post->post_title );
					list( $tab['content'] ) = explode( "\n", wordwrap( str_replace( "\n", "", strip_shortcodes( strip_tags( $_post->post_content ) ) ), 155 ) );

					// content excerpt
					if ( strlen( $_post->post_content ) > 155 ) $tab['content'] .= '...';
					if ( $tab['content'] ) $tab['content'] .= ' - ';
					$tab['content'] .= ' <a href="' . get_edit_post_link( $_post->ID ) . '">' . __( 'Edit Global Tab Content', WC_Tab_Manager::TEXT_DOMAIN ) . '</a>';

					$global_tabs[ 'global_tab_' . $_post->ID ] = $tab;

				}

				// get any 3rd party tabs
				$third_party_tabs = array();
				if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
					foreach ( $wc_tab_manager->get_third_party_tabs_2() as $id => $tab ) {
						if ( ! isset( $tab['ignore'] ) || false == $tab['ignore'] )
							$third_party_tabs[ $id ] = array( 'id' => $tab['id'], 'position' => 0, 'type' => 'third_party', 'title' => $tab['title'], 'description' => $tab['description'] );
					}
				} else {
					foreach ( $wc_tab_manager->get_third_party_tabs() as $id => $tab ) {
						$third_party_tabs[ $id ] = array( 'id' => $tab['id'], 'position' => 0, 'type' => 'third_party', 'title' => $tab['title'], 'description' => $tab['description'] );
					}
				}

				// if no tabs are set (for this product) try defaulting to the default tab layout, if it exists
				if ( ! is_array( $tabs ) ) $tabs = get_option( 'wc_tab_manager_default_layout', false );

				// if no default tab layout either, default to the core + 3rd party tabs
				if ( ! is_array( $tabs ) ) {
					$tabs = $core_tabs + $third_party_tabs;
				} else {
					// otherwise, get the content and title for any product/global tabs, and verify that any global/3rd party tabs still exist
					foreach ( $tabs as $id => $tab ) {

						if ( 'global' == $tab['type'] ) {
							// global tab: get an excerpt of the content to display if any, or if the tab has been removed or trashed, remove it from view

							if ( isset( $global_tabs[ $id ] ) ) {
								$tabs[ $id ]['title']   = $global_tabs[ $id ]['title'];
								$tabs[ $id ]['content'] = $global_tabs[ $id ]['content'];
							} else {
								// global tab is gone
								unset( $tabs[ $id ] );
							}

						} elseif ( 'third_party' == $tab['type'] ) {
							// 3rd party tab, does the plugin still exist?

							if ( isset( $third_party_tabs[ $id ] ) ) {
								$tabs[ $id ]['title']       = $third_party_tabs[ $id ]['title'];
								$tabs[ $id ]['description'] = $third_party_tabs[ $id ]['description'];
							} else {
								unset( $tabs[ $id ] );
							}

						} elseif ( 'product' == $tab['type'] ) {
							// get any custom product tab content from the underlying post

							$tab_post = get_post( $tab['id'] );

							if ( $tab_post && 'publish' == $tab_post->post_status ) {
								$tabs[ $id ]['content'] = $tab_post->post_content;
								$tabs[ $id ]['title']   = $tab_post->post_title;
							} else {
								// product tab is gone
								unset( $tabs[ $id ] );
							}

						}
					}
				}

				// markup for all core, global and 3rd party tabs will be rendered, and if not currently added to the product, they will be hidden until added
				$combined_tabs = array_merge( $core_tabs, $global_tabs, $third_party_tabs, $tabs );

				$i = 0;
				foreach ( $combined_tabs as $id => $tab ) {

					$position = $tab['position'];

					$active = isset( $tabs[ $id ] );

					// for the core tabs, even if the title is changed, keep the displayed name the same in the bar so there's less confusion
					$name = 'core' == $tab['type'] ? $core_tabs[ $id ]['title'] : $tab['title'];
					// handle the Reviews tab specially by cutting off the ' (%d)' which looks like garbage in the sortable tab list
					if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 && 'core' == $tab['type'] && 'reviews' == $tab['id'] ) $name = substr( $name, 0, -4 );

					?>
					<div class="woocommerce_product_tab wc-metabox closed product_tab_<?php echo $tab['type']; ?> <?php echo $id; ?>" rel="<?php echo $position; ?>" <?php if ( ! $active ) echo ' style="display:none;"'; ?>>
						<h3>
							<button type="button" class="remove_row button"><?php _e( 'Remove', WC_Tab_Manager::TEXT_DOMAIN ); ?></button>
							<div class="handlediv" title="<?php _e( 'Click to toggle', WC_Tab_Manager::TEXT_DOMAIN ); ?>"></div>
							<strong class="product_tab_name"><?php echo $name; ?></strong>
						</h3>
						<table class="woocommerce_product_tab_data wc-metabox-content">
							<tr>
								<td>
									<?php if ( isset( $core_tabs[ $id ]['description'] ) ) : ?>
										<p><em><?php echo $core_tabs[ $id ]['description']; ?></em></p>
									<?php endif; ?>
									<?php if ( 'third_party' == $tab['type'] ) : ?>
										<p><em><?php echo $tab['description'] ? $tab['description'] : __( 'The title/content for this tab will be provided by a third party plugin', WC_Tab_Manager::TEXT_DOMAIN ); ?></em></p>
									<?php endif; ?>
									<div class="options_group">
										<?php if ( 'third_party' != $tab['type'] ) : ?>
											<p class="form-field product_tab_title_field">
												<label for="product_tab_title_<?php echo $i; ?>"><?php _e( 'Title', WC_Tab_Manager::TEXT_DOMAIN ); ?></label>
												<?php if ( 'global' == $tab['type'] ) : ?>
													<span><?php echo $tab['title']; ?></span>
													<input type="hidden" name="product_tab_title[<?php echo $i; ?>]" value="<?php echo esc_attr( $tab['title'] ); ?>" />
												<?php elseif ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) < 0 && ! WC_Tab_Manager::WC_PRE_2_PATCHED && 'core' == $tab['type'] ) : ?>
													<span><?php echo $core_tabs[ $id ]['title']; ?></span>
													<input type="hidden" name="product_tab_title[<?php echo $i; ?>]" value="<?php echo esc_attr( $core_tabs[ $id ]['title'] ); ?>" />
												<?php else: ?>
													<input type="text" value="<?php echo esc_attr( $tab['title'] ); ?>" id="product_tab_title_<?php echo $i; ?>" name="product_tab_title[<?php echo $i; ?>]" class="short product_tab_title"> <span class="description"><?php _e( "The tab title, this appears in the tab", WC_Tab_Manager::TEXT_DOMAIN ); ?></span>
												<?php endif; ?>
											</p>
										<?php endif; ?>
										<?php if ( isset( $core_tabs[ $id ]['heading'] ) && $core_tabs[ $id ]['heading'] ) : ?>
											<p class="form-field product_tab_heading_field">
												<label for="product_tab_heading_<?php echo $i; ?>"><?php _e( 'Heading', WC_Tab_Manager::TEXT_DOMAIN ); ?></label>
												<input type="text" value="<?php echo $tab['heading']; ?>" id="product_tab_heading_<?php echo $i; ?>" name="product_tab_heading[<?php echo $i; ?>]" class="short"> <span class="description"><?php _e( "The tab heading, this appears just before the tab content", WC_Tab_Manager::TEXT_DOMAIN ); ?></span>
											</p>
										<?php endif; ?>
										<?php if ( 'global' == $tab['type'] ) : ?>
											<p class="form-field product_tab_heading_field">
												<label for="product_tab_content_<?php echo $i; ?>"><?php _e( 'Content', WC_Tab_Manager::TEXT_DOMAIN ); ?></label>
												<span><?php echo $tab['content']; ?></span>
											</p>
										<?php endif; ?>
									</div>
									<?php if ( 'product' == $tab['type'] && isset( $tab['content'] ) ) : ?>
										<?php /* Because the editor is within a movable block, we must disable the rich visual MCE editor, and use only the quicktags editor */
											wp_editor( $tab['content'], 'producttabcontent' . $i, array( 'textarea_name' => 'product_tab_content[' . $i . ']', 'tinymce' => false, 'textarea_rows' => 10 ) ); ?>
									<?php endif; ?>
									<input type="hidden" name="product_tab_active[<?php echo $i; ?>]" class="product_tab_active" value="<?php echo esc_attr( $active ); ?>" />
									<input type="hidden" name="product_tab_position[<?php echo $i; ?>]" class="product_tab_position" value="<?php echo esc_attr( $position ); ?>" />
									<input type="hidden" name="product_tab_type[<?php echo $i; ?>]" class="product_tab_type" value="<?php echo esc_attr( $tab['type'] ); ?>" />
									<input type="hidden" name="product_tab_id[<?php echo $i; ?>]" class="product_tab_id" value="<?php echo esc_attr( $tab['id'] ); ?>" />
								</td>
							</tr>
						</table>
					</div>
					<?php
					$i++;
				}
			?>
		</div>

		<?php $select_tabs = $core_tabs + $global_tabs + $third_party_tabs; ?>
		<p class="toolbar">
			<button type="button" class="button button-primary add_product_tab"><?php _e( 'Add', WC_Tab_Manager::TEXT_DOMAIN ); ?></button>
			<select name="product_tab" class="product_tab">
				<?php if ( 'product' == $typenow ) : ?><option value=""><?php _e( 'Custom Tab', WC_Tab_Manager::TEXT_DOMAIN ); ?></option><?php endif; ?>
				<?php
					foreach ( $select_tabs as $id => $tab ) :
						echo '<option value="' . $id . '">' . __( $tab['title'], WC_Tab_Manager::TEXT_DOMAIN ) . '</option>';
					endforeach;
				?>
			</select>
		</p>

		<div class="clear"></div>
		<div id="wc_tab_manager_block"></div>
		</div>
	</div>
	<?php
}


/**
 * Process and return the tab data POSTed by the sortable product tabs
 * function.
 *
 * @access public
 * @param int $post_id optional post identifier.  A value of 0 indicates product-level
 *        tabs will not be processed
 * @param object $post the optional post object.
 *
 * @return array tab data, ready for persistance
 */
function wc_tab_manager_process_tabs( $post_id = 0, $post = null ) {
	global $woocommerce;

	$tab_active    = isset( $_POST['product_tab_active'] )   ? $_POST['product_tab_active']   : array();
	$tab_positions = isset( $_POST['product_tab_position'] ) ? $_POST['product_tab_position'] : array();
	$tab_types     = isset( $_POST['product_tab_type'] )     ? $_POST['product_tab_type']     : array();
	$tab_headings  = isset( $_POST['product_tab_heading'] )  ? $_POST['product_tab_heading']  : array(); // available only for the core description/additional_information tabs
	$tab_titles    = isset( $_POST['product_tab_title'] )    ? $_POST['product_tab_title']    : array();
	$tab_content   = isset( $_POST['product_tab_content'] )  ? $_POST['product_tab_content']  : array(); // available only for product tab type
	$tab_ids       = isset( $_POST['product_tab_id'] )       ? $_POST['product_tab_id']       : array();

	$tabs = array();

	// create the new set of active tabs (if any)
	for ( $i = 0; $i < count( $tab_positions ); $i++ ) {
		if ( $tab_active[ $i ] ) {
			$tab = array( 'position' => $tab_positions[ $i ], 'type' => $tab_types[ $i ], 'id' => $tab_ids[ $i ] );

			if ( isset( $tab_titles[ $i ] ) ) $tab['title'] = $tab_titles[ $i ];

			if ( 'product' == $tab['type'] ) {
				if ( ! $tab['id'] ) {
					// new custom product tab

					$new_tab_data = array(
						'post_title'    => $tab_titles[ $i ],
						'post_content'  => $tab_content[ $i ],
						'post_status'   => 'publish',
						'ping_status'   => 'closed',
						'post_author'   => get_current_user_id(),
						'post_type'     => 'wc_product_tab',
						'post_parent'   => $post_id,
						'post_password' => uniqid( 'tab_' ) // Protects the post just in case
					);

					$tab['id'] = wp_insert_post( $new_tab_data );
				} else {
					// update existing custom product tab

					$tab_data = array(
						'ID'           => $tab['id'],
						'post_title'   => $tab_titles[ $i ],
						'post_content' => $tab_content[ $i ]
					);
					wp_update_post( $tab_data );
				}
			}

			// only the core description and additional information tabs have a heading
			if ( isset( $tab_headings[ $i ] ) ) {
				$tab['heading'] = $tab_headings[ $i ];
			}

			$tabs[ $tab['type'] . '_tab_' . $tab['id'] ] = $tab;
		} else {
			// tab removed
			if ( 'product' == $tab_types[ $i ] ) {
				// for product custom tabs, remove the tab post record
				wp_delete_post( $tab_ids[ $i ] );
			}
		}
	}

	// sort the tabs according to position
	if ( ! function_exists( 'product_tabs_cmp' ) ) {
		function product_tabs_cmp( $a, $b ) {
			if ( $a['position'] == $b['position'] ) return 0;
			return $a['position'] < $b['position'] ? -1 : 1;
		}
	}

	uasort( $tabs, 'product_tabs_cmp' );

	// make sure the position values are 0, 1, 2 ...
	$i = 0;
	foreach ( $tabs as &$tab ) $tab['position'] = $i++;


	// it's important to generate unique names to use for the tab/tab panel css ids, so that
	//  clicking a tab brings up the correct tab panel (since we can't change their names)
	//  We'll generate names like 'description', 'description-1', 'description-2', etc
	$found_names = array();
	$tab_names   = array();

	// first off, the core tabs get priority on naming (which for them is their id)
	foreach ( $tabs as &$tab ) {
		if ( 'core' == $tab['type'] ) {
			$tab_name = $tab['id'];
			if ( ! isset( $found_names[ $tab_name ] ) ) $found_names[ $tab_name ] = 0;
			$found_names[ $tab_name ]++;
		}
	}

	// next up: the 3rd party tabs; we don't want to clash with their keys
	foreach ( $tabs as &$tab ) {
		if ( 'third_party' == $tab['type'] ) {
			$tab_name = $tab['id'];
			if ( ! isset( $found_names[ $tab_name ] ) ) $found_names[ $tab_name ] = 0;
			$found_names[ $tab_name ]++;
		}
	}

	// next up are the global tabs
	foreach ( $tabs as &$tab ) {
		if ( 'global' == $tab['type'] ) {
			$tab_name = sanitize_title( $tab['title'] );
			if ( ! isset( $found_names[ $tab_name ] ) ) $found_names[ $tab_name ] = 0;
			$found_names[ $tab_name ]++;

			if ( $found_names[ $tab_name ] > 1 ) $tab_name .= '-' . ( $found_names[ $tab_name ] - 1 );

			$tab['name'] = $tab_name;

			// once the title is used to generate the unique name, it is no longer needed as it will be pulled from the tab post
			unset( $tab['title'] );
		}
	}

	// finally the custom product tabs
	foreach ( $tabs as &$tab ) {
		if ( 'product' == $tab['type'] ) {
			$tab_name = sanitize_title( $tab['title'] );
			if ( ! isset( $found_names[ $tab_name ] ) ) $found_names[ $tab_name ] = 0;
			$found_names[ $tab_name ]++;

			if ( $found_names[ $tab_name ] > 1 ) $tab_name .= '-' . ( $found_names[ $tab_name ] - 1 );

			$tab['name'] = $tab_name;

			// once the title is used to generate the unique name, it is no longer needed as it will be pulled from the tab post
			unset( $tab['title'] );
		}
	}

	return $tabs;
}
