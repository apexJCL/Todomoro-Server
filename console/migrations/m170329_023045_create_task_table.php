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
            'pomodoro_cycles' => $this->integer()->check('pomodoro_cycles >= 0'),
            'due_date' => 'timestamptz',
            'created_at' => 'timestamptz'
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
