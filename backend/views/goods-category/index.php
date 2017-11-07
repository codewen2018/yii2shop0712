<?php
/* @var $this yii\web\View */
?>
<h1>文章分类列表</h1>
<?= \yii\bootstrap\Html::a("添加", ['add'], ['class' => 'btn btn-info']) ?>
<table class="table">

    <tr>
        <th>Id</th>
        <th>名称</th>
        <th>操作</th>
    </tr>

    <?php foreach ($cates as $cate): ?>
        <tr data-tree='<?=$cate->tree?>' data-lft='<?=$cate->lft?>' data-rgt='<?=$cate->rgt?>'>
            <td><?= $cate->id ?></td>
            <td>

                <?= $cate->nameText ?>
                <span class="glyphicon glyphicon-menu-down expand" style="float: right"></span>
            </td>
            <td>编辑 删除</td>
        </tr>


    <?php endforeach; ?>

</table>


<?php
$js=<<<EOT
    $(".expand").click(function(){
        $(this).toggleClass("glyphicon-menu-down");
        $(this).toggleClass("glyphicon-menu-up");
        var tr = $(this).closest("tr");
        var p_lft = tr.attr("data-lft");
        var p_rgt = tr.attr("data-rgt");
        var p_tree= tr.attr("data-tree");
        $("tbody tr").each(function(){
            var lft = $(this).attr("data-lft");
            var rgt = $(this).attr("data-rgt");
            var tree = $(this).attr("data-tree");
            
            
            if(tree - p_tree==0 &&　lft-p_lft>0 && rgt-p_rgt<0){
            console.dir(typeof tree);
            console.dir(p_tree);
            console.dir(lft);
            console.dir(rgt);
                $(this).fadeToggle();
            }
        });
    });
EOT;
$this->registerJs($js);