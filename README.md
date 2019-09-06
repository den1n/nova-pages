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

If you want to serve pages from root of the site add this route to the end of `routes/web.php` file.

```php
Route::novaPagesRoutes();
```

This route will serve all incoming /{page} requests.

Or you can define route with prefix to stop serving from root of the sites.

```php
Route::novaPagesRoutes('/pages');
```

You can get url to existing page by using Laravel `route` helper.

```php
use \Den1n\NovaPages\Page;

$url = route('nova-pages.show', [
    'page' => Page::find(1),
]);

// Or you can pass a page slug.
$url = route('nova-pages.show', [
    'page' => 'page-slug',
]);
```

## Default template

Page controller will serve pages with `default` template.

Template is published to views directory `resources\views\vendor\nova-pages\default.blade.php`.

Instance of `Page` model passed to template in `$page` variable.

You can freely modify `default` template.

## Creating a custom template

First create a custom blade template in `resources\views\vendor\nova-pages` directory.

For example, `rich.blade.php`.

Then register it in configuration file `config/nova-pages.php`.

```php
/**
 * Array of templates used by controller.
 */

'templates' => [
    // ...
    [
        'name' => 'rich',
        'description' => 'A rich template',
    ],
],
```

After that your custom template will be available to select in Nova Pages tool.

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
