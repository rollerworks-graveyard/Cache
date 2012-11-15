<?php

/**
 * This file is part of the Rollerworks Cache Component.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rollerworks\Component\Cache;

use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Cache\CacheProvider;

/**
 * Doctrine Session Cache-driver.
 *
 * Stores caching data in a Symfony Session.
 *
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
class SessionCache extends CacheProvider
{
    protected $session;
    protected $bagName;

    /**
     * Constructor.
     *
     * @param Session              $session
     * @param string               $storageKey
     * @param SessionCacheBag|null $bag
     */
    public function __construct(Session $session, $storageKey = '_rollerworks_cache', SessionCacheBag $bag = null)
    {
        if (!$bag) {
            $bag = new SessionCacheBag($storageKey);
            $session->registerBag($bag);
        }

        $this->bagName = $bag->getName();
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetch($id)
    {
        return $this->session->getBag($this->bagName)->get($id, false);
    }

    /**
     * {@inheritdoc}
     */
    protected function doContains($id)
    {
        return $this->session->getBag($this->bagName)->has($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        $this->session->getBag($this->bagName)->set($id, $data, $lifeTime);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function doDelete($id)
    {
        $this->session->getBag($this->bagName)->remove($id);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function doFlush()
    {
        $this->session->getBag($this->bagName)->clear();

        return true;
    }

     /**
     * {@inheritdoc}
     */
    protected function doGetStats()
    {
        return null;
    }
}
