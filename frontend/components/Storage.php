<?php

namespace frontend\components;


use Yii;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use Intervention\Image\ImageManager;

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
            //$this->checkSize($path);
            return $this->fileName;
        }
    }

    /**
     * Resize image if needed
     */
    public function checkSize($path)
    {
        $imageManager = new ImageManager(['driver' => 'imagick']);
        $image = $imageManager->make($path);

        $width = Yii::$app->params['profilePicture']['maxWidth'];
        $height = Yii::$app->params['profilePicture']['maxHeight'];

        if ($image->getHeight() > $height || $image->getWidth() > $width) {
            // 3-й аргумент - органичения - специальные настройки при изменении размера
            $image->resize($width, $height, function ($constraint) {

                // Пропорции изображений оставлять такими же (например, для избежания широких или вытянутых лиц)
                $constraint->aspectRatio();

                // Изображения, размером меньше заданных $width, $height не будут изменены:
                $constraint->upsize();

            })->save($path);
        }
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