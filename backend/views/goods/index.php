<?php
/* @var $this yii\web\View */
?>
<h1>商品列表</h1>



<div class="row">
    <div class="col-md-2"><?=\yii\bootstrap\Html::a("添加",['add'],['class'=>'btn btn-info'])?></div>
    <div class="col-md-10">

      <!--  <form class="form-inline pull-right">


            <input type="text" class="form-control" id="minPrice" name="minPrice" size="8" placeholder="最低价" value="<?/*=Yii::$app->request->get('minPrice')*/?>"> -
            <input type="text" class="form-control" id="maxPrice" name="maxPrice"  size="8" placeholder="最高价" value="<?/*=Yii::$app->request->get('maxPrice')*/?>">
                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="请输入商品名称或货号" value="<?/*=Yii::$app->request->get('keyword')*/?>">




            <button type="submit" class="btn btn-default">搜索</button>
        </form>-->


        <?php
        $searchForm=new \backend\models\GoodsSearchForm();
        $form=\yii\bootstrap\ActiveForm::begin([
                'method' => 'get',
                'action' => ['index'],
                'options' => ['class'=>"form-inline pull-right"]
        ]);
        echo $form->field($searchForm,'minPrice')->label(false)->textInput(['size'=>5,'name'=>'minPrice']);
        echo "-";
        echo $form->field($searchForm,'maxPrice')->label(false)->textInput(['size'=>5,'placeholder'=>"最高价",'name'=>'maxPrice']);
        echo " ";
        echo $form->field($searchForm,'keyword')->label(false)->textInput(['name'=>'keyword']);
        echo " ";
        echo \yii\bootstrap\Html::submitButton("搜索",['class'=>'btn btn-success','style'=>"margin-bottom:8px"]);

        \yii\bootstrap\ActiveForm::end();
        ?>

    </div>


</div>


<table class="table">


    <tr>
        <th>Id</th>
        <th>名称</th>
        <th>商品分类</th>
        <th>品牌</th>
        <th>操作</th>
    </tr>

    <?php foreach ($models as $model):?>

        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->goods_category_id?></td>
            <td><?=$model->brand_id?></td>
            <td><?php


                echo \yii\bootstrap\Html::a("删除",['del','id'=>$model->id])
                ?></td>
        </tr>

    <?php endforeach;?>
</table>