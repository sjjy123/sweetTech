        var showX = getElementLeft($Obj("datetime")) - 10;
        var showY = (window.navigator.userAgent.indexOf("MSIE") >=1 )? getElementTop($Obj("datetime")) + 30 :  getElementTop($Obj("datetime")) + 30;
        if((window.navigator.userAgent.indexOf("MSIE 7.0") >=1 )) {
            showX = getElementLeft($Obj("datetime"))+10;
            showY = getElementTop($Obj("datetime"))+30;
        }
        if(window.navigator.userAgent.indexOf("MSIE 6.0")>=1)
        {
            Calendar.setup({
                inputField     :    "datetime",
                ifFormat       :    "%Y-%m-%d %H:%M:%S",
                showsTime      :    true,
                timeFormat     :    "24"
            });
        } else {
            Calendar.setup({
                inputField     :    "datetime",
                ifFormat       :    "%Y-%m-%d %H:%M:%S",
                showsTime      :    true,
                position       :    [showX, showY],
                timeFormat     :    "24"
            });
        }
		
		