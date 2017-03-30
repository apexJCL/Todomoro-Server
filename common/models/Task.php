<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property string $due_date
 * @property integer $pomodoro_cycles
 * @property string $created_at
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

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ],
                'value' => new Expression('CURRENT_TIMESTAMP')
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
            [['user_id', 'title', 'due_date', 'created_at'], 'required'],
            [['user_id', 'pomodoro_cycles'], 'integer'],
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
