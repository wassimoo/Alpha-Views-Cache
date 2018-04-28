<?php

/**
 * Alpha Views Cache
 * API Documentation: https://github.com/wassimoo/alpha-view-cache
 *
 * @author Wassim Bougarfa
 * @since 24.04.2018
 * @copyright Alpha-Solutions
 * @version 0.1
 * @license BSD http://www.opensource.org/licenses/bsd-license.php
 */

use AlphaViewCache\ViewCache;

require __DIR__ . "/../src/ViewCache.php";

/**
 * Example : every user has his own cache file and though his own views
 * @return ViewCache instance or null
 */
function create_cache_instance($user)
{
    $cache = null;
    try {
        $cache = new ViewCache($user, __DIR__ . "/../cache/", ".cache");
    } catch (\Exception $ex) {
        echo $ex->getMessage();
    }
    return $cache;
}


function register_cache_succefully(ViewCache $cache, $fingerPrint)
{
    $cache->cache("head", "$fingerPrint on top of  the World !");
    $cache->cache("footer", "$fingerPrint in the bottom of the world ! ");
}

$cache = create_cache_instance("wassim");
register_cache_succefully($cache, " Alpha");

$cache2 = create_cache_instance("waelo");
register_cache_succefully($cache2, " Beta");

echo $cache->retrieve("head") . "<br>"; // will load view associated to user (Alpha)
echo $cache2->retrieve("footer") . "<br>"; // same but for (Beta)