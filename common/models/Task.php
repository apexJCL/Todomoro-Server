<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $pomodoro_cycles
 * @property integer $due_date
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $done
 *
 * @property User $user
 */
class Task extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    public static function createFor($user_id, $t)
    {
        $task = new self();
        $task->user_id = $user_id;
        $task->title = $t->title;
        $task->description = $t->description;
        $task->due_date = $t->due_date;
        $task->pomodoro_cycles = $t->pomodoro_cycles;
        $task->done = $t->done;
        $task->save();
        return self::findOne(['id' => $task->primaryKey]);
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ]
            ]
        ];
    }


    /**
     * @inheritdoc
     */
    public
    function rules()
    {
        return [
            [['user_id', 'title', 'due_date'], 'required'],
            [['user_id', 'pomodoro_cycles', 'created_at', 'updated_at'], 'integer'],
            [['due_date', 'created_at'], 'safe'],
            [['done'], 'boolean'],
            [['title'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 500],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public
    function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'description' => 'Description',
            'due_date' => 'Due Date',
            'pomodoro_cycles' => 'Pomodoro Cycles',
            'created_at' => 'Created At',
            'done' => 'Done',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public
    function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
