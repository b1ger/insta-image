<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $username
 * @property integer $post_id
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 */
class Comment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{comment}}';
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->updated_at, 'long');
    }
}
