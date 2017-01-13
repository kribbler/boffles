<?php
/*
Template Name: Home Page
*/


	get_header();
?>

<?php 
	extract(etheme_get_page_sidebar());
?>
<?php /*
<?php if ($page_heading != 'disable' && ($page_slider == 'no_slider' || $page_slider == '')): ?>
	<div class="page-heading bc-type-<?php etheme_option('breadcrumb_type'); ?>">
		<div class="container">
			<div class="row-fluid">
				<div class="span12 a-center">
					<!--<h1 class="title"><span><?php the_title(); ?></span></h1>-->
					<?php etheme_breadcrumbs(); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>
*/?>

<?php if($page_slider != 'no_slider' && $page_slider != ''): ?>
	
	<?php echo do_shortcode('[rev_slider_vc alias="'.$page_slider.'"]'); ?>

<?php endif; ?>

<div id="home_block0" class="greener margin_40">
	<div class="container">
		<?php
			if ($_SERVER['REMOTE_ADDR'] == '::1') 
				echo do_shortcode('[content_block id=197 ]');
			else 
				echo do_shortcode('[content_block id=82 ]'); 
		?>
	</div>
</div>

<div id="home_block1" class="greener margin_40">
	<div class="container">
		<?php
			if ($_SERVER['REMOTE_ADDR'] == '::1') 
				echo do_shortcode('[content_block id=37 ]');
			else 
				echo do_shortcode('[content_block id=54 ]'); 
		?>
	</div>
</div>

<div id="home_block2" class="greener margin_40">
	<div class="container">
		<?php
			if ($_SERVER['REMOTE_ADDR'] == '::1') 
				echo do_shortcode('[content_block id=39 ]');
			else 
				echo do_shortcode('[content_block id=56 ]'); 
		?>
	</div>
</div>

<div id="home_block3" class="greener margin_40">
	<div class="container">
		<?php
			if ($_SERVER['REMOTE_ADDR'] == '::1') 
				echo do_shortcode('[content_block id=41 ]');
			else 
				echo do_shortcode('[content_block id=58 ]'); 
		?>
	</div>
</div>

<div id="home_block4" class="greener margin_40">
	<div class="container">
		<?php
			if ($_SERVER['REMOTE_ADDR'] == '::1') 
				echo do_shortcode('[content_block id=43 ]');
			else 
				echo do_shortcode('[content_block id=60 ]'); 
		?>
	</div>
</div>

<div id="home_block5" class="greener margin_40">
	<div class="container">
		<?php
			if ($_SERVER['REMOTE_ADDR'] == '::1') 
				echo do_shortcode('[content_block id=45 ]');
			else 
				echo do_shortcode('[content_block id=62 ]'); 
		?>
	</div>
</div>

<div id="home_block6" class="greener margin_40">
	<div class="container">
		<?php
			if ($_SERVER['REMOTE_ADDR'] == '::1') 
				echo do_shortcode('[content_block id=47 ]');
			else 
				echo do_shortcode('[content_block id=64 ]'); 
		?>
	</div>
</div>

<div id="home_block7" class="greener margin_40">
	<div class="container">
		<?php
			if ($_SERVER['REMOTE_ADDR'] == '::1') 
				echo do_shortcode('[content_block id=49 ]');
			else 
				echo do_shortcode('[content_block id=66 ]'); 
		?>
	</div>
</div>

<div id="home_block8" class="greener margin_40">
	<div class="container">
		<?php
			if ($_SERVER['REMOTE_ADDR'] == '::1') 
				echo do_shortcode('[content_block id=51 ]');
			else 
				echo do_shortcode('[content_block id=68 ]'); 
		?>
	</div>
</div>

<div id="home_block9" class="greener margin_40">
	<div class="container">
		<?php
			if ($_SERVER['REMOTE_ADDR'] == '::1') 
				echo do_shortcode('[content_block id=53 ]');
			else 
				echo do_shortcode('[content_block id=70 ]'); 
		?>
	</div>
</div>

<div class="container" style="display: none">
	<div class="page-content sidebar-position-<?php echo $position; ?> responsive-sidebar-<?php echo $responsive; ?>">
		<div class="row-fluid">
			<?php if($position == 'left' || ($responsive == 'top' && $position == 'right')): ?>
				<div class="<?php echo $sidebar_span; ?> sidebar sidebar-left">
					<?php //etheme_get_sidebar($sidebarname); ?>
				</div>
			<?php endif; ?>
			
			<div class="content <?php echo $content_span; ?>">
				<?php if(have_posts()): while(have_posts()) : the_post(); ?>
					
					<?php the_content(); ?>

					<div class="post-navigation">
						<?php wp_link_pages(); ?>
					</div>
					
					<?php if ($post->ID != 0 && current_user_can('edit_post', $post->ID)): ?>
						<?php edit_post_link( __('Edit this', ETHEME_DOMAIN), '<p class="edit-link">', '</p>' ); ?>
					<?php endif ?>

				<?php endwhile; else: ?>

					<h3><?php _e('No pages were found!', ETHEME_DOMAIN) ?></h3>

				<?php endif; ?>

			</div>

			<?php if($position == 'right' || ($responsive == 'bottom' && $position == 'left')): ?>
				<div class="<?php echo $sidebar_span; ?> sidebar sidebar-right">
					<?php etheme_get_sidebar($sidebarname); ?>
				</div>
			<?php endif; ?>
		</div><!-- end row-fluid -->

	</div>
</div><!-- end container -->


<script type="text/javascript">
	jQuery(document).ready(function($){
		
		for (i=1; i<=9; i++){
			$('#graph_' + i).find('span').hide();
			$('#graph_' + i).hover(
				function(){
					$(this).addClass('visible');
					if ($(this).attr('id') == 'graph_1'){
						$(this).css('background-color', '#007da5');
					}
					if ($(this).attr('id') == 'graph_2'){
						$(this).css('background-color', '#fa4c06');
					}
					if ($(this).attr('id') == 'graph_3'){
						$(this).css('background-color', '#f18903');
						$(this).css('width', '100px');
					}
					if ($(this).attr('id') == 'graph_4'){
						$(this).css('background-color', '#1fc2de');
					}
					if ($(this).attr('id') == 'graph_5'){
						$(this).css('background-color', '#c3d600');
						$(this).css('color', '#000');
					}
					if ($(this).attr('id') == 'graph_6'){
						$(this).css('background-color', '#f9e11b');
						$(this).css('color', '#000');
					}
					if ($(this).attr('id') == 'graph_7'){
						$(this).css('background-color', '#00b287');
					}
					if ($(this).attr('id') == 'graph_8'){
						$(this).css('background-color', '#f6303e');
					}
					if ($(this).attr('id') == 'graph_9'){
						$(this).css('background-color', '#76bd1d');
					}
					$(this).find('span').show();
				},
				function(){
					$(this).find('span').hide();
					$(this).removeClass('visible');
					$(this).css('background', 'none');
					$(this).css('color', '#fff');
				}
			);
	
		}

		var mlife = $('#five_letters').html();

		$('#five_letters li').hide();

		$('#five_letters li').each(function(i) {
		  $(this).fadeOut(0).delay(500*i).fadeIn(1000);
		});
		
	});

</script>
<?php
	get_footer();
?>