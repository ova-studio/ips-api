# IPS REST API Laravel Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ova-studio/ips-api.svg?style=flat-square)](https://packagist.org/packages/ova-studio/ips-api)
[![Total Downloads](https://img.shields.io/packagist/dt/ova-studio/ips-api.svg?style=flat-square)](https://packagist.org/packages/ova-studio/ips-api)

# [IPS REST API Documentation](https://invisioncommunity.com/developers/rest-api)

## Installation

You can install the package via composer:

```bash
composer require ova-studio/ips-api
```

## Configuration

In `config/services.php`:

```php
'ips' => [
    // ... other options
    'base_uri' => env('IPS_BASE_URI'),
    'api_key' => env('IPS_API_KEY'),
    'default_user' => env('IPS_DEFAULT_USER_ID')
]
```

## Implemented API Methods

### Sending private message

[Method documentation](https://invisioncommunity.com/developers/rest-api?endpoint=core/messages/POSTindex)

Basic usage:
```php
$api = new IpsApi();
$to_user_id = 1;

$api->system()->messages()->create($to_user_id, 'Message title', 'Message body');
```

By default, message is sent from default user from config file.
If you want to send message from another user, you can set user id with
`withSender` method.
```php
$api = new IpsApi();
$from_user_id = 1;
$to_user_id = 1;

$api->system()->messages()->withSender($from_user_id)->create($to_user_id, 'Message title', 'Message body');
```

### Sending message to topic

[Method documentation](https://invisioncommunity.com/developers/rest-api?endpoint=forums/posts/POSTindex)

Basic usage:
```php
$api = new IpsApi();
$topic_id = 1;

$api->forums()->posts()->create($topic_id, '<p>Message HTML body</p>');
```

By default, message is sent from default user from config file.
If you want to send message from another user, you can set user id with
`withAuthor(int $author, ?string $author_name = null)` method.

If author ID is equal 0, author name is required.
```php
$api = new IpsApi();
$from_user_id = 1;
$topic_id = 1;

$api->forums()->posts()
        ->withAuthor($from_user_id) // or ->withAuthor(0, 'Somename')
        ->create($to_user_id, 'Message title', 'Message body');
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email chaker@ova.in.ua instead of using the issue tracker.

## Credits

-   [Danylo Kolodiy](https://github.com/ova-studio)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
