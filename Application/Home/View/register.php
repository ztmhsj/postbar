<!DOCTYPE html>
<html>
<head>
    <title>注册</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="/postBar/Public/Css/register.css" />
    <script type="text/javascript" src="/postBar/Public/Js/register.js"></script>
</head>
<body>
    <div id="main">
            <div class="la">
                <form  action="/postBar/index.php/Home/Register/signup"  method="post" onsubmit="return check()">
                    <label id="recheck">&nbsp;  </label>
                    <table border="0">
                        <tr>
                            <td>用户名</td>
                            <td><input type='text' name="userName" class="in" id="username"
                                       onchange="renew()"/></td>
                        </tr>
                        <tr>
                            <td>密码</td>
                            <td><input type="password" name="passwd" id="passwd"
                                       class="in" onchange="renew()"/></td>
                        </tr>
                        <tr>
                            <td>验证码</td>
                            <td><input type="text" name="verify" id="vr"/>
                            <img src="/postBar/index.php/Home/Register/verify" id="ver">
                            <a href="javascript:changeVerify()">看不清</a></td>

                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" value="登陆" id="su" /></td>
                        </tr>
                        <tr align="center">
                            <td colspan="2" ><span>记住帐号</span>
                                <input type="checkbox" name="auto"  id="ck"/></td>
                        </tr>
                    </table>
                </form>
                <?php if(isset($_GET['er']))
                echo '<div><p id="mess">你输入的帐号密码错误</p></div>';
                ?>
            </div>
    </div>

</body>
</html>