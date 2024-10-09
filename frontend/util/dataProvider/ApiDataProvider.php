<?php

namespace frontend\util\dataProvider;

use Yii;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\httpclient\Client;
use yii\helpers\Json;
use common\models\Diamond;

class ApiDataProvider extends ArrayDataProvider {
    public $apiUrl;
    public $params = [];
    private Client $client;
    public function __construct($config = [])
    {
        $this->pagination = new Pagination([
            'pageSize' => 20,
        ]);
        parent::__construct($config);
        $this->client = Yii::$app->httpClient; // Initialize the client here
    }

    protected function prepareModels() {
        $models = [];
        if ($this->pagination !== false) {
            $page = $this->pagination->page + 1;
            $this->params['page'] = $page;
            $this->params['pageSize'] = $this->pagination->pageSize;
        }

        $apiUrl = $this->apiUrl;
        $params = $this->params;

        $models = Yii::$app->cache->getOrSet(
            "diamonds-$page", 
            function () use ($apiUrl, $params) {
                    $response = $this->client->get($this->apiUrl, $this->params)->send();
            
                    if($response->getIsOk()) {
                        $models = Json::decode($response->content, true);
                        $models = array_map(function($model) {
                            $diamond = new Diamond();
                            $diamond->attributes = $model;
                            return $diamond;
                        }, $models);
                    }
                    return [];
            },
            null,
            new TagDependency(["tags" => "diamonds-all"])
        );

        if (count($models) == 0) {
            Yii::$app->cache->delete("diamonds-$page");
        }
        
        return $models;
    }

    protected function prepareTotalCount() {
        $response = $this->client->head($this->apiUrl, $this->params)->send();
        $total = 0;
        if($response->getIsOk()) {
            $total = (int) $response->getHeaders()->get('x-pagination-total-count');
            $this->params['total'] = $total;
        }
        return $total;
    }
}