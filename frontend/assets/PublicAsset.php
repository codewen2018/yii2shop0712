<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/11/17
 * Time: 11:55
 * Company: 源码时代重庆校区
 */


namespace frontend\assets;
use yii\web\AssetBundle;
class PublicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/bottomnav.css',
        'style/footer.css',
    ];
    public $js = [
        "js/header.js",
        "js/home.js"
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}