function money_china(insu)
{
	var arr_krUnit  = new Array(
		"仟","百","拾","無量大數",
		"仟","百","拾","不可思議",
		"仟","百","拾","那由他",
		"仟","百","拾","阿僧祇",
		"仟","百","拾","恒河沙",		
		"仟","百","拾","極",
		"仟","百","拾","載",
		"仟","百","拾","正",
		"仟","百","拾","澗",
		"仟","百","拾","溝",
		"仟","百","拾","穰",
		"仟","百","拾","柘",
		"仟","百","拾","垓",
		"仟","百","拾","京",
		"仟","百","拾","兆",
		"仟","百","拾","亿",
		"仟","百","拾","万",
		"仟","百","拾",""
	);

    var arr_kr = new Array(
		"壹",
		"貳",
		"參",
		"肆",
		"伍",
		"陸",
		"柒",
		"捌",
		"玖"
	);

	var arr_krDecimal = new Array(
		"拾",
		""
	);

    
	var insu = insu.split(".");

    var i = 0;
    var n = arr_krUnit.length-1;
    var insuString = '';
	var insuString2 = '';
    var extractStr = '';
	var extractStr2 = '';
    
	//소수점 왼쪽 금액 문자화
    for(i = insu[0].length;i>0;i--)
    {
        extractStr = insu[0].substring(i-1,i);
        if(extractStr != '0' ||
          ((n+1)%4 == 0 &&
            ((i >= 2 && insu[0].substring(i-2,i-1) !='0') ||
            (i >= 3 && insu[0].substring(i-3,i-2) !='0') ||
            (i >= 4 && insu[0].substring(i-4,i-3) !='0')
            )
          )
          )
            insuString = arr_krUnit[n]+insuString;
        if(extractStr != '0')
            insuString = arr_kr[parseInt(extractStr)-1]+insuString;
        n--;
    }

	//소수점 오른쪽 금액 문자화
	if (insu[1])
	{
		if (insu[1].length > 0)
	{
		for(i = 0; i < insu[1].length; i++)
		{
			extractStr2 = insu[1].substr(i,1);
				if(extractStr2 != '0')
				{
					insuString2 = insuString2+arr_kr[parseInt(extractStr2)-1]+arr_krDecimal[i];
				}       
		}

	}
	}
	
	
	var kr_coin;
	if (insu[1])
	{
		kr_coin = insuString+"원"+insuString2+"전";
	}
	else kr_coin = insuString+"원";
	
	return kr_coin;
	
}