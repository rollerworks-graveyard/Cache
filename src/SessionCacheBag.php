<?php

/*
 * This file is part of the RollerworksCache component package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\Cache;

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;

/**
 * SessionCacheBag.
 *
 * Keeps the cached data in a session-bag.
 * And supports lifeTime for caching.
 *
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
class SessionCacheBag implements SessionBagInterface
{
    /**
     * @var string
     */
    private $name = 'cache';

    /**
     * @var string
     */
    private $storageKey;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * Constructor.
     *
     * @param string $storageKey The key used to store caches in the session
     */
    public function __construct($storageKey = '_rollerworks_cache')
    {
        $this->storageKey = $storageKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the bag.
     *
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array &$attributes)
    {
        $this->data = &$attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getStorageKey()
    {
        return $this->storageKey;
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        if (!array_key_exists($name, $this->data)) {
            return false;
        }

        if (0 === $this->data[$name]['lifeTime']) {
            return true;
        }

        return $this->data[$name]['lifeTime'] > time();
    }

    /**
     * {@inheritdoc}
     */
    public function get($name, $default = null)
    {
        if (!array_key_exists($name, $this->data)) {
            return $default;
        }

        if (0 === $this->data[$name]['lifeTime']) {
            return $this->data[$name]['data'];
        }

        return $this->data[$name]['lifeTime'] < time() ? $default : $this->data[$name]['data'];
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value, $lifeTime = 0)
    {
        if ($lifeTime > 0) {
            $lifeTime = time() + $lifeTime;
        }

        $this->data[$name] = array('data' => $value, 'lifeTime' => $lifeTime);
    }

    /**
     * Removes a cached item.
     *
     * @param string $name
     */
    public function remove($name)
    {
        if (array_key_exists($name, $this->data)) {
            unset($this->data[$name]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $return = $this->data;
        $this->data = array();

        return $return;
    }
}
