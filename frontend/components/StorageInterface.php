<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17.12.17
 * Time: 20:51
 */

namespace frontend\components;


use yii\web\UploadedFile;

interface StorageInterface
{
    public function saveUploadedFile(UploadedFile $file);

    public function getFile(string $filename);
}