Cache Component
===============

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/3f9a632c-e024-4e9c-96fd-eb628978e08d/mini.png)](https://insight.sensiolabs.com/projects/3f9a632c-e024-4e9c-96fd-eb628978e08d)
[![Build Status](https://travis-ci.org/rollerworks/Cache.png?branch=master)](https://travis-ci.org/rollerworks/Cache)

The Rollerworks Cache component provides a Session based cache-driver
for Doctrine Common. (Cache data is stored in a session).

Installation
------------

This Component uses Composer to manage its dependencies.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then add the following to your
`composer.json` file:

```js
// composer.json
{
    // ...
    require: {
        // ...
        "rollerworks/cache": "~1.0"
    }
}
```

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

// The first parameter of the SessionCache must be a `Symfony\Component\HttpFoundation\Session\Session` object.
// The second parameter is an optional session storageKey that used for storing the session, default is '_rollerworks_cache'.
// The third parameter is an optional SessionCacheBag object

// When a SessionCacheBag is provided, it must be registered at the session by calling registerBag() on the $session object.
$sessionCacheDriver = new SessionCache($session, '_my_cache');

// Now you can use the $sessionCacheDriver object for any Doctrine Caching.
// See the resources below for more information.
```

Resources
---------

Doctrine Caching <http://docs.doctrine-project.org/en/2.0.x/reference/caching.html>

This Component is released under MIT license.

You can run the unit tests with the following command:

    phpunit
