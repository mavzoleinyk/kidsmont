<?php

/**
 * add_to_cart
 */


function add_to_cart() {
    $product_id = (int)$_GET['product_id'];
    $variation_id = (int)$_GET['variation_id'];
    $qty = (int)$_GET['qty']??1;


    $added = WC()->cart->add_to_cart($product_id, $qty, $variation_id);
    update_totals();

    WC_AJAX :: get_refreshed_fragments();
    wp_die();


}

add_action('wp_ajax_nopriv_add_to_cart', 'add_to_cart');
add_action('wp_ajax_add_to_cart',  'add_to_cart');

/*
*

 GET MIN AND MAX PRICES 

 */

function get_filtered_price() {
  global $wpdb;

  $args       = wc()->query->get_main_query();

  $tax_query  = isset( $args->tax_query->queries ) ? $args->tax_query->queries : array();
  $meta_query = isset( $args->query_vars['meta_query'] ) ? $args->query_vars['meta_query'] : array();

  foreach ( $meta_query + $tax_query as $key => $query ) {
    if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
      unset( $meta_query[ $key ] );
    }
  }

  $meta_query = new \WP_Meta_Query( $meta_query );
  $tax_query  = new \WP_Tax_Query( $tax_query );

  $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
  $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

  $sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
  $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
  $sql .= "   WHERE {$wpdb->posts}.post_type IN ('product')
      AND {$wpdb->posts}.post_status = 'publish'
      AND price_meta.meta_key IN ('_price')
      AND price_meta.meta_value > '' ";
  $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

  $search = \WC_Query::get_main_search_query_sql();
  if ( $search ) {
    $sql .= ' AND ' . $search;
  }

  $prices = $wpdb->get_row( $sql ); 

  return [
    'min' => floor( $prices->min_price ),
    'max' => ceil( $prices->max_price )
  ];
}


/*
*

FILTER

*/

function filter(){

  $args['post_type'] = 'product';
  $args['posts_per_page'] = 12;
  $args['paged'] = ( get_query_var('page') ) ? get_query_var('page') : 1;

  $args['tax_query'] = [ 'relation' => 'AND'];

  if($_GET['color']){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_color',
        'field' => 'id',
        'terms' => $_GET['color'],
        'operator' => 'IN',
    ];
  }

  if($_GET['size']){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_size',
        'field' => 'id',
        'terms' => $_GET['size'],
        'operator' => 'IN',
    ];
  }

  if($_GET['material']){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_material',
        'field' => 'id',
        'terms' => $_GET['material'],
        'operator' => 'IN',
    ];
  }


  if ($_GET['price']) {
    $args['meta_query'] = [ 'relation' => 'AND'];
    $a = $_GET['price'];

    $arr = explode(';', $a);

      $meta_query = [

        [
          'key' => '_price',
          'value' => array($arr[0], $arr[1]),
          'compare' => 'BETWEEN',
          'type' => 'NUMERIC'
        ]
      ];
    $args['meta_query'] = $meta_query  ;
  }

   if ($_GET['orderby']) {
        switch ($_GET['orderby']) :
            case 'menu_order' :
                // $args['orderby'] = 'meta_value';
                // $args['order'] = 'ASC';
                // $args['meta_key'] = 'total_sales';
            break;
            case 'popularity' :
                $args['orderby'] = 'meta_value';
                $args['order'] = 'DESC';
                $args['meta_key'] = 'total_sales';             
            break;
            case 'date' :
                $args['orderby'] = 'date';
                $args['order'] = 'ASC';
            break;
            case 'price-desc' :
                $args['orderby'] = 'meta_value';
                $args['order'] = 'DESC';
                $args['meta_key'] = '_price';             
            break;
            case 'price' :
                $args['orderby'] = 'meta_value';
                $args['order'] = 'ASC';
                $args['meta_key'] = '_price';
            break;
        endswitch;
    }




   ob_start();

  $wp_query = new WP_Query($args);

  if ( $wp_query->have_posts() ) {

  ?>

    <ul class="products__list">

      <?php while ( $wp_query->have_posts() ) {

        $wp_query->the_post();

        echo '<li>';

        wc_get_template_part( 'content', 'product' );

        echo '</li>';

    }

    ?>


    </ul>
    <div class="products__bottom">
                            
        <?php woocommerce_pagination();?>

        <?php //kama_pagenavi([], $wp_query, $_GET);?>

    </div>
      
  <?php 

  }else {

      do_action( 'woocommerce_no_products_found' );

    }

 
 

  ob_start();
  // get_template_part('parts/select-filter');
  $select_filter = ob_get_clean();


    $count = sprintf( _n( '%d product', '%d products', $wp_query->found_posts, 'woocommerce' ), $wp_query->found_posts );

  wp_send_json([
      'content' => $content,
      'select_filter' => $select_filter,
      'count' => $count
  ]);

