<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 */
class m170329_023045_create_task_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(200)->notNull(),
            'description' => $this->string(500),
            'due_date' => $this->dateTime()->notNull(),
            'pomodoro_cycles' => $this->integer()->check('pomodoro_cycles >= 0'),
            'created_at' => $this->dateTime()->notNull()
        ]);
        $this->addForeignKey('task_user_fk', 'task', 'user_id', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('task');
    }
}
