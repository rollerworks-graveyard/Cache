<?php

/*
 * This file is part of the Rollerworks Cache Component package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rollerworks\Component\Cache\Tests;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Rollerworks\Component\Cache\SessionCache;

class SessionCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Session
     */
    protected $session;

    public function testSetFetch()
    {
        $cache = new SessionCache($this->session);

        $cache->save('foo', 'bar');
        $this->assertTrue($cache->contains('foo'));
        $this->assertEquals('bar', $cache->fetch('foo'));

        $cache->save('foo2', 'bar2');
        $this->assertTrue($cache->contains('foo2'));
        $this->assertEquals('bar2', $cache->fetch('foo2'));
    }

    public function testRemove()
    {
        $cache = new SessionCache($this->session);

        $cache->save('foo', 'bar');

        $this->assertTrue($cache->contains('foo'));
        $this->assertTrue($cache->delete('bar'));
        $this->assertTrue($cache->contains('foo'));
        $this->assertTrue($cache->delete('foo'));
        $this->assertFalse($cache->contains('foo'));
    }

    public function testFlush()
    {
        $cache = new SessionCache($this->session);

        $cache->save('foo', 'bar');
        $cache->save('foo2', 'bar2');

        $this->assertTrue($cache->contains('foo'));
        $this->assertTrue($cache->contains('foo2'));
        $this->assertTrue($cache->flushAll());

        $this->assertFalse($cache->contains('foo'));
        $this->assertFalse($cache->contains('foo2'));
    }

    public function testExpires()
    {
        $cache = new SessionCache($this->session);

        $cache->save('foo', 'bar', 2);
        $this->assertTrue($cache->contains('foo'));

        sleep(3);

        // This should return false as the cache is expired
        $this->assertFalse($cache->contains('foo'));
        $this->assertFalse($cache->fetch('foo'));
    }

    protected function setUp()
    {
        $storage = new MockArraySessionStorage();
        $this->session = new Session($storage);
    }
}
