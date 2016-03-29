# Overview

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a4467ecd-4467-4551-bb58-7486d298d316/big.png)](https://insight.sensiolabs.com/projects/a4467ecd-4467-4551-bb58-7486d298d316)

This Symfony bundle allows to integrate a Tip Manager in your Symfony application.
The Tip Manager shows you tips relevant to your application. The tips can be seen in different languages.

The idea is to:
* write tips and their translations in files (yml) for at least one language (the default language of your website for example).
* load tips and their translations into the database by using command line.
* freely edit/add translation through an edition page.

You can also provide feedback for a tip through like/dislike buttons.
The feedback and other details related to the tips can be viewed on a stats page.

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

#### Creating the database schema

```html
php app/console doctrine:database:create
php app/console doctrine:schema:update
```

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

Render in the pages where you want the tips to show up:

```html
{{ render(controller('TamagoTipsManagerBundle:TipsManager:index', {'domain': 'some-domain-name'})) }}
```
The value of 'domain' attribute in above should be the name of the domain which the tips belong to.
You can split tips into multiple categories/domains.

OR

Refer to the Symfony documentation about hinclude [here](http://symfony.com/doc/current/book/templating.html#asynchronous-content-with-hinclude-js)

## **Import translations**

To import translations files content into your database, place tip translation YAML files somewhere in your project
and import from the directory.  For example:

```html
php app/console lexik:translations:import -p app/Resources/translations/tips/
```

See [tips-example.en.yml](Resources/translations/tips/tips-example.en.yml) for an example of a simple translation file.

#### Routing

To use the tamago based admin pages, add this to routing file of your application:

```yml
# app/config/routing.yml
tip_bundle_homepage:
    resource: "@TamagoTipsManagerBundle/Resources/config/routing.yml"
    prefix:   /_tips
```

The stats page will be available here:

* `/_tips/stats`

A screenshot of the stats page:
![stats page screen](https://github.com/tamago-db/TamagoTipsManagerBundle/blob/master/Resources/doc/StatsScreen.JPG)

________________________________

The page to edit/add tips will be available here:

* `/_tips/editor`

A screenshot of the edition page:
![edition page screen](https://github.com/tamago-db/TamagoTipsManagerBundle/blob/master/Resources/doc/TranslationsScreen.JPG)

________________________________