die();

}

add_action('wp_ajax_filter', 'filter');
add_action('wp_ajax_nopriv_filter', 'filter');



/*
*
Viewed Products
*/

add_action( 'template_redirect', 'recently_viewed_product_cookie', 20 );
 
function recently_viewed_product_cookie() {
 
    if ( ! is_product() ) {
        return;
    }
 
 
    if ( empty( $_COOKIE[ 'woocommerce_recently_viewed_2' ] ) ) {
        $viewed_products = array();
    } else {
        $viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_2' ] );
    }
 
    if ( ! in_array( get_the_ID(), $viewed_products ) ) {
        $viewed_products[] = get_the_ID();
    }
 
    if ( sizeof( $viewed_products ) > 4 ) {
        array_shift( $viewed_products );
    }
 
    wc_setcookie( 'woocommerce_recently_viewed_2', join( '|', $viewed_products ) );
 
}


add_action( 'woocommerce_save_account_details', 'save_favorite_color_account_details', 12, 1 );
function save_favorite_color_account_details( $user_id ) {
    
    if( isset( $_POST['phone'] ) )
        update_user_meta( $user_id, 'billing_phone', sanitize_text_field( $_POST['phone'] ) );

    if( isset( $_POST['address'] ) )
        update_user_meta( $user_id, 'billing_address_1', sanitize_text_field( $_POST['address'] ) );

}


add_filter('woocommerce_save_account_details_required_fields', 'myaccount_required_fields');

function myaccount_required_fields( $account_fields ) {

    unset( $account_fields['account_display_name'] );

    return $required_fields;
        
}


/*
*

Set Car Item QTY

*/

function set_cart_item_qty() {

    $key = $_GET['key'];
    $qty = (int)$_GET['qty'];
    WC()->cart->set_quantity( $key, $qty, true  );

    update_totals();

    wp_die();
}

add_action('wp_ajax_nopriv_set_cart_item_qty', 'set_cart_item_qty');
add_action('wp_ajax_set_cart_item_qty', 'set_cart_item_qty');


/**
* 
 Update Totals
*/ 


function update_totals() {

    ob_start();

    
    WC()->cart->calculate_totals();

    $tax = WC()->cart->get_total_tax();
    $taxes = number_format($tax, 2, ',', ' ');
    $sub = number_format(WC()->cart->subtotal, 2, ',', ' ');
    $total = number_format(WC()->cart->total, 2, ',', ' ');
    $count = WC()->cart->get_cart_contents_count();

    if($count==1){
        $count2 = $count . ' product';
    }else{
        $count2 = $count . ' products';
    }

    $html = ob_get_clean();

    wp_send_json_success(
        ['totals' => $html,
            'total' => $total . get_woocommerce_currency_symbol(),
            'subtotal' => $sub . get_woocommerce_currency_symbol(),
            'cart_qty' => $count,
            'cart_qty2' => $count2,
            'tax_total' => 'Including VAT ' .$taxes .get_woocommerce_currency_symbol(),
        ]
    );


    die();
}

add_action('wp_ajax_update_totals', 'update_totals');
add_action('wp_ajax_nopriv_update_totals', 'update_totals');



/**
* 
 Update Mini Cart
*/

function update_mini_cart() {
    wc_get_template('cart/mini-cart.php');
    die();
}

add_action('wp_ajax_update_mini_cart', 'update_mini_cart');
add_action('wp_ajax_nopriv_update_mini_cart', 'update_mini_cart');



