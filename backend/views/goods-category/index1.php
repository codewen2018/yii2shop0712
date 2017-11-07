<?php
/* @var $this yii\web\View */
?>
<h1>文章分类列表</h1>
<?= \yii\bootstrap\Html::a("添加", ['add'], ['class' => 'btn btn-info']) ?>
<table class="table">

    <tr>
        <th>Id</th>
        <th>名称</th>
        <th>简介</th>
        <th>操作</th>
    </tr>

    <?php foreach ($cates as $cate): ?>
        <tr data-lft="<?=$cate->lft?>" data-rgt="<?=$cate->rgt?>" data-tree="<?=$cate->tree?>">
            <td><?= $cate->id ?></td>
            <td >
              <span class="glyphicon glyphicon-minus-sign cate"></span>  <?= $cate->nameText ?>
            </td>
            <td>
                <?=$cate->intro?>
            </td>
            <td>
                <?php
                echo \yii\bootstrap\Html::a("编辑",['edit','id'=>$cate->id]);
                echo \yii\bootstrap\Html::a("删除",['del','id'=>$cate->id]);


                ?>


            </td>
        </tr>


    <?php endforeach; ?>

</table>

<?php
$js=<<<EOF
  $(".cate").click(function(){
      
       $(this).toggleClass("glyphicon-minus-sign");
       $(this).toggleClass("glyphicon-plus-sign");
  
       var tr= $(this).parent().parent();
       
       var lft=tr.attr('data-lft');
       var rgt=tr.attr('data-rgt');
       
       var tree=tr.attr('data-tree');
       
       
       /*得到所有的tr*/
       
     var trs= $("tr")
       
       $.each(trs,function(k,v){
       
       var treePer=$(v).attr('data-tree');  
       var lftPer=$(v).attr('data-lft');
       var rgtPer=$(v).attr('data-rgt');
        console.log($(v).attr('data-lft'),$(v).attr('data-rgt'));
        
        if(tree==treePer && lftPer-lft>0 && rgtPer - rgt<0){
        
        $(v).toggle();
        }
       
       })
       
        
        
        
        
        
    });



EOF;

$this->registerJs($js);

?>

<script>
    $(".cate").click(function(){

        console.log(2);
    });


</script>
