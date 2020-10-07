# Raisely Webhooks for Craft CMS 3.x


## Requirements

This plugin requires Craft CMS 3.0.0. or later.

## Configuration

Create a `raisely-webhooks.php` config file with the following contents, or copy the one from the root of this plugin.
Then add the following constant to the `.env` file.

- RAISELY_SECRET

```php
return [
    /*
     * Raisely's  Secret
     */
    'signingSecret' => getenv('RAISELY_SECRET'),

    /*
     * The url of the endpoint you would like to use
     */
    'endpoint' => 'raisely-webhooks',
];
```

Brought to you by [Daniel G Adarve](mailto:dgonzalezad@gmail.com)
