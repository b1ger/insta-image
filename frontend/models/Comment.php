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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'username', 'post_id'], 'required'],
            [['text'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '',
            'post_id' => '',
            'text' => '',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->updated_at, 'long');
    }
}
