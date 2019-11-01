<?php
require __DIR__ .'/vendor/autoload.php';

header("Content-Type: text/html");
$router = new AltoRouter();
$router->setBasePath('/altorouter');
/* Setup the URL routing. This is production ready. */
// Main routes that non-customers see
// map homepage
$router->map( 'GET', '/', function() {
	require __DIR__ . '/views/home.php';
});

$router->map( 'GET', '/home/[a:action]', function($action) {
	require __DIR__ . '/views/home.php';
	echo '<pre><br />';
	var_dump($action);
});

// map user details page
/*$router->map( 'GET', '/user/[i:id]/', function( $id ) {
	require __DIR__ . '/views/user-details.php';
});*/

//$router->map('GET','/', 'views/home.php', 'home');
//$router->map('GET','/home/[i:id]', 'views/home.php', 'home-home');
$router->map('GET','/plans/', 'plans.php', 'plans');
$router->map('GET','/about/', 'about.php', 'about');
$router->map('GET','/contact/', 'contact.php', 'contact');
$router->map('GET','/tos/', 'tos.html', 'tos');
// Special (payments, ajax processing, etc)
$router->map('GET','/charge/[*:customer_id]/','charge.php','charge');
$router->map('GET','/pay/[*:status]/','payment_results.php','payment-results');
// API Routes
$router->map('GET','/api/[*:key]/[*:name]/', 'json.php', 'api');
/* Match the current request */
$match = $router->match();
if( is_array($match) && is_callable( $match['target'] ) ) {
  //require $match['target'];
  call_user_func_array( $match['target'], $match['params'] ); 
}
else {
  header("HTTP/1.0 404 Not Found");
  require '/views/404.html';
}