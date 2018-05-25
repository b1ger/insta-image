<?php

namespace frontend\modules\post\models\forms;

use frontend\models\Comment;
use yii\base\Model;

class CommentForm extends Model
{
    public $user_id;
    public $text;
    public $created_at;
    public $updated_at;
    public $post_id;

    public function rules()
    {
        return [
            [['text', 'user_id', 'post_id'], 'required'],
            [['user_id'], 'integer'],
            [['text'], 'string'],
            [['post_id'], 'integer'],
            [['text'], 'string', 'max' => 1000],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '',
            'post_id' => '',
            'text' => '',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function save()
    {
        $comment = new Comment();
        $comment->post_id = $this->post_id;
        $comment->user_id = $this->user_id;
        $comment->text = $this->text;
        $comment->created_at = time();
        $comment->updated_at = $comment->created_at;

        if ($comment->save(false)) {
            return true;
        }

        return false;
    }
}