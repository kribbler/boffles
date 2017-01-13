<?php
function child_ts_theme_widgets_init(){
    register_sidebar( array(
        'name' => __( 'Header Top Right', 'legenda' ),
        'id' => 'header-top-right',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Header Top Links', 'legenda' ),
        'id' => 'header-top-links',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Copyright area 1', 'legenda' ),
        'id' => 'coyright-area-1',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );
    
    register_sidebar( array(
        'name' => __( 'Copyright area 2', 'legenda' ),
        'id' => 'coyright-area-2',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );
    
    register_sidebar( array(
        'name' => __( 'Footer Bellow', 'legenda' ),
        'id' => 'footer-bellow',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Footer Left', 'legenda' ),
        'id' => 'footer-left',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Footer Right', 'legenda' ),
        'id' => 'footer-right',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );
}

add_action( 'widgets_init', 'child_ts_theme_widgets_init' );

add_shortcode( 'latest_blog_post', 'show_last_blog_post_on_homepage' );

function show_last_blog_post_on_homepage(){
    global $post;

    $query_args = array(
        'post_type'         => 'post',
        'numberposts'       => 1,
        'orderby'           => 'post_date',
        'order'             => 'DESC',
        'post_status'       => 'publish'
    );

    $recent_posts = wp_get_recent_posts( $query_args, OBJECT );
    $post = $recent_posts[0];
    setup_postdata( $post );
    $output = "";
    $output .= '<div class="latest_blog_post">';
    $output .= '<a class="small_featured" href="'.get_permalink().'">'.get_the_post_thumbnail($post->ID).'</a>';
    $output .= '<div id="block_title">Latest from the Buffle Blog</div>';
    $output .= '<div id="latest_blog_post_inside">';
    $output .= '<a class="latest_post_title" href="' . get_permalink() . '">' . get_the_title($post->ID) . '</a>';
    $output .= '<p>' . get_the_excerpt( $post->ID ) . ' <a href="'.get_permalink().'">Read more</a>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

/***************************************************************/
/* Etheme Global Search */
/***************************************************************/
if(!function_exists('my_search')) {
    function my_search($atts) {
        extract( shortcode_atts( array(
            'products' => 1,
            'posts' => 1,
            'portfolio' => 1,
            'pages' => 1,
            'images' => 1,
            'count' => 3,
            'class' => ''
        ), $atts ) );
        
        $search_input = $output = '';
        $post_type = "post";
        
        if($products == 1) {
            $post_type = "product";
        } else {
            $post_type = "post";
        }
        
        if(get_search_query() != '') {  
            $search_input = get_search_query(); 
        }
        
        $output .= '<div class="my_search et-mega-search '.$class.'" data-products="'.$products.'" data-count="'.$count.'" data-posts="'.$posts.'" data-portfolio="'.$portfolio.'" data-pages="'.$pages.'" data-images="'.$images.'">';
            $output .= '<form method="get" action="'.home_url( '/' ).'">';
                $output .= '<input type="text" value="'.$search_input.'" name="s" id="s" autocomplete="off" placeholder="'.__('search 3D files, enter keyword', ETHEME_DOMAIN).'"/>';
                $output .= '<input type="hidden" name="post_type" value="'.$post_type.'"/>';
                $output .= '<input type="submit" value="'.__( 'Go', ETHEME_DOMAIN ).'" class="button active filled"  /> ';
            $output .= '</form>';
            $output .= '<span class="et-close-results"></span>';
            $output .= '<div class="et-search-result">';
            $output .= '</div>';
        $output .= '</div>';
        
        return $output;
            
    }
}

add_shortcode('my_search', 'my_search');

function show_tried_and_tested($post){
    $tried_and_tested = get_post_meta($post->ID, 'boffles_tried_and_tested', true );
    if ($tried_and_tested == 1){
        echo '<div class="tried_and_tested"></div>';
    }
}

function show_product_made_by( $product ){
    $made_by = $product->get_attribute( 'pa_manufacturer' );
    if ($made_by){
        //pr($made_by);
        $manu = get_term_by( 'name', $made_by, 'pa_manufacturer' );
        //pr($manu);
        $manufacturer_link = get_term_link( $manu->slug, 'pa_manufacturer' );
        echo '<div class="made_by">Made by <a href="' . $manufacturer_link . '">'.$made_by.'</a></div>';
    }
}

function show_last_comment_content( $id ){
    $args = array ('post_id' => $id); 
    $comments = get_comments( $args );
    if ($comments && is_product()){
        echo '<div class="last_comment">' . $comments[0]->comment_content . '</div>';
    }
}

add_shortcode('s11_featured', 's11_featured_shortcodes');
function s11_featured_shortcodes($atts, $content=null){
    global $wpdb;
    if ( !class_exists('Woocommerce') ) return false;
    
    extract(shortcode_atts(array( 
        'shop_link' => 1,
        'limit' => 50,
        'categories' => '',
        'title' => __('Featured Products', ETHEME_DOMAIN)
    ), $atts)); 
    
    $key = '_featured';
    

    $args = apply_filters('woocommerce_related_products_args', array(
        'post_type'             => 'product',
        'meta_key'              => $key,
        'meta_value'            => 'yes',
        'ignore_sticky_posts'   => 1,
        'no_found_rows'         => 1,
        'posts_per_page'        => $limit
    ) );
    
      // Narrow by categories
      if ( $categories != '' ) {
          $categories = explode(",", $categories);
          $gc = array();
          foreach ( $categories as $grid_cat ) {
              array_push($gc, $grid_cat);
          }
          $gc = implode(",", $gc);
          ////http://snipplr.com/view/17434/wordpress-get-category-slug/
          $args['category_name'] = $gc;
          $pt = array('product');

          $taxonomies = get_taxonomies('', 'object');
          $args['tax_query'] = array('relation' => 'OR');
          foreach ( $taxonomies as $t ) {
              if ( in_array($t->object_type[0], $pt) ) {
                  $args['tax_query'][] = array(
                      'taxonomy' => $t->name,//$t->name,//'portfolio_category',
                      'terms' => $categories,
                      'field' => 'id',
                  );
              }
          }
      }
      
    ob_start();
    s11_create_slider($args,$title, $shop_link);
    $output = ob_get_contents();
    ob_end_clean();
    
    return $output;
}

// **********************************************************************// 
// ! WooCommerce featured slider
// **********************************************************************// 
add_shortcode('s11_show_products_from_category', 's11_show_products_from_category');
function s11_show_products_from_category($atts, $content=null){
    global $wpdb;
    if ( !class_exists('Woocommerce') ) return false;
    
    extract(shortcode_atts(array( 
        'shop_link' => 1,
        'limit' => 50,
        'categories' => '',
        'title' => __('Featured Products', ETHEME_DOMAIN)
    ), $atts)); 
    
    $key = '_featured';
    
    $cat = get_term_by('name', $categories, 'product_cat');
    $categories = $cat->term_id;

    $args = apply_filters('woocommerce_related_products_args', array(
        'post_type'             => 'product',
        //'meta_key'              => $key,
        //'meta_value'            => 'yes',
        'ignore_sticky_posts'   => 1,
        'no_found_rows'         => 1,
        'posts_per_page'        => $limit
    ) );
    
      // Narrow by categories
      if ( $categories != '' ) {
          $categories = explode(",", $categories);
          $gc = array();
          foreach ( $categories as $grid_cat ) {
              array_push($gc, $grid_cat);
          }
          $gc = implode(",", $gc);
          
          ////http://snipplr.com/view/17434/wordpress-get-category-slug/
          $args['category_name'] = $gc;
          $pt = array('product');

          $taxonomies = get_taxonomies('', 'object');
          $args['tax_query'] = array('relation' => 'OR');
          foreach ( $taxonomies as $t ) {
              if ( in_array($t->object_type[0], $pt) ) {
                  $args['tax_query'][] = array(
                      'taxonomy' => $t->name,//$t->name,//'portfolio_category',
                      'terms' => $categories,
                      'field' => 'id',
                  );
              }
          }
      }
      //pr($args);
    ob_start();
    s11_create_slider($args,$title, $shop_link);
    $output = ob_get_contents();
    ob_end_clean();
    
    return $output;
}

// **********************************************************************// 
// ! Create products slider by args
// **********************************************************************//
if(!function_exists('s11_create_slider')) {
    function s11_create_slider($args, $slider_args = array()){//, $title = false, $shop_link = true, $slider_type = false, $items = '[[0, 1], [479,2], [619,2], [768,4],  [1200, 4], [1600, 4]]', $style = 'default'
        global $wpdb, $woocommerce_loop;
        $product_per_row = etheme_get_option('prodcuts_per_row');

        extract(shortcode_atts(array( 
            'title' => false,
            'shop_link' => false,
            'slider_type' => false,
            'items' => '[[0, 1], [479,2], [619,2], [768,4],  [1200, 4], [1600, 4]]',
            'style' => 'default',
            'block_id' => false
        ), $slider_args));
        
        $box_id = rand(1000,10000);
        $multislides = new WP_Query( $args );
        $shop_url = get_permalink(woocommerce_get_page_id('shop'));
        $class = $title_output = '';
        if(!$slider_type) {
            $woocommerce_loop['lazy-load'] = true;
            $woocommerce_loop['style'] = $style;
        }
        
        if($multislides->post_count > 1) {
            $class .= ' posts-count-gt1';
        }
        if($multislides->post_count < 4) {
            $class .= ' posts-count-lt4';
        }

        if ( $multislides->have_posts() ) :
            if ($title) {
                $title_output = '<h2 class="title"><span>'.$title.'</span></h2>';
            }   
              echo '<div class="slider-container '.$class.'">';
                  echo $title_output;
                  if($shop_link && $title)
                    echo '<a href="'.$shop_url.'" class="show-all-posts hidden-tablet hidden-phone">'.__('View more products', ETHEME_DOMAIN).'</a>';
                  echo '<div class="items-slider products-slider '.$slider_type.'-container slider-'.$box_id.'">';
                        echo '<div class="slider '.$slider_type.'-wrapper">';
                        $_i=0;
                            if($block_id && $block_id != '' && et_get_block($block_id) != '') {
                                echo '<div class=" '.$slider_type.'-slide">';
                                    echo et_get_block($block_id);
                                echo '</div><!-- slide-item -->';
                            }
                            while ($multislides->have_posts()) : $multislides->the_post();
                                $_i++;
                                
                                if(class_exists('Woocommerce')) {
                                    global $product;
                                    if (!$product->is_visible()) continue; 
                                    echo '<div class="slide-item product-slide '.$slider_type.'-slide">';
                                        woocommerce_get_template_part( 'content', 'product' );
                                    echo '</div><!-- slide-item -->';
                                }

                            endwhile; 
                        echo '</div><!-- slider -->'; 
                  echo '</div><!-- products-slider -->'; 
              echo '</div><!-- slider-container -->'; 
        endif;
        wp_reset_query();
        unset($woocommerce_loop['lazy-load']);
        unset($woocommerce_loop['style']);
        if($items != '[[0, 1], [479,2], [619,2], [768,4],  [1200, 4], [1600, 4]]') {
            $items = '[[0, '.$items['phones'].'], [479,'.$items['phones'].'], [619,'.$items['tablet'].'], [768,'.$items['tablet'].'],  [1200, '.$items['notebook'].'], [1600, '.$items['desktop'].']]';
        } 
        
        if(!$slider_type) {
            echo '
    
                <script type="text/javascript">
                    jQuery(".slider-'.$box_id.' .slider").owlCarousel({
                        items:5, 
                        lazyLoad : true,
                        navigation: true,
                        navigationText:false,
                        rewindNav: false,
                        //itemsCustom: '.$items.'
                        itemsCustom: false
                    });
    
                </script>
            ';
        } elseif($slider_type == 'swiper') {
            echo '
    
                <script type="text/javascript">
                  if(jQuery(window).width() > 767) {
                      jQuery(".slider-'.$box_id.'").etFullWidth();
                      var mySwiper'.$box_id.' = new Swiper(".slider-'.$box_id.'",{
                        keyboardControl: true,
                        centeredSlides: true,
                        calculateHeight : true,
                        slidesPerView: "auto"
                      })
                  } else {
                      var mySwiper'.$box_id.' = new Swiper(".slider-'.$box_id.'",{
                        calculateHeight : true
                      })
                  }

                    jQuery(function($){
                        $(".slider-'.$box_id.' .slide-item").click(function(){
                            mySwiper'.$box_id.'.swipeTo($(this).index());
                            $(".lookbook-index").removeClass("active");
                            $(this).addClass("active");
                        });
                        
                        $(".slider-'.$box_id.' .slide-item a").click(function(e){
                            if($(this).parents(".swiper-slide-active").length < 1) {
                                e.preventDefault();
                            }
                        });
                    }, jQuery);
                </script>
            ';
        }
        echo '<div class="clear"></div>';  
    }
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' ); // 2.1 +
function woo_custom_cart_button_text() {
    global $product;
    if ($product->is_downloadable('yes'))
        return __( 'Download This Boffle', 'woocommerce' );
    else 
        return __( 'Add to Cart', 'woocommerce' );
}

function string_limit_words($string, $word_limit) { 
    $words = explode(' ', $string); 

    return implode(' ', array_slice($words, 0, $word_limit)); 
}

function pr($str){
    echo "<pre>"; var_dump($str); echo "</pre>";
}