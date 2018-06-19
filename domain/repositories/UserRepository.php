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

class UserRepository
{
    public function getUser(int $id): User
    {
        if (!$user = User::findOne($id)) {
            throw new \DomainException('User not found');
        }

        return $user;
    }

    public function getFriendsRecommendation(User $user): array
    {
        return User::find()
            ->select([
                'id',
                'friendsByUser2.user_id AS recommend_id',
                new Expression('count(friendsByUser2.user_id) AS rate'),
            ])
            ->joinWith(['friendsByUser', 'friendsByUser2'])
            ->andWhere(['id' => $user->primaryKey])
            ->andWhere(['not', ['users.id' => '[[friendsByUser]].[[user_id]]']])
            ->andWhere(['not', ['users.id' => '[[friendsByUser2]].[[user_id]]']])
            ->groupBy(['friendsByUser2.user_id'])
            ->orderBy(['rate' => SORT_DESC])
            ->limit(1)
            ->asArray()
            ->all();
    }
}