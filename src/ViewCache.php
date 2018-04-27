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

namespace AlphaViewCache;

require_once "Cache.php";

class ViewCache
{
    /**
     * @var Cache instance
     */
    private $mainCache;

    /**
     * @var array viewName => key
     */
    private $views;


    /**
     * @var string folder path
     */
    private $cacheFolder;

    /**
     * @var string path to cached views list.
     */
    private $cacheListPath;
    

    /**
     * ViewCache constructor.
     * @param string $filName CacheFileName
     * @param string $folder
     * @param string $extension
     * @throws Exception
     */
    public function __construct(string $fileName, string $folder, string $extension)
    {
        $this->mainCache = new \Cache(
            ["name" => $fileName,
            "path"=> $folder,
            "extension"=> $extension]
        );

        $this->views = [];
        $this->cacheFolder = $folder;
        $this->cacheListPath = $this->cacheFolder . "cacheList.list";

        try{
            $this->views = $this->getRenderedFileList();
        }catch(\Exception $ex){
            //create associated file .
            
            if(($file =  fopen($this->cacheListPath,"w")) == false){
                //TODO : log to file ;
           }
        }
        
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
            $this->updateRenderedFileList();
            return true;
        }
        return false;

    }

    public function changeCacheFile(string $fileName){
        $this->mainCache = $filName;
    }

    /**
     * Update cache views list. 
     * @return bool success/failure
     */
    private function updateRenderedFileList(){
        $data = json_encode($this->views);
        return file_put_contents($this->cacheListPath, $data);
    }

    /**
     * 
     * @throws \Exception
     * @return array rendered views list name => key
     */
    private function getRenderedFileList(){
        $data = file_get_contents($this->cacheListPath);
        if($data === false)
            throw new \Exception("Can't read file ");
        return json_decode($data,true);
    }
    
    /**
     * @var string $name viewName
     * @return string $data
     * @throws \Exception
     */
    public function retrieve(string $name){
        $data = $this->mainCache->retrieve($this->views[$name]);

        if($data === null){
            //TODO: log to file
           throw new \Exception("undefined view name");
           
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