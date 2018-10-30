# StatusPage Card for Laravel Nova
Laravel Nova StatusPage Card

![Card Demo](https://res.cloudinary.com/davidpiesse/image/upload/v1535394526/Screen_Shot_2018-08-26_at_23.27.32_zmjpoz.png)

It displays the company, current overall status with a colored icon, and a description of any issues a company might be having. Click on the card to go to the compaines Status Page (new tab).

## Installation

Just like most other packages - composer!

```
composer require davidpiesse/nova-statuspage
```

## Usage

Add the card to your NovaServiceProvider.php

```php
protected function cards()
{
    return [
        (new StatusPage())->page('cloudflare'),
        ...
    ];
}
```

### Page Prop
This is where you set the StatusPage customer you are interested in. 
This can be one of two options:
* The name of the provider. We currently allow for
    * cloudflare
    * dropbox
    * newrelic
    * travisci
    * twilio
* The StatusPage ID for a customer; such as *yh6f0r4529hb*

