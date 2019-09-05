# nova-pages

Laravel Nova static pages resource.

## Installation

Require package with Composer.

```sh
composer require den1n/nova-pages
```

Publish configuration file `config/pages.php`, migration file `*_create_pages_table.php`, views `views/vendor/nova-pages` and translations `lang/vendor/nova-pages`.

```sh
php artisan vendor:publish --provider=Den1n\NovaPages\ServiceProvider
```

Migrate database to create table where all pages will be stored.

```sh
php artisan migrate
```

Add instance of class `Den1n\NovaPages\Tool` to your `App\Providers\NovaServiceProvider::toots()` method to display the Pages within your Nova resources.

```php
/**
 * Get the tools that should be listed in the Nova sidebar.
 *
 * @return array
 */
public function tools()
{
    return [
        new \Den1n\NovaPages\Tool,
    ];
}
```

## Serving Pages

Add routes to your `routes/web.php` file.

```php
Route::novaPagesRoutes();
```

This route will serve all incoming /{page} requests. Because of that you must put this route to the end of file.

## Screenshots

### Pages

![Pages](https://raw.githubusercontent.com/den1n/nova-pages/master/screens/pages.png)

### Page Details

![Page Details](https://raw.githubusercontent.com/den1n/nova-pages/master/screens/page-form.png)

## Contributing

1. Fork it.
2. Create your feature branch: `git checkout -b my-new-feature`.
3. Commit your changes: `git commit -am 'Add some feature'`.
4. Push to the branch: `git push origin my-new-feature`.
5. Submit a pull request.

## Support

If you require any support open an issue on this repository.

## License

MIT
