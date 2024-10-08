<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Diamond $model */

$this->title = 'Create Diamond';
$this->params['breadcrumbs'][] = ['label' => 'Diamonds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="diamond-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'blockEditId' => false,
        'model' => $model,
    ]) ?>

</div>
