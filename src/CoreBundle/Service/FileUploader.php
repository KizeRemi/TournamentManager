<?php

namespace CoreBundle\Service;

use Symfony\Component\HttpFoundation\File\File;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload($name, File $file)
    {
        $fileName = $name."_".md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->targetDir, $fileName);

        return $fileName;
    }
}