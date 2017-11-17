<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/11/17
 * Time: 14:45
 * Company: 源码时代重庆校区
 */

namespace frontend\widgets;


use backend\models\GoodsCategory;
use Guzzle\Http\Url;
use yii\base\Widget;
use yii\helpers\Html;

class GoodsWidget extends Widget
{
    public function run()
    {

        $html='';

        $cates=GoodsCategory::find()->where(['parent_id'=>0])->all();

        //var_dump($cates);
        //exit;

        foreach ($cates as $k1=>$v1){

            $html.='<div class="cat">';
            $html.='  <h3>'.Html::a($v1->name,['index/list','id'=>$v1->id]).' <b></b></h3>';

             $html.='<div class="cat_detail">';

             foreach ($v1->children as $k2=>$v2){
                 $html.='<dl class="dl_1st">';

                 $html.=' <dt>'.Html::a($v2->name,['index/list','id'=>$v2->id]).'</dt>';

                $html.='<dd>';
                  foreach ($v2->children as $k3=>$v3){

                      $html.=Html::a($v3->name,['index/list','id'=>$v3->id]);

                  }
                $html.="</dd>";
                 $html.='</dl>';
             }



            $html.="</div></div>";

        }

       // return $html;
        return <<<EOF
    <div class="category fl"> <!-- 非首页，需要添加cat1类 -->
            <div class="cat_hd">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>

            <div class="cat_bd">

       <!--         <div class="cat item1">
                    <h3><a href="/">图像、音像、数字商品</a> <b></b></h3>
                    <div class="cat_detail">
                        <dl class="dl_1st">
                            <dt><a href="/">电子书</a></dt>
                            <dd>
                                <a href="/">免费</a>
                                <a href="/">小说</a>
                                <a href="/">励志与成功</a>
                                <a href="/">婚恋/两性</a>
                                <a href="/">文学</a>
                                <a href="/">经管</a>
                                <a href="/">畅读VIP</a>
                            </dd>
                        </dl>

                        

                    </div>
                </div>-->
                {$html}

        

             

            </div>

        </div>
EOF;
;
    }

}