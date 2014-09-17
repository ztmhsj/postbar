<?php
class LoginController extends Controller {
    public function main() {
        $this->display('login');
    }
    public function access() {
        $userName=$_POST['userName'];
        $passwd=$_POST['passwd'];
        $user=$this->loadModel('User');
        if($user->tryLogin($userName,$passwd)<0){
            header('Location:main?er=1');
            exit;
        }
        header("Location:{$_COOKIE['previous']}");
        exit;
    }
    public function logout(){
        session_start();
        session_destroy();
        setcookie('userName','',1,'/');
        setcookie('passwd','',1,'/');
        header("Location:http://{$_SERVER['SERVER_NAME']}/postBar/index.php");
    }
}