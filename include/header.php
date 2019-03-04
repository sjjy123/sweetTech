<?php
define('INIT_XMALL',true);
session_start();
include_once("config/conn.php");

$product_cate = cms_Get_SidClass(94);//产品分类
?>
<div class="head pr"> <s class="pa shadow"></s>
    <div class="wrap fix">
        <div class="tr head_top">
            <div class="dib sele mob">

            </div>
            <div class="dib log">

            </div>
            <div class="dib log">

            </div>
            <div class="dib head_f">
                <form name="searchform" id="searchform" method="post" action="search.php">
                    <input type="text" class="inp" name="search" id="s" value="站内搜索"/>
                    <input type="button" name="toptosearch" id="toptosearch" value=" " title="搜索" class="btn" />
                    <script type="text/javascript">
                        $("#toptosearch").click(function(){$("#searchform").submit();});
                        $("#s").focus(function(){if($.trim($("#s").val())=='站内搜索'){$("#s").val("");}});
                        $("#s").blur(function(){if($.trim($("#s").val())==''){$("#s").val("站内搜索");}});
                    </script>
                </form>
            </div>
        </div>
        <h1 class="l logo"><a href="index.php" title="博霏科生物"><img src="images/logo.png" alt="博霏科生物" width="220" height="70" /></a></h1>
        <div class="r nav pr">
            <ul>
                <li class="li" data-name="about" id="top101"><a href="about.php"  class="nav_cell">走进博霏科</a>
                    <div class="nav_lev2 nav_lev2_6 navtoplev1"> <s class="pa shadow"></s>
                        <div class="l percent30 nav_menu">
                            <ul class="p20">
                                <li><a href="about.php?cid=57">关于我们</a></li>
                                <li><a href="about.php?cid=113">企业文化</a></li>
                                <li><a href="about.php?cid=118">荣誉资质</a></li>
                            </ul>
                        </div>

                    </div>
                </li>
                <li class="li" data-name="news" id="top102"><a href="news.php"  class="nav_cell">新闻中心</a>
                    <div class="nav_lev2 nav_lev2_2 navtoplev2"> <s class="pa shadow"></s>
                        <div class="l percent30 nav_menu">
                            <ul class="p20">
                                <li><a href="news.php？cid=2">行业动态</a></li>
                                <li><a href="news.php？cid=5"> 产品新闻</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="li" data-name="product" id="top103"><a href="products.php" class="nav_cell">产品中心</a>
                    <div class="nav_lev2 nav_lev2_3 navtoplev3"> <s class="pa shadow"></s>
                        <div class="l percent30 nav_menu">
                            <ul class="p20">
                                <?php for($i=0;$i < count($product_cate);$i++){?>
                                <li><a href="products.php?cid=<?php echo $product_cate[$i]['ID'];?>" ><?php echo $product_cate[$i]['ClassName'];?></a></li>
                                <?php }?>
                            </ul>
                        </div>

                    </div>
                </li>
                <li class="li" data-name="career" id="top104"><a href="career.php"  class="nav_cell">求贤纳才</a>
                    <div class="nav_lev2 nav_lev2_6 navtoplev4"> <s class="pa shadow"></s>
                        <div class="l percent30 nav_menu">
                            <ul class="p20">
                                <li><a href="career.php">人才理念</a></li>
                                <li><a href="jobs.php">招聘职位</a></li>
                            </ul>
                        </div>

                    </div>
                </li>
                <li class="li" data-name="service" id="top105"><a href="service.php" class="nav_cell">客户服务</a>
                    <div class="nav_lev2 nav_lev2_5 navtoplev5"> <s class="pa shadow"></s>
                        <div class="l percent30 nav_menu">
                            <ul class="p20">
                                <li><a href="service.php">服务理念</a></li>
                                <li><a href="qa.php">问题解答</a></li>
                            </ul>
                        </div>

                    </div>
                </li>
                <li class="li" data-name="contact" id="top106"><a href="contact.php" class="nav_cell">联系我们</a>
                    <div class="nav_lev2 nav_lev2_6 navtoplev6"> <s class="pa shadow"></s>
                        <div class="l percent30 nav_menu">
                            <ul class="p20">
                                <li><a href="contact.php">联系方式</a></li>
                                <li><a href="feedback.php">在线留言</a></li>
                            </ul>
                        </div>

                    </div>
                </li>

            </ul>
            <div class="pa nav_block">
                <div class="pa nav_line"></div>
            </div>
        </div>
    </div>
    <div class="pa head_block">
        <div class="pa head_line"></div>
    </div>
</div>
<script type="text/javascript">
    $(".nav .li[data-name='']").addClass('cur');
</script>