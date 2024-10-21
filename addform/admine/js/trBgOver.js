function trBgOver(target)												//테이블 행간 롤오버 함수2
{
	if (document.getElementById && document.createTextNode)
	{
		var tables=document.getElementsByTagName('table');
		for (var i=0;i<tables.length;i++)
		{
			if(tables[i].className==target)
			{
				var trs=tables[i].getElementsByTagName('tr');
				for(var j=0;j<trs.length;j++)
				{
					if(trs[j].parentNode.nodeName=='TBODY')
					{
						trs[j].onmouseover=function(){this.className='ruled2';return false}
						trs[j].onmouseout=function(){this.className='';return false}
					}
				}
			}
		}
	}
}
