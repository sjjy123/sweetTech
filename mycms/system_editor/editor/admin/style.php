<?php
/*
*######################################
* eWebEditor v5.5 - Advanced online web based WYSIWYG HTML editor.
* Copyright (c) 2003-2008 eWebSoft.com
*
* For further information go to http://www.ewebsoft.com/
* This copyright notice MUST stay intact for use.
*######################################
*/
require("private.php");
$sPosition = $sPosition."��ʽ����";
if ($sAction == "STYLEPREVIEW"){
InitStyle();
ShowStylePreview();
exit;}
eWebEditor_Header();
ShowPosition();
eWebEditor_Content();
eWebEditor_Footer();
function eWebEditor_Content(){
switch ($GLOBALS["sAction"]){
case "UPDATECONFIG":
DoUpdateConfig();
break;
case "COPY":
InitStyle();
DoCopy();
ShowStyleList();
break;
case "STYLEADD":
ShowStyleForm("ADD");
break;
case "STYLESET":
InitStyle();
ShowStyleForm("SET");
break;
case "STYLEADDSAVE":
CheckStyleForm();
DoStyleAddSave();
break;
case "STYLESETSAVE":
CheckStyleForm();
DoStyleSetSave();
break;
case "STYLEDEL":
InitStyle();
DoStyleDel();
ShowStyleList();
break;
case "CODE":
InitStyle();
ShowStyleCode();
break;
case "TOOLBAR":
InitStyle();
ShowToolBarList();
break;
case "TOOLBARADD":
InitStyle();
DoToolBarAdd();
ShowToolBarList();
break;
case "TOOLBARMODI":
InitStyle();
DoToolBarModi();
ShowToolBarList();
break;
case "TOOLBARDEL":
InitStyle();
DoToolBarDel();
ShowToolBarList();
break;
case "BUTTONSET":
InitStyle();
InitToolBar();
ShowButtonList();
break;
case "BUTTONSAVE":
InitStyle();
InitToolBar();
DoButtonSave();
break;
default:
ShowStyleList();
break;}}
function ShowPosition(){
echo "<table border=0 cellspacing=1 align=center class=navi>".
"<tr><th>".$GLOBALS["sPosition"]."</th></tr>".
"<tr><td align=center>[<a href='?'>������ʽ�б�</a>]&nbsp;&nbsp;&nbsp;&nbsp;[<a href='?action=styleadd'>�½�һ��ʽ</a>]&nbsp;&nbsp;&nbsp;&nbsp;[<a href='?action=updateconfig'>����������ʽ��ǰ̨�����ļ�</a>]&nbsp;&nbsp;&nbsp;&nbsp;[<a href='#' onclick='history.back()'>����ǰһҳ</a>]</td></tr>".
"</table><br>";}
function ShowMessage($str){
echo "<table border=0 cellspacing=1 align=center class=list><tr><td>".$str."</td></tr></table><br>";}
function ShowStyleList(){
ShowMessage("<b class=blue>����Ϊ��ǰ������ʽ�б�</b>");
echo "<table border=0 cellpadding=0 cellspacing=1 class=list align=center>".
"<form action='?action=del' method=post name=myform>".
"<tr align=center>".
"<th width='10%'>��ʽ��</th>".
"<th width='10%'>��ѿ��</th>".
"<th width='10%'>��Ѹ߶�</th>".
"<th width='45%'>˵��</th>".
"<th width='25%'>����</th>".
"</tr>";
for ($i=1;$i<=count($GLOBALS["aStyle"]);$i++){
$aCurrStyle = explode("|||", $GLOBALS["aStyle"][$i]);
$sManage = "<a href='?action=stylepreview&id=".$i."' target='_blank'>Ԥ��</a>|<a href='?action=code&id=".$i."'>����</a>|<a href='?action=styleset&id=".$i."'>����</a>|<a href='?action=toolbar&id=".$i."'>������</a>|<a href='?action=copy&id=".$i."'>����</a>|<a href='?action=styledel&id=".$i."' onclick=\"return confirm('��ʾ����ȷ��Ҫɾ������ʽ��')\">ɾ��</a>";
echo "<tr align=center>".
"<td>".htmlspecialchars($aCurrStyle[0])."</td>".
"<td>".$aCurrStyle[4]."</td>".
"<td>".$aCurrStyle[5]."</td>".
"<td align=left>".htmlspecialchars($aCurrStyle[26])."</td>".
"<td>".$sManage."</td>".
"</tr>";}
echo "</table><br>";
ShowMessage("<b class=blue>��ʾ��</b>�����ͨ����������һ��ʽ�Դﵽ�����½���ʽ��Ŀ�ġ�");}
function DoCopy(){
$b = false;
$i = 0;
while ($b == false){
$i = $i + 1;
$sNewName = $GLOBALS["sStyleName"].$i;
if (StyleName2ID($sNewName) == -1) {
$b = true;}}
$nNewStyleID = count($GLOBALS["aStyle"]) + 1;
$GLOBALS["aStyle"][$nNewStyleID] = $sNewName.substr($GLOBALS["aStyle"][$GLOBALS["nStyleID"]], strlen($GLOBALS["sStyleName"]));
$nToolbarNum = count($GLOBALS["aToolbar"]);
for ($i=1;$i<=$nToolbarNum;$i++){
$aCurrToolbar = explode("|||", $GLOBALS["aToolbar"][$i]);
if ($aCurrToolbar[0] == $GLOBALS["sStyleID"]) {
$nNewToolbarID = count($GLOBALS["aToolbar"]) + 1;
$GLOBALS["aToolbar"][$nNewToolbarID] = $nNewStyleID."|||".$aCurrToolbar[1]."|||".$aCurrToolbar[2]."|||".$aCurrToolbar[3];}}
WriteConfig();
WriteStyle($nNewStyleID);
GoUrl("?");}
function StyleName2ID($str){
for ($i=1;$i<=count($GLOBALS["aStyle"]);$i++){
$aTemp = explode("|||", $GLOBALS["aStyle"][$i]);
if (strtolower($aTemp[0]) == strtolower($str)){
return $i;}}
return -1;}
function ShowStyleForm($sFlag){
if ($sFlag == "ADD"){
$GLOBALS["sStyleID"] = "";
$GLOBALS["sStyleName"] = "";
$GLOBALS["sFixWidth"] = "";
$GLOBALS["sSkin"] = "office2003";
$GLOBALS["sStyleUploadDir"] = "uploadfile/";
$GLOBALS["sStyleBaseHref"] = "";
$GLOBALS["sStyleContentPath"] = "";
$GLOBALS["sStyleWidth"] = "550";
$GLOBALS["sStyleHeight"] = "350";
$GLOBALS["sStyleMemo"] = "";
$GLOBALS["nStyleIsSys"] = 0;
$s_Title = "������ʽ";
$s_Action = "StyleAddSave";
$GLOBALS["sStyleFileExt"] = "rar|zip|exe|doc|xls|chm|hlp";
$GLOBALS["sStyleFlashExt"] = "swf";
$GLOBALS["sStyleImageExt"] = "gif|jpg|jpeg|bmp";
$GLOBALS["sStyleMediaExt"] = "rm|mp3|wav|mid|midi|ra|avi|mpg|mpeg|asf|asx|wma|mov";
$GLOBALS["sStyleRemoteExt"] = "gif|jpg|bmp";
$GLOBALS["sStyleFileSize"] = "500";
$GLOBALS["sStyleFlashSize"] = "100";
$GLOBALS["sStyleImageSize"] = "100";
$GLOBALS["sStyleMediaSize"] = "100";
$GLOBALS["sStyleRemoteSize"] = "100";
$GLOBALS["sStyleStateFlag"] = "1";
$GLOBALS["sSBCode"] = "1";
$GLOBALS["sSBEdit"] = "1";
$GLOBALS["sSBText"] = "1";
$GLOBALS["sSBView"] = "1";
$GLOBALS["sEnterMode"] = "1";
$GLOBALS["sAreaCssMode"] = "0";
$GLOBALS["sStyleAutoRemote"] = "1";
$GLOBALS["sStyleShowBorder"] = "0";
$GLOBALS["sStyleAllowBrowse"] = "0";
$GLOBALS["sStyleUploadObject"] = "0";
$GLOBALS["sStyleAutoDir"] = "0";
$GLOBALS["sStyleDetectFromWord"] = "1";
$GLOBALS["sStyleInitMode"] = "EDIT";
$GLOBALS["sStyleBaseUrl"] = "1";
$GLOBALS["sSLTFlag"] = "0";
$GLOBALS["sSLTMinSize"] = "300";
$GLOBALS["sSLTOkSize"] = "120";
$GLOBALS["sSYWZFlag"] = "0";
$GLOBALS["sSYText"] = "��Ȩ����...";
$GLOBALS["sSYFontColor"] = "000000";
$GLOBALS["sSYFontSize"] = "12";
$GLOBALS["sSYFontName"] = "";
$GLOBALS["sSYPicPath"] = "";
$GLOBALS["sSLTSYObject"] = "0";
$GLOBALS["sSLTSYExt"] = "bmp|jpg|jpeg|gif";
$GLOBALS["sSYWZMinWidth"] = "100";
$GLOBALS["sSYShadowColor"] = "FFFFFF";
$GLOBALS["sSYShadowOffset"] = "1";
$GLOBALS["sStyleLocalExt"] = "gif|jpg|bmp|wmz";
$GLOBALS["sStyleLocalSize"] = "100";
$GLOBALS["sSYWZMinHeight"] = "100";
$GLOBALS["sSYWZPosition"] = "1";
$GLOBALS["sSYWZTextWidth"] = "66";
$GLOBALS["sSYWZTextHeight"] = "17";
$GLOBALS["sSYWZPaddingH"] = "5";
$GLOBALS["sSYWZPaddingV"] = "5";
$GLOBALS["sSYTPFlag"] = "0";
$GLOBALS["sSYTPMinWidth"] = "100";
$GLOBALS["sSYTPMinHeight"] = "100";
$GLOBALS["sSYTPPosition"] = "1";
$GLOBALS["sSYTPPaddingH"] = "5";
$GLOBALS["sSYTPPaddingV"] = "5";
$GLOBALS["sSYTPImageWidth"] = "88";
$GLOBALS["sSYTPImageHeight"] = "31";
$GLOBALS["sSYTPOpacity"] = "1";
$GLOBALS["sCusDirFlag"] = "0";}else{
$GLOBALS["sStyleName"] = htmlspecialchars($GLOBALS["sStyleName"]);
$GLOBALS["sFixWidth"] = htmlspecialchars($GLOBALS["sFixWidth"]);
$GLOBALS["sSkin"] = htmlspecialchars($GLOBALS["sSkin"]);
$GLOBALS["sStyleUploadDir"] = htmlspecialchars($GLOBALS["sStyleUploadDir"]);
$GLOBALS["sStyleBaseHref"] = htmlspecialchars($GLOBALS["sStyleBaseHref"]);
$GLOBALS["sStyleContentPath"] = htmlspecialchars($GLOBALS["sStyleContentPath"]);
$GLOBALS["sStyleMemo"] = htmlspecialchars($GLOBALS["sStyleMemo"]);
$GLOBALS["sSYText"] = htmlspecialchars($GLOBALS["sSYText"]);
$GLOBALS["sSYFontColor"] = htmlspecialchars($GLOBALS["sSYFontColor"]);
$GLOBALS["sSYFontSize"] = htmlspecialchars($GLOBALS["sSYFontSize"]);
$GLOBALS["sSYFontName"] = htmlspecialchars($GLOBALS["sSYFontName"]);
$GLOBALS["sSYPicPath"] = htmlspecialchars($GLOBALS["sSYPicPath"]);
$s_Title = "������ʽ";
$s_Action = "StyleSetSave";}
$s_FormStateFlag = InitCheckBox("d_stateflag", "1", $GLOBALS["sStyleStateFlag"]);
$s_FormSBCode = InitCheckBox("d_sbcode", "1", $GLOBALS["sSBCode"]);
$s_FormSBEdit = InitCheckBox("d_sbedit", "1", $GLOBALS["sSBEdit"]);
$s_FormSBText = InitCheckBox("d_sbtext", "1", $GLOBALS["sSBText"]);
$s_FormSBView = InitCheckBox("d_sbview", "1", $GLOBALS["sSBView"]);
$s_FormEnterMode = InitSelect("d_entermode", explode("|", "Enter����<P>��Shift+Enter����<BR>|Enter����<BR>��Shift+Enter����<P>"), explode("|", "1|2"), $GLOBALS["sEnterMode"], "", "");
$s_FormAreaCssMode = InitSelect("d_entermode", explode("|", "����ģʽ|Word����ģʽ"), explode("|", "0|1"), $GLOBALS["sAreaCssMode"], "", "");
$s_FormAutoRemote = InitSelect("d_autoremote", explode("|", "�Զ��ϴ�|���Զ��ϴ�"), explode("|", "1|0"), $GLOBALS["sStyleAutoRemote"], "", "");
$s_FormShowBorder = InitSelect("d_showborder", explode("|", "Ĭ����ʾ|Ĭ�ϲ���ʾ"), explode("|", "1|0"), $GLOBALS["sStyleShowBorder"], "", "");
$s_FormAllowBrowse = InitSelect("d_allowbrowse", explode("|", "��,����|��,�ر�"), explode("|", "1|0"), $GLOBALS["sStyleAllowBrowse"], "", "");
$s_FormUploadObject = InitSelect("d_uploadobject", explode("|", "�Դ�"), explode("|", "0"), $GLOBALS["sStyleUploadObject"], "", "");
$s_FormAutoDir = InitSelect("d_autodir", explode("|", "��ʹ��|��Ŀ¼|����Ŀ¼|������Ŀ¼"), explode("|", "0|1|2|3"), $GLOBALS["sStyleAutoDir"], "", "");
$s_FormDetectFromWord = InitSelect("d_detectfromword", explode("|", "�Զ��������ʾ|���Զ����"), explode("|", "1|0"), $GLOBALS["sStyleDetectFromWord"], "", "");
$s_FormInitMode = InitSelect("d_initmode", explode("|", "����ģʽ|�༭ģʽ|�ı�ģʽ|Ԥ��ģʽ"), explode("|", "CODE|EDIT|TEXT|VIEW"), $GLOBALS["sStyleInitMode"], "", "");
$s_FormBaseUrl = InitSelect("d_baseurl", explode("|", "���·��|���Ը�·��|����ȫ·��|վ�����ȫ·��"), explode("|", "0|1|2|3"), $GLOBALS["sStyleBaseUrl"], "", "");
$s_FormSLTFlag = InitSelect("d_sltflag", explode("|", "ʹ��|��ʹ��"), explode("|", "1|0"), $GLOBALS["sSLTFlag"], "", "");
$s_FormSYWZFlag = InitSelect("d_sywzflag", explode("|", "��ʹ��|ʹ��|ǰ̨�û�����"), explode("|", "0|1|2"), $GLOBALS["sSYWZFlag"], "", "");
$s_FormSLTSYObject = InitSelect("d_sltsyobject", explode("|", "PHP GD2ͼ�ο�"), explode("|", "0"), $GLOBALS["sSLTSYObject"], "", "");
$s_FormSYTPFlag = InitSelect("d_sytpflag", explode("|", "��ʹ��|ʹ��|ǰ̨�û�����"), explode("|", "0|1|2"), $GLOBALS["sSYTPFlag"], "", "");
$s_FormSYWZPosition = InitSelect("d_sywzposition", explode("|", "����|����|����|����|����|����|����|����|����"), explode("|", "1|2|3|4|5|6|7|8|9"), $GLOBALS["sSYWZPosition"], "", "");
$s_FormSYTPPosition = InitSelect("d_sytpposition", explode("|", "����|����|����|����|����|����|����|����|����"), explode("|", "1|2|3|4|5|6|7|8|9"), $GLOBALS["sSYTPPosition"], "", "");
$s_FormCusDirFlag = InitSelect("d_cusdirflag", explode("|", "����|����"), explode("|", "0|1"), $GLOBALS["sCusDirFlag"], "", "");
echo "<table border=0 cellpadding=0 cellspacing=1 align=center class=form>".
"<form action='?action=".$s_Action."&id=".$GLOBALS["sStyleID"]."' method=post name=myform onsubmit='return checkStyleSetForm(this)'>".
"<tr><th colspan=4>&nbsp;&nbsp;".$s_Title."������Ƶ������ɿ�˵������*��Ϊ�����</th></tr>".
"<tr><td width='15%'>��ʽ���ƣ�</td><td width='35%'><input type=text class=input size=20 name=d_name title='���ô���ʽ�����֣���Ҫ���������' value=\"".$GLOBALS["sStyleName"]."\"> <span class=red>*</span></td><td width='15%'>��ʼģʽ��</td><td width='35%'>".$s_FormInitMode." <span class=red>*</span></td></tr>".
"<tr><td width='15%'>�޿�ģʽ��ȣ�</td><td width='35%'><input type=text class=input size=20 name=d_fixwidth title='���ձ�ʾ�����ã����������磺500px' value=\"".$GLOBALS["sFixWidth"]."\"></td><td width='15%'>����Ƥ��Ŀ¼��</td><td width='35%'><input type=text class=input size=15 name=d_skin title='��Ž���Ƥ���ļ���Ŀ¼����������skin��' value=\"".$GLOBALS["sSkin"]."\"> <select size=1 id=d_skin_drop onchange='this.form.d_skin.value=this.value'><option>-ϵͳ�Դ�-</option><option value='blue1'>blue1</option><option value='blue2'>blue2</option><option value='green1'>green1</option><option value='light1'>light1</option><option value='office2000'>office2000</option><option value='office2003'>office2003</option><option value='officexp'>officexp</option><option value='red1'>red1</option><option value='vista1'>vista1</option><option value='yellow1'>yellow1</option></select> <span class=red>*</span></td></tr>".
"<tr><td width='15%'>��ѿ�ȣ�</td><td width='35%'><input type=text class=input name=d_width size=20 title='�������Ч���Ŀ�ȣ�������' value='".$GLOBALS["sStyleWidth"]."'> <span class=red>*</span></td><td width='15%'>��Ѹ߶ȣ�</td><td width='35%'><input type=text class=input name=d_height size=20 title='�������Ч���ĸ߶ȣ�������' value='".$GLOBALS["sStyleHeight"]."'> <span class=red>*</span></td></tr>".
"<tr><td width='15%'>��ʾ״̬������ť��</td><td width='35%'>".$s_FormStateFlag."״̬�� ".$s_FormSBCode."���� ".$s_FormSBEdit."�༭ ".$s_FormSBText."�ı� ".$s_FormSBView."Ԥ��<span class=red>*</span></td><td width='15%'>Wordճ����</td><td width='35%'>".$s_FormDetectFromWord." <span class=red>*</span></td></tr>".
"<tr><td width='15%'>Զ���ļ���</td><td width='35%'>".$s_FormAutoRemote." <span class=red>*</span></td><td width='15%'>ָ�����룺</td><td width='35%'>".$s_FormShowBorder." <span class=red>*</span></td></tr>".
"<tr><td width='15%'>�س�����ģʽ��</td><td width='35%'>".$s_FormEnterMode." <span class=red>*</span></td><td width='15%'>�༭��CSSģʽ��</td><td width='35%'>".$s_FormAreaCssMode." <span class=red>*</span></td></tr>".
"<tr><td>��ע˵����</td><td colspan=3><input type=text name=d_memo size=90 title='����ʽ��˵�����������ڵ���' value=\"".$GLOBALS["sStyleMemo"]."\"></td></tr>".
"<tr><td colspan=4><span class=red>&nbsp;&nbsp;&nbsp;�ϴ�������ã��������˵������û��ֲᣩ��</span></td></tr>".
"<tr><td width='15%'>�ϴ������</td><td width='35%'>".$s_FormUploadObject." <span class=red>*</span></td><td width='15%'>�������Զ�Ŀ¼��</td><td width='35%'>".$s_FormAutoDir." <span class=red>*</span></td></tr>".
"<tr><td width='15%'>�ϴ��ļ������</td><td width='35%'>".$s_FormAllowBrowse." <span class=red>*</span></td><td width='15%'>�Զ��ϴ�·���ӿڣ�</td><td width='35%'>".$s_FormCusDirFlag."</td></tr>".
"<tr><td width='15%'>·��ģʽ��</td><td width='35%'>".$s_FormBaseUrl." <span class=red>*</span> <a href='#baseurl'>˵��</a></td><td width='15%'>�ϴ�·����</td><td width='35%'><input type=text class=input size=20 name=d_uploaddir title='�ϴ��ļ������·�������eWebEditor��Ŀ¼�ļ���·��' value=\"".$GLOBALS["sStyleUploadDir"]."\"> <span class=red>*</span></td></tr>".
"<tr><td width='15%'>��ʾ·����</td><td width='35%'><input type=text class=input size=20 name=d_basehref title='��ʾ����ҳ�����·����������&quot;/&quot;��ͷ' value=\"".$GLOBALS["sStyleBaseHref"]."\"></td><td width='15%'>����·����</td><td width='35%'><input type=text class=input size=20 name=d_contentpath title='ʵ�ʱ����������е�·���������ʾ·����·����������&quot;/&quot;��ͷ' value=\"".$GLOBALS["sStyleContentPath"]."\"></td></tr>".
"<tr><td colspan=4><span class=red>&nbsp;&nbsp;&nbsp;�����ϴ��ļ����ͼ��ļ���С���ã��ļ���С��λΪKB��0��ʾ��������</span></td></tr>".
"<tr><td width='15%'>ͼƬ���ͣ�</td><td width='35%'><input type=text class=input name=d_imageext size=20 title='����ͼƬ��ص��ϴ�' value='".$GLOBALS["sStyleImageExt"]."'></td><td width='15%'>ͼƬ���ƣ�</td><td width='35%'><input type=text class=input name=d_imagesize size=20 title='�����ͣ���λKB' value='".$GLOBALS["sStyleImageSize"]."'></td></tr>".
"<tr><td width='15%'>Flash���ͣ�</td><td width='35%'><input type=text class=input name=d_flashext size=20 title='���ڲ���Flash����' value='".$GLOBALS["sStyleFlashExt"]."'></td><td width='15%'>Flash���ƣ�</td><td width='35%'><input type=text class=input name=d_flashsize size=20 title='�����ͣ���λKB' value='".$GLOBALS["sStyleFlashSize"]."'></td></tr>".
"<tr><td width='15%'>ý�����ͣ�</td><td width='35%'><input type=text class=input name=d_mediaext size=20 title='���ڲ���ý���ļ�' value='".$GLOBALS["sStyleMediaExt"]."'></td><td width='15%'>ý�����ƣ�</td><td width='35%'><input type=text class=input name=d_mediasize size=20 title='�����ͣ���λKB' value='".$GLOBALS["sStyleMediaSize"]."'></td></tr>".
"<tr><td width='15%'>�������ͣ�</td><td width='35%'><input type=text class=input name=d_fileext size=20 title='���ڲ��������ļ�' value='".$GLOBALS["sStyleFileExt"]."'></td><td width='15%'>�������ƣ�</td><td width='35%'><input type=text class=input name=d_filesize size=20 title='�����ͣ���λKB' value='".$GLOBALS["sStyleFileSize"]."'></td></tr>".
"<tr><td width='15%'>Զ�����ͣ�</td><td width='35%'><input type=text class=input name=d_remoteext size=20 title='�����Զ��ϴ�Զ���ļ�' value='".$GLOBALS["sStyleRemoteExt"]."'></td><td width='15%'>Զ�����ƣ�</td><td width='35%'><input type=text class=input name=d_remotesize size=20 title='�����ͣ���λKB' value='".$GLOBALS["sStyleRemoteSize"]."'></td></tr>".
"<tr><td width='15%'>�������ͣ�</td><td width='35%'><input type=text class=input name=d_localext size=20 title='�����Զ��ϴ������ļ�' value='".$GLOBALS["sStyleLocalExt"]."'></td><td width='15%'>�������ƣ�</td><td width='35%'><input type=text class=input name=d_localsize size=20 title='�����ͣ���λKB' value='".$GLOBALS["sStyleLocalSize"]."'>KB</td></tr>".
"<tr><td colspan=4><span class=red>&nbsp;&nbsp;&nbsp;����ͼ��ˮӡ������ã�</span></td></tr>".
"<tr><td width='15%'>ͼ�δ��������</td><td width='35%'>".$s_FormSLTSYObject."</td><td width='15%'>����ͼ����չ����</td><td width='35%'><input type=text name=d_sltsyext size=20 class=input value=\"".$GLOBALS["sSLTSYExt"]."\"></td></tr>".
"<tr><td width='15%'>����ͼʹ��״̬��</td><td width='35%'>".$s_FormSLTFlag."</td><td width='15%'>����ͼ��������</td><td width='35%'><input type=text name=d_sltminsize size=20 class=input title='ͼ�εĳ���ֻ�дﵽ����С����Ҫ��ʱ�Ż���������ͼ��������' value='".$GLOBALS["sSLTMinSize"]."'>px</td></tr>".
"<tr><td width='15%'>����ͼ���ɳ��ȣ�</td><td width='35%'><input type=text name=d_sltoksize size=20 class=input title='���ɵ�����ͼ����ֵ��������' value='".$GLOBALS["sSLTOkSize"]."'>px</td><td width='15%'>&nbsp;</td><td width='35%'>&nbsp;</td></tr>".
"<tr><td width='15%'>����ˮӡʹ��״̬��</td><td width='35%'>".$s_FormSYWZFlag."</td><td width='15%'>����ˮӡ����������</td><td width='35%'>��:<input type=text name=d_sywzminwidth size=4 class=input title='ͼ�εĿ��ֻ�дﵽ����С���Ҫ��ʱ�Ż�����ˮӡ��������' value='".$GLOBALS["sSYWZMinWidth"]."'>px&nbsp; ��:<input type=text name=d_sywzminheight size=4 class=input title='ͼ�εĸ߶�ֻ�дﵽ����С�߶�Ҫ��ʱ�Ż�����ˮӡ��������' value='".$GLOBALS["sSYWZMinHeight"]."'>px</td></tr>".
"<tr><td width='15%'>����ˮӡ���ݣ�</td><td width='35%'><input type=text name=d_sytext size=20 class=input title='��ʹ������ˮӡʱ����������' value=\"".$GLOBALS["sSYText"]."\"></td><td width='15%'>����ˮӡ������ɫ��</td><td width='35%'><input type=text name=d_syfontcolor size=20 class=input title='��ʹ������ˮӡʱ���ֵ���ɫ' value=\"".$GLOBALS["sSYFontColor"]."\"></td></tr>".
"<tr><td width='15%'>����ˮӡ��Ӱ��ɫ��</td><td width='35%'><input type=text name=d_syshadowcolor size=20 class=input title='��ʹ������ˮӡʱ��������Ӱ��ɫ' value=\"".$GLOBALS["sSYShadowColor"]."\"></td><td width='15%'>����ˮӡ��Ӱ��С��</td><td width='35%'><input type=text name=d_syshadowoffset size=20 class=input title='��ʹ������ˮӡʱ���ֵ���Ӱ��С' value=\"".$GLOBALS["sSYShadowOffset"]."\">px</td></tr>".
"<tr><td width='15%'>����ˮӡ�����С��</td><td width='35%'><input type=text name=d_syfontsize size=20 class=input title='��ʹ������ˮӡʱ���ֵ������С' value=\"".$GLOBALS["sSYFontSize"]."\">px</td><td width='15%'>��������⼰·����</td><td width='35%'><input type=text name=d_syfontname size=20 class=input title='��ʹ��������ʱ���������ļ���' value=\"".$GLOBALS["sSYFontName"]."\"> <a href='#fontname'>˵��</a></td></tr>".
"<tr><td width='15%'>����ˮӡλ�ã�</td><td width='35%'>".$s_FormSYWZPosition."</td><td width='15%'>����ˮӡ�߾ࣺ</td><td width='35%'>����:<input type=text name=d_sywzpaddingh size=4 class=input title='����ʱ����Ϊ��߾࣬����ʱ����Ϊ�ұ߾࣬������' value='".$GLOBALS["sSYWZPaddingH"]."'>px&nbsp; ����:<input type=text name=d_sywzpaddingv size=4 class=input title='����ʱ����Ϊ�ϱ߾࣬����ʱ����Ϊ�±߹�������' value='".$GLOBALS["sSYWZPaddingV"]."'>px</td></tr>".
"<tr><td width='15%'>����ˮӡ����ռλ��</td><td width='35%'>��:<input type=text name=d_sywztextwidth size=4 class=input title='ˮӡ���ֵ�ռλ��ȣ��������������С�����õ�Ч��ȷ����������' value='".$GLOBALS["sSYWZTextWidth"]."'>px&nbsp; ��:<input type=text name=d_sywztextheight size=4 class=input title='ˮӡ���ֵ�ռλ�߶ȣ��������������С�����õ�Ч��ȷ����������' value='".$GLOBALS["sSYWZTextHeight"]."'>px&nbsp; <input type=button value='�����' onclick='doCheckWH(1)'></td><td width='15%'></td><td width='35%'></td></tr>".
"<tr><td width='15%'>ͼƬˮӡʹ��״̬��</td><td width='35%'>".$s_FormSYTPFlag."</td><td width='15%'>ͼƬˮӡ����������</td><td width='35%'>��:<input type=text name=d_sytpminwidth size=4 class=input title='ͼ�εĿ��ֻ�дﵽ����С���Ҫ��ʱ�Ż�����ˮӡ��������' value='".$GLOBALS["sSYTPMinWidth"]."'>px&nbsp; ��:<input type=text name=d_sytpminheight size=4 class=input title='ͼ�εĸ߶�ֻ�дﵽ����С�߶�Ҫ��ʱ�Ż�����ˮӡ��������' value='".$GLOBALS["sSYTPMinHeight"]."'>px</td></tr>".
"<tr><td width='15%'>ͼƬˮӡλ�ã�</td><td width='35%'>".$s_FormSYTPPosition."</td><td width='15%'>ͼƬˮӡ�߾ࣺ</td><td width='35%'>����:<input type=text name=d_sytppaddingh size=4 class=input title='����ʱ����Ϊ��߾࣬����ʱ����Ϊ�ұ߾࣬������' value='".$GLOBALS["sSYTPPaddingH"]."'>px&nbsp; ����:<input type=text name=d_sytppaddingv size=4 class=input title='����ʱ����Ϊ�ϱ߾࣬����ʱ����Ϊ�±߹�������' value='".$GLOBALS["sSYTPPaddingV"]."'>px</td></tr>".
"<tr><td width='15%'>ͼƬˮӡͼƬ·����</td><td width='35%'><input type=text name=d_sypicpath size=20 class=input title='��ʹ��ͼƬˮӡʱͼƬ��·��' value=\"".$GLOBALS["sSYPicPath"]."\"></td><td width='15%'>ͼƬˮӡ͸���ȣ�</td><td width='35%'><input type=text name=d_sytpopacity size=20 class=input title='0��1������֣���0.5��ʾ��͸��' value=\"".$GLOBALS["sSYTPOpacity"]."\"></td></tr>".
"<tr><td width='15%'>ͼƬˮӡͼƬռλ��</td><td width='35%'>��:<input type=text name=d_sytpimagewidth size=4 class=input title='ˮӡͼƬ�Ŀ�ȣ�������' value='".$GLOBALS["sSYTPImageWidth"]."'>px&nbsp; ��:<input type=text name=d_sytpimageheight size=4 class=input title='ˮӡͼƬ�ĸ߶ȣ�������' value='".$GLOBALS["sSYTPImageHeight"]."'>px&nbsp; <input type=button value='�����' onclick='doCheckWH(2)'></td><td width='15%'></td><td width='35%'></td></tr>".
"<tr><td width='15%'>ˮӡ��߼������</td><td width='85%' colspan=3><span id=tdPreview></span></td></tr>".
"<tr><td align=center colspan=4><input type=submit value='  �ύ  ' align=absmiddle>&nbsp;<input type=reset name=btnReset value='  ����  '></td></tr>".
"</form>".
"</table><br>";
$sMsg = "<a name=baseurl></a><p><span class=blue><b>·��ģʽ����˵����</b></span><br>".
"<b>���·����</b>ָ���е�����ϴ����Զ������ļ�·�����༭����\"UploadFile/...\"��\"../UploadFile/...\"��ʽ���֣���ʹ�ô�ģʽʱ����ʾ·��������·�������ʾ·��������\"/\"��ͷ�ͽ�β������·�������в�����\"/\"��ͷ��<br>".
"<b>���Ը�·����</b>ָ���е�����ϴ����Զ������ļ�·�����༭����\"/eWebEditor/UploadFile/...\"������ʽ���֣���ʹ�ô�ģʽʱ����ʾ·��������·�������<br>".
"<b>����ȫ·����</b>ָ���е�����ϴ����Զ������ļ�·�����༭����\"http://xxx.xxx.xxx/eWebEditor/UploadFile/...\"������ʽ���֣���ʹ�ô�ģʽʱ����ʾ·��������·�������<br>".
"<b>վ�����ȫ·����</b>��ʹ�ô�ģʽʱ���ϴ�·��������ʵ������·�����磺\"c:\\xxx\\\"����ʾ·��Ϊ�գ�����·��������\"http\"��ͷ��</p>".
"<a name=fontname></a><p><span class=blue><b>��������⼰·������˵����</b></span><br>".
"��ʹ����������ˮӡʱ����һ���ֿ⣬ʹ��Ӣ��ˮӡʱΪ���Ч�������գ�����Ϊ��simkai.ttf��������Ѵ�������ļ��������༭����phpĿ¼��</p>";
ShowMessage($sMsg);}
function InitStyle(){
global $sStyleID, $sStyleName, $sFixWidth, $sSkin, $sStyleUploadDir, $sStyleWidth, $sStyleHeight, $sStyleMemo, $nStyleIsSys, $sStyleStateFlag, $sStyleDetectFromWord, $sStyleInitMode, $sStyleBaseUrl, $sStyleUploadObject, $sStyleAutoDir, $sStyleBaseHref, $sStyleContentPath, $sStyleAutoRemote, $sStyleShowBorder, $sStyleAllowBrowse;
global $sSLTFlag, $sSLTMinSize, $sSLTOkSize, $sSYWZFlag, $sSYText, $sSYFontColor, $sSYFontSize, $sSYFontName, $sSYPicPath, $sSLTSYObject, $sSLTSYExt, $sSYWZMinWidth, $sSYShadowColor, $sSYShadowOffset, $sSYWZMinHeight, $sSYWZPosition, $sSYWZTextWidth, $sSYWZTextHeight, $sSYWZPaddingH, $sSYWZPaddingV, $sSYTPFlag, $sSYTPMinWidth, $sSYTPMinHeight, $sSYTPPosition, $sSYTPPaddingH, $sSYTPPaddingV, $sSYTPImageWidth, $sSYTPImageHeight, $sSYTPOpacity, $sCusDirFlag;
global $sStyleFileExt, $sStyleFlashExt, $sStyleImageExt, $sStyleMediaExt, $sStyleRemoteExt, $sStyleLocalExt, $sStyleFileSize, $sStyleFlashSize, $sStyleImageSize, $sStyleMediaSize, $sStyleRemoteSize, $sStyleLocalSize;
global $sToolBarID, $sToolBarName, $sToolBarOrder, $sToolBarButton;
global $sSBCode, $sSBEdit, $sSBText, $sSBView;
global $sEnterMode, $sAreaCssMode;
global $nStyleID;
$b = false;
$sStyleID = toTrim("id");
if (is_numeric($sStyleID)) {
$nStyleID = (int)($sStyleID);
if ($nStyleID <= count($GLOBALS["aStyle"])) {
$aCurrStyle = explode("|||", $GLOBALS["aStyle"][$nStyleID]);
$sStyleName = $aCurrStyle[0];
$sFixWidth = $aCurrStyle[1];
$sSkin = $aCurrStyle[2];
$sStyleUploadDir = $aCurrStyle[3];
$sStyleBaseHref = $aCurrStyle[22];
$sStyleContentPath = $aCurrStyle[23];
$sStyleWidth = $aCurrStyle[4];
$sStyleHeight = $aCurrStyle[5];
$sStyleMemo = $aCurrStyle[26];
$sStyleFileExt = $aCurrStyle[6];
$sStyleFlashExt = $aCurrStyle[7];
$sStyleImageExt = $aCurrStyle[8];
$sStyleMediaExt = $aCurrStyle[9];
$sStyleRemoteExt = $aCurrStyle[10];
$sStyleFileSize = $aCurrStyle[11];
$sStyleFlashSize = $aCurrStyle[12];
$sStyleImageSize = $aCurrStyle[13];
$sStyleMediaSize = $aCurrStyle[14];
$sStyleRemoteSize = $aCurrStyle[15];
$sStyleStateFlag = $aCurrStyle[16];
$sSBCode = $aCurrStyle[62];
$sSBEdit = $aCurrStyle[63];
$sSBText = $aCurrStyle[64];
$sSBView = $aCurrStyle[65];
$sEnterMode = $aCurrStyle[66];
$sAreaCssMode = $aCurrStyle[67];
$sStyleAutoRemote = $aCurrStyle[24];
$sStyleShowBorder = $aCurrStyle[25];
$sStyleUploadObject = $aCurrStyle[20];
$sStyleAutoDir = $aCurrStyle[21];
$sStyleDetectFromWord = $aCurrStyle[17];
$sStyleInitMode = $aCurrStyle[18];
$sStyleBaseUrl = $aCurrStyle[19];
$sSLTFlag = $aCurrStyle[29];
$sSLTMinSize = $aCurrStyle[30];
$sSLTOkSize = $aCurrStyle[31];
$sSYWZFlag = $aCurrStyle[32];
$sSYText = $aCurrStyle[33];
$sSYFontColor = $aCurrStyle[34];
$sSYFontSize = $aCurrStyle[35];
$sSYFontName = $aCurrStyle[36];
$sSYPicPath = $aCurrStyle[37];
$sSLTSYObject = $aCurrStyle[38];
$sSLTSYExt = $aCurrStyle[39];
$sSYWZMinWidth = $aCurrStyle[40];
$sSYShadowColor = $aCurrStyle[41];
$sSYShadowOffset = $aCurrStyle[42];
$sStyleAllowBrowse = $aCurrStyle[43];
$sStyleLocalExt = $aCurrStyle[44];
$sStyleLocalSize = $aCurrStyle[45];
$sSYWZMinHeight = $aCurrStyle[46];
$sSYWZPosition = $aCurrStyle[47];
$sSYWZTextWidth = $aCurrStyle[48];
$sSYWZTextHeight = $aCurrStyle[49];
$sSYWZPaddingH = $aCurrStyle[50];
$sSYWZPaddingV = $aCurrStyle[51];
$sSYTPFlag = $aCurrStyle[52];
$sSYTPMinWidth = $aCurrStyle[53];
$sSYTPMinHeight = $aCurrStyle[54];
$sSYTPPosition = $aCurrStyle[55];
$sSYTPPaddingH = $aCurrStyle[56];
$sSYTPPaddingV = $aCurrStyle[57];
$sSYTPImageWidth = $aCurrStyle[58];
$sSYTPImageHeight = $aCurrStyle[59];
$sSYTPOpacity = $aCurrStyle[60];
$sCusDirFlag = $aCurrStyle[61];
$b = true;}}
if ($b == false) {
GoError("��Ч����ʽID�ţ���ͨ��ҳ���ϵ����ӽ��в�����");}}
function CheckStyleForm(){
$GLOBALS["sStyleName"] = toTrim("d_name");
$GLOBALS["sFixWidth"] = toTrim("d_fixwidth");
$GLOBALS["sSkin"] = toTrim("d_skin");
$GLOBALS["sStyleUploadDir"] = toTrim("d_uploaddir");
$GLOBALS["sStyleBaseHref"] = toTrim("d_basehref");
$GLOBALS["sStyleContentPath"] = toTrim("d_contentpath");
$GLOBALS["sStyleWidth"] = toTrim("d_width");
$GLOBALS["sStyleHeight"] = toTrim("d_height");
$GLOBALS["sStyleMemo"] = toTrim("d_memo");
$GLOBALS["sStyleImageExt"] = toTrim("d_imageext");
$GLOBALS["sStyleFlashExt"] = toTrim("d_flashext");
$GLOBALS["sStyleMediaExt"] = toTrim("d_mediaext");
$GLOBALS["sStyleRemoteExt"] = toTrim("d_remoteext");
$GLOBALS["sStyleFileExt"] = toTrim("d_fileext");
$GLOBALS["sStyleImageSize"] = toTrim("d_imagesize");
$GLOBALS["sStyleFlashSize"] = toTrim("d_flashsize");
$GLOBALS["sStyleMediaSize"] = toTrim("d_mediasize");
$GLOBALS["sStyleRemoteSize"] = toTrim("d_remotesize");
$GLOBALS["sStyleFileSize"] = toTrim("d_filesize");
$GLOBALS["sStyleStateFlag"] = toTrim("d_stateflag");
$GLOBALS["sSBCode"] = toTrim("d_sbcode");
$GLOBALS["sSBEdit"] = toTrim("d_sbedit");
$GLOBALS["sSBText"] = toTrim("d_sbtext");
$GLOBALS["sSBView"] = toTrim("d_sbview");
$GLOBALS["sEnterMode"] = toTrim("d_entermode");
$GLOBALS["sAreaCssMode"] = toTrim("d_areacssmode");
$GLOBALS["sStyleAutoRemote"] = toTrim("d_autoremote");
$GLOBALS["sStyleShowBorder"] = toTrim("d_showborder");
$GLOBALS["sStyleAllowBrowse"] = toTrim("d_allowbrowse");
$GLOBALS["sStyleUploadObject"] = toTrim("d_uploadobject");
$GLOBALS["sStyleAutoDir"] = toTrim("d_autodir");
$GLOBALS["sStyleDetectFromWord"] = toTrim("d_detectfromword");
$GLOBALS["sStyleInitMode"] = toTrim("d_initmode");
$GLOBALS["sStyleBaseUrl"] = toTrim("d_baseurl");
$GLOBALS["sSLTFlag"] = toTrim("d_sltflag");
$GLOBALS["sSLTMinSize"] = toTrim("d_sltminsize");
$GLOBALS["sSLTOkSize"] = toTrim("d_sltoksize");
$GLOBALS["sSYWZFlag"] = toTrim("d_sywzflag");
$GLOBALS["sSYText"] = toTrim("d_sytext");
$GLOBALS["sSYFontColor"] = toTrim("d_syfontcolor");
$GLOBALS["sSYFontSize"] = toTrim("d_syfontsize");
$GLOBALS["sSYFontName"] = toTrim("d_syfontname");
$GLOBALS["sSYPicPath"] = toTrim("d_sypicpath");
$GLOBALS["sSLTSYObject"] = toTrim("d_sltsyobject");
$GLOBALS["sSLTSYExt"] = toTrim("d_sltsyext");
$GLOBALS["sSYWZMinWidth"] = toTrim("d_sywzminwidth");
$GLOBALS["sSYShadowColor"] = toTrim("d_syshadowcolor");
$GLOBALS["sSYShadowOffset"] = toTrim("d_syshadowoffset");
$GLOBALS["sStyleLocalExt"] = toTrim("d_localext");
$GLOBALS["sStyleLocalSize"] = toTrim("d_localsize");
$GLOBALS["sSYWZMinHeight"] = toTrim("d_sywzminheight");
$GLOBALS["sSYWZPosition"] = toTrim("d_sywzposition");
$GLOBALS["sSYWZTextWidth"] = toTrim("d_sywztextwidth");
$GLOBALS["sSYWZTextHeight"] = toTrim("d_sywztextheight");
$GLOBALS["sSYWZPaddingH"] = toTrim("d_sywzpaddingh");
$GLOBALS["sSYWZPaddingV"] = toTrim("d_sywzpaddingv");
$GLOBALS["sSYTPFlag"] = toTrim("d_sytpflag");
$GLOBALS["sSYTPMinWidth"] = toTrim("d_sytpminwidth");
$GLOBALS["sSYTPMinHeight"] = toTrim("d_sytpminheight");
$GLOBALS["sSYTPPosition"] = toTrim("d_sytpposition");
$GLOBALS["sSYTPPaddingH"] = toTrim("d_sytppaddingh");
$GLOBALS["sSYTPPaddingV"] = toTrim("d_sytppaddingv");
$GLOBALS["sSYTPImageWidth"] = toTrim("d_sytpimagewidth");
$GLOBALS["sSYTPImageHeight"] = toTrim("d_sytpimageheight");
$GLOBALS["sSYTPOpacity"] = toTrim("d_sytpopacity");
$GLOBALS["sCusDirFlag"] = toTrim("d_cusdirflag");}
function DoStyleAddSave(){
if (StyleName2ID($GLOBALS["sStyleName"]) != -1){
GoError("����ʽ���Ѿ����ڣ�������һ����ʽ����");}
$nNewStyleID = count($GLOBALS["aStyle"]) + 1;
$GLOBALS["aStyle"][$nNewStyleID] = $GLOBALS["sStyleName"]."|||".$GLOBALS["sFixWidth"]."|||".$GLOBALS["sSkin"]."|||".$GLOBALS["sStyleUploadDir"]."|||".$GLOBALS["sStyleWidth"]."|||".$GLOBALS["sStyleHeight"]."|||".$GLOBALS["sStyleFileExt"]."|||".$GLOBALS["sStyleFlashExt"]."|||".$GLOBALS["sStyleImageExt"]."|||".$GLOBALS["sStyleMediaExt"]."|||".$GLOBALS["sStyleRemoteExt"]."|||".$GLOBALS["sStyleFileSize"]."|||".$GLOBALS["sStyleFlashSize"]."|||".$GLOBALS["sStyleImageSize"]."|||".$GLOBALS["sStyleMediaSize"]."|||".$GLOBALS["sStyleRemoteSize"]."|||".$GLOBALS["sStyleStateFlag"]."|||".$GLOBALS["sStyleDetectFromWord"]."|||".$GLOBALS["sStyleInitMode"]."|||".$GLOBALS["sStyleBaseUrl"]."|||".$GLOBALS["sStyleUploadObject"]."|||".$GLOBALS["sStyleAutoDir"]."|||".$GLOBALS["sStyleBaseHref"]."|||".$GLOBALS["sStyleContentPath"]."|||".$GLOBALS["sStyleAutoRemote"]."|||".$GLOBALS["sStyleShowBorder"]."|||".$GLOBALS["sStyleMemo"]."|||||||||".$GLOBALS["sSLTFlag"]."|||".$GLOBALS["sSLTMinSize"]."|||".$GLOBALS["sSLTOkSize"]."|||".$GLOBALS["sSYWZFlag"]."|||".$GLOBALS["sSYText"]."|||".$GLOBALS["sSYFontColor"]."|||".$GLOBALS["sSYFontSize"]."|||".$GLOBALS["sSYFontName"]."|||".$GLOBALS["sSYPicPath"]."|||".$GLOBALS["sSLTSYObject"]."|||".$GLOBALS["sSLTSYExt"]."|||".$GLOBALS["sSYWZMinWidth"]."|||".$GLOBALS["sSYShadowColor"]."|||".$GLOBALS["sSYShadowOffset"]."|||".$GLOBALS["sStyleAllowBrowse"]."|||".$GLOBALS["sStyleLocalExt"]."|||".$GLOBALS["sStyleLocalSize"]."|||".$GLOBALS["sSYWZMinHeight"]."|||".$GLOBALS["sSYWZPosition"]."|||".$GLOBALS["sSYWZTextWidth"]."|||".$GLOBALS["sSYWZTextHeight"]."|||".$GLOBALS["sSYWZPaddingH"]."|||".$GLOBALS["sSYWZPaddingV"]."|||".$GLOBALS["sSYTPFlag"]."|||".$GLOBALS["sSYTPMinWidth"]."|||".$GLOBALS["sSYTPMinHeight"]."|||".$GLOBALS["sSYTPPosition"]."|||".$GLOBALS["sSYTPPaddingH"]."|||".$GLOBALS["sSYTPPaddingV"]."|||".$GLOBALS["sSYTPImageWidth"]."|||".$GLOBALS["sSYTPImageHeight"]."|||".$GLOBALS["sSYTPOpacity"]."|||".$GLOBALS["sCusDirFlag"]."|||".$GLOBALS["sSBCode"]."|||".$GLOBALS["sSBEdit"]."|||".$GLOBALS["sSBText"]."|||".$GLOBALS["sSBView"]."|||".$GLOBALS["sEnterMode"]."|||".$GLOBALS["sAreaCssMode"];
WriteConfig();
WriteStyle($nNewStyleID);
ShowMessage("<b><span class=red>��ʽ���ӳɹ���</span></b><li><a href='?action=toolbar&id=".$nNewStyleID."'>���ô���ʽ�µĹ�����</a>");}
function DoUpdateConfig(){
WriteConfig();
for ($i=1;$i<=count($GLOBALS["aStyle"]);$i++){
WriteStyle($i);}
ShowMessage("<b><span class=red>������ʽ��ǰ̨�����ļ����²����ɹ���</span></b><li><a href='?'>����������ʽ�б�</a>");}
function DoStyleSetSave(){
$GLOBALS["sStyleID"] = toTrim("id");
if (is_numeric($GLOBALS["sStyleID"])) {
$n = StyleName2ID($GLOBALS["sStyleName"]);
if ((($n) != (int)$GLOBALS["sStyleID"]) && ($n != -1)) {
GoError("����ʽ���Ѿ����ڣ�������һ����ʽ����");}
if (((int)($GLOBALS["sStyleID"]) < 1) && ((int)($GLOBALS["sStyleID"])>count($GLOBALS["aStyle"]))) {
GoError("��Ч����ʽID�ţ���ͨ��ҳ���ϵ����ӽ��в�����");}
$aTemp = explode("|||", $GLOBALS["aStyle"][$GLOBALS["sStyleID"]]);
$s_OldStyleName = $aTemp[0];
$GLOBALS["aStyle"][$GLOBALS["sStyleID"]] = $GLOBALS["sStyleName"]."|||".$GLOBALS["sFixWidth"]."|||".$GLOBALS["sSkin"]."|||".$GLOBALS["sStyleUploadDir"]."|||".$GLOBALS["sStyleWidth"]."|||".$GLOBALS["sStyleHeight"]."|||".$GLOBALS["sStyleFileExt"]."|||".$GLOBALS["sStyleFlashExt"]."|||".$GLOBALS["sStyleImageExt"]."|||".$GLOBALS["sStyleMediaExt"]."|||".$GLOBALS["sStyleRemoteExt"]."|||".$GLOBALS["sStyleFileSize"]."|||".$GLOBALS["sStyleFlashSize"]."|||".$GLOBALS["sStyleImageSize"]."|||".$GLOBALS["sStyleMediaSize"]."|||".$GLOBALS["sStyleRemoteSize"]."|||".$GLOBALS["sStyleStateFlag"]."|||".$GLOBALS["sStyleDetectFromWord"]."|||".$GLOBALS["sStyleInitMode"]."|||".$GLOBALS["sStyleBaseUrl"]."|||".$GLOBALS["sStyleUploadObject"]."|||".$GLOBALS["sStyleAutoDir"]."|||".$GLOBALS["sStyleBaseHref"]."|||".$GLOBALS["sStyleContentPath"]."|||".$GLOBALS["sStyleAutoRemote"]."|||".$GLOBALS["sStyleShowBorder"]."|||".$GLOBALS["sStyleMemo"]."|||||||||".$GLOBALS["sSLTFlag"]."|||".$GLOBALS["sSLTMinSize"]."|||".$GLOBALS["sSLTOkSize"]."|||".$GLOBALS["sSYWZFlag"]."|||".$GLOBALS["sSYText"]."|||".$GLOBALS["sSYFontColor"]."|||".$GLOBALS["sSYFontSize"]."|||".$GLOBALS["sSYFontName"]."|||".$GLOBALS["sSYPicPath"]."|||".$GLOBALS["sSLTSYObject"]."|||".$GLOBALS["sSLTSYExt"]."|||".$GLOBALS["sSYWZMinWidth"]."|||".$GLOBALS["sSYShadowColor"]."|||".$GLOBALS["sSYShadowOffset"]."|||".$GLOBALS["sStyleAllowBrowse"]."|||".$GLOBALS["sStyleLocalExt"]."|||".$GLOBALS["sStyleLocalSize"]."|||".$GLOBALS["sSYWZMinHeight"]."|||".$GLOBALS["sSYWZPosition"]."|||".$GLOBALS["sSYWZTextWidth"]."|||".$GLOBALS["sSYWZTextHeight"]."|||".$GLOBALS["sSYWZPaddingH"]."|||".$GLOBALS["sSYWZPaddingV"]."|||".$GLOBALS["sSYTPFlag"]."|||".$GLOBALS["sSYTPMinWidth"]."|||".$GLOBALS["sSYTPMinHeight"]."|||".$GLOBALS["sSYTPPosition"]."|||".$GLOBALS["sSYTPPaddingH"]."|||".$GLOBALS["sSYTPPaddingV"]."|||".$GLOBALS["sSYTPImageWidth"]."|||".$GLOBALS["sSYTPImageHeight"]."|||".$GLOBALS["sSYTPOpacity"]."|||".$GLOBALS["sCusDirFlag"]."|||".$GLOBALS["sSBCode"]."|||".$GLOBALS["sSBEdit"]."|||".$GLOBALS["sSBText"]."|||".$GLOBALS["sSBView"]."|||".$GLOBALS["sEnterMode"]."|||".$GLOBALS["sAreaCssMode"];}else{
GoError("��Ч����ʽID�ţ���ͨ��ҳ���ϵ����ӽ��в�����");}
WriteConfig();
if (strtolower($s_OldStyleName) != strtolower($GLOBALS["sStyleName"])){
DeleteFile($s_OldStyleName);}
WriteStyle($GLOBALS["sStyleID"]);
ShowMessage("<b><span class=red>��ʽ�޸ĳɹ���</span></b><li><a href='?action=stylepreview&id=".$GLOBALS["sStyleID"]."' target='_blank'>Ԥ������ʽ</a><li><a href='?action=toolbar&id=".$GLOBALS["sStyleID"]."'>���ô���ʽ�µĹ�����</a><li><a href='?action=styleset&id=".$GLOBALS["sStyleID"]."'>�������ô���ʽ</a>");}
function DoStyleDel(){
$GLOBALS["aStyle"][$GLOBALS["sStyleID"]] = "";
WriteConfig();
DeleteFile($GLOBALS["sStyleName"]);
GoUrl("?");}
function ShowStylePreview(){
echo "<html><head>".
"<title>��ʽԤ��</title>".
"<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>".
"</head><body>".
"<input type=hidden name=content1  value=''>".
"<iframe ID='eWebEditor1' src='../ewebeditor.htm?id=content1&style=".$GLOBALS["sStyleName"]."' frameborder=0 scrolling=no width='".$GLOBALS["sStyleWidth"]."' HEIGHT='".$GLOBALS["sStyleHeight"]."'></iframe>".
"</body></html>";}
function ShowStyleCode(){
echo "<table border=0 cellspacing=1 align=center class=list>".
"<tr><th>��ʽ��".htmlspecialchars($GLOBALS["sStyleName"])."������ѵ��ô������£�����XXX��ʵ�ʹ����ı�������޸ģ���</th></tr>".
"<tr><td><textarea rows=5 cols=65 style='width:100%'><IFRAME ID=\"eWebEditor1\" SRC=\"ewebeditor.htm?id=XXX&style=".$GLOBALS["sStyleName"]."\" FRAMEBORDER=\"0\" SCROLLING=\"no\" WIDTH=\"".$GLOBALS["sStyleWidth"]."\" HEIGHT=\"".$GLOBALS["sStyleHeight"]."\"></IFRAME></textarea></td></tr>".
"</table>";}
function ShowToolBarList(){
ShowMessage("<b class=blue>��ʽ��".htmlspecialchars($GLOBALS["sStyleName"])."���µĹ���������</b>");
$nMaxOrder = 0;
for ($i=1;$i<=count($GLOBALS["aToolbar"]);$i++){
$aCurrToolbar = explode("|||", $GLOBALS["aToolbar"][$i]);
if ($aCurrToolbar[0] == $GLOBALS["sStyleID"]) {
if ((int)($aCurrToolbar[3]) > $nMaxOrder) {
$nMaxOrder = (int)($aCurrToolbar[3]);}}}
$nMaxOrder = $nMaxOrder + 1;
$s_AddForm = "<hr width='80%' align=center size=1><table border=0 cellpadding=4 cellspacing=0 align=center>".
"<form action='?id=".$GLOBALS["sStyleID"]."&action=toolbaradd' name='addform' method=post>".
"<tr><td>����������<input type=text name=d_name size=20 class=input value='������".$nMaxOrder."'> ����ţ�<input type=text name=d_order size=5 value='".$nMaxOrder."' class=input> <input type=submit name=b1 value='����������'></td></tr>".
"</form></table><hr width='80%' align=center size=1>";
$s_ModiForm = "<form action='?id=".$GLOBALS["sStyleID"]."&action=toolbarmodi' name=modiform method=post>".
"<table border=0 cellpadding=0 cellspacing=1 align=center class=form>".
"<tr align=center><th>ID</th><th>��������</th><th>�����</th><th>����</th></tr>";
for ($i=1;$i<=count($GLOBALS["aToolbar"]);$i++){
$aCurrToolbar = explode("|||", $GLOBALS["aToolbar"][$i]);
if ($aCurrToolbar[0] == $GLOBALS["sStyleID"]){
$s_Manage = "<a href='?id=".$GLOBALS["sStyleID"]."&action=buttonset&toolbarid=".$i."'>��ť����</a>";
$s_Manage = $s_Manage."|<a href='?id=".$GLOBALS["sStyleID"]."&action=toolbardel&delid=".$i."'>ɾ��</a>";
$s_ModiForm = $s_ModiForm."<tr align=center>".
"<td>".$i."</td>".
"<td><input type=text name='d_name".$i."' value=\"".htmlspecialchars($aCurrToolbar[2])."\" size=30 class=input></td>".
"<td><input type=text name='d_order".$i."' value='".$aCurrToolbar[3]."' size=5 class=input></td>".
"<td>".$s_Manage."</td>".
"</tr>";}}
$s_ModiForm = $s_ModiForm."<tr><td colspan=4 align=center><input type=submit name=b1 value='  �޸�  '></td></tr></table></form>";
echo $s_AddForm.$s_ModiForm;}
function DoToolBarAdd(){
$s_Name = toTrim("d_name");
$s_Order = toTrim("d_order");
if ($s_Name == "") {
GoError("������������Ϊ�գ�");}
if (!is_numeric($s_Order)){
GoError("��Ч�Ĺ���������ţ�����ű���Ϊ���֣�");}
$nToolbarNum = count($GLOBALS["aToolbar"]) + 1;
$GLOBALS["aToolbar"][$nToolbarNum] = $GLOBALS["sStyleID"]."||||||".$s_Name."|||".$s_Order;
WriteConfig();
WriteStyle($GLOBALS["sStyleID"]);
echo "<script language=javascript>alert(\"��������".htmlspecialchars($s_Name)."�����Ӳ����ɹ���\");</script>";
GoUrl("?action=toolbar&id=".$GLOBALS["sStyleID"]);}
function DoToolBarModi(){
for ($i=1;$i<=count($GLOBALS["aToolbar"]);$i++){
$aCurrToolbar = explode("|||", $GLOBALS["aToolbar"][$i]);
if ($aCurrToolbar[0] == $GLOBALS["sStyleID"]){
$s_Name = toTrim("d_name".$i);
$s_Order = toTrim("d_order".$i);
if (($s_Name == "") || (is_numeric($s_Order) == false)) {
$aCurrToolbar[0] = "";
$s_Name = "";}
$GLOBALS["aToolbar"][$i] = $aCurrToolbar[0]."|||".$aCurrToolbar[1]."|||".$s_Name."|||".$s_Order;}}
WriteConfig();
WriteStyle($GLOBALS["sStyleID"]);
echo "<script language=javascript>alert('�������޸Ĳ����ɹ���');</script>";
GoUrl("?action=toolbar&id=".$GLOBALS["sStyleID"]);}
function DoToolBarDel(){
$s_DelID = toTrim("delid");
if (is_numeric($s_DelID)){
$GLOBALS["aToolbar"][$s_DelID] = "";
WriteConfig();
WriteStyle($GLOBALS["sStyleID"]);
echo "<script language=javascript>alert('��������ID��".$s_DelID."��ɾ�������ɹ���');</script>";
GoUrl("?action=toolbar&id=".$GLOBALS["sStyleID"]);}}
function InitToolBar(){
$b = false;
$GLOBALS["sToolBarID"] = toTrim("toolbarid");
if (is_numeric($GLOBALS["sToolBarID"])){
if (((int)($GLOBALS["sToolBarID"]) <= count($GLOBALS["aToolbar"])) && ((int)($GLOBALS["sToolBarID"]) > 0)) {
$aCurrToolbar = explode("|||", $GLOBALS["aToolbar"][$GLOBALS["sToolBarID"]]);
$GLOBALS["sToolBarName"] = $aCurrToolbar[2];
$GLOBALS["sToolBarOrder"] = $aCurrToolbar[3];
$GLOBALS["sToolBarButton"] = $aCurrToolbar[1];
$b = true;}}
if ($b == false) {
GoError("��Ч�Ĺ�����ID�ţ���ͨ��ҳ���ϵ����ӽ��в�����");}}
function ShowButtonList(){
ShowMessage("<b class=blue>��ǰ��ʽ��<span class=red>".htmlspecialchars($GLOBALS["sStyleName"])."</span>&nbsp;&nbsp;��ǰ��������<span class=red>".htmlspecialchars($GLOBALS["sToolBarName"])."</span></b>");
echo "<script language='javascript' src='../js/buttons.js'></script>";
echo "<script language='javascript' src='../js/zh-cn.js'></script>";
echo "<table border=0 cellpadding=5 cellspacing=0 align=center>".
"<form action='?action=buttonsave&id=".$GLOBALS["sStyleID"]."&toolbarid=".$GLOBALS["sToolBarID"]."' method=post name=myform>".
"<tr align=center><td>��ѡ��ť</td><td></td><td>��ѡ��ť</td><td></td></tr>".
"<tr>".
"<td><DIV id=div1 style='BORDER-RIGHT: 1.5pt inset; PADDING-RIGHT: 0px; BORDER-TOP: 1.5pt inset; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; OVERFLOW: auto; BORDER-LEFT: 1.5pt inset; WIDTH: 250px; PADDING-TOP: 0px; BORDER-BOTTOM: 1.5pt inset; HEIGHT: 350px; BACKGROUND-COLOR: white'></DIV></td>".
"<td><input type=button name=b1 value=' �� ' onclick='Add()'><br><br><input type=button name=b1 value=' �� ' onclick='Del()'></td>".
"<td><DIV id=div2 style='BORDER-RIGHT: 1.5pt inset; PADDING-RIGHT: 0px; BORDER-TOP: 1.5pt inset; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; OVERFLOW: auto; BORDER-LEFT: 1.5pt inset; WIDTH: 250px; PADDING-TOP: 0px; BORDER-BOTTOM: 1.5pt inset; HEIGHT: 350px; BACKGROUND-COLOR: white'></DIV></td>".
"<td><input type=button name=b3 value='��' onclick='Up()'><br><br><br><input type=button name=b4 value='��' onclick='Down()'></td>".
"</tr>".
"<input type=hidden name='d_button' value='".$GLOBALS["sToolBarButton"]."'>".
"<tr><td colspan=4 align=right><input type=submit name=b value=' �������� '></td></tr>".
"</form>".
"</table>";
echo "<script language=javascript>".
"initButtonOptions('".$GLOBALS["sSkin"]."');".
"</script>";
ShowMessage("<b class=blue>��ʾ��</b>�����ͨ������Ctrl����Shift�������ٶ�ѡ����������ָ�����ϡ�˫�����������ӻ�ɾ�������ѡ�������ťͬʱ���ƻ����Ʋ�����");}
function DoButtonSave(){
$s_Button = toTrim("d_button");
$nToolBarID = (int)($GLOBALS["sToolBarID"]);
$aCurrToolbar = explode("|||", $GLOBALS["aToolbar"][$nToolBarID]);
$GLOBALS["aToolbar"][$nToolBarID] = $aCurrToolbar[0]."|||".$s_Button."|||".$aCurrToolbar[2]."|||".$aCurrToolbar[3];
WriteConfig();
WriteStyle($GLOBALS["sStyleID"]);
ShowMessage("<b><span class=red>��������ť���ñ���ɹ���</span></b><li><a href='?action=stylepreview&id=".$GLOBALS["sStyleID"]."' target='_blank'>Ԥ������ʽ</a><li><a href='?action=toolbar&id=".$GLOBALS["sStyleID"]."'>���ع���������</a><li><a href='?action=buttonset&id=".$GLOBALS["sStyleID"]."&toolbarid=".$GLOBALS["sToolBarID"]."'>�������ô˹������µİ�ť</a>");}
function WriteStyle($n_StyleID){
$sConfig = "";
$aTmpStyle = explode("|||", $GLOBALS["aStyle"][$n_StyleID]);
$sConfig = $sConfig."config.FixWidth = \"".$aTmpStyle[1]."\";\r\n";
if ($aTmpStyle[19]=="3"){
$sConfig = $sConfig."config.UploadUrl = \"".$aTmpStyle[23]."\";\r\n";}else{
$sConfig = $sConfig."config.UploadUrl = \"".$aTmpStyle[3]."\";\r\n";}
$sConfig = $sConfig."config.InitMode = \"".$aTmpStyle[18]."\";\r\n";
$sConfig = $sConfig."config.AutoDetectPasteFromWord = \"".$aTmpStyle[17]."\";\r\n";
$sConfig = $sConfig."config.BaseUrl = \"".$aTmpStyle[19]."\";\r\n";
$sConfig = $sConfig."config.BaseHref = \"".$aTmpStyle[22]."\";\r\n";
$sConfig = $sConfig."config.AutoRemote = \"".$aTmpStyle[24]."\";\r\n";
$sConfig = $sConfig."config.ShowBorder = \"".$aTmpStyle[25]."\";\r\n";
$sConfig = $sConfig."config.StateFlag = \"".$aTmpStyle[16]."\";\r\n";
$sConfig = $sConfig."config.SBCode = \"".$aTmpStyle[62]."\";\r\n";
$sConfig = $sConfig."config.SBEdit = \"".$aTmpStyle[63]."\";\r\n";
$sConfig = $sConfig."config.SBText = \"".$aTmpStyle[64]."\";\r\n";
$sConfig = $sConfig."config.SBView = \"".$aTmpStyle[65]."\";\r\n";
$sConfig = $sConfig."config.EnterMode = \"".$aTmpStyle[66]."\";\r\n";
$sConfig = $sConfig."config.Skin = \"".$aTmpStyle[2]."\";\r\n";
$sConfig = $sConfig."config.AllowBrowse = \"".$aTmpStyle[43]."\";\r\n";
$sConfig = $sConfig."config.AllowImageSize = \"".$aTmpStyle[13]."\";\r\n";
$sConfig = $sConfig."config.AllowFlashSize = \"".$aTmpStyle[12]."\";\r\n";
$sConfig = $sConfig."config.AllowMediaSize = \"".$aTmpStyle[14]."\";\r\n";
$sConfig = $sConfig."config.AllowFileSize = \"".$aTmpStyle[11]."\";\r\n";
$sConfig = $sConfig."config.AllowRemoteSize = \"".$aTmpStyle[15]."\";\r\n";
$sConfig = $sConfig."config.AllowLocalSize = \"".$aTmpStyle[45]."\";\r\n";
$sConfig = $sConfig."config.AllowImageExt = \"".$aTmpStyle[8]."\";\r\n";
$sConfig = $sConfig."config.AllowFlashExt = \"".$aTmpStyle[7]."\";\r\n";
$sConfig = $sConfig."config.AllowMediaExt = \"".$aTmpStyle[9]."\";\r\n";
$sConfig = $sConfig."config.AllowFileExt = \"".$aTmpStyle[6]."\";\r\n";
$sConfig = $sConfig."config.AllowRemoteExt = \"".$aTmpStyle[10]."\";\r\n";	
$sConfig = $sConfig."config.AreaCssMode = \"".$aTmpStyle[67]."\";\r\n";	
$sConfig = $sConfig."config.SYWZFlag = \"".$aTmpStyle[32]."\";\r\n";	
$sConfig = $sConfig."config.SYTPFlag = \"".$aTmpStyle[52]."\";\r\n";	
$sConfig = $sConfig."config.ServerExt = \"php\";\r\n";	
$sConfig = $sConfig."\r\n";
$sConfig = $sConfig."config.Toolbars = [\r\n";
$s_Order = "";
$s_ID = "";
for ($n=1;$n<=count($GLOBALS["aToolbar"]);$n++){
if ($GLOBALS["aToolbar"][$n] != "") {
$aTmpToolbar = explode("|||", $GLOBALS["aToolbar"][$n]);
if ((int)$aTmpToolbar[0] == $n_StyleID) {
if ($s_ID != "") {
$s_ID = $s_ID."|";
$s_Order = $s_Order."|";}
$s_ID = $s_ID.$n;
$s_Order = $s_Order.$aTmpToolbar[3];}}}
if ($s_ID != "") {
$a_ID = explode("|", $s_ID);
$a_Order = explode("|", $s_Order);
for ($n=0;$n<count($a_Order);$n++){
$a_Order[$n] = (int)($a_Order[$n]);
$a_ID[$n] = (int)($a_ID[$n]);}
$a_ID = doSort($a_ID, $a_Order);
for ($n=0;$n<count($a_ID);$n++){
$aTmpToolbar = explode("|||", $GLOBALS["aToolbar"][$a_ID[$n]]);
$aTmpButton = explode("|", gb2utf8($aTmpToolbar[1]));
$n_Count = count($aTmpButton);
if ($n>0){
$sConfig = $sConfig.",\r\n";}
$sConfig = $sConfig."\t[";
for ($i=0;$i<$n_Count;$i++){
if ($i > 0){
$sConfig = $sConfig.", ";}
$sConfig = $sConfig."\"".$aTmpButton[$i]."\"";}
$sConfig = $sConfig."]";}}
$sConfig = $sConfig."\r\n];\r\n";
WriteFile("../style/".strtolower($aTmpStyle[0]).".js", $sConfig);}
function DeleteFile($s_StyleName){
@unlink("../style/".strtolower($s_StyleName).".js");}
?>