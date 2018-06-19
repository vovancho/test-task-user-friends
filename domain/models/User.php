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
        return $this->hasOne(UserFriends::class, ['friend_id' => 'id'])
            ->from(['friendsByUser' => UserFriends::tableName()]);
    }
}
