<?php

namespace backend\controllers;

use backend\models\Brand;
use common\components\Upload;
use yii\helpers\Json;
use yii\web\UploadedFile;
use flyok666\qiniu\Qiniu;
class BrandController extends \yii\web\Controller
{
    /**
     * 品牌列表
     * @return string
     */
    public function actionIndex()
    {
        //处理数据
        $brands = Brand::find()->all();

        return $this->render('index', ['brands' => $brands]);
    }

    public function actionAdd()
    {
        //创建对象
        $model = new Brand();

        $request = \Yii::$app->request;

        if ($model->load($request->post())) {

            //创建文件上传对象
           // $model->imgFile = UploadedFile::getInstance($model, 'imgFile');
            //拼装路径
          //  $imgFilePath = "images/brand/" . uniqid() . "." . $model->imgFile->extension;

            //保存图片
         //   $model->imgFile->saveAs($imgFilePath, false);


            if ($model->validate()) {

                //和数据库里logo字段绑定
             //   $model->logo = $imgFilePath;

                //保存数据
                if ($model->save()) {
                    //跳转
                    return $this->redirect(['index']);
                }

            }

        }

        //显示视图
        $model->status = 1;
        return $this->render("add", ['model' => $model]);

    }




    public function actionUpload(){
       //本地上传
     /*   $file=new Upload();

        $info=$file->upImage();*/



      /* 测试
      $info= [
            'code'=>0,
            'url'=>'http://www.itsource.cn/upload/superStar/superStar_picture/2017-08-21/9395f2d0-a49f-4120-bd88-9ddb663a0d3c.jpg',
            'attachment'=>'upload/superStar/superStar_picture/2017-08-21/9395f2d0-a49f-4120-bd88-9ddb663a0d3c.jpg'
        ];*/

      //七牛云上传

       // var_dump($_FILES["file"]['tmp_name']);exit;

         //配置
        $config = [
            'accessKey'=>'5BoK9fVIkpdyYXntlMYdqIwhPIXqAEjcSZBDJ76-',//ak
            'secretKey'=>'_4b531Xed6ijMFiF3vOtJ6wjF0miVse1524iZw9u',//sk
            'domain'=>'http://oyveukumy.bkt.clouddn.com/',//域名
            'bucket'=>'php0712',//空间名称
            'area'=>Qiniu::AREA_HUANAN //区域
        ];
        //实例化对象
        $qiniu = new Qiniu($config);
        $key = time();
        //调用上传方法
        $qiniu->uploadFile($_FILES["file"]['tmp_name'],$key);
        $url = $qiniu->getLink($key);

        $info=[
          'code'=>0,
          'url'=>$url,
          'attachment'=>$url
        ];

        //exit($url);

       exit(Json::encode($info));

        //{"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}
    }

    public function actionDel7(){

        $qiNiu=new Qiniu($config = [
            'accessKey'=>'5BoK9fVIkpdyYXntlMYdqIwhPIXqAEjcSZBDJ76-',//ak
            'secretKey'=>'_4b531Xed6ijMFiF3vOtJ6wjF0miVse1524iZw9u',//sk
            'domain'=>'http://oyveukumy.bkt.clouddn.com/',//域名
            'bucket'=>'php0712',//空间名称
            'area'=>Qiniu::AREA_HUANAN //区域
        ]);


        var_dump($qiNiu->delete("309345.jpg","php0712"));


    }


}
