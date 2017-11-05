<?php
/* @var $this yii\web\View */
?>
<h1>文章分类列表</h1>
<?=\yii\bootstrap\Html::a("添加",['add'],['class'=>'btn btn-info'])?>
<table class="table">

    <tr>
        <th>Id</th>
        <th>名称</th>
        <th>简介</th>
        <th>状态</th>
        <th>排序</th>
        <th>是否帮助</th>
        <th>操作</th>
    </tr>

    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->intro?></td>
            <td><?=$model->status?></td>
            <td><?=$model->sort?></td>
            <td><?=$model->is_help?></td>
            <td>编辑 删除</td>
        </tr>


    <?php endforeach;?>

</table>