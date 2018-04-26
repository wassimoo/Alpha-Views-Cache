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

namespace AlphaViewCache;

require_once "Cache.php";

class ViewCache
{
    /**
     * @var Cache instance
     */
    private $mainCache;
    /**
     * @var cached Views array viewName => hashCode
     */
    private $views;


    /**
     * ViewCache constructor.
     * @param string $folder
     * @param string $extension
     * @throws Exception
     */
    public function __construct(string $folder, string $extension)
    {
        $this->mainCache = new \Cache(
            ["name" => "view",
            "path"=> $folder,
            "extension"=> $extension]
        );

        $this->views = array();

    }


    /**
     * @param string $name
     * @param string $data
     * @param int $expiration
     * @return bool
     * @throws \Exception
     */
    public function cache(string $name, string $data, int $expiration = 0)
    {
        if(array_key_exists($name,$this->views)){
            try{
                $this->mainCache->erase($this->views[$name]);
            }catch(\Exception $e){
                //TODO : log to file .
            }
        }

        $key = $this->randHash(18);
        if($this->mainCache->store($key, $data, $expiration)){
            $this->views[$name] = $key;
            return true;
        }
        return false;
    }


    public function retrieve(string $name){
        $data = $this->mainCache->retrieve($this->views[$name]);

        if($data === null){
            //TODO: log to file
            return "";
        }

        return $data;
    }

    /**
     * @param int $len
     * @return bool|string
     */
    function randHash($len = 32)
    {
        return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
    }
}