function URLParams (ParamName)
{
	// ȡͨ��URL�������Ĳ��� (��ʽ�� ?Param1=Value1&Param2=Value2)

	var URLParams = new Object();
	var aParams = document.location.search.substr(1).split('&');
	for (i=0; i < aParams.length; i++)
	{
		var aParam = aParams[i].split('=');
		URLParams[aParam[0]] = aParam[1];
	}

	return URLParams[ParamName];
}

