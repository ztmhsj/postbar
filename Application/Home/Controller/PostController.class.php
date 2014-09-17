<?php
class PostController extends Controller{
    public function main(){
        $url=curPageURL();
        setcookie('previous',$url,0,'/');
        $pageNow=isset($_GET['pa'])?$_GET['pa']:1;
        $tid= isset($_GET['tid'])?$_GET['tid']:1;
        $post=$this->loadModel('Post');
        $postCount=$post->getPostCountById($tid);
        $pageSize=10;
        $page=$this->loadModel('Page',
            array($pageSize,$pageNow,$postCount,"/postBar/index.php/Home/Post?tid=$tid&",'pageblock','pageblock_now',5));
        $result=$post->getPostPage($page,$tid);
        $this->assign('post',$result);
        $this->assign('pageBar',$page->showPageBar());
        $postNum=($pageNow-1)*$pageSize+1;
        $this->assign('postNum',$postNum);

        $this->display('postList');
    }
    public function addPost(){
        print_r($_POST);
        if(empty($_POST['editorValue'])){
            echo '你不能不输入内容';
            exit;
        }
        $content=trim($_POST['editorValue']);
        if(!str_replace(' ','',str_replace('&nbsp;','',strip_tags($content)))){
            echo '内容不合法';
            exit;
        }
        if(empty($_SESSION['userId'])){
            echo '你还没登陆 你想干什么!';
            exit;
        }
        $userId=$_SESSION['userId'];
        $post=$this->loadModel('Post');
        if(empty($_POST['tid'])){
            echo 'error1';
            exit;
        }
        $tid=$_POST['tid'];
        $post->addPost($tid,$userId,$content);
        header("Location:{$_COOKIE['previous']}");
    }
    public function addReply(){
        $content=$_POST['reply'];
        $pid=$_POST['pid'];
        $tid=$_POST['tid'];
        $uid=$_SESSION['userId'];
        if($content&&$pid&&$uid){
            $reply=$this->loadModel('Post');
            $reply->addReply($pid,$content,$uid,$tid);
            header("Location:{$_COOKIE['previous']}");
        }else{
            echo '你的操作有问题';
            exit;
        }

    }
}