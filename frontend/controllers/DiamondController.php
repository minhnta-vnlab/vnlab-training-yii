<?php

namespace frontend\controllers;

use common\models\Diamond;
use Yii;
use yii\caching\ArrayCache;
use yii\caching\TagDependency;
use yii\data\ArrayDataProvider;
use yii\data\BaseDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\util\dataProvider\ApiDataProvider;
/**
 * DiamondController implements the CRUD actions for Diamond model.
 */
class DiamondController extends Controller
{
    /**
     * @inheritDoc
     */
    private Client $client;
    public function __construct($id, $module, $config = [])
    {
        // Assign custom property
        $this->client = Yii::$app->httpClient;

        // Call the parent constructor
        parent::__construct($id, $module, $config);
    }
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Diamond models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ApiDataProvider([
            'apiUrl' => 'diamonds'
        ]);

        // $dataProvider = new ActiveDataProvider([
        //     'query'=> Diamond::find()
        // ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Diamond model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Diamond model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Diamond();

        if ($this->request->isPost) {
            $data = $this->request->post();
            $data = Json::encode($data['Diamond']);
            $response = $this->client->post("diamonds", $data, [
                'Content-Type' => 'application/json'
            ])->send();
            if($response->getIsOk()) {
                $data = $response->content;
                $data = Json::decode($data);
                Yii::$app->session->setFlash('success', 'Created successfully');

                TagDependency::invalidate(Yii::$app->cache,'diamonds-all');

                return $this->redirect(['view','id'=> $data['id']]);
            } else {
                $statusCode = $response->getStatusCode();
                Yii::$app->session->setFlash('error', "Error $statusCode");
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Diamond model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $data = $this->request->post();
            $data = Json::encode($data['Diamond']);
            $response = $this->client->put("diamonds/$id", $data, [
                'Content-Type' => 'application/json'
            ])->send();
            if($response->getIsOk()) {
                Yii::$app->session->setFlash('success','Updated successfully');

                Yii::$app->cache->delete("diamond-$id");
                TagDependency::invalidate(Yii::$app->cache,"diamonds-all");

                return $this->redirect(['view','id'=> $model->id]);
            } else {
                $statusCode = $response->getStatusCode();
                Yii::$app->session->setFlash('error', "Error $statusCode");
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Diamond model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $response = $this->client->delete("diamonds/$id")->send();
        if($response->getIsOk()) {
            Yii::$app->session->setFlash("success","Deleted successfully");
            
            Yii::$app->cache->delete("diamond-$id");
            TagDependency::invalidate(Yii::$app->cache,"diamonds-all");

            return $this->redirect(["index"]);
        } else {
            $statusCode = $response->getStatusCode();
            Yii::$app->session->setFlash("error", "Error $statusCode");
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Diamond model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Diamond the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Yii::$app->cache->getOrSet('diamond-'.$id, function () use ($id) {
            Yii::debug("Not found in cache. Fetching...");
            $response = $this->client->get("diamonds/$id")->send();
            if($response->getIsOk()) {
                $data = Json::decode($response->content);
                $model = new Diamond();
                $model->attributes = $data;
                return $model;
            }
            throw new NotFoundHttpException('The requested page does not exist.');
        });

        return $model;
    }
}
