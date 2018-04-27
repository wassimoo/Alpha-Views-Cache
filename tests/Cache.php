<?php

/**
 * Alpha View Cache
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
 * @return ViewCache instance or null
 */
function create_cache_instance(){
    $cache = null;
    try{
        /** example : every user had his own cache file */
        $cache = new ViewCache("wassimoo", __DIR__ . "/../cache/", ".cache");
    }catch(\Exception $ex){
        echo $ex->getMessage();
    }
    return $cache;
}


function retrieve_cache_succefully(ViewCache $cache){
    echo $cache->retrieve("css");
}

function register_cache_succefully(ViewCache $cache){
    $cache->cache("script","Script the World !");
    $cache->cache("css","CSS the world ! ");
}


$cache = create_cache_instance();
register_cache_succefully($cache);
retrieve_cache_succefully($cache);
