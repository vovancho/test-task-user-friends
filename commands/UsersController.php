<?php

namespace app\commands;

use yii\base\Module;
use yii\console\Controller;
use yii\console\ExitCode;
use app\domain\services\UserService;
use yii\console\widgets\Table;

class UsersController extends Controller
{
    private $service;

    public function __construct($id, Module $module, array $config = [], UserService $service)
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionFriendsRecommendation($userID, $limit = 5)
    {
        try {
            echo Table::widget([
                'headers' => ['user_id', 'recommend_id', 'rate'],
                'rows' => $this->service->getFriendsRecommendation($userID, $limit),
            ]);
        } catch (\DomainException $e) {
            $this->stderr('Ошибка: ' . $e->getMessage());
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }
}
