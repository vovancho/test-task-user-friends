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

    public function getFriendsRecommendation($count)
    {
        if (is_int($count) && $count < 1) {
            throw new \DomainException('Count must be greater than 0 and this integer number');
        }

        return $this->users->getFriendsRecommendation($count);
    }
}