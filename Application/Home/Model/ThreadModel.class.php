<?php
class Thread extends Model {
    public function getThreadPage(Page $pageserver){
        $pageSize=$pageserver->getPageSize();
        $pageNow=$pageserver->getPageNow();
        $sql="select *,from_unixtime(lastime,'%m-%d %h:%i')
         as time from vthread order by lastime desc".
        " limit ".($pageSize*($pageNow-1)).",".$pageSize ;
        return $result=$this->execute_dql($sql);
    }
    public function getThreadCount() {
        $sql="select count(1) as count from thread";
        $result=$this->execute_dql($sql);
        return $result[0]['count'];
    }
    public function addThread($subject,$content,$userId,$post){
        $subject=$this->real_escape_string($subject);
        $subject=str_replace('/<.+>/','',$subject);
        $sql="insert into thread (subject,uid)
        values (\"$subject\",$userId)";
        $this->execute_dml($sql);
        $tid=$this->insert_id;
        $post->addPost($tid,$userId,$content);
    }
};
?>