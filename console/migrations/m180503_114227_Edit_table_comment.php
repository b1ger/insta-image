<?php

use yii\db\Migration;

/**
 * Class m180503_114227_Edit_table_comment
 */
class m180503_114227_Edit_table_comment extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('comment', 'username');
        $this->addColumn('comment', 'user_id', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('comment', 'user_id');
        $this->addColumn('comment', 'username', $this->string());
    }
}
