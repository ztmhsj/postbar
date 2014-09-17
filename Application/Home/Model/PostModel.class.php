<?php

class Post extends Model{
    public function getPost($tid){
        $tid=$this->real_escape_string($tid);
        $sql="select * from vpost where tid=$tid order by time asc";
        $result=$this->execute_dql($sql);
        foreach($result as &$value){
           $re_result=$this->getF_Reply($value['reply_id']);
            if(!empty($re_result))
                $value['f_reply']=$re_result;
        }
        return $result;
    }

    public function getPostCount(){
        $sql="select count(1) as count from post";
        $resutl=$this->execute_dql($sql);
        return $resutl[0]['count'];
    }

    public function getPostPage(Page $pageserver,$tid){
        $tid=$this->real_escape_string($tid);
        $pageSize=$pageserver->getPageSize();
        $pageNow=$pageserver->getPageNow();
        $sql="select *,from_unixtime(public_time,'%Y-%m-%d %h:%i') as time from vpost where tid=$tid order by time asc
         limit ".($pageSize*($pageNow-1)).",".$pageSize;
        $result=$this->execute_dql($sql);
        foreach($result as &$value){
            $re_result=$this->getReply($value['pid']);
            if(!empty($re_result))
                $value['reply']=$re_result;
        }
        return $result;
    }
    public function getPostCountById($tid){
        $tid=$this->real_escape_string($tid);
        $sql="select count(1) as count from post where tid=$tid";
        $result=$this->execute_dql($sql);
        return $result[0]['count'];
    }
    private function getReply($pid){
        $pid=$this->real_escape_string($pid);
        $sql="select *,from_unixtime(public_time,'%y-%m-%d %h:%i') as time from vreply
         where pid=$pid order by time asc";
        $result=$this->execute_dql($sql);
        return $result;
    }
    public function addPost($tid,$userId,$content){
        $sql="insert into post (tid,uid,content,public_time)
        values ($tid,$userId,'$content',".time().")";
        $this->execute_dml($sql);
        $sql='update thread set lastime='.time().",post_count=post_count+1 where tid=$tid";
        $this->execute_dml($sql);
    }
    public function addReply($pid,$content,$uid,$tid){
        $pid=$this->real_escape_string($pid);
        $content=$this->real_escape_string($content);
        $uid=$this->real_escape_string($uid);
        $sql="insert into reply (pid,uid,content,public_time)
        values ($pid,$uid,\"$content\",".time().")";
        $this->execute_dml($sql);
        $sql='update thread set lastime='.time().",post_count=post_count+1 where tid=$tid";
        $this->execute_dml($sql);
    }
}
