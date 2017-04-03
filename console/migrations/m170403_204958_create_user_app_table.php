<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_app`.
 */
class m170403_204958_create_user_app_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_app', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'firebase_token' => $this->string(1024),
            'last_synced' => $this->bigInteger()
        ]);
        $this->addForeignKey('user_app_user_fk', 'user_app', 'user_id', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_app');
    }
}
