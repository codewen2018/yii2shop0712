<?php
/* @var $this yii\web\View */
?>
<h1>品牌列表</h1>
<?=\yii\bootstrap\Html::a("添加",['add'],['class'=>'btn btn-info'])?>
<table class="table">

    <tr>
        <th>Id</th>
        <th>名称</th>
        <th>图片</th>
        <th>排序</th>
        <th>状态</th>
        <th>操作</th>
    </tr>

    <?php foreach ($brands as $brand):?>
        <tr>
            <td><?=$brand->id?></td>
            <td><?=$brand->name?></td>
            <td><?=\yii\bootstrap\Html::img($brand->image,['height'=>100])?></td>
            <td><?=$brand->sort?></td>
            <td><?=$brand->status?></td>
            <td>
                <?php
               echo \yii\bootstrap\Html::a("编辑",['edit','id'=>$brand->id],['class'=>'btn btn-success']);
               echo \yii\bootstrap\Html::a("删除",['del','id'=>$brand->id],['class'=>'btn btn-danger']);
                ?>



            </td>
        </tr>



    <?php endforeach;?>

</table>