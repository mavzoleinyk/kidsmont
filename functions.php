<?php

include 'inc/woo.php';

add_action( 'wp_enqueue_scripts', 'add_styles' );
add_action( 'wp_enqueue_scripts', 'add_scripts' );
add_action('after_setup_theme', 'theme_register_nav_menu');


function add_styles() {
	wp_enqueue_style('dropzone', 'https://unpkg.com/dropzone@5/dist/min/dropzone.min.css');
  	wp_enqueue_style('style', get_template_directory_uri().'/css/style.css');
	wp_enqueue_style( 'theme', get_stylesheet_uri() );

}

function add_scripts() {

	wp_enqueue_script( 'jqs', get_template_directory_uri() . '/js/jQueryScripts.min.js', array('jquery'), false, true);
	wp_enqueue_script( 'fa', 'https://use.fontawesome.com/releases/v5.15.3/js/all.js', array('jquery'), false, true);
    wp_enqueue_script( 'cookie', get_template_directory_uri() . '/js/jquery.cookie.js', array(), false, true);
	wp_enqueue_script( 'vendors', get_template_directory_uri() . '/js/vendors.js', array(), false, true);
	wp_enqueue_script( 'app', get_template_directory_uri() . '/js/app.js', array(), false, true);

    wp_enqueue_script('jqueryvalidation',  'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js', array(), false, 1);
  wp_enqueue_script( 'messages_de', get_template_directory_uri() . '/js/messages_de.min.js', array(), false, true);
	wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.js', array('jquery'), false, true);

	wp_localize_script('script', 'globals',
		array(
			'url' => admin_url('admin-ajax.php'),
			'template' => get_template_directory_uri(),
            'upload'=>admin_url( 'admin-ajax.php?action=handle_dropped_media' ),
            'delete'=>admin_url( 'admin-ajax.php?action=handle_deleted_media' ),
		)
	);


}


add_filter('wpcf7_autop_or_not', '__return_false');

function theme_register_nav_menu(){
	register_nav_menus( array(
        'main-menu' => 'header',
        'mob-menu'  => 'mobile',
        'cat-menu'  => 'mobile-catalog',
        'foot-menu1' => 'footer1',
        'foot-menu2'  => 'footer2',
        'foot-menu3' => 'footer3',
       )
    );
	add_theme_support( 'post-thumbnails'); 
	add_theme_support( 'woocommerce');
}


if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();

	acf_add_options_sub_page('Theme Settings');
}

function phone_clear($phone_num){ 
    $phone_num = preg_replace("![^0-9]+!",'',$phone_num);
    return($phone_num); 
}				
 

function my_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyD7Q82l2QjSzJJk1uUW3OzUBGPTlbk8w1g');
}

add_action('acf/init', 'my_acf_init');


/*
*
TIME AGO
*/

function meks_time_ago() {
    return human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ).' '.__( 'ago' );
}

/*
*
 Custom Guttenberg Blocks
 */

function cq_register_blocks() {
    if( ! function_exists('acf_register_block') )
        return;
    acf_register_block( array(
        'name'          => 'custom_quotte',
        'title'         => 'Blockquote',
        'render_template'   => 'parts/quote.php',
        'category'      => 'common',
        'icon'          => 'format-quote',
        'mode'          => 'edit',
        'keywords'      => array( 'profile', 'user', 'author' )
    ));
}
add_action('acf/init', 'cq_register_blocks' );

function video_register_blocks() {
    if( ! function_exists('acf_register_block') )
        return;
    acf_register_block( array(
        'name'          => 'custom_video',
        'title'         => 'Video Custom',
        'render_template'   => 'parts/video.php',
        'category'      => 'common',
        'icon'          => 'format-video',
        'mode'          => 'edit',
        'keywords'      => array( 'profile', 'user', 'author' )
    ));
}
add_action('acf/init', 'video_register_blocks' );

/*
*
POST VIEWS
==========
*/

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


/*
*
excerpts
*/

add_filter( 'excerpt_more', function( $more ) {
    return '...';
} );

add_filter( 'excerpt_length', function(){
    return 20;
} );


/*
*
pagination
*/

add_filter('navigation_markup_template', 'my_navigation_template', 10, 2 );
function my_navigation_template( $template, $class ){
    
    return '<div class="pagination">%3$s</div>';

}


/*
*
DROPZONE
*/
add_action( 'wp_ajax_handle_dropped_media', 'handle_dropped_media' );
add_action( 'wp_ajax_nopriv_handle_dropped_media', 'handle_dropped_media' );

