<?php

namespace frontend\modules\post\models\forms;

use yii\base\Model;

class CommentForm extends Model
{
    public $username;
    public $text;
    public $created_at;
    public $updated_at;
    public $post_id;

    public function rules()
    {
        return [
            [['text', 'username', 'post_id'], 'required'],
            [['username'], 'string'],
            [['text'], 'string'],
            [['post_id'], 'integer'],
            [['text'], 'string', 'max' => 1000],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '',
            'post_id' => '',
            'text' => 'Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function bind()
    {
        return [
            'CommentForm' => [
                'username' => $this->username,
                'text' => $this->text,
                'created_at' => $this->created_at = time(),
                'updated_at' => $this->created_at,
                'post_id' => $this->post_id,
            ]
        ];
    }
}