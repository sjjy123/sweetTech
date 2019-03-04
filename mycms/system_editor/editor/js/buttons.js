/*
*######################################
* eWebEditor v5.5 - Advanced online web based WYSIWYG HTML editor.
* Copyright (c) 2003-2008 eWebSoft.com
*
* For further information go to http://www.ewebsoft.com/
* This copyright notice MUST stay intact for use.
*######################################
*/


// image, event, class, type
var Buttons = {
	"TBSep"			: ["", "", "TBSep", 2],
	"TBHandle"		: ["", "", "TBHandle", 2],
	"Space"			: ["", "", "TBGen", 2],

	"EditMenu"		: [1, "showToolMenu('edit')", "Btn", 0],
	"UnDo"			: [2, "goHistory(-1)", "Btn", 0],
	"ReDo"			: [3, "goHistory(1)", "Btn", 0],
	"Cut"			: [4, "format('cut')", "Btn", 0],
	"Copy"			: [5, "format('copy')", "Btn", 0],
	"Paste"			: [6, "format('paste')", "Btn", 0],
	"PasteText"		: [7, "PasteText()", "Btn", 0],
	"PasteWord"		: [8, "PasteWord()", "Btn", 0],	
	"Delete"		: [9, "format('delete')", "Btn", 0],
	"RemoveFormat"	: [10, "format('RemoveFormat')", "Btn", 0],
	"SelectAll"		: [11, "format('SelectAll')", "Btn", 0],
	"UnSelect"		: [12, "format('Unselect')", "Btn", 0],
	"FindReplace"	: [13, "findReplace()", "Btn", 0],	
	"SpellCheck"	: [14, "spellCheck()", "Btn", 0],

	"FontMenu"		: [15, "showToolMenu('font')", "Btn", 0],
	"Bold"			: [16, "format('bold')", "Btn", 0],
	"Italic"		: [17, "format('italic')", "Btn", 0],
	"UnderLine"		: [18, "format('underline')", "Btn", 0],	
	"StrikeThrough"	: [19, "format('StrikeThrough')", "Btn", 0],
	"SuperScript"	: [20, "format('superscript')", "Btn", 0],
	"SubScript"		: [21, "format('subscript')", "Btn", 0],
	"UpperCase"		: [22, "formatText('uppercase')", "Btn", 0],
	"LowerCase"		: [23, "formatText('lowercase')", "Btn", 0],
	"ForeColor"		: [24, "showDialog('selcolor.htm?action=forecolor', true)", "Btn", 0],
	"BackColor"		: [25, "showDialog('selcolor.htm?action=backcolor', true)", "Btn", 0],
	"Big"			: [26, "insert('big')", "Btn", 0],
	"Small"			: [27, "insert('small')", "Btn", 0],

	"ParagraphMenu"	: [28, "showToolMenu('paragraph')", "Btn", 0],
	"JustifyLeft"	: [29, "format('justifyleft')", "Btn", 0],
	"JustifyCenter"	: [30, "format('justifycenter')", "Btn", 0],
	"JustifyRight"	: [31, "format('justifyright')", "Btn", 0],
	"JustifyFull"	: [32, "format('JustifyFull')", "Btn", 0],
	"OrderedList"	: [33, "format('insertorderedlist')", "Btn", 0],
	"UnOrderedList"	: [34, "format('insertunorderedlist')", "Btn", 0],
	"Indent"		: [35, "format('indent')", "Btn", 0],
	"Outdent"		: [36, "format('outdent')", "Btn", 0],
	"BR"			: [37, "insert('br')", "Btn", 0],
	"Paragraph"		: [38, "format('InsertParagraph')", "Btn", 0],
	"ParagraphAttr"	: [39, "paragraphAttr()", "Btn", 0],

	"ComponentMenu"	: [40, "showToolMenu('component')", "Btn", 0],
	"Image"			: [41, "showDialog('img.htm', true)", "Btn", 0],
	"Flash"			: [42, "showDialog('flash.htm', true)", "Btn", 0],
	"Media"			: [43, "showDialog('media.htm', true)", "Btn", 0],
	"File"			: [44, "showDialog('file.htm', true)", "Btn", 0],
	"RemoteUpload"	: [45, "remoteUpload()", "Btn", 0],
	"LocalUpload"	: [46, "localUpload()", "Btn", 0],
	"Fieldset"		: [47, "showDialog('fieldset.htm', true)", "Btn", 0],
	"Iframe"		: [48, "showDialog('iframe.htm', true)", "Btn", 0],
	"HorizontalRule": [49, "format('InsertHorizontalRule')", "Btn", 0],
	"Marquee"		: [50, "showDialog('marquee.htm', true)", "Btn", 0],
	"CreateLink"	: [51, "createLink()", "Btn", 0],
	"Unlink"		: [52, "format('UnLink')", "Btn", 0],
	"Map"			: [53, "mapEdit()", "Btn", 0],
	"Anchor"		: [54, "showDialog('anchor.htm', true)", "Btn", 0],

	"GalleryMenu"	: [55, "showToolMenu('gallery')", "Btn", 0],
	"GalleryImage"	: [56, "showDialog('browse.htm?type=image', true)", "Btn", 0],
	"GalleryFlash"	: [57, "showDialog('browse.htm?type=flash', true)", "Btn", 0],
	"GalleryMedia"	: [58, "showDialog('browse.htm?type=media', true)", "Btn", 0],
	"GalleryFile"	: [59, "showDialog('browse.htm?type=file', true)", "Btn", 0],

	"ObjectMenu"		: [60, "showToolMenu('object')", "Btn", 0],
	"BgColor"			: [61, "showDialog('selcolor.htm?action=bgcolor', true)", "Btn", 0],
	"BackImage"			: [62, "showDialog('backimage.htm', true)", "Btn", 0],
	"absolutePosition"	: [63, "absolutePosition()", "Btn", 0],
	"zIndexBackward"	: [64, "zIndex('backward')", "Btn", 0],
	"zIndexForward"		: [65, "zIndex('forward')", "Btn", 0],
	"ShowBorders"		: [66, "showBorders()", "Btn", 0],
	"Quote"				: [67, "insert('quote')", "Btn", 0],
	"Code"				: [68, "insert('code')", "Btn", 0],

	"ToolMenu"		: [69, "showToolMenu('tool')", "Btn", 0],
	"Symbol"		: [70, "showDialog('symbol.htm', true)", "Btn", 0],
	"PrintBreak"	: [71, "insert('printbreak')", "Btn", 0],
	"Excel"			: [72, "showDialog('owcexcel.htm', true)", "Btn", 0],
	"Emot"			: [73, "showDialog('emot.htm', true)", "Btn", 0],
	"EQ"			: [74, "showDialog('eq.htm', true)", "Btn", 0],
	"Art"			: [75, "showDialog('art.htm', true)", "Btn", 0],
	"NowDate"		: [76, "insert('nowdate')", "Btn", 0],
	"NowTime"		: [77, "insert('nowtime')", "Btn", 0],
	"ImportWord"	: [78, "showDialog('importword.htm', true)", "Btn", 0],
	"ImportExcel"	: [79, "showDialog('importexcel.htm', true)", "Btn", 0],
	"Template"		: [123, "showDialog('template.htm', true)", "Btn", 0],

	"FormMenu"		: [80, "showToolMenu('form')", "Btn", 0],
	"FormText"		: [81, "format('InsertInputText')", "Btn", 0],
	"FormTextArea"	: [82, "format('InsertTextArea')", "Btn", 0],
	"FormRadio"		: [83, "format('InsertInputRadio')", "Btn", 0],
	"FormCheckbox"	: [84, "format('InsertInputCheckbox')", "Btn", 0],
	"FormDropdown"	: [85, "format('InsertSelectDropdown')", "Btn", 0],
	"FormButton"	: [86, "format('InsertButton')", "Btn", 0],

	"TableMenu"		: [87, "showToolMenu('table')", "Btn", 0],
	"TableInsert"	: [88, "TableInsert()", "Btn", 0],
	"TableProp"		: [89, "TableProp()", "Btn", 0],
	"TableCellProp"	: [90, "TableCellProp()", "Btn", 0],
	"TableCellSplit": [91, "TableCellSplit()", "Btn", 0],
	"TableRowProp"	: [92, "TableRowProp()", "Btn", 0],
	"TableRowInsertAbove"	: [93, "TableRowInsertAbove()", "Btn", 0],
	"TableRowInsertBelow"	: [94, "TableRowInsertBelow()", "Btn", 0],
	"TableRowMerge"			: [95, "TableRowMerge()", "Btn", 0],
	"TableRowSplit"			: [96, "TableRowSplit(2)", "Btn", 0],
	"TableRowDelete"		: [97, "TableRowDelete()", "Btn", 0],
	"TableColInsertLeft"	: [98, "TableColInsertLeft()", "Btn", 0],
	"TableColInsertRight"	: [99, "TableColInsertRight()", "Btn", 0],
	"TableColMerge"			: [100, "TableColMerge()", "Btn", 0],
	"TableColSplit"			: [101, "TableColSplit(2)", "Btn", 0],
	"TableColDelete"		: [102, "TableColDelete()", "Btn", 0],

	"FileMenu"		: [103, "showToolMenu('file')", "Btn", 0],
	"Refresh"		: [104, "format('refresh')", "Btn", 0],
	"ModeCode"		: [105, "setMode('CODE')", "Btn", 0],
	"ModeEdit"		: [106, "setMode('EDIT')", "Btn", 0],
	"ModeText"		: [107, "setMode('TEXT')", "Btn", 0],
	"ModeView"		: [108, "setMode('VIEW')", "Btn", 0],
	"SizePlus"		: [109, "sizeChange(300)", "Btn", 0],
	"SizeMinus"		: [110, "sizeChange(-300)", "Btn", 0],
	"Print"			: [111, "format('Print')", "Btn", 0],

	"ZoomMenu"		: [112, "showToolMenu('zoom')", "Btn", 0],
	"Maximize"		: [113, "Maximize()", "Btn", 0],
	"Minimize"		: [114, "parent.Minimize()", "Btn", 0],
	"Save"			: [115, "parent.doSave()", "Btn", 0],

	"Help"			: [116, "showDialog('help.htm')", "Btn", 0],
	"About"			: [117, "showDialog('about.htm')", "Btn", 0],
	"Site"			: [118, "window.open('http://www.ewebeditor.net')", "Btn", 0],

	"FontSizeMenu"		: [121, "showToolMenu('fontsize')", "Btn", 0],
	"FontNameMenu"		: [122, "showToolMenu('fontname')", "Btn", 0],
	"FormatBlockMenu"	: [124, "showToolMenu('formatblock')", "Btn", 0],

	"FontName"		: ["", "formatFont('face',this[this.selectedIndex].value);this.selectedIndex=0", "TBGen", 1],
	"FontSize"		: ["", "formatFont('size',this[this.selectedIndex].value);this.selectedIndex=0", "TBGen", 1],
	"FormatBlock"	: ["", "format('FormatBlock',this[this.selectedIndex].value);this.selectedIndex=0", "TBGen", 1],
	"ZoomSelect"	: ["", "doZoom(this[this.selectedIndex].value)", "TBGen", 1]

};
