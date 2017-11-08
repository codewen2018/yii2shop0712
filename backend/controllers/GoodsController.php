<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use backend\models\GoodsSearchForm;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class GoodsController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }
    public function actionIndex()
    {


        //构造查询对象
        $query = Goods::find();

        $request=\Yii::$app->request;

       // var_dump($request->get());exit;
        //接收变量
        $keyword=$request->get('keyword');
        $minPrice=$request->get('minPrice');
        $maxPrice=$request->get('maxPrice');
        $status=$request->get('status');

        if ($minPrice>0){
            //拼接条件
            $query->andWhere("shop_price >= {$minPrice}");
        }

        if ($maxPrice>0){
            $query->andWhere("shop_price <= {$maxPrice}");
        }
        if (isset($keyword)){
            $query->andWhere("name like '%{$keyword}%' or sn like '%{$keyword}%'");
        }

        //
        if ($status ==="1" or $status==="0"){

            $query->andWhere("status= {$status}");
        }



        $count=$query->count();

        $searchForm=new GoodsSearchForm();
        $page = new Pagination(
            [
                'pageSize'=>5,
                'totalCount'=>$count
            ]
        );
        $models=$query->limit($page->limit)->offset($page->offset)->all();
        return $this->render('index',compact("page","models","searchForm"));
    }

    public function actionAdd()
    {
        //商品模型对象
        $model=new Goods();
        //商品详情
        $goodsIntro=new GoodsIntro();

        //查出所有品牌
        $brands=Brand::find()->all();
        //拼接品牌  ['品牌id'=>"名称"]   ['1'=>'华为','2'=>'小米']
        $brandsArray=ArrayHelper::map($brands,'id','name');
        //分类列表
        $cates=GoodsCategory::find()->orderBy('tree,lft')->all();
        //拼接
        $catesArray=ArrayHelper::map($cates,'id','nameText');


        $request=\Yii::$app->request;
         //判断是不是Post提交
        if ($request->isPost){

            $model->load($request->post());
            $today=date("Y-m-d",time());
            //判断如果用户没有输入货号,则货号自动生成
            if(empty($model->sn)===true){

                //判断数据库goods_day_count 有没有数据
                $goodsCount=GoodsDayCount::findOne(['day'=>$today]);
                //如果没有数据 添加数据
                if ($goodsCount==null){
                    $goodsCount = new GoodsDayCount();
                    $goodsCount->day = $today;
                    $goodsCount->count = 0;
                    $goodsCount->save();
                }
                // 1  00001    00001
                //99999  000099999   99999  取后面五位
                $countStr=substr("0000".($goodsCount->count+1),-5);
               //$countStr=  sprintf("%05d",1);
                $model->sn=date("Ymd").$countStr;

                //$goodsCount->count=$goodsCount->count+1;
                //$goodsCount->save();
            }
            //保存商品
            $model->save();
            //给当日商品统计加1  固定语法
            GoodsDayCount::updateAllCounters(['count'=>1],['day'=>$today]);

            //保存详情
            $goodsIntro->load($request->post());
            $goodsIntro->goods_id=$model->id;
            $goodsIntro->save();



            //保存图片

            // var_dump($model->imgFiles);exit;

            foreach ($model->imgFiles as $imgFile){
                //创建相册对象
                $goodsGallery=new  GoodsGallery();
                //赋值
                $goodsGallery->goods_id=$model->id;
                $goodsGallery->path=$imgFile;
                $goodsGallery->save();
            }

            \Yii::$app->session->setFlash("success","添加");
            return $this->redirect(['index']);

        }


       // return $this->render('add',compact('model','goodsIntro','brandsArray','catesArray'));
        return $this->render('add',['model'=>$model,'goodsIntro'=>$goodsIntro,'brandsArray'=>$brandsArray,'catesArray'=>$catesArray]);



    }

    public function actionEdit($id)
    {

        $model=Goods::findOne($id);
        $goodsIntro=GoodsIntro::findOne($model->id);


        $brands=Brand::find()->all();
        $brandsArray=ArrayHelper::map($brands,'id','name');
        $cates=GoodsCategory::find()->orderBy('tree,lft')->all();
        $catesArray=ArrayHelper::map($cates,'id','nameText');


        $request=\Yii::$app->request;

        if ($request->isPost){

            $model->load($request->post());
            $today=date("Y-m-d",time());
            if(empty($model->sn)===true){

                //

                $goodsCount=GoodsDayCount::findOne(['day'=>$today]);
                if ($goodsCount==null){
                    $goodsCount = new GoodsDayCount();
                    $goodsCount->day = $today;
                    $goodsCount->count = 0;
                    $goodsCount->save();
                }

                $countStr=substr("0000".($goodsCount->count+1),-5);

                $model->sn=date("Ymd").$countStr;

                //$goodsCount->count=$goodsCount->count+1;
                //$goodsCount->save();
            }
            //保存商品
            $model->save();

           // GoodsDayCount::updateAllCounters(['count'=>1],['day'=>$today]);

            //保存详情
            $goodsIntro->load($request->post());
            $goodsIntro->goods_id=$model->id;
            $goodsIntro->save();



            //保存图片

            // var_dump($model->imgFiles);exit;

            foreach ($model->imgFiles as $imgFile){
                $goodsGallery=new  GoodsGallery();
                $goodsGallery->goods_id=$model->id;
                $goodsGallery->path=$imgFile;
                $goodsGallery->save();
            }

            \Yii::$app->session->setFlash("success","添加");
            return $this->redirect(['index']);









        }

        //找到所有相片

        $goodsGallerys=GoodsGallery::find()->where(['goods_id'=>$id])->all();
        //循环输出
        foreach ($goodsGallerys as $goodsGallery){
            //把每张相片赋值给imgFiles属性
            $model->imgFiles[]=$goodsGallery->path;
        }
        //var_dump($images);exit();
        //$model->imgFiles=["http://oyveukumy.bkt.clouddn.com/1510067341","http://oyveukumy.bkt.clouddn.com/1510065428"];
       // $model->imgFiles=["http://oyveukumy.bkt.clouddn.com/1510067951","http://oyveukumy.bkt.clouddn.com/5a025d67a13c6"];
        return $this->render('add',compact('model','goodsIntro','brandsArray','catesArray'));



    }


    /**
     * 删除功能
     * @param $id
     * @return \yii\web\Response
     */
  public function actionDel($id){

        Goods::findOne($id)->delete();
        GoodsIntro::findOne($id)->delete();
        //如果要做7牛云删除 把所有相片取出来 然后循环删除
        //删除当前商品所有相片
        GoodsGallery::deleteAll(['goods_id'=>$id]);
        \Yii::$app->session->setFlash("success",'删除成功');
        return $this->redirect("index");
  }


}
