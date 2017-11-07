<?php
/**
 * @var $this \yii\web\View
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model, 'name');
echo $form->field($model, 'parent_id')->hiddenInput(['value'=>0]);

echo \liyuze\ztree\ZTree::widget([
    'setting' => '{
            callback: {
		        onClick: function(event, treeId, treeNode){
		        console.dir(treeNode);
		        $("#goodscategory-parent_id").val(treeNode.id);
		        }
	     },
			data: {
				simpleData: {
					enable: true,
					idKey: "id",
			        pIdKey: "parent_id",
			        rootPId: 0
				}
			}
		}',
    'nodes' => $cates
]);

echo $form->field($model, 'intro')->textarea();
echo \yii\bootstrap\Html::submitButton("提交", ['class' => 'btn btn-success']);


\yii\bootstrap\ActiveForm::end();

$js=<<<EOF
var treeObj = $.fn.zTree.getZTreeObj("w1");
treeObj.expandAll(true);
/*选中当前节点*/
var node = treeObj.getNodeByParam("id", "{$model->parent_id}", null);
treeObj.selectNode(node);
EOF;
//注册JS代码
$this->registerJs($js);


?>






