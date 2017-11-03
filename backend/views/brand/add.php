<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;
use xj\uploadify\Uploadify;

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form ActiveForm */
?>
<div class="brand-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'sort') ?>
        <?= $form->field($model, 'status')->radioList(\backend\models\Brand::$statusText) ?>



         <?php

         //外部TAG
         echo Html::fileInput('test', NULL, ['id' => 'test']);
         echo Uploadify::widget([
             'url' => yii\helpers\Url::to(['s-upload']),
             'id' => 'test',
             'csrf' => true,
             'renderTag' => false,
             'jsOptions' => [
                 'width' => 120,
                 'height' => 40,
                 'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
                 ),
                 'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
    }
}
EOF
                 ),
             ]
         ]);
         ?>



        <?= $form->field($model, 'intro') ?>

    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- brand-add -->
