<?php
defined('BASEPATH') or exit('No direct script access allowed');


$route['default_controller'] = 'web/welcome';
$route['product_details/(:any)/(:num)'] = 'web/Product/product_details/$2';
$route['product/(:any)/(:num)'] = 'web/Product/product_details/$2';
$route['home/add_to_cart'] = 'web/Home/add_to_cart';
$route['home/delete_cart/(:any)'] = 'web/Home/delete_cart/$1';
$route['home/update_cart'] = 'web/Home/update_cart';
$route['home/apply_coupon'] = 'web/Home/apply_coupon';
$route['checkout'] = 'web/Home/checkout';
$route['view_cart'] = 'web/Home/view_cart';
$route['comparison'] = 'web/Home/comparison';
$route['submit_checkout'] = 'web/Home/submit_checkout';
$route['category/(:any)/(:any)'] = 'web/Category/category_product/$1/$2';
$route['category/p/(:any)/(:any)'] = 'web/Category/category_product/$2';
$route['category/(:any)'] = 'web/Category/category_product/$1';
$route['category_product_search'] = 'web/Category/category_product_search';
$route['category_product/(:any)'] = 'web/Category/category_product/$1';
$route['category_product/(:any)/(:num)'] = 'web/Category/category_product/$1/$2';
$route['brand_product/list/(:any)'] = 'web/Product/brand_product/$1';
$route['change_currency'] = 'web/Home/change_currency';
$route['change_language'] = 'web/Home/change_language';
//Front end routing end

$route['track_my_order'] = 'web/Home/track_my_order';

//Customer dashboard and profile start
$route['forget_password_form'] = 'web/customer/Login/forget_password_form'; //martbd
$route['forget_password'] = 'web/customer/Login/forget_password'; //ajax call
$route['password_reset/(:num)'] = 'web/customer/Login/password_reset_form/$1';//after send email get link
$route['password_update'] = 'web/customer/Login/password_update';
$route['login'] = 'web/customer/Login';
$route['logout'] = 'web/customer/Customer_dashboard/Logout';
$route['do_login'] = 'web/customer/Login/do_login';
$route['signup'] = 'web/customer/Signup';
$route['user_signup'] = 'web/customer/Signup/user_signup';
$route['customer/customer_dashboard'] = 'web/customer/Customer_dashboard';
$route['customer/customer_dashboard/edit_profile'] = 'web/customer/Customer_dashboard/edit_profile';
$route['customer/customer_dashboard/update_profile'] = 'web/customer/Customer_dashboard/update_profile';
$route['customer/customer_dashboard/change_password_form'] = 'web/customer/Customer_dashboard/change_password_form';
$route['customer/customer_dashboard/change_password'] = 'web/customer/Customer_dashboard/change_password';
$route['customer/customer_dashboard/wishlist'] = 'web/customer/customer_dashboard/wishlist';
$route['customer/customer_dashboard/wishlist_delete/(:any)'] = 'web/customer/customer_dashboard/wishlist_delete/$1';
//Customer dashboard and profile end

//Customer order start
$route['customer/order'] = 'web/customer/Corder/new_order';
$route['customer/insert_order'] = 'web/customer/Corder/insert_order';
$route['customer/order/manage_order'] = 'web/customer/Corder/manage_order';
//Customer order end

//Customer invoice start
$route['customer/invoice'] = 'web/customer/Cinvoice/manage_invoice';
$route['customer/invoice/invoice_inserted_data/(:any)'] = 'web/customer/Cinvoice/invoice_inserted_data/$1';
//Customer invoice end

//Link page 
$route['about_us'] = 'web/Setting/about_us';
$route['contact_us'] = 'web/Setting/contact_us';
$route['delivery_info'] = 'web/Setting/delivery_info';
$route['privacy_policy'] = 'web/Setting/privacy_policy';
$route['terms_condition'] = 'web/Setting/terms_condition';
$route['help'] = 'web/Setting/help';
$route['submit_contact'] = 'web/Setting/submit_contact';
//Link page end

$route['admin'] = 'dashboard/admin_auth';
$route['Admin_dashboard'] = 'dashboard/Admin_dashboard';

$route['autoupdate'] = 'dashboard/Autoupdate';
$route['backend/autoupdate/update'] = 'dashboard/Autoupdate/update';
$route['forget_admin_password'] = 'dashboard/Admin_dashboard/forget_admin_password'; //ajax call
$route['admin_password_reset/(:num)'] = 'dashboard/Admin_dashboard/admin_password_reset_form/$1';//after send email get link
$route['admin_password_update'] = 'dashboard/Admin_dashboard/admin_password_update';
//Paypal Success
$route['paypal_success'] = 'web/home/paypal_success';
$route['paypal_cancel'] = 'web/home/paypal_cancel';
$route['paypal_ipn'] = 'web/home/paypal_ipn';
//Admin Dashboard End

// Role
$route['create_system_role'] = 'role/create_system_role';
$route['role_list'] = 'role/role_list';
$route['role/edit_role/item/(:num)'] = 'role/edit_role/$1';
$route['role/delete_role/item/(:num)'] = 'role/delete_role/$1';
$route['role_save_update'] = 'role/save_update';
//$route['dashboard_role_list'] = 'role/role_list';
$route['assign_role_to_user'] = 'role/assign_role_to_user';
$route['role_save_create'] = 'role/save_create';
$route['save_role_access'] = 'role/save_role_access';
$route['role/edit_access_role/item/(:num)'] = 'role/edit_access_role/$1';
$route['role/delete_access_role/item/(:num)'] = 'role/delete_access_role/$1';
$route['update_access_role'] = 'role/update_access_role';
$route['user_access_role'] = 'role/user_access_role';




$route['404_override'] = 'my404';
$route['translate_uri_dashes'] = FALSE;


//set modules/config/routes.php
$modules_path = APPPATH . 'modules/';
$modules = scandir($modules_path);

foreach ($modules as $module) {
    if ($module === '.' || $module === '..') continue;
    if (is_dir($modules_path) . '/' . $module) {
        $routes_path = $modules_path . $module . '/config/routes.php';
        if (file_exists($routes_path)) {
            require($routes_path);
        } else {
            continue;
        }
    }
}
