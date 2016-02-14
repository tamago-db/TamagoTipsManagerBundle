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

Then install the required assets:

```
./app/console assets:install
```
