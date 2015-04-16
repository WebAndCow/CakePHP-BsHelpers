BsFormHelper and BsHelper
==========================

[![Build Status](https://travis-ci.org/WebAndCow/CakePHP-BsHelpers.svg?branch=master)](https://travis-ci.org/WebAndCow/CakePHP-BsHelpers) [![Coverage Status](https://coveralls.io/repos/WebAndCow/CakePHP-BsHelpers/badge.svg?branch=master)](https://coveralls.io/r/WebAndCow/CakePHP-BsHelpers?branch=master)
 [![Packagist](https://img.shields.io/packagist/v/webandcow/bs_helpers.svg)](https://packagist.org/packages/webandcow/bs_helpers)

Extension of the CakePHP's FormHelper to use the framework Twitter Bootstrap v3.0.0 more easily.

The full documentation is available here : http://webandcow.github.io/CakePHP-BsHelpers


## Installation

Ensure require is present in composer.json. This will install the plugin into Plugin/BsHelpers:

```json
{
	"require": {
		"webandcow/bs_helpers": "*"
	}
}
```

### Enable plugin

You need to enable the plugin in your app/Config/bootstrap.php file:

`CakePlugin::load('BsHelpers');`

If you are already using `CakePlugin::loadAll();`, then this is not necessary.

Then, add those following lines in your app/Controller/AppController.php file :

```php
class AppController extends Controller {
         public $helpers = array('BsHelpers.Bs', 'BsHelpers.BsForm');
}
```

##Versioning

BsHelpers will be maintained under the Semantic Versioning guidelines as much as possible. Releases will be numbered
with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major (and resets the minor and patch)
* New features, without breaking backward compatibility bumps the minor (and resets the patch)
* Bug fixes bumps the patch

For more information on SemVer, please visit http://semver.org.

##License

BsHelpers is licensed under the MIT license.
