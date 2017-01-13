
<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php 
	global $product;
	extract(etheme_get_single_product_sidebar());
?>

<?php
	/**
	 * Single Product Content
	 *
	 * @author 		WooThemes
	 * @package 	WooCommerce/Templates
	 * @version     2.1.2
	 */
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
?>

<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class('single-product-page'); ?>>
	
	<div class="row product-info sidebar-position-<?php echo $position; ?> responsive-sidebar-<?php echo $responsive; ?>">
		<?php
			/**
			 * woocommerce_before_single_product_summary hook
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>

		<?php if($single_product_sidebar && ($position == 'left' || ($responsive == 'top' && $position == 'right'))): ?>
			<div class="span3 sidebar sidebar-left single-product-sidebar">
				<?php et_product_brand_image(); ?>
				<?php if(etheme_get_option('upsell_location') == 'sidebar') woocommerce_upsell_display(); ?>
				<?php dynamic_sidebar('single-sidebar'); ?>
			</div>
		<?php endif; ?>

		<div class="span<?php echo $images_span; ?>">
			<?php woocommerce_show_product_images(); ?>
		</div>
		<div class="span<?php echo $meta_span; ?> product_meta">
			<?php if (etheme_get_option('show_name_on_single')): ?>
				<h2 class="product-name"><?php the_title(); ?></h2>
			<?php endif ?>
			
			<!-- DANIEL's CODE HERE -->
			<?php 
			show_product_made_by( $product );
			show_tried_and_tested( $post );
			echo apply_filters( 'woocommerce_short_description', $post->post_excerpt );


			?>
			<h4 style="display: none"><?php _e('Product Information', ETHEME_DOMAIN) ?></h4>
			<?php //echo do_shortcode( '[addtoany]' );
echo do_shortcode( '[ssba]' );
			?>
			<?php woocommerce_template_loop_rating(); ?>


			<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && $product->get_sku() ) : ?>
				<span itemprop="productID" class="sku_wrapper"><?php _e( 'Product code', ETHEME_DOMAIN ); ?>: <span class="sku"><?php echo $product->get_sku(); ?></span></span>
			<?php endif; ?>
			
			<?php
				$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
				//echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $size, 'woocommerce' ) . ' ', '.</span>' );
			?>
			
			<div class="product_page_price">
			<p class="price"><?php echo $product->get_price_html();?></p>
			<?php
				/**
				 * woocommerce_single_product_summary hook
				 *
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 */
				//do_action( 'woocommerce_single_product_summary' );
			?>
			<div class="clear"></div>
			</div>
		    <?php if ( etheme_get_custom_field('size_guide_img') ) : ?>
		    	<?php $lightbox_rel = (get_option('woocommerce_enable_lightbox') == 'yes') ? 'prettyPhoto' : 'lightbox'; ?>
		        <div class="size_guide">
		    	 <a rel="<?php echo $lightbox_rel; ?>" href="<?php etheme_custom_field('size_guide_img'); ?>"><?php _e('SIZING GUIDE', ETHEME_DOMAIN); ?></a>
		        </div>
		    <?php endif; ?>	

			<?php if (is_user_logged_in()) {
				if ($product->is_downloadable('yes'))
					woocommerce_template_single_add_to_cart(); 
				else if ($product->is_type('external')) {
					$price = get_post_meta( get_the_ID(), '_regular_price');

					$price = $price[0];
					if ($price == '0.00') {
						$product_url = get_post_meta( get_the_ID(), '_product_url');
						$product_url = $product_url[0];
						echo '<div class="direct_download">';
						echo '<a class="single_add_to_cart_button filled big font2 button alt" href="'.$product_url.'" download>Download this boffle</a>';
						echo '</div>';
					} else {
						woocommerce_template_single_add_to_cart(); 
					}
				} else 
					woocommerce_template_single_add_to_cart(); 
			} else {
				if ($product->is_downloadable('yes')){
					$price = get_post_meta( get_the_ID(), '_regular_price');
					$price = $price[0];
					if ($price) {
						//echo '<div class="login_to_download"><a class="filled big font2 single_add_to_cart_button button big alt" href="'.site_url().'/my-account/">Add to Cart</a></div>';
						?>
<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>
	 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	 	<?php
	 		if ( ! $product->is_sold_individually() )
	 			woocommerce_quantity_input( array(
	 				'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
	 				'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
	 			) );
	 	?>

	 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />

	 	<button type="submit" class="<?php if(etheme_get_option('ajax_addtocart')): ?>etheme-simple-product<?php endif; ?> filled big font2 single_add_to_cart_button button big alt">Add to Cart.</button>
	 	
	 	<?php etheme_wishlist_btn(); ?>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
						<?php
					} else
						echo '<div class="login_to_download"><a class="filled big font2 single_add_to_cart_button button big alt" href="'.site_url().'/my-account/">Login to Download</a></div>';
				}
				else if ($product->is_type('external')) {
					$price = get_post_meta( get_the_ID(), '_regular_price');
					$price = $price[0];
					if ($price == '0.00') {
						echo '<div class="login_to_download"><a class="filled big font2 single_add_to_cart_button button big alt" href="'.site_url().'/my-account/">Login to Download</a></div>';
					} else {
						woocommerce_template_single_add_to_cart(); 
					}
				}
				else 
					woocommerce_template_single_add_to_cart(); 
			}

			?>

			<?php woocommerce_template_single_meta(); ?>
            
            <?php if(etheme_get_option('share_icons')) echo do_shortcode('[share text="'.get_the_title().'"]'); ?>
            
            
			<?php //woocommerce_template_single_sharing(); ?>
				
		</div>

		<?php if($single_product_sidebar && ($position == 'right' || ($responsive == 'bottom' && $position == 'left'))): ?>
			<div class="span3 sidebar sidebar-right single-product-sidebar">
				<?php et_product_brand_image(); ?>
				<?php if(etheme_get_option('upsell_location') == 'sidebar') woocommerce_upsell_display(); ?>
				<?php dynamic_sidebar('single-sidebar'); ?>
			</div>
		<?php endif; ?>

	</div>
	
	<?php
		woocommerce_output_product_data_tabs();

		if(etheme_get_custom_field('additional_block') != '') {
			echo '<div class="sidebar-position-without">';
			et_show_block(etheme_get_custom_field('additional_block'));
			echo '</div>';
		} 

	  	if(etheme_get_option('upsell_location') == 'after_content') woocommerce_upsell_display();
	  	if(etheme_get_option('show_related'))
			woocommerce_output_related_products();
	?>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>