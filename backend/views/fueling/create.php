<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Fueling */

$this->title = 'Create Fueling';
$this->params['breadcrumbs'][] = ['label' => 'Fuelings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fueling-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
