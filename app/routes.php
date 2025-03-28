// Add the review routes
$router->get('/Review', 'ReviewController@index');
$router->get('/Review/user', 'ReviewController@user');
$router->get('/Review/product/{id}', 'ReviewController@product'); 