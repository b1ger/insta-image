<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

/* @property UploadedFile $picture */

class PictureUpload extends Model
{
    public $picture;

    public function rules()
    {
        return [
            [['picture'], 'file', 'extensions' => 'jpg,png'],
        ];
    }
    /**
     * @param UploadedFile $file
     * @param $currentImage
     * @return string
     */
    public function uploadFile(UploadedFile $file, $currentImage)
    {
        $this->picture = $file;
        if ($this->validate()) {
            $this->deleteCurrentPicture($currentImage);
            return $this->savePicture();
        }
    }
    /**
     * @return string
     */
    private function getFolder()
    {
        return Yii::getAlias('@web') . 'uploads/';
    }
    /**
     * @return string
     */
    private function generateFilename()
    {
        return strtolower(md5(uniqid($this->picture->baseName)). '.' . $this->picture->extension);
    }
    /**
     * @param $currentPicture
     */
    public function deleteCurrentPicture($currentPicture)
    {
        if ($this->pictureExist($currentPicture))  {
            unlink($this->getFolder() . $currentPicture);
        }
    }
    /**
     * @param $currentPicture
     * @return bool
     */
    public function pictureExist($currentPicture)
    {
        if (!empty($currentPicture) && $currentPicture != null) {
            return file_exists($this->getFolder() . $currentPicture);
        }
    }
    /**
     * @return string
     */
    private function savePicture()
    {
        $filename = $this->generateFilename();
        $this->picture->saveAs($this->getFolder() . $filename);
        return $filename;
    }
}