/**
* 
 Update Cart
*/


function update_cart() {
    WC()->cart->empty_cart();

    foreach ($_GET['products'] as $p) {
        $product_id = (int)$p[0];
        $qty = (int)$p[1];

        WC()->cart->add_to_cart($product_id, $qty);


    }

    echo do_shortcode('[woocommerce_cart]');

    wp_die();
}
add_action('wp_ajax_update_cart', 'update_cart');
add_action('wp_ajax_nopriv_update_cart', 'update_cart');

/**
* 
 Favorite to Cart
*/


function fav_to_cart() {

    $prod = $_GET['product_id'];

    $arr = explode(',', $prod);

    foreach ($arr as $p) {

        $product_id = (int)$p;

        WC()->cart->add_to_cart($product_id, 1);


    }

    update_totals();

    WC_AJAX :: get_refreshed_fragments();
    wp_die();
}
add_action('wp_ajax_fav_to_cart', 'fav_to_cart');
add_action('wp_ajax_nopriv_fav_to_cart', 'fav_to_cart');


/**
 * set_shipping
 */


function set_shipping() {

    $method = $_GET['method'];


    WC()->session->set('chosen_shipping_methods', array( $method ) );

    WC()->cart->calculate_totals();

    $shipping = number_format(WC()->cart->shipping_total, 2, ',', ' ');
    $total = number_format(WC()->cart->total, 2, ',', ' ');

    wp_send_json([
       'shipping' => $shipping . get_woocommerce_currency_symbol(),
       'total' => $total . get_woocommerce_currency_symbol(),
    ]);

    wp_die();
}



add_action('wp_ajax_noprivset_shipping', 'set_shipping');
add_action('wp_ajax_set_shipping',  'set_shipping');

/*

Set states

*/


function state() {

    $st = WC()->customer->get_shipping_state();
    $country_code = $_GET['code'];
    $states_array = WC()->countries->get_states( $country_code );

    if(!empty($states_array)): ?>

        <select name="shipping_city" class="_select">
            <?php foreach ($states_array as $kod => $state) {?>
                <option <?php selected($st, $kod) ?> value="<?= $kod ?>"><?= $state ?></option>
            <?php } ?>
        </select>
    <?php endif;

    wp_die();
}



add_action('wp_ajax_nopriv_state', 'state');
add_action('wp_ajax_state',  'state');



function bill_state() {

    $stb = WC()->customer->get_billing_state();
    $states_arrayb = WC()->countries->get_states( $_GET['code'] );
    if(!empty($states_arrayb)):?>
        <select name="billing_state" class="_select">
            <?php foreach ($states_arrayb as $kodb => $stateb) {?>
                <option <?php selected($stb, $kodb) ?> value="<?= $kod ?>"><?= $stateb ?></option>
            <?php } ?>
        </select>
    <?php endif;

    wp_die();
}



add_action('wp_ajax_nopriv_bill_state', 'bill_state');
add_action('wp_ajax_bill_state',  'bill_state');




function update_inst() {
    


    $tot = WC()->cart->total;

    $sum = $tot + $_GET['inst'];

    $total = number_format($sum, 2, ',', ' ');

    WC()->cart->add_fee( "Gratuity", 23, false, '' );

    WC()->cart->calculate_totals();

    //echo $total.get_woocommerce_currency_symbol();


    wp_die();
}

//add_action('wp_ajax_update_inst', 'update_inst');
//add_action('wp_ajax_nopriv_update_inst', 'update_inst');



 add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );
function woo_add_cart_fee( $cart ){

    if ( isset( $_POST['post_data'] ) ) {
        parse_str( $_POST['post_data'], $post_data );
    } else {
        $post_data = $_POST; // fallback for final checkout (non-ajax)
    }

    if (isset($post_data['billing_installation'])) {
        $extracost = $post_data['billing_installation']; // not sure why you used intval($_POST['state']) ?
        WC()->cart->add_fee( 'Installation beinhalten', $extracost );
    }



      // WC()->cart->calculate_totals();

//    if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
//        return;
//    }
//

//




}