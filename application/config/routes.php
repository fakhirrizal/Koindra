<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|   my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] = 'Auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

/* Auth */
$route['login_process'] = 'Auth/login_process';
$route['registrasi'] = 'Auth/registration';
$route['register_process'] = 'Auth/register_process';

/* Admin */
$route['admin_side/launcher'] = 'admin/App/launcher';
$route['admin_side/beranda'] = 'admin/App/home';
$route['admin_side/menu'] = 'admin/App/menu';
$route['admin_side/log_activity'] = 'admin/App/log_activity';
$route['admin_side/cleaning_log'] = 'admin/App/cleaning_log';
$route['admin_side/tentang_aplikasi'] = 'admin/App/about';
$route['admin_side/bantuan'] = 'admin/App/helper';

$route['admin_side/profile'] = 'admin/User_profile/profile';
$route['admin_side/update_profile'] = 'admin/User_profile/update_profile';
$route['admin_side/update_profile_photo'] = 'admin/User_profile/update_profile_photo';
$route['admin_side/password_setting'] = 'admin/User_profile/password_setting';
$route['admin_side/update_password'] = 'admin/User_profile/update_password';

$route['admin_side/administrator'] = 'admin/Master/admin_data';
$route['admin_side/tambah_data_admin'] = 'admin/Master/add_admin_data';
$route['admin_side/simpan_data_admin'] = 'admin/Master/save_admin_data';
$route['admin_side/detail_data_admin/(:any)'] = 'admin/Master/detail_admin_data/$1';
$route['admin_side/atur_ulang_kata_sandi_admin/(:any)'] = 'admin/Master/reset_password_admin_account/$1';
$route['admin_side/hapus_data_admin/(:any)'] = 'admin/Master/delete_admin_data/$1';

$route['admin_side/sekolah'] = 'admin/Master/school_data';
$route['admin_side/detail_data_sekolah/(:any)'] = 'admin/Master/detail_school_data/$1';
$route['admin_side/simpan_data_sekolah'] = 'admin/Master/save_school_data';
$route['admin_side/perbarui_data_sekolah'] = 'admin/Master/update_school_data';
$route['admin_side/hapus_data_sekolah/(:any)'] = 'admin/Master/delete_school_data/$1';

$route['admin_side/siswa'] = 'admin/Master/student_data';
$route['admin_side/tambah_data_siswa'] = 'admin/Master/add_student_data';
$route['admin_side/simpan_data_siswa'] = 'admin/Master/save_student_data';
$route['admin_side/detail_data_siswa/(:any)'] = 'admin/Master/detail_student_data/$1';
$route['admin_side/impor_data_siswa'] = 'admin/Master/import_student_data';
$route['admin_side/ubah_data_siswa/(:any)'] = 'admin/Master/edit_student_data/$1';
$route['admin_side/perbarui_data_siswa'] = 'admin/Master/update_student_data';
$route['admin_side/update_status'] = 'admin/Master/update_status';
$route['admin_side/atur_ulang_kata_sandi_siswa/(:any)'] = 'admin/Master/reset_password_student_account/$1';
$route['admin_side/hapus_data_siswa/(:any)'] = 'admin/Master/delete_student_data/$1';
$route['admin_side/kirim_pemberitahuan/(:any)/(:any)'] = 'admin/Master/send_notification/$1/$2';

$route['admin_side/paket'] = 'admin/Master/packet_data';
$route['admin_side/tambah_data_paket'] = 'admin/Master/add_packet_data';
$route['admin_side/simpan_data_paket'] = 'admin/Master/save_packet_data';
$route['admin_side/detail_data_paket/(:any)'] = 'admin/Master/detail_packet_data/$1';
$route['admin_side/ubah_data_paket/(:any)'] = 'admin/Master/edit_packet_data/$1';
$route['admin_side/perbarui_data_paket'] = 'admin/Master/update_packet_data';
$route['admin_side/hapus_data_paket/(:any)'] = 'admin/Master/delete_packet_data/$1';

$route['admin_side/laporan_kehadiran'] = 'admin/Report/presence_data';
$route['admin_side/detail_data_kehadiran/(:any)'] = 'admin/Report/presence_data_detail/$1';
$route['admin_side/simpan_data_kehadiran'] = 'admin/Report/save_presence_data';
$route['admin_side/impor_data_kehadiran'] = 'admin/Report/import_presence_data';
$route['admin_side/perbarui_data_kehadiran'] = 'admin/Report/update_presence_data';
$route['admin_side/hapus_data_kehadiran/(:any)'] = 'admin/Report/delete_presence_data';

$route['admin_side/pembayaran'] = 'admin/Payment/all_payment';
$route['admin_side/impor_data_pembayaran'] = 'admin/Payment/import_payment_data';
$route['admin_side/konfirmasi_pembayaran'] = 'admin/Payment/payment_confirmation';
$route['admin_side/hapus_transaksi/(:any)'] = 'admin/Payment/delete_payment/$1';

$route['admin_side/tambah_transaksi'] = 'admin/Payment/add_transaction';
$route['admin_side/transaction_check'] = 'admin/Payment/transaction_check';
$route['admin_side/delete_transaction/(:any)'] = 'admin/Payment/delete_transaction/$1';
$route['admin_side/save_transaction'] = 'admin/Payment/save_transaction';
$route['admin_side/destroy_cart'] = 'admin/Payment/destroy_cart';

/* Student */
$route['student/launcher'] = 'student/App/launcher';
$route['student/beranda'] = 'student/App/home';
$route['student/menu'] = 'student/App/menu';
$route['student/log_activity'] = 'student/App/log_activity';
$route['student/tentang_aplikasi'] = 'student/App/about';
$route['student/bantuan'] = 'student/App/helper';

$route['student/profile'] = 'student/User_profile/profile';
$route['student/update_profile'] = 'student/User_profile/update_profile';
$route['student/update_profile_photo'] = 'student/User_profile/update_profile_photo';
$route['student/password_setting'] = 'student/User_profile/password_setting';
$route['student/update_password'] = 'student/User_profile/update_password';
$route['student/email_setting'] = 'student/User_profile/email_setting';
$route['student/update_email'] = 'student/User_profile/update_email';

$route['student/start_free_trial'] = 'student/Master/start_free_trial';

$route['student/paket'] = 'student/Payment/packet_data';
$route['student/detail_data_paket/(:any)'] = 'student/Payment/detail_packet_data/$1';
$route['student/add_to_cart/(:any)'] = 'student/Payment/add_to_cart/$1';
$route['student/cart'] = 'student/Payment/cart';
$route['student/destroy_cart'] = 'student/Payment/destroy_cart';
$route['student/transaction_completed'] = 'student/Payment/transaction_completed';
$route['student/riwayat_pembelian'] = 'student/Payment/payment_history';
$route['student/detail_transaksi/(:any)'] = 'student/Payment/payment_detail/$1';
$route['student/pembatalan_transaksi/(:any)'] = 'student/Payment/transaction_canceled/$1';

$route['student/laporan_kehadiran'] = 'student/Report/presence_data';

/* REST API */
$route['rest_server'] = 'Rest_server/documentation';

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
