<?php

use yii\db\Migration;

/**
 * Class m180514_104204_Edit_table_user
 */
class m180514_104204_Edit_table_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('{{%user}}', 'username');
        $this->addColumn('{{%user}}', 'first_name', $this->string());
        $this->addColumn('{{%user}}', 'last_name', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'first_name');
        $this->dropColumn('{{%user}}', 'last_name');
        $this->addColumn('{{%user}}', 'username', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180514_104204_Edit_table_user cannot be reverted.\n";

        return false;
    }
    */
}
