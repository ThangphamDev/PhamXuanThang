// Inventory routes
$router->get('/inventory', 'InventoryController@index');
$router->get('/inventory/edit/:id', 'InventoryController@edit');
$router->post('/inventory/edit', 'InventoryController@edit');
$router->post('/inventory/updateStock', 'InventoryController@updateStock');
$router->post('/inventory/checkStock', 'InventoryController@checkStock'); 