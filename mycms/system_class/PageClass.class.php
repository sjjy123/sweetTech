<style>
/**
 *---------------页面样式开始-----------------
 */

.pages {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px; float:right;
}
.pages li {
	display:inline;
	float: left;
	padding:0px 5px;
	height:21px;
	color:#2F969B;
	line-height:21px;
	margin-right: 0.3em;
	border: 1px solid #E0E0E0;
	background:#FFF;
}
.pages li span {
	color:#2F969B;
	background:#FFF;
}
.pages li.page_a {
	padding:0;
	border:0;
}
.pages li.page_a a {
	FLOAT: left;
	display: block;
	padding:0px 5px;
	color:#0044DD;
	border: 1px solid #E0E0E0;
}
.pages li.page_a a:hover {
	display: block;
	color:#0066FF;
	border: 1px solid #A0A0A0;
}
.pages li.pages_input {
	padding:0;
	border: 1px solid #A0A0A0; 
}
.pages li.pages_input input {
	width:18px;
	font-size:14px;
	border:0px;
	padding:0px 3px;
	margin:0px 3px;
	text-align:center;
}
.pages .on {
	padding:0px 5px;
	color: red;
	font-weight:bold;
}
.pages .page_clear {
	clear:both;
}
/**
 *------------------分页样式结束---------------------
 */

</style>
<?php
/**
 *-------------------------翻页类----------------------*
 */
class PageClass
{
	private $myde_count;       //总记录数
	var $myde_size;        //每页记录数
	private $myde_page;        //当前页
	private $myde_page_count;  //总页数
	private $page_url;         //页面url
	private $page_i;           //起始页
	private $page_ub;          //结束页
	var $page_limit;
	
	function __construct($myde_count=0, $myde_size=1, $myde_page=1,$page_url)//构造函数
	{	
		
		$this -> myde_count = $this -> numeric($myde_count);
		$this -> myde_size  = $this -> numeric($myde_size);
		$this -> myde_page  = $this -> numeric($myde_page);
		$this -> page_limit = ($this -> myde_page * $this -> myde_size) - $this -> myde_size; 
		
		$this -> page_url       = $page_url;
		
		if($this -> myde_page < 1) $this -> myde_page =1;
		
		if($this -> myde_count < 0) $this -> myde_page =0;
		
		$this -> myde_page_count  = ceil($this -> myde_count/$this -> myde_size);
		
		if($this -> myde_page_count < 1) $this -> myde_page_count = 1;
		
		if($this -> myde_page > $this -> myde_page_count) $this -> myde_page = $this -> myde_page_count;
		
		$this -> page_i = $this -> myde_page - 2;
		
        $this -> page_ub = $this -> myde_page + 2;
		
        if($this -> page_i < 1){
		
            $this -> page_ub = $this -> page_ub + (1 - $this -> page_i);
			
            $this -> page_i = 1;
        }
        
        if($this -> page_ub > $this -> myde_page_count){
		
            $this -> page_i = $this -> page_i - ($this -> page_ub - $this -> myde_page_count);
			
            $this -> page_ub = $this -> myde_page_count;
			
            if($this -> page_i < 1) $this -> page_i = 1;
        }
	}
	
	
	private function numeric($id) //判断是否为数字
	{
		if (strlen($id)){
    		if (!preg_match("/^[0-9]+$/",$id)){
				$id = 1;
    		}else{
				$id = substr($id,0,11);
 			}
		}else{
			$id = 1;
		}
		return $id;
	}
	
	private function page_replace($page) //地址替换
	{
		return str_replace("{page}", $page, $this -> page_url);
	}
	
	
	private function myde_home() //首页
	{
		if($this -> myde_page != 1){
		
			return "    <li class=\"page_a\"><a href=\"".$this -> page_replace(1)."\"  title=\"首页\" >首页</a></li>\n";
			
		}else{
		
			return "    <li>首页</li>\n";
			
		}
	}
	
	private function myde_prev() //上一页
	{
		if($this -> myde_page != 1){
		
			return "    <li class=\"page_a\"><a href=\"".$this -> page_replace($this->myde_page-1) ."\"  title=\"上一页\" >上一页</a></li>\n";
			
		}else{
		
			return "    <li>上一页</li>\n";
			
		}
	}
	
	private function myde_next() //下一页
	{
		if($this -> myde_page != $this -> myde_page_count){
		
				return "    <li class=\"page_a\"><a href=\"".$this -> page_replace($this->myde_page+1) ."\"  title=\"下一页\" >下一页</a></li>\n";
				
		}else{
		
			return "    <li>下一页</li>\n";
			
		}
	}
	
	private function myde_last() //尾页
	{
		if($this -> myde_page != $this -> myde_page_count){
		
				return "    <li class=\"page_a\"><a href=\"".$this -> page_replace($this -> myde_page_count)."\"  title=\"尾页\" >尾页</a></li>\n";
				
		}else{
		
			return "    <li>尾页</li>\n";
			
		}
	}
	
	function myde_write($id='page') //输出
	{
		$str  = "<div id=\"".$id."\" class=\"pages\">\n  <ul>\n  ";
		
		$str .= "  <li>总记录:<span>".$this -> myde_count."</span></li>\n";
		
		$str .= "    <li><span>".$this -> myde_page."</span>/<span>".$this -> myde_page_count."</span></li>\n";
		
		$str .= $this -> myde_home();
		
		$str .= $this -> myde_prev();
		
		for($page_for_i = $this -> page_i;$page_for_i <= $this -> page_ub; $page_for_i++){
		
			if($this -> myde_page == $page_for_i){
			
            	$str .= "    <li class=\"on\">".$page_for_i."</li>\n";
				
			}
			
			else{
			
				$str .= "    <li class=\"page_a\"><a href=\"".$this -> page_replace($page_for_i)."\" title=\"第".$page_for_i."页\">";
				
				$str .= $page_for_i . "</a></li>\n";
				
			}
        }
		$str .= $this -> myde_next();
		
		$str .= $this -> myde_last();
		
		//$str .= "    <li class=\"pages_input\"><input type=\"text\" value=\"".$this -> myde_page."\"";
		
		//$str .= " onkeydown=\"javascript: if(event.keyCode==13){ location='";
		
		//$str .= $this -> page_replace("'+this.value+'")."';return false;}\"";
		
		//$str .= " title=\"输入您想要到达的页码\" /></li>\n";
		
		$str .= "  </ul>\n  <div class=\"page_clear\"></div>\n</div>";
		
		return $str;
	}
}
/*-------------------------实例--------------------------------*
$page = new PageClass(1000,5,$_GET['page'],'?page={page}');//用于动态
$page = new PageClass(1000,5,$_GET['page'],'list-{page}.html');//用于静态或者伪静态
$page -> myde_write();//显示
*/
?>