function handle_dropped_media() {
    
    status_header(200);



   // $newupload = [];

    if ( !empty($_FILES) ) {
        $files = $_FILES;
        foreach($files as $file) {
            $newfile = array (
            'name' => $file['name'],
            'type' => $file['type'],
            'tmp_name' => $file['tmp_name'],
            'error' => $file['error'],
            'size' => $file['size']
            );

            $_FILES = array('upload'=>$newfile);
            foreach($_FILES as $file => $array) {
                $newupload  = insert_attachment( $file  );

            }

        }
    }

    echo $newupload;

    die();
}


function insert_attachment($file_handler) {
    // check to make sure its a successful upload
    //  if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $attach_id = media_handle_upload( $file_handler, 0 );

    return intval($attach_id);
}


add_action( 'wp_ajax_handle_deleted_media', 'handle_deleted_media' );

function handle_deleted_media(){

    if( isset($_REQUEST['media_id']) ){
        $post_id = absint( $_REQUEST['media_id'] );

        $status = wp_delete_attachment($post_id, true);

        if( $status )
        echo json_encode(array('status' => 'OK'));
        else
        echo json_encode(array('status' => 'FAILED'));
    }


    die();
}


function add_review(){

    $images = explode(",", $_GET['media_ids']);
 
    $args = array(
        'post_type' => 'reviews',
        'post_status' => 'draft',
        'post_title'=> $_GET['name'],
    );
    $post_id = wp_insert_post($args);

    update_post_meta($post_id, 'text_reviews', $_GET['text']);
    update_post_meta($post_id, 'gallery', $images);
 

    die();
}
 
 
add_action('wp_ajax_add_review', 'add_review');
add_action('wp_ajax_nopriv_add_review', 'add_review');



function add_review_mob(){

    $images = explode(",", $_GET['media_ids']);
 
    $args = array(
        'post_type' => 'reviews',
        'post_status' => 'draft',
        'post_title'=> $_GET['name_m'],
    );
    $post_id = wp_insert_post($args);

    update_post_meta($post_id, 'text_reviews', $_GET['text_m']);
    update_post_meta($post_id, 'gallery', $images);
 

    die();
}
 
 
add_action('wp_ajax_add_review_mob', 'add_review_mob');
add_action('wp_ajax_nopriv_add_review_mob', 'add_review_mob');


/**
 * ajax_search
 */



function faq_search() {

     if ($_GET['q'])
        
        $q = new wp_Query([
            'post_type' => 'faq',
            's' => $_GET['q']
        ]);

        while ($q->have_posts()) { $q->the_post();
            $cat = get_the_terms(get_the_ID(), 'category_faq');
            $cid = $cat[0]->term_id;?>
    
            <a href="#faq_<?= get_the_ID();?>" class="search-link" data-term="<?= $cid;?>"><?php the_title();?></a>

        <?php }

    die();
}

add_action('wp_ajax_faq_search', 'faq_search');
add_action('wp_ajax_nopriv_faq_search', 'faq_search');


/*
*
Main Menu
*/

class Main_Menu extends Walker_Nav_Menu {

    function start_lvl( &$output, $depth = 0, $args = NULL ) {
        
        $output .= '<div class="menu__sub-menu-wrap"><ul class="sub-menu">';
    }

    function start_el( &$output, $item, $depth = 0, $args = NULL, $id = 0 ) {
        global $wp_query;           

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
 
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

        if($depth==0){
            $class_names = ' class="menu__list-item ' . esc_attr( $class_names ) . '"';
        }else{
            $class_names = ' class="' . esc_attr( $class_names ) . '"'; 
        }


        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        if ( $args->walker->has_children ) {
            $child = 'data-menu-item-has-sab-menu';

            $output .= $indent . '<li' . $id . $value . $class_names . $child.'>';
        }else{
            $output .= $indent . '<li' . $id . $value . $class_names.'>';
        }
        

        
 
        
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
 
        $item_output = $args->before;
        if($depth==0){
            $item_output .= '<a'. $attributes .' class="menu__link">';
        }else{
            $im = get_field('image', $item);
            $item_output .= '<a'. $attributes .' class="sub-menu__link" data-img-url="'.$im.'">'; 
        }
        
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        
        $item_output .= '</a>';
        $item_output .= $args->after;
 
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function end_lvl( &$output, $depth = 0, $args = NULL ) {
        $output .= '</ul><div class="menu__img"><a href="#"><img src="" alt=""></a></div></div>';
    }
}


/*
*
Mob Menu
*/

class Mob_Menu extends Walker_Nav_Menu {


