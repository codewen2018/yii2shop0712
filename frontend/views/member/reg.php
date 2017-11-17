<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Member */
?>
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form=\yii\widgets\ActiveForm::begin(
                    [
                            'fieldConfig' => [
                                    'options'=>['tag'=>'li'],
                                     'errorOptions'=>['tag'=>'p'],

                            ]


                    ]
            );
            echo "<ul>";
            echo $form->field($model,"username")->textInput(['class'=>'txt'])->label("用户名：");
            echo $form->field($model,"password")->textInput(['class'=>'txt']);
            echo $form->field($model,'rePassword')->passwordInput(['class'=>'txt']);
            echo $form->field($model,'email')->textInput(['class'=>'txt']);
            echo $form->field($model,'mobile')->textInput(['class'=>'txt']);
            $button =  '<input type="button" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px;margin-left: 10px">';
            echo $form->field($model,'smsCode',[
                'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
            ])->textInput(['class'=>'txt','style'=>'width:100px','disabled'=>'disabled']);
            echo $form->field($model,'code',[
                'options'=>['class'=>'checkcode']
            ])->widget(
                \yii\captcha\Captcha::className(),[
                    'template'=>'{input}{image}',
                ]
            );





            echo $form->field($model,'checked')->hint("我已阅读并同意《用户注册协议》")->checkbox(['class'=>'chb']);

            echo '<li><label for="">&nbsp;</label>'.\yii\helpers\Html::submitButton('',['class'=>'login_btn']).'</li>';

            echo "</ul>";

            \yii\widgets\ActiveForm::end();


            ?>

            <form action="" method="post">
                <ul>
                    <li>
                        <label for="">用户名：</label>
                        <input type="text" class="txt" name="username" />
                        <p>3-20位字符，可由中文、字母、数字和下划线组成</p>
                    </li>
                    <li>
                        <label for="">密码：</label>
                        <input type="password" class="txt" name="password" />
                        <p>6-20位字符，可使用字母、数字和符号的组合，不建议使用纯数字、纯字母、纯符号</p>
                    </li>
                    <li>
                        <label for="">确认密码：</label>
                        <input type="password" class="txt" name="password" />
                        <p> <span>请再次输入密码</p>
                    </li>
                    <li>
                        <label for="">邮箱：</label>
                        <input type="text" class="txt" name="email" />
                        <p>邮箱必须合法</p>
                    </li>
                    <li>
                        <label for="">手机号码：</label>
                        <input type="text" class="txt" value="" name="tel" id="tel" placeholder=""/>
                    </li>
               <!--     <li>
                        <label for="">验证码：</label>
                        <input type="text" class="txt" value="" placeholder="请输入短信验证码" name="captcha" disabled="disabled" id="captcha"/> <input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px"/>

                    </li>-->
                    <li class="checkcode">
                        <label for="">验证码：</label>
                        <input type="text"  name="checkcode" />
                        <img src="images/checkcode1.jpg" alt="" />
                        <span>看不清？<a href="">换一张</a></span>
                    </li>

                    <li>
                        <label for="">&nbsp;</label>
                        <input type="checkbox" class="chb" checked="checked" /> 我已阅读并同意《用户注册协议》
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input type="submit" value="" class="login_btn" />
                    </li>
                </ul>
            </form>


        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<?php

$url=\yii\helpers\Url::to(['member/sms']);
$js=<<<EOF
$("#get_captcha").click(function(){
var mobile=$("#member-mobile").val();

if(!mobile){
alert("手机号必填");
return
}



//>1.发AJax请求发送短信
$.post("{$url}",{"mobile":mobile},function(data){
console.log(data);
});
 //启用输入框
        $('#member-smscode').prop('disabled',false);

        var time=30;
        var interval = setInterval(function(){
            time--;
            if(time<=0){
                clearInterval(interval);
                var html = '获取验证码';
                $('#get_captcha').prop('disabled',false);
            } else{
                var html = time + ' 秒后再次获取';
                $('#get_captcha').prop('disabled',true);
            }

            $('#get_captcha').val(html);
        },1000);

});

EOF;


$this->registerJs($js);

?>

<script type="text/javascript">
    function bindPhoneNum(){
        //启用输入框
        $('#member-smscode').prop('disabled',false);

        var time=30;
        var interval = setInterval(function(){
            time--;
            if(time<=0){
                clearInterval(interval);
                var html = '获取验证码';
                $('#get_captcha').prop('disabled',false);
            } else{
                var html = time + ' 秒后再次获取';
                $('#get_captcha').prop('disabled',true);
            }

            $('#get_captcha').val(html);
        },1000);
    }
</script>