<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_app".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $firebase_token
 * @property integer $last_synced
 *
 * @property User $user
 */
class UserApp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_app';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'last_synced'], 'integer'],
            [['firebase_token'], 'string', 'max' => 1024],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'firebase_token' => 'Firebase Token',
            'last_synced' => 'Last Synced',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
