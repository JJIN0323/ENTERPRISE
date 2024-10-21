function func_calendar(obYear, obMonth, obDay, BoxId, ClassName)
{
	arr_Month = new Array(
		'1월', 
		'2월', 
		'3월', 
		'4월', 
		'5월', 
		'6월', 
		'7월', 
		'8월', 
		'9월', 
		'10월', 
		'11월', 
		'12월'
	);
    
    NewD = new Date();
	Year = (obYear == null) ? NewD.getFullYear() : obYear;
    Month = (obMonth == null) ? NewD.getMonth() : obMonth - 1;
    while(Month < 0){Month += 12;Year--}
    while(Month >= 12){Month -= 12;Year++}
    Day = (obDay == null) ? 0 : obDay;
    NewD = new Date(Year, Month, 1);
    NextMonth = new Date(Year, Month + 1, 1);
    WeekStart = NewD.getDay();    
    Mdays = Math.round((NextMonth.getTime() - NewD.getTime()) / 86400000) + 1;
    
    if(BoxId != null)
    {
        BoxId = BoxId;
        Box = document.getElementById(BoxId);
        
        if(!Box)
            document.write('<div id="' + BoxId + '">&nbsp;</div>');
    }
    else
    {
        
        do
        {
            BoxId = 'cal_tbl' + Math.round(Math.random() * 1000);
        }
        while(document.getElementById(BoxId));
        
        document.write('<div id="' + BoxId + '">&nbsp;</div>');
    }
    Box = document.getElementById(BoxId);
    ClassName = (ClassName == null) ? 'cal_tbl' : ClassName;
    CODEING = '<table class="' + ClassName + '" cellspacing="0">';
    // 상 단 구 성
    CODEING += '<tr class="cal_title"><td class="Nav"><a href="javascript:void(0)" onclick="func_calendar(' + Year + ', ' + Month + ', ' + Day+', \''+BoxId+'\', \''+ClassName+'\');"><img src=\'icon_prew.gif\' border=0></a></td><td colspan="5" class="Title">' + arr_Month[Month] + ' ' + Year + '</td><td class="Nav"><a href="javascript:void(0)" onclick="func_calendar(' + Year + ', ' + (Month + 2) + ', ' + Day+', \''+BoxId+'\', \''+ClassName+'\');"><img src=\'icon_next.gif\' border=0></a></td></tr>';
    // 요일 표기방법
    CODEING += '<tr class="cal_week"><td>일</td><td>월</td><td>화</td><td>수</td><td>목</td><td>금</td><td>토</td></tr>';
    CODEING += '<tr class="cal_day">';

    for(count_days = 0; count_days < WeekStart; count_days++)
    {
        CODEING += '<td>&nbsp;</td>';
    }
    
    for(count_days = 1; count_days < Mdays; count_days++)
    {
        if((count_days + WeekStart) % 7 == 1) CODEING += '<tr class="cal_day">';
        if(count_days == Day)
            CODEING += '<td class="SelectedDay"><a href="javascript:ToOpener(' + count_days + ')">' + count_days + '</a></td>';
        else CODEING += '<td><a href="javascript:ToOpener(' + count_days + ')">' + count_days + '</a></td>';
        if((count_days + WeekStart) % 7 == 0) CODEING += '</tr>';
    }
    
    for(j = (42 - (Mdays + WeekStart)), count_days = 0; count_days <= j; count_days++)
    {
        CODEING += '<td>&nbsp;</td>';
        if((j - count_days) % 7 == 0) CODEING += '</tr>';
    }
    CODEING += '</table>';
    Box.innerHTML = CODEING;
    return BoxId;
}



function ToOpener(Day)
{	
	Month = Month+1;
	if(Month < 10)
	{
		Month = "0"+Month;
	}
	if(Day < 10)
	{
		Day = "0"+Day;
	}
	opener.Date_in(Day, Month, Year,getId1,getId2);
	
    window.close();
}



function init_calendar(obYear, obMonth, obDay)
{	
func_calendar(obYear, obMonth, obDay, 'calendar', 'cal_TblTop'); 
}
