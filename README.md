# Zing-Finder

Zing Finder is a component of the Zing Framework(under development) which provides a fluent api for performing operations on files and directories.

## Installation

Zing Finder can be downloaaded into a project by cloning the repo ```norris1z/Zing-Finder``` or by
installing this package through Composer. Run this command from the Terminal to install the package through composer:

```bash
composer require norris1z/zing_finder
```

### Usage

```php
<?php

require 'vendor/autoload.php';
use Zing\Finder\Exceptions\DirectoryException;
use Zing\Finder\Finder;

try {

   //Path to the directory can be passed through the constructor or the setDirectory method.
    $file = new Finder('foo/bar/dir');
    
    //setting path to the directory through setDirectory
    $file->setDirectory('foo/bar/dir');
    
    // this scans through a directory 
    // it accepts a boolean parameter which is set to false by default
    // to scan through the directory and subdirectories in the directory set parameter to true
    var_dump($find->search()); // prints all files in the directory 
    var_dump($find->search(true)); //prints files in both directories and subdirectories 
    
    // finds and displays files in a directory given an extentsion 
    var_dump($find->findFilesWithExtension('extension')->show());
    
    //includes sub-directories
     var_dump($find->findFilesWithExtension('extension',true)->show());
    
    // finds and deletes files in a directory given an extentsion 
     $find->findFilesWithExtension('extension')->delete();
     
     //includes sub-directories
     $find->findFilesWithExtension('extension',true)->delete();
    
    // finds and copies files in a directory given an extentsion to another directory 
    $find->findFilesWithExtension('extension')->copy('foo/bar/dir');
    
    //includes sub-directories
     $find->findFilesWithExtension('extension',true)->copy('foo/bar/dir');
    
    //finds zip files in a given directory and extracts them to a given folder
    $find->findFilesWithExtension('zip')->extractTo('foo/bar/dir');
    
     //includes sub-directories
     $find->findFilesWithExtension('zip',true)->extractTo('foo/bar/dir');
    
}catch (DirectoryException $e){
    echo $e->getMessage();
}

```
