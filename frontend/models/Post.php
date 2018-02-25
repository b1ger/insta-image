<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\redis\Connection;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $filename
 * @property string $description
 * @property integer $created_at
 */
class Post extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{post}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    public function getImage()
    {
        return Yii::$app->storage->getFile($this->filename);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Like current post by given user
     * @param \frontend\models\User $user
     */
    public function like(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->sadd("post:{$this->getId()}:likes", $user->getId());
        $redis->sadd("user:{$user->getId()}:likes", $this->getId());
    }

    public function unlike(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->srem("post:{$this->getId()}:likes", $user->getId());
        $redis->srem("user:{$user->getId()}:likes", $this->getId());
    }

    public function countLikes()
    {
        /* @var $redis Connection*/
        $redis = Yii::$app->redis;
        return $redis->scard("post:{$this->getId()}:likes");
    }

    public function getId()
    {
        return $this->id;
    }

    public function isLikedBy(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->getId()}:likes", $user->getId());
    }

    public function hasComments($id)
    {
        $comments = Comment::find()->where(['post_id' => $id])->all();

        if (count($comments) > 0) {
            return true;
        }

        return false;
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }
}
