<?php

namespace frontend\models\events;

use yii\base\Event;
use frontend\models\User;
use frontend\models\Post;

class PostCreatedEvent extends Event
{
    /**
     * @var $user User
     */
    public $user;

    /**
     * @var $post Post
     */
    public $post;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }
}