<?php
class RegisterController extends Controller {
    public  function main(){
        $this->display('register');
    }
    public function signup(){
        if(isset($_POST['userName'])&&isset($_POST['passwd'])){
            $verify=strtolower($_SESSION['an']);
            if($verify!=$_POST['verify']){
                echo '你验证码错误';
                exit;
            }
            $userName=$_POST['userName'];
            $passwd=$_POST['passwd'];
            $user=$this->loadModel('User');
            $user->register($userName,$passwd);
            if($user->tryLogin($userName,$passwd)<0){
                echo '>_<';
                exit;
            }
        }else{
            echo 'error in sigup';
            exit;
        }
        header("Location:http://{$_SERVER['SERVER_NAME']}/postBar/index.php");
    }
    public function verify(){
        $an = new Authnum();
        $an->ext_num_type='';
        $an->ext_pixel = true; //干扰点
        $an->ext_line = false; //干扰线
        $an->ext_rand_y= true; //Y轴随机
        $an->green = 238;
        $an->create();
    }
}