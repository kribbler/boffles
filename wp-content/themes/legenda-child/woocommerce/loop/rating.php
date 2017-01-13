<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
	return;
?>
<?php if (is_product()){?>
	<h3>Customer Reviews</h3>
<?php } ?>

<?php if ( $rating_html = $product->get_rating_html() ) { ?>
	<span class="rating-label"><?php _e('Rating:', ETHEME_DOMAIN); ?></span>
	<?php echo $rating_html; ?>
	<?php show_last_comment_content($product->id);?>
<?php } else { ?>
	<div class="star-rating" title="Rated 3.00 out of 5"></div>
<?php } ?>