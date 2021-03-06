<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 19.06.2018
 * Time: 11:52
 */

namespace app\domain\services;

use app\domain\repositories\UserRepository;

class UserService
{
    private $users;

    public function __construct(UserRepository $repository)
    {
        $this->users = $repository;
    }

    public function getFriendsRecommendation($userID, $limit): array
    {
        $this->validateLimit($limit);
        $user = $this->users->getUser($userID);

        return $this->users->getFriendsRecommendation($user, $limit);
    }

    protected function validateLimit($limit)
    {
        if ($limit < 1) {
            throw new \DomainException('Limit must be integer number and greater than 0.');
        }
    }
}