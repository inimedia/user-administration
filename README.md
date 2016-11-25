# user-administration

Laravel package for common user administration

Installation Steps:
* php artisan make:auth (laravel default)
* install zizaco\entrust
* install inimedia/user-administration
* add UserAdministrationServiceProvider in config/app.php
* uncomment fillable in \App\User
* change Role and Permission class in entrust.php (from zizaco\entrust)
* migrate
* add UserAdministrationSeeder in DatabaseSeeder
* db:seed

recommended routes - without registration:
```php
//Auth::routes();
Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');
```
