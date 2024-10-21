function money_kr(insu)
{
	var arr_krUnit  = new Array(
		"천","백","십","무량대수",
		"천","백","십","불가사의",
		"천","백","십","나유타",
		"천","백","십","아승기",
		"천","백","십","항하사",	
		"천","백","십","극",
		"천","백","십","재",
		"천","백","십","정",
		"천","백","십","간",
		"천","백","십","구",
		"천","백","십","양",
		"천","백","십","자",
		"천","백","십","해",
		"천","백","십","경",
		"천","백","십","조",
		"천","백","십","억",
		"천","백","십","만",
		"천","백","십",""
	);

    var arr_kr = new Array(
		"일",
		"이",
		"삼",
		"사",
		"오",
		"육",
		"칠",
		"팔",
		"구"
	);

	var arr_krDecimal = new Array(
		"십",
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