<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/home', 'Home::index');
$routes->get('/', 'Home::index');

$routes->get('/login', 'Login::index');
$routes->get('/authentication/logout', 'Authentication::logout');
$routes->post('/authentication/login', 'Authentication::login');

$routes->get('/dashboard/research/(:any)', 'Dashboard::research/$1');
$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/document/get-jenis-transparansi', 'Document::getJenisTransparansi');
$routes->get('/document/add-jenis-transparansi', 'Document::addJenisTransparansi');
$routes->get('/document/drop-jenis-transparansi', 'Document::dropJenisTransparansi');
$routes->get('/document/edit-status', 'Document::editStatus');
$routes->get('/document/new', 'Document::new');
$routes->get('/document', 'Document::index');
$routes->post('/document/add-new', 'Document::addNew');

$routes->get('/post/edit-status', 'Post::editStatus');
$routes->get('/post/edit', 'Post::edit');
$routes->get('/post/new', 'Post::new');
$routes->get('/post', 'Post::index');
$routes->post('/post/add-new', 'Post::addNew');
$routes->post('/post/update', 'Post::update');

$routes->get('/page/edit-status', 'Page::editStatus');
$routes->get('/page/edit', 'Page::edit');
$routes->get('/page/new', 'Page::new');
$routes->get('/page', 'Page::index');
$routes->post('/page/add-new', 'Page::addNew');
$routes->post('/page/update', 'Page::update');

$routes->get('/service/unapprove', 'Service::unapprove');
$routes->get('/service/approve', 'Service::approve');
$routes->get('/service', 'Service::index');
$routes->post('/service/reply', 'Service::reply');

$routes->get('/comment/unapprove', 'Comment::unapprove');
$routes->get('/comment/approve', 'Comment::approve');
$routes->get('/comment', 'Comment::index');
$routes->post('/comment/reply', 'Comment::reply');

$routes->post('/upload/image-file-editor/(:any)', 'Upload::imageFileEditor/$1');
$routes->post('/upload/image-file-featured/(:any)', 'Upload::imageFileFeatured/$1');

//post artikel berita, pengumuman
$routes->get('/artikel/arsip/(:any)', 'Post::archive/$1'); //by ID_category
$routes->get('/artikel/tags/(:any)', 'Post::tags/$1'); //by tags
$routes->get('/artikel/pencarian', 'Post::search'); //by keywords get method
$routes->get('/artikel/arsip', 'Post::archive'); //all category
$routes->get('/artikel/(:any)', 'Post::article/$1'); //by slug
$routes->get('/artikel', 'Post::archive'); //all category

//page halaman, sitemap dsb
$routes->get('/halaman/peta-situs', 'Page::sitemap');
$routes->get('/halaman/(:any)', 'Page::article/$1');
$routes->get('/halaman', 'Page::sitemap');

$routes->get('/dip', 'Page::dip');
$routes->get('/transparansi-anggaran', 'Document::transparansi');
$routes->get('/download-area', 'Document::umum');

$routes->get('/layanan-pengaduan-masyarakat', 'Service::pengaduan');
$routes->get('/layanan-permohonan-informasi', 'Service::permohonan');
$routes->post('/kirim-layanan', 'Service::kirim');

//comment on ui
$routes->post('/kirim-komentar', 'Comment::kirim');

//option
$routes->get('/option', 'Option::index');
$routes->post('/option/save', 'Option::save');

//user
$routes->get('/user/hapus', 'User::delete');
$routes->get('/user', 'User::index');
$routes->post('/user/add-new', 'User::new');
$routes->post('/user/edit', 'User::edit');
$routes->post('/user/update', 'User::update');

//media
$routes->get('/media/delete', 'Media::delete');
$routes->get('/media', 'Media::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
