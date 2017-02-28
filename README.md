# Zing-Finder

Zing Finder is a component of the Zing Framework(under development) which provides a fluent api for performing operations on files and directories.

## Installation

Zing Finder can be downloaaded into a project by cloning the repo ```norris1z/Zing-Finder``` or by
installing this package through Composer. Run this command from the Terminal to install the package through composer:

```bash
composer require norris1z/Zing-Finder
```

### Usage

```php
<?php

require 'vendor/autoload.php';
use Zing\Finder\Exceptions\DirectoryException;
use Zing\Finder\Finder;

try {
    // this setsup the directory foo/bar/dir
    $find = new Finder('foo/bar/dir');
    
    // this scans through a directory 
    // it accepts a boolean parameter which is set to false by default
    // to scan through the directory and subdirectories in the directory set parameter to true
    $find->search(); //searches through a directory 
    $find->search(true); //searches both directories and subdirectories 
    
    // finds and displays files in a directory given an extentsion 
    $find->findFilesWithExtension('extension')->show();
    
    //includes sub-directories
     $find->findFilesWithExtension('extension',true)->show();
    
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
