<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleCategory */
/* @var $form ActiveForm */
?>
<div class="article-category-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'intro') ?>
        <?= $form->field($model, 'status')->radioList(['1'=>"是",'0'=>"否"]) ?>
        <?= $form->field($model, 'sort') ?>
        <?= $form->field($model, 'is_help')->radioList(['1'=>"是",'0'=>"否"]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- article-category-add -->
