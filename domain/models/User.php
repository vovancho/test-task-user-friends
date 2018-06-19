<?php

namespace app\domain\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%users}}';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['name', 'password'], 'string', 'max' => 191],
            [['email'], 'unique'],
            [['email'], 'email'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'E-Mail',
            'create_at' => 'Дата создания',
            'update_at' => 'Дата обновления',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFriendsByUser()
    {
        return $this->hasOne(UserFriends::class, ['user_id' => 'user_id'])->from(['friendsByUser' => UserFriends::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersByFriends()
    {
        return $this->hasOne(UserFriends::class, ['user_id' => 'friend_id'])->from(['userByFriends' => UserFriends::tableName()]);
    }
}
