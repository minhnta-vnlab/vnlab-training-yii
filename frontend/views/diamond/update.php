<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Diamond $model */

$this->title = 'Update Diamond: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Diamonds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="diamond-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'blockEditId' => true,
        'model' => $model,
    ]) ?>

</div>
