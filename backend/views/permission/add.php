<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name');

echo $form->field($model,'description')->textarea();

echo \yii\bootstrap\Html::submitButton("提交");


\yii\bootstrap\ActiveForm::end();