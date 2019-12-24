FormLayerBundle
==============
General:
[![Build Status](https://travis-ci.com/pfilsx/FormLayerBundle.svg?branch=master)](https://travis-ci.com/pfilsx/FormLayerBundle)
[![Latest Stable Version](https://poser.pugx.org/pfilsx/form-layer-bundle/v/stable)](https://packagist.org/packages/pfilsx/form-layer-bundle)
[![License](https://poser.pugx.org/pfilsx/form-layer-bundle/license)](https://packagist.org/packages/pfilsx/form-layer-bundle)

Quality:
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pfilsx/FormLayerBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pfilsx/FormLayerBundle/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/pfilsx/FormLayerBundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/pfilsx/FormLayerBundle/build-status/master)
[![Coverage Status](https://coveralls.io/repos/github/pfilsx/FormLayerBundle/badge.svg?branch=master)](https://coveralls.io/github/pfilsx/FormLayerBundle?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/pfilsx/FormLayerBundle/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

Numbers:
[![Total Downloads](https://poser.pugx.org/pfilsx/form-layer-bundle/downloads)](https://packagist.org/packages/pfilsx/form-layer-bundle)
[![Monthly Downloads](https://poser.pugx.org/pfilsx/form-layer-bundle/d/monthly)](https://packagist.org/packages/pfilsx/form-layer-bundle)
[![Daily Downloads](https://poser.pugx.org/pfilsx/form-layer-bundle/d/daily)](https://packagist.org/packages/pfilsx/form-layer-bundle)



Introduction
------------

The bundle provides additional functional to follow rule "An entity should be always valid" with forms validation for your Symfony project.

Features
--------
* Special layer between your entities and forms
* Maker for FormLayer classes
* Easy to use
* Easy to extend
* Documented (in [Resources/doc](https://github.com/pfilsx/FormLayerBundle/blob/master/src/Resources/doc/index.rst))

Requirement
-----------
* PHP 7.1+
* Symfony >= 3.4

Installation
------------

Via bash:
```bash
$ composer require pfilsx/form-layer-bundle
```
Via composer.json:

You need to add the following lines in your deps :
```json
{
    "require": {
        "pfilsx/form-layer-bundle": "*"
    }
}
```

For non symfony-flex apps dont forget to add bundle:
``` php
$bundles = array(
    ...
    new Pfilsx\FormLayer\FormLayerBundle(),
);
```

Documentation
-------------

Please, read the [docs](https://github.com/pfilsx/FormLayerBundle/tree/master/src/Resources/doc).

License
-------

This bundle is released under the MIT license.

Contribute
----------

If you'd like to contribute, feel free to propose a pull request! Or just contact me :) 
