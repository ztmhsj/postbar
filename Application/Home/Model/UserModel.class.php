<?php
class User extends Model {
    public function getUserMessage($userid){
        $sql="select username,uid,icon from user where uid=$userid";
        $result=$this->execute_dql($sql);
        return $result[0];

    }
    public function userCount(){
        $sql='select count(1) as count from user';
        $result=$this->execute_dql($sql);
        return $result[0]['count'];
    }
    public function tryLogin($userName,$passwd){
        $sql="select passwd,uid from user where username='$userName'";
        $result=$this->execute_dql($sql);
        if(!empty($result)&&md5($passwd)==$result[0]['passwd']){
            $userId=$result[0]['uid'];
            if(isset($_POST['auto'])){
                setcookie('userName',$userName,time()+24*7*3600,'/');
                setcookie('passwd',md5($passwd),time()+24*7*3600,'/');
            }
            session_start();
            $_SESSION['userName']=$userName;
            $_SESSION['passwd']=$passwd;
            $_SESSION['userId']=$userId;
            return $userId;
        }
        else
            return -1;
    }
    public function tryKeepLogin(){
        if(isset($_COOKIE['userName'])&&isset($_COOKIE['passwd'])){
            $userName=$_COOKIE['userName'];
            $passwd=$_COOKIE['passwd'];
            $sql="select passwd,uid from user where username='$userName'";
            $result=$this->execute_dql($sql);
            if(!empty($result)&&$passwd==$result[0]['passwd']){
                $userId=$result[0]['uid'];
                $_SESSION['userName']=$userName;
                $_SESSION['passwd']=$passwd;
                $_SESSION['userId']=$userId;
                return $userId;
            }
        }
            return -1;
    }
    public function register($userName,$passwd){
        $sql="insert into user (username,passwd,create_time) values
        ('$userName',md5('$passwd'),".time().")";
        echo $sql;
        $this->execute_dml($sql);
    }
};
?>