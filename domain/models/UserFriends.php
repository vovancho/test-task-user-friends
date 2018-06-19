<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 19.06.2018
 * Time: 11:32
 */

namespace app\domain\models;


use yii\db\ActiveRecord;

class UserFriends extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%users_friends}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'friend_id'], 'integer'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id'])->from(['user' => User::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFriend()
    {
        return $this->hasOne(User::class, ['user_id' => 'friend_id'])->from(['friend' => User::tableName()]);
    }
}