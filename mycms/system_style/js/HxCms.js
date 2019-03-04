//function hideinfo()
//{ 
//   if(event.srcElement.tagName=="A")
//   {//如果触发函数的对象是链接 
//    //设置状态栏的显示为链接的文本 
//     window.status="HxCms"; 
//    } 
//   } 
//document.onmouseover=hideinfo           //鼠标移上时调用 hideinfo 函数 
//document.onmousemove=hideinfo          //鼠标移动时调用 hideinfo 函数 
//document.onmousedown=hideinfo         //鼠标按下时调用 hideinfo 函数 
//

var trIndex = 0;
var tmpIndex = 0;
function addItem(strname,strlength) {
		//var trIndex = 0;
		var tmpIndex = 0;
    trIndex++;
    tmpIndex++;
    var containerObj = document.getElementById("container"+strname);
    var tr = containerObj.insertRow(trIndex);
    var td = tr.insertCell(0);
    str = strname + String(trIndex);
	temp="<span style=\"vertical-align:middle\"><iframe src=\"../system_include/upload.php?fieldname="+ str +"&fieldout=9\" width=\"310\" height=\"25\" scrolling=\"no\" marginwidth=\"0\" framespacing=\"0\" marginheight=\"0\" frameborder=\"0\"></iframe></span>";
    td.innerHTML = "<input id=\""+str+"\" name=\""+strname+"[]\" type=\"text\" style=\"width:"+strlength+"px\"> "+ temp + " <input name=\"del\" type=\"button\" value=\"删除\" onclick=\"delItem('"+strname+"',"+String(trIndex)+");\"> ";   

}

function delItem(strname,trnum) {
    var containerObj = document.getElementById("container"+strname);
    var tr = containerObj.deleteRow(trnum);
    trIndex--;
}
/*下面是日历控件调用的JS*/
document.write('<script type="text/javascript" src="../system_style/datejs/calendar.js"></script>')
document.write('<script type="text/javascript" src="../system_style/datejs/main.js"></script>')
