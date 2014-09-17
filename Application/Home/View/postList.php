<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>欢迎来到贴吧</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="/postBar/Public/Css/postList.css"/>
</head>
<body>
<script src="/postBar/Public/Js/postList.js" type="text/javascript">
</script>
<div id="contianer">
    <div id="head">
        <?php
            if(!isset($_SESSION['userId']))
            echo '<div id="user"><span><a href="/postBar/index.php/Home/Login">登陆</a>
             | <a href="/postBar/index.php/Home/Register">注册</a></span></div>';
        else{
            echo "<div id='user'><span><a class='userbar' href='#'>{$_SESSION['userName']}</a>";
            echo " | <a class='userbar' href='/postBar/index.php/Home/Login/logout'>退出</a></span></div>";
        }
        ?>
            <div id="intruduction">
                <a href="/postBar/index.php"> <img src="/postBar/Public/Image/Material/01.gif" /></a>
                <p id="count">test</p>
            </div>
        <div id="meum">
                <a href="/postBar/index.php" class="inmeum">看贴</a><a href="#" class="inmeum">精品</a>
        </div>
    </div>
    <div id="main">
        <?php
        $var=0;
        $rnum=0;
        foreach($post as $value) { ?>
        <div class="reply">
            <div class="user"><img src="/postBar/Public/Image/Icon/<?php echo isset($value['icon'])&&$value['icon']?$value['uid']:'default';?>.png">
            <div><a><?php echo $value['username'];?></a></div></div>
            <div class="reply-content">
                <div class="main-reply"><?php echo $value['content'];?></div>
                <div class="control"><?php
                    if(isset($_SESSION['userName'])&&$value['username']==$_SESSION['userName'])
                    echo '<a>删除</a><span>';?> <?php echo $postNum++; ?> 楼</span>
                    <span><?php echo $value['time'];?></span><a class="con-re" onclick="displyf(<?php echo $var;?>)">回复
                        <?php echo isset($value['reply'])?count($value['reply']):'';?></a></div>
                <div class="f-reply">
                    <div class="f-reply-content" style="display:block">
                        <div class="f-reply-div">
                            <?php
                            if(isset($value['reply'])){
                            foreach($value['reply'] as $fr) { ?>
                        <div class="fr-div">
                            <img src="/postBar/Public/Image/Icon/<?php echo isset($fr['icon'])&&$fr['icon']?$fr['uid']:'default';?>.png"
                                 class="f-head"/>
                            <div class="fr-content">
                                <?php echo "<a href='#' class='freplyName'>{$fr['username']}</a>:".$fr['content'];?>
                            </div>
                            <div class="fr-control">
                                <span><?php $fr['time'];?>
                                </span><a onclick="tofReply(<?php echo "$rnum,$var";?>)"> 回复 </a>
                            </div>
                        </div>

                            <?php
                             $rnum++;}
                            if(isset($value['reply'])){
                            ?>
                        <div class="wc"><a class="wca" onclick="disply_text(<?php echo $var;?>)">我也插一句</a></div>
                        <div style="clear:both;"></div>
                            <?php
                            }
                            } ?>
                        </div>
                    </div>
                    <div class="f-istream" style="display:none">
                        <form action="/postBar/index.php/Home/Post/addReply" method="post" onsubmit="return checkFReply(<?php echo $var;?>)">
                            <textarea name="reply" class="text"></textarea>
                            <input type="hidden" name="pid" value="<?php echo $value['pid'];?>"/>
                            <input type="hidden" name="tid" value="<?php echo $value['tid'];?>"/>
                            <?php if(isset($_SESSION['userId'])){ ?>
                                <input type="submit" value="发表"/>
                            <?php }else{ ?>
                                <input type="submit" value="发表" disabled="disabled"  />
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
       <?php
            $var++;
        }?>
    </div>
    <div id="page">
        <?php echo $pageBar;?>
    </div>
    <div id="istream">
        <form action="/postBar/index.php/Home/Post/addPost" method="post" onsubmit="return checkReply()"/>
            <table>
                <?php if(isset($_SESSION['userId'])){ ?>
                <tr><td>发表回复:</td></tr>
                <?php }else{ ?>
                <tr><td>发表话题前请登录:</td></tr>
                <?php } ?>
                <tr><td><div id="public">
                            <?php
                            require ("{$_SERVER['DOCUMENT_ROOT']}/postBar/Public/Umeditor/index.html");?>
                </div></td></tr>
                <tr><td><input type="text" id="verifyt" maxlength="4" name="verify"/><img src="/postBar/Public/Image/n1.gif" id="verifyi"></td></tr>
                <tr><td>
                        <?php if(isset($_SESSION['userId'])){ ?>
                            <input type="submit" value="发帖"/>
                        <?php }else{ ?>
                            <input type="submit" value="发帖" disabled="disabled"  />
                        <?php } ?>
                    </td></tr>
            </table>
        <input type="hidden" name="tid" value="<?php echo $_GET['tid'];?>"/>
        </form>
    </div>
</div>
</body>
</html>
