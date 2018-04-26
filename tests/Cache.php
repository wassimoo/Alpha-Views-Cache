<?php

/**
 * Alpha View Cache
 * API Documentation: https://github.com/wassimoo/alpha-view-cache
 * 
 * @author Wassim Bougarfa
 * @since 24.04.2018
 * @copyright Alpha-Soltions
 * @version 0.1
 * @license BSD http://www.opensource.org/licenses/bsd-license.php
 */

 use AlphaViewCache\ViewCache;

 require __DIR__ . "/../src/ViewCache.php";

try{
    $cache = new ViewCache(__DIR__ . "/../cache/", ".twig");
    $cache->cache("head","Hello World !");
    echo $cache->retrieve("head");
}catch(\Exception $ex){
    echo $ex->getMessage();
}