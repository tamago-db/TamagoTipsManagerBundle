# TamagoTipsManagerBundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a4467ecd-4467-4551-bb58-7486d298d316/big.png)](https://insight.sensiolabs.com/projects/a4467ecd-4467-4551-bb58-7486d298d316)

## **Installation**

Add the bundle to your `composer.json` file:

```php
require: {
    // ...
    "tamago/tips-manager-bundle": "dev-master"
}
```

Or install directly through composer with:

```
# Latest stable
composer require tamago/tips-manager-bundle dev-master
```

Then run a composer update:

```
composer update
# OR
composer update tamago/tips-manager-bundle # to only update the bundle
```

Register the bundles with your kernel:

```php
// in AppKernel::registerBundles()

$bundles = array(
    // ...
    new Tamago\TipsManagerBundle\TamagoTipsManagerBundle(),
    new Lexik\Bundle\TranslationBundle\LexikTranslationBundle(), //if you don't have this installed already
    // ...
);
```

## **Integration**

#### Download the hinclude.js (from [hinclude.js](http://mnot.github.io/hinclude/))

Save it under 'web' directory of your application
Then include it in the required html view:

```html
<html>
    <head>
        <title>...</title>
        // ...
        <script src="/hinclude.js" type="text/javascript"></script>
        // ...
```

Add render_hinclude to the pages you want the tips to show up:

```html
{{ render_hinclude(controller('TamagoTipsManagerBundle:TipsManager:index')) }}
```

OR

Refer to the Symfony documentation about hinclude [here](http://symfony.com/doc/current/book/templating.html#asynchronous-content-with-hinclude-js)

#### Routing

To use the tamago based admin pages, add this to routing file of your application:

```yml
# app/config/routing.yml
tip_bundle_homepage:
    resource: "@TamagoTipsManagerBundle/Resources/config/routing.yml"
    prefix:   /tamago
```

The stats page will be available here:

* `/tamago/tip/stats`

The page to edit/add tips will be available here:

* `/tamago/tip/editor`

___________________


