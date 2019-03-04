<script type="text/javascript" src="datejs/calendar.js"></script>
<script type="text/javascript" src="datejs/main.js"></script>
  <div style="margin:0 auto; width:600px;">
  
   <input name="pubdate" value="2011-04-06 09:18:31" type="text" id="pubdate" style="width:200px;"> 
	 <script language="javascript" type="text/javascript">
        var showX = getElementLeft($Obj("pubdate")) - 10;
        var showY = (window.navigator.userAgent.indexOf("MSIE") >=1 )? getElementTop($Obj("pubdate")) + 30 :  getElementTop($Obj("pubdate")) + 30;
        if((window.navigator.userAgent.indexOf("MSIE 7.0") >=1 )) {
            showX = getElementLeft($Obj("pubdate"))+10;
            showY = getElementTop($Obj("pubdate"))+30;
        }
        if(window.navigator.userAgent.indexOf("MSIE 6.0")>=1)
        {
            Calendar.setup({
                inputField     :    "pubdate",
                ifFormat       :    "%Y-%m-%d %H:%M:%S",
                showsTime      :    true,
                timeFormat     :    "24"
            });
        } else {
            Calendar.setup({
                inputField     :    "pubdate",
                ifFormat       :    "%Y-%m-%d %H:%M:%S",
                showsTime      :    true,
                position       :    [showX, showY],
                timeFormat     :    "24"
            });
        }
     </script> 
   </div>
