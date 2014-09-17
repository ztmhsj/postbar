<?php
class IndexController extends Controller{
    public function main(){
        $pageNow=isset($_GET['pa'])?$_GET['pa']:1;
        $thread=$this->loadModel('Thread');
        $threadCount=$thread->getThreadCount();
        $page=$this->loadModel('Page',
            array(20,$pageNow,$threadCount,'/postBar/index.php/Home/Index?','pageblock','pageblock_now',5));
        $result=$thread->getThreadPage($page);
        $this->assign('thread',$result);
        $this->assign('threadCount',$threadCount);
        $this->assign('pageBar',$page->showPageBar());

        $user=$this->loadModel('User');
        $user->tryKeepLogin();
        if(isset($_SESSION['userId'])){
            $result=$user->getUserMessage($_SESSION['userId']);
            $this->assign('isLogin',1);
        }
        else
            $result=array('username'=>'游客','uid'=>0);
        $userCount=$user->userCount();
        $this->assign('userMess',$result);
        $this->assign('userCount',$userCount);

        $post=$this->loadModel("Post");
        $postCount=$post->getPostCount();
        $this->assign('postCount',$postCount);

        $url=curPageURL();
        setcookie('previous',$url,0,'/');
        $this->display('threadList');
    }
    public function addThread() {
        print_r($_POST);
        if(empty($_POST['subject'])||!trim($_POST['subject'])){
            echo '标题不能为空';
            exit;
        }
        $subject=$_POST['subject'];
        $content=trim($_POST['editorValue']);
        $thread=$this->loadModel('Thread');
        if(empty($_SESSION['userId'])){
            echo '用户未登陆';
            exit;
        }
        $userId=$_SESSION['userId'];
        $post=$this->loadModel('Post');
        $thread->addThread($subject,$content,$userId,$post);
        header("Location:http://{$_SERVER['SERVER_NAME']}/postBar/index.php");
    }
}