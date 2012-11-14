Cache Component
===============

The Rollerworks Cache component provides a Session based cache-driver
for Doctrine Common. (Cache data is stored in a session).

Installation
------------

This Component uses Composer to manage its dependencies.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then just add the following to your
`composer.json` file:

```js
// composer.json
{
    // ...
    require: {
        // ...
        "rollerworks/cache": "master-dev"
    }
}
```

**NOTE**: Please replace `master-dev` in the snippet above with the latest stable
branch, for example ``1.0.*``.

Then, you can install the new dependencies by running Composer's ``update``
command from the directory where your ``composer.json`` file is located:

```bash
$ php composer.phar update rollerworks/cache
```

Now, Composer will automatically download all required files, and install them
for you.

That's it! You can now use the Rollerworks Cache Component.

Usage
-----

This component depends on the Symfony HttpFoundation Component and Doctrine Common.
Usage is very simple.

```php

use Symfony\Component\HttpFoundation\Session\Session;
use Rollerworks\Component\Cache\SessionCache;

$session = new Session();
$session->start();

// ... 

// The first paramater of the SessionCache must be a `Symfony\Component\HttpFoundation\Session\Session` object.
// The second is an optional session bag name, the default is 'cache'.
$sessionCacheDriver = new SessionCache($session, 'my_cache');

// Now you can use the $sessionCacheDriver object for any Doctrine Caching.
// See the resources below for more information.
```

Resources
---------

Doctrine Caching <http://docs.doctrine-project.org/en/2.0.x/reference/caching.html>

This Component is released under MIT license.

You can run the unit tests with the following command:

    phpunit
