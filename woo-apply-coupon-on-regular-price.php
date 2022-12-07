<?php

/**
 * @link              https://titasbhukta.in
 * @since             1.0.0
 * @package           Woo_Apply_Coupon_On_Regular_Price
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Apply Coupon On Regular Price
 * Plugin URI:        https://https://titasbhukta.in/
 * Description:       This is a plugin to allow the coupon to be calculated on the regular price instead of the sale price.
 * Version:           1.0.0
 * Author:            Titas Bhukta
 * Author URI:        https://titasbhukta.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-apply-coupon-on-regular-price
 * Domain Path:       /languages
 */


add_action( 'woocommerce_before_calculate_totals', 'apply_coupon_on_regular_price', 10, 1);

function apply_coupon_on_regular_price( $cart_products ) {

    global $woocommerce;

    if( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    $coupon = False;

    if($coupons = WC()->cart->get_applied_coupons() == False ) { 
        $coupon = False;
    } else {
        foreach( WC()->cart->get_applied_coupons() as $applied_coupon ) {
            $current_coupon = new WC_Coupon( $applied_coupon );
            if($current_coupon->type == 'percent_product' || $current_coupon->type == 'percent') {
                $coupon = True;
            }
        }
    }

    if($coupon == True) {
        foreach ( $cart_products->get_cart() as $cart_product ) 
        {
            $price = $cart_product['data']->regular_price;
            $cart_product['data']->set_price( $price );
        }
    }

}

?>