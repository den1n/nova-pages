# nova-pages

Static pages resource for Laravel Nova.

## Installation

Install package with Composer.

```sh
composer require den1n/nova-pages
```

Publish package resources.

```sh
php artisan vendor:publish --provider="Den1n\NovaPages\ServiceProvider"
```

This will publish the following resources:

* Configuration file `config/nova-pages.php`
* Migration file `database/migrations/*_create_pages_tables.php`
* Translations `resources/lang/vendor/nova-pages`
* Vue example `resources/js/vendor/nova-pages/example.vue`

Migrate database.

```sh
php artisan migrate
```

Add instance of class `Den1n\NovaPages\Tool` to your `App\Providers\NovaServiceProvider::tools()` method to display the pages within your Nova resources.

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

After that `Pages` resource will be available in navigation panel of Nova.

## Serving pages example

You will need to create the Vue component to render existing pages.

As example you can use page component `resources/js/vendor/nova-pages/example.vue` provided by the package.

Add it to your Vue Router.

```js
const routes = {
    // ...

    {
        name: 'pages',
        path: '/pages/:slug',
        component: () => import(`resources/js/vendor/nova-pages/example.vue`),
    }
};
```

Then use `router-link` to navigate to `pages` route.

```html
    <router-link :to="{ name: 'pages', params: { slug: 'existing-page-slug' } }">
        Existing Page
    </router-link>
```

## Page types

By default all pages will has `default` type.

You can register additional types in configuration file `config/nova-pages.php`.

```php
/**
 * Page types.
 */

'types' => [
    // ...
    [
        'name' => 'my_type',
        'description' => 'My Type',
    ],
],
```

After that new type will be available to select when creating page or updating existing one.

## WYSIWYG editor

By default package uses default WYSIWYG editor [provided by Nova](https://nova.laravel.com/docs/1.0/resources/fields.html#trix-field).

You can replace default editor. For example, with `froala/nova-froala-field`.

To do this, [install the package](https://github.com/froala/nova-froala-field) and update `editor` settings in `config/nova-pages.php` file.

```php
    /**
     * Settings for WYSIWYG editor.
     */

    'editor' => [
        /**
         * Nova field class name.
         */

        'class' => \Froala\NovaFroalaField\Froala::class,

        /**
         * Options which will be applied to te field instance.
         * Key: name of field method.
         * Value: list of method arguments.
         */

        'options' => [
            'withFiles' => ['public', 'nova-pages'],

            // Froala options.
            'options' => [[
                'heightMax' => 800,
                'heightMin' => 300,
            ]],
        ],
    ],
```

## Screenshots

### Pages

![Pages](https://raw.githubusercontent.com/den1n/nova-pages/master/screens/pages.png)

### Page Form

![Page Form](https://raw.githubusercontent.com/den1n/nova-pages/master/screens/page-form.png)

### Page Details

![Page Details](https://raw.githubusercontent.com/den1n/nova-pages/master/screens/page-details.png)

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
