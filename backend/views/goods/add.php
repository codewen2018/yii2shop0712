<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Goods */
/* @var $form ActiveForm */
?>
<div class="goods-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'sn') ?>
        <?= $form->field($model, 'logo')->widget('manks\FileInput', []); ?>

        <?= $form->field($model, 'imgFiles')->widget('manks\FileInput',  [
            'clientOptions' => [
                'pick' => [
                    'multiple' => true,
                ],
                // 'server' => Url::to('upload/u2'),
                // 'accept' => [
                // 	'extensions' => 'png',
                // ],
            ],
        ]); ?>

        <?= $form->field($model, 'goods_category_id')->dropDownList($catesArray) ?>
        <?= $form->field($model, 'brand_id')->dropDownList($brandsArray) ?>
        <?= $form->field($model, 'market_price') ?>
        <?= $form->field($model, 'shop_price') ?>
        <?= $form->field($model, 'stock') ?>
        <?= $form->field($model, 'is_on_sale')->radioList([1=>'在售',0=>"下架"],['value'=>1]) ?>
        <?= $form->field($model, 'status')->radioList([1=>'正常',0=>"回收站"],['value'=>1]) ?>
        <?= $form->field($model, 'sort')->textInput(['value'=>100]) ?>
        <?= $form->field($goodsIntro, 'content')->widget('kucha\ueditor\UEditor',[])?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- goods-add -->
