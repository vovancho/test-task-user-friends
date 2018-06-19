<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 19.06.2018
 * Time: 12:02
 */

namespace app\domain\repositories;


use app\domain\models\User;
use yii\db\Expression;
use yii\db\Query;

class UserRepository
{
    public function getUser(int $id): User
    {
        if (!$user = User::findOne($id)) {
            throw new \DomainException('User not found');
        }

        return $user;
    }

    public function getFriendsRecommendation(User $user, int $limit): array
    {
        return (new Query())
            ->select([
                'id',
                'friendsOfFriends.user_id AS recommend_id',
                new Expression('count(friendsOfFriends.user_id) AS rate'),
            ])
            ->from('{{%users}}')
            ->leftJoin('{{%users_friends}} friendsByUser', '`users`.`id` = `friendsByUser`.`friend_id`')
            ->leftJoin('{{%users_friends}} friendsOfFriends', '`friendsByUser`.`user_id` = `friendsOfFriends`.`friend_id`')
            ->andWhere(['id' => $user->primaryKey])
            ->andWhere(['not in', 'users.id', '[[friendsByUser]].[[user_id]]'])
            ->andWhere(['not in', 'friendsOfFriends.user_id', (new Query())
                ->select('friend_id')
                ->from('{{%users_friends}}')
                ->where(['user_id' => $user->primaryKey])
            ])
            ->groupBy(['id', 'friendsOfFriends.user_id'])
            ->orderBy(['rate' => SORT_DESC])
            ->limit($limit)
            ->all();
    }
}