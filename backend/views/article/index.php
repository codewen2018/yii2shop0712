<?php
/* @var $this yii\web\View */
?>
<h1>文章列表</h1>
<?=\yii\bootstrap\Html::a("添加",['add'],['class'=>'btn btn-info'])?>

<table class="table">


    <tr>
        <th>Id</th>
        <th>标题</th>
        <th>文章分类</th>
        <th>操作</th>
    </tr>

    <?php foreach ($models as $model):?>

        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->cate->name?></td>
            <td>编辑 删除</td>
        </tr>

    <?php endforeach;?>
</table>