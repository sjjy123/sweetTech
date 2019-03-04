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
@session_start();
if(empty($_SESSION["eWebEditor_User"])){
echo "<script language=javascript>top.location.href='login.php';</script>";
exit;}
require("../php/config.php");
CheckAndUpdateConfig();
$sAction = strtoupper(toTrim("action"));
$sPosition = "当前位置：";
function eWebEditor_Header(){
echo "<html><head>";
echo "<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>"
."<title>eWebEditor在线编辑器 - 后台管理</title>"
."<link rel='stylesheet' type='text/css' href='private.css'>"
."<script language='javascript' src='private.js'></script>";
echo "</head>";
echo "<body>";
echo "<a name=top></a>";}
function eWebEditor_Footer(){
echo "<table border=0 cellpadding=0 cellspacing=0 align=center width='100%'>"
."<tr><td height=40></td></tr>"
."<tr><td><hr size=1 color=#000000 width='60%' align=center></td></tr>"
."<tr>"
."<td align=center>Copyright  &copy;  2003-2008  <b>eWebEditor<font color=#CC0000>.net</font></b> <b>eWebSoft<font color=#CC0000>.com</font></b>, All Rights Reserved .</td>"
."</tr>"
."<tr>"
."<td align=center><a href='mailto:service@ewebsoft.com'>service@ewebsoft.com</a></td>"
."</tr>"
."</table>";
echo "</body></html>";}
function IsSafeStr($str){
$aBadstr = array("'", "|", "\"");
for ($i=0;$i<count($aBadstr);$i++){
if (strpos($str, $aBadstr[$i]) !== false) {
return false;}}
return true;}
function GoError($str){
echo "<script language=javascript>alert('".$str."\\n\\n系统将自动返回前一页面...');history.back();</script>";
exit;}
function toTrim($name){
if (isset($_GET[$name])){
return trim($_GET[$name]);}
if (isset($_POST[$name])){
return trim($_POST[$name]);}
return "";}
function WriteConfig(){
$sConfig = "<"."?php\r\n";
$sConfig = $sConfig."\r\n";
$sConfig = $sConfig."$"."sUsername = \"".$GLOBALS["sUsername"]."\";\r\n";
$sConfig = $sConfig."$"."sPassword = \"".$GLOBALS["sPassword"]."\";\r\n";
$sConfig = $sConfig."\r\n";
$nConfigStyle = 0;
$sConfigStyle = "";
$nConfigToolbar = 0;
$sConfigToolbar = "";
for ($i=1;$i<=count($GLOBALS["aStyle"]);$i++){
if ($GLOBALS["aStyle"][$i] != "") {
$aTmpStyle = explode("|||", $GLOBALS["aStyle"][$i]);
if ($aTmpStyle[0] != "") {
$nConfigStyle = $nConfigStyle + 1;
$sConfigStyle = $sConfigStyle."$"."aStyle[".$nConfigStyle."] = \"".$GLOBALS["aStyle"][$i]."\";\r\n";
$s_Order = "";
$s_ID = "";
for ($n=1;$n<=count($GLOBALS["aToolbar"]);$n++){
if ($GLOBALS["aToolbar"][$n] != ""){
$aTmpToolbar = explode("|||", $GLOBALS["aToolbar"][$n]);
if ($aTmpToolbar[0] == $i) {
if ($s_ID != ""){
$s_ID = $s_ID."|";
$s_Order = $s_Order."|";}
$s_ID = $s_ID.$n;
$s_Order = $s_Order.$aTmpToolbar[3];}}}
if ($s_ID != ""){
$a_ID = explode("|", $s_ID);
$a_Order = explode("|", $s_Order);
$a_ID = doSort($a_ID, $a_Order);
for ($n=0;$n<count($a_ID);$n++){
$nConfigToolbar = $nConfigToolbar + 1;
$aTmpToolbar = explode("|||", $GLOBALS["aToolbar"][$a_ID[$n]]);
$sTmpToolbar = $nConfigStyle."|||".$aTmpToolbar[1]."|||".$aTmpToolbar[2]."|||".$aTmpToolbar[3];
$sConfigToolbar = $sConfigToolbar."$"."aToolbar[".$nConfigToolbar."] = \"".$sTmpToolbar."\";\r\n";}}}}}
$sConfig = $sConfig.$sConfigStyle."\r\n".$sConfigToolbar."\r\n?".">";
WriteFile("../php/config.php", $sConfig);}
function WriteFile($s_FileName, $s_Text){
if (!$handle = fopen($s_FileName, 'w')) {
exit;}
if (fwrite($handle, $s_Text) === FALSE) {
exit;}
fclose($handle);}
function doSort($aryValue, $aryOrder){
$KeepChecking = true;
while ($KeepChecking == true){
$KeepChecking = false;
for ($i=0; $i<count($aryOrder);$i++){
if ($i == count($aryOrder)-1){
break 1;}
if ($aryOrder[$i] > $aryOrder[$i+1]){
$FirstOrder = $aryOrder[$i];
$SecondOrder = $aryOrder[$i+1];
$aryOrder[$i] = $SecondOrder;
$aryOrder[$i+1] = $FirstOrder;
$FirstValue = $aryValue[$i];
$SecondValue = $aryValue[$i+1];
$aryValue[$i] = $SecondValue;
$aryValue[$i+1] = $FirstValue;
$KeepChecking = true;}}}
return $aryValue;}
function GoUrl($url){
echo "<script language=javascript>location.href=\"".$url."\";</script>";
exit;}
function gb2utf8($gb){
if(!trim($gb)){return $gb;}
$filename="../php/gb2312.txt";
$tmp=file($filename);
$codetable=array();
while(list($key,$value)=each($tmp))
$codetable[hexdec(substr($value,0,6))]=substr($value,7,6);
$utf8="";
while($gb){
if (ord(substr($gb,0,1))>127){
$tthis=substr($gb,0,2);
$gb=substr($gb,2,strlen($gb)-2);
$utf8.=u2utf8(hexdec($codetable[hexdec(bin2hex($tthis))-0x8080]));}else{
$tthis=substr($gb,0,1);
$gb=substr($gb,1,strlen($gb)-1);
$utf8.=u2utf8($tthis);}}
return $utf8;}
function u2utf8($c){
$str="";
if ($c < 0x80){
$str.=$c;}else if ($c < 0x800){
$str.=chr(0xC0 | $c>>6);
$str.=chr(0x80 | $c & 0x3F);}else if ($c < 0x10000){
$str.=chr(0xE0 | $c>>12);
$str.=chr(0x80 | $c>>6 & 0x3F);
$str.=chr(0x80 | $c & 0x3F);}else if ($c < 0x200000){
$str.=chr(0xF0 | $c>>18);
$str.=chr(0x80 | $c>>12 & 0x3F);
$str.=chr(0x80 | $c>>6 & 0x3F);
$str.=chr(0x80 | $c & 0x3F);}
return $str;}
function InitSelect($s_FieldName, $a_Name, $a_Value, $v_InitValue, $s_AllName, $s_Attribute){
$s_Result = "<select name='".$s_FieldName."' size=1 ".$s_Attribute.">";
if ($s_AllName != "") {
$s_Result = $s_Result."<option value=''>".$s_AllName."</option>";}
for ($i=0;$i<count($a_Name);$i++){
$s_Result = $s_Result."<option value=\"".htmlspecialchars($a_Value[$i])."\"";
if ($a_Value[$i] == $v_InitValue) {
$s_Result = $s_Result." selected";}
$s_Result = $s_Result.">".htmlspecialchars($a_Name[$i])."</option>";}
$s_Result = $s_Result."</select>";
return $s_Result;}
function InitCheckBox($s_FieldName, $s_Value, $s_InitValue){
$s_Result = "";
if ($s_Value == $s_InitValue){
$s_Result = "<input type=checkbox name='".$s_FieldName."' value='".$s_Value."' checked>";}else{
$s_Result = "<input type=checkbox name='".$s_FieldName."' value='".$s_Value."'>";}
return $s_Result;}
function CheckAndUpdateConfig(){
$n_Old = count(explode("|||", $GLOBALS["aStyle"][1]))-1;
$n_New = 67;
if (($n_Old<66) || ($n_Old>=$n_New)){
return;}
$s = "";
for ($i=$n_Old+1; $i<=$n_New; $i++){
$s = $s."|||";
switch($i){
case 67:
$s = $s."0";
break;}}
for ($i=1; $i<=count($GLOBALS["aStyle"]); $i++){
$GLOBALS["aStyle"][$i] = $GLOBALS["aStyle"][$i].$s;}
WriteConfig();}
?>