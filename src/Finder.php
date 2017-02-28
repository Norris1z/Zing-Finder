<?php

namespace Zing\Finder;

use Zing\Finder\Exceptions\DirectoryException;

class Finder
{
    /**
     * @var null
     */
    protected $dir;
    /**
     * @var array
     */
    protected $subDirs = array();
    /**
     * @var
     */
    protected $subDirFiles;

    /**
     * @var array
     */
    protected $filesWithExtensions = array();

    /**
     * Finder constructor.
     * @param null $dir
     */
    public function __construct($dir = NULL)
    {
        $this->dir = $dir;
    }

    /**
     * @param null $dir
     * @return null
     */
    public function setDirectory($dir = NULL)
    {
        return $this->dir = $dir;
    }

    /**
     * @param $dir
     * @return $this
     * @throws DirectoryException
     */
    private function validateDirectory($dir)
    {
        if ( ! is_dir($dir) ) {
            throw new DirectoryException("Directory ".$dir." does not exist");
        }
        return $this;
    }

    /**
     * @param $containsSubDir
     * @return array
     */
    public function search($containsSubDir = false)
    {
        if ($containsSubDir) {
            return $this->validateDirectory($this->dir)
                ->containsSubDirectory($this->performOperation($this->dir,true));
        }
        return $this->validateDirectory($this->dir)
            ->performOperation($this->dir);
    }

    /**
     * @param $dir
     * @return array
     */
    private function performOperation($dir,$withDir=false)
    {
        $files = scandir($dir);
//        array_shift($files);
//        array_shift($files);
        if($withDir){
            return $files;
        }
        return $this->excludeFilesWithoutExtensions($files);
    }

    /**
     * @param $files
     * @return array
     */
    private function excludeFilesWithoutExtensions($files)
    {
        $validFiles = array();
        foreach ($files as $file){
            if((pathinfo($file,PATHINFO_EXTENSION))!=""){
                $validFiles [] = $file;
            }
        }
        return $validFiles;
    }
    /**
     * @param $files
     * @return array
     */
    private function containsSubDirectory($files)
    {
        foreach ($files as $file) {
            if ( is_dir($this->dir.'/'.$file) ){
                $this->handleSubDirectoryLogic($file);
                $key = array_search($file,$files);
                unset($files[$key]);
            }
        }
        return array_merge($this->subDirs,$files);
    }

    /**
     * @param $file
     */
    private function handleSubDirectoryLogic($file)
    {
        $this->subDirFiles = $this->performOperation($this->dir.'/'.$file);
        $this->subDirs[$file]= $this->subDirFiles;
    }

    /**
     * @param $extension
     * @param $multiDir
     * @return $this
     */
    public function findFilesWithExtension($extension, $multiDir= false)
    {
        foreach ($this->search($multiDir) as $file) {
            if( is_array($file) ){
                foreach ($file as $single) {
                    if(is_array($single)){
                        continue;
                    }
                    $this->checkForFileType($single,$extension);
                }
                continue;
            }
            $this->checkForFileType($file,$extension);
        }
        return $this;
    }

    /**
     * @param $file
     * @param $extension
     * @return mixed
     */
    private function checkForFileType($file, $extension)
    {
        if($extension == pathinfo($file,PATHINFO_EXTENSION)) {
            return $this->filesWithExtensions[] = $file;
        }
    }

    /**
     * @param $dir
     * @return string
     */
    public function extractTo($dir)
    {
        foreach ($this->filesWithExtensions as $file ){
            $zip = new \ZipArchive();
            $zip->open($this->dir.'\\'.$file);
            $zip->extractTo($dir);
            $zip->close();
        }
        return "All files Unzipped";
    }

    /**
     * @param $dir
     * @return string
     */
    public function copy($dir)
    {
        foreach ($this->filesWithExtensions as $file){
            copy($this->dir.'\\'.$file,$dir.'\\'.$file);
        }
        return "Files Copied";
    }

    /**
     * @return string
     */
    public function delete()
    {
        foreach ($this->filesWithExtensions as $file){
            unlink($this->dir.'\\'.$file);
        }
        return "All files Deleted";
    }

    /**
     * @return array
     */
    public function show()
    {
        return $this->filesWithExtensions;
    }
}