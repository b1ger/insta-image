<?php

namespace common\components;


use Yii;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Storage extends Component implements StorageInterface
{
    public $fileName;

    /**
     * Save given UploadFile instance to disk.
     * @param UploadedFile $file
     * @return mixed
     */
    public function saveUploadedFile(UploadedFile $file)
    {
        $path = $this->preparePath($file);

        if ($path && $file->saveAs($path)) {
            return $this->fileName;
        }

        return false;
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getFile(string $filename)
    {
        return Yii::$app->params['storageUri'] . $filename;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function getFileName(UploadedFile $file)
    {
        $hash = sha1($file->tempName);

        $name = substr_replace($hash, '/', 2, 0);
        $name = substr_replace($name, '/', 5, 0);

        return $name . '.' . $file->extension;
    }

    /**
     * @return bool|string
     */
    public function getStoragePath()
    {
        return Yii::getAlias(Yii::$app->params['storagePath']);
    }

    /**
     * Prepare path to save uploaded file.
     * @param UploadedFile $file
     * @return string
     */
    public function preparePath(UploadedFile $file)
    {
        $this->fileName = $this->getFileName($file);

        $path = $this->getStoragePath() . $this->fileName;

        $path = FileHelper::normalizePath($path);
        if (FileHelper::createDirectory(dirname($path))) {
            return $path;
        }
    }

    /**
     * @param string $filename
     * @return bool
     */
    public function deletePicture(string $filename)
    {
        $file = $this->getStoragePath() . $filename;
        $dir = mb_substr($filename, 0, mb_strpos($filename, '/'));
        $dir = $this->getStoragePath() . $dir;
        if (file_exists($file)) {
            unlink($file);
            $this->dirDel($dir);
        }

        return true;
    }

    public function dirDel($dir)
    {
        $d = opendir($dir);

        while(($entry = readdir($d)) !== false) {
            if ($entry != "." && $entry != "..") {
                if (is_dir($dir. "/" .$entry)) {
                    $this->dirDel($dir."/".$entry);
                } else {
                    unlink ($dir."/".$entry);
                }
            }
        }

        closedir($d);
        rmdir($dir);
    }
}