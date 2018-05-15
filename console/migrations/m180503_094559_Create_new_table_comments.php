<?php

use yii\db\Migration;

/**
 * Class m180503_094559_Create_new_table_comments
 */
class m180503_094559_Create_new_table_comments extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'text' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('comment');
    }
}
