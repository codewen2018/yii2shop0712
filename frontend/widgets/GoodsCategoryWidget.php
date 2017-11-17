<?php
namespace frontend\widgets;
use backend\models\GoodsCategory;
use yii\helpers\Html;
class GoodsCategoryWidget extends \yii\base\Widget
{
    public $expand = false;//是否展开商品分类
    public function run()
    {
        $cat1 = $this->expand?'':'cat1';
        $none = $this->expand?'':'none';
        $html = '';
        $categories = GoodsCategory::find()->roots()->all();//获取一级分类
        //$categories = GoodsCategory::find()->where(['parent_id'=>0])->all();//获取一级分类
        //遍历一级分类
        foreach($categories as $k=>$category){
            $html .= '<div class="cat '.($k==0?'item1':'').'">
                    <h3>'.Html::a($category->name,['index/list','id'=>$category->id]).'<b></b></h3>
                    <div class="cat_detail">';
            //遍历二级分类
            foreach($category->children as $child){
                $html .= '<dl class="dl_1st">
                            <dt>'.Html::a($child->name,['index/list','id'=>$child->id]).'</dt>
                            <dd>';
                //遍历三级分类
                foreach($child->children as $cate)
                    $html .= Html::a($cate->name,['index/list','id'=>$cate->id]);
                $html .= '</dd>
                        </dl>';
            }
            $html .= '</div></div>';
        }
        $html = <<<EOT
        <div class="category fl {$cat1}"> <!-- 非首页，需要添加cat1类 -->
            <div class="cat_hd">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>
            <div class="cat_bd {$none}">
                {$html}
            </div>
        </div>
EOT;
        return $html;
    }
}