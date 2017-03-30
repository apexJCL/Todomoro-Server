<?php

use yii\db\Migration;

class m170330_182110_add_column_to_task extends Migration
{
    public function up()
    {
        $this->addColumn('task', 'done', 'boolean');
    }

    public function down()
    {
        $this->dropColumn('task', 'done');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
