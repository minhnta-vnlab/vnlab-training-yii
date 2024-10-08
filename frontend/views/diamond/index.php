<?php

use common\models\Diamond;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Diamonds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="diamond-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Diamond', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'carat',
            'cut',
            'color',
            'clarity',
            //'depth',
            //'table',
            //'price',
            //'x',
            //'y',
            //'z',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Diamond $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

</div>