    function start_el( &$output, $item, $depth = 0, $args = NULL, $id = 0 ) {
        global $wp_query;           

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
 
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

       
        $class_names = ' class="menu-mobile__list-item ' . esc_attr( $class_names ) . '"'; 
        


        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        if ( $args->walker->has_children ) {
            $child = 'data-action="show-next-list"';
        }
        

        $output .= $indent . '<li' . $id . $value . $class_names . $child.'>';
 
        
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
 
        $item_output = $args->before;
        if ( $args->walker->has_children ) {
            $item_output .= '<a'. $attributes .' class="menu-mobile__link menu-mobile__link--with-chevron menu-mobile__link">';
        }else{
            $item_output .= '<a'. $attributes .' class="menu-mobile__link">'; 
        }
        
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        
        $item_output .= '</a>';
        $item_output .= $args->after;
 
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}


/* REGISTER*/

add_action('wp_ajax_registration_validation', 'registration_validation');
add_action('wp_ajax_nopriv_registration_validation', 'registration_validation');
function registration_validation(  )  {

    $reg_errors = new WP_Error;

    $email      =  sanitize_email($_POST['email']);
    $password   =  esc_attr($_POST['password']);
    $first_name =  sanitize_text_field($_POST['first_name']);
    $last_name  =  sanitize_text_field($_POST['last_name']);


    if ( empty( $password ) || empty( $email ) ) {
        $reg_errors->add('field','Required form field is missing');
    }



    if ( !is_email( $email ) ) {
        $reg_errors->add('email_invalid', 'Email is not valid');
    }

    if ( email_exists( $email ) ) {
        $reg_errors->add('email', 'Email Already in use');
    }

    if (  !empty($reg_errors->errors ) )  {
        foreach ( $reg_errors->get_error_messages() as $error ) {
            echo '<div><strong>';
            echo $error . '</strong><br/>';

            echo '</div>';
        }
    } else {

        complete_registration( $password, $email, $first_name, $last_name);

    }



    die();
}

function complete_registration(  $password, $email, $first_name, $last_name) {


        $userdata = array(
        'user_login'    =>  $email,
        'user_email'    =>  $email,
        'user_pass'     =>  $password,
        'first_name'    =>   $first_name,
        'last_name'     =>   $last_name,
        );
        $user_id = wp_insert_user( $userdata );

        nocache_headers();
        wp_clear_auth_cookie();
        wp_set_auth_cookie( $user_id );

        echo '<script>  location.href = "'.get_permalink(34).'"; </script>';

}


function my_login_action()  {



  if(!isset($_POST['action']) || $_POST['action'] !== 'my_login_action')
    return;

    $info = array();
    $info['user_login'] = $_POST['email'];
    $info['user_password'] = $_POST['pwd'];

  $result = wp_signon( $info, false );

  if(is_wp_error($result))

      wp_send_json([
          'msg' => 'Login failed. Wrong password or user name?',
      ]);

  else

    wp_send_json([
        'url' => get_permalink(34),
        'msg' => 'Processing..'
    ]);

    wp_redirect( get_permalink(34));

    
  
  exit;
};


add_action('wp_ajax_my_login_action', 'my_login_action');
add_action('wp_ajax_nopriv_my_login_action', 'my_login_action');


add_action( 'wp_ajax_loadmore', 'loadmore' );
add_action( 'wp_ajax_nopriv_loadmore', 'loadmore' );
 
function loadmore() {
 
    $paged = ! empty( $_GET[ 'paged' ] ) ? $_GET[ 'paged' ] : 1;
    $paged++;
 
    $args = array(
        'paged' => $paged,
        'post_type' => 'reviews',
        'posts_per_page' => 5,
        'post_status' => 'publish',
    );
 
    $wp_query = new WP_Query($args);
 
    while( $wp_query->have_posts() ) : $wp_query->the_post();

        $images = get_field('gallery');
        $c = count($images);

        ?>
                        
        <li>
            <div class="reviews-list-card">
                <div class="reviews-list-card__col-1">
                    <div class="reviews-list-card__text text-content"><?php the_field('text_reviews');?></div>
                    <div class="reviews-list-card__author"><?php the_title();?></div>
                </div>
                <div class="reviews-list-card__col-2">
                    <?php if( $c > 1 ):?>
                        <div class="reviews-list-card__slider swiper" data-reviews-list-card-slider>
                            <button class="reviews-list-card__btn reviews-list-card__btn--next">Next</button>
                            <div class="swiper-wrapper">
                                <?php foreach( $images as $im ): ?>
                                    <div class="swiper-slide ibg">
                                        <img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    <?php else:?>
                        <div class="reviews-list-card__img ibg">
                            <?php foreach( $images as $im ): ?>
                                <img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </li>
 
    <?php endwhile;
 
    die;
 
}


