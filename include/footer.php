<?php
define('INIT_XMALL',true);
session_start();
include_once("config/conn.php");

$rights = cms_GetConfig(1);

?>
<div class="foot">
    <div class="wrap foot_c">
        <div class="oh foot_menu_wrap">
            <dl class="l foot_menu">
                <dt><a href="about.php"><em class="f_ico_1"></em>走进博霏科</a></dt>

            </dl>
            <dl class="l foot_menu">
                <dt><a href="news.php"><em class="f_ico_2"></em>新闻中心</a></dt>

            </dl>
            <dl class="l foot_menu">
                <dt><a href="products.php"><em class="f_ico_3"></em>产品中心</a></dt>

            </dl>
            <dl class="l foot_menu">
                <dt><a href="career.php"><em class="f_ico_6"></em>求贤纳才</a></dt>

            </dl>
            <dl class="l foot_menu">
                <dt><a href="service.php"><em class="f_ico_5"></em>客户服务</a></dt>

            </dl>
            <dl class="l foot_menu">
                <dt><a href="contact.php"><em class="f_ico_7"></em>联系我们</a></dt>
            </dl>
        </div>
    </div>
    <div class="foot_last">
        <div class="wrap">
            <div class="r">友情链接：
                <select id="frLinks">
                    <option value="">--请选择--</option>
                    <option value="http://www.aconlabs.com/default.html">Aconlabs</option><option value="http://www.adicon.com.cn/">Adicon</option><option value="http://www.acondiabetescare.com.cn/">血糖网站</option></select>
            </div>
            <div class="foot_last_c">版权所有(C) 2017 博霏科生物科技（杭州）有限公司&nbsp;&nbsp; <a href="#" rel="nofollow">浙ICP备05049929号</a>  </div>
        </div>
    </div>
</div>