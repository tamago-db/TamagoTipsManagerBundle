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

Register the bundle with your kernel:

```php
// in AppKernel::registerBundles()

$bundles = array(
    // ...
    new Tamago\TipsManagerBundle\TamagoTipsManagerBundle(),
    // ...
);
```

@todo What about registering Lexik?  Remember that some users may already have it installed.

## **Integration**

#### Download the hinclude.js

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

@todo Would it make sense to reference the Symfony documentation about hinclude?

Add render_hinclude to the pages you want the tips to show up:

```html
{{ render_hinclude(controller('TamagoTipsManagerBundle:TipsManager:index')) }}
```

#### Routing

To use the lexik based admin pages, add the routing file to your application:

```yml
# app/config/routing.yml
lexik_translation_edition:
    resource: "@LexikTranslationBundle/Resources/config/routing.yml"
    prefix:   /my-prefix
```

@todo We should specify a better prefix

The translations edition page will be available here:

* `/my-prefix/grid` for the translations grid

___________________


