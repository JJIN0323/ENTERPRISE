//get 으로 넘겨받은 값을 자바스크립트에서 사용
function f_getStr(url)
{
   var res    = new Array;
   var url_queryStr = location.search; // ?를 포함한 get string
   var arr1    = new Array; 
   var arr2    = new Array;
   var i = 0;

   url_queryStr = url_queryStr.slice(1);   
   arr1    = url_queryStr.split("&");   

   for(i=0; i< arr1.length; i++)
   {
      arr2 = arr1[i].split("=");   
      res[arr2[0]] = arr2[1]; 
   }   

   if(res[url] != null)
   {      
      return res[url];      
   }
   else
   {      
      return "";
   }
}

if(f_getStr("w") != "")
{
   pop_center(f_getStr("w"),f_getStr("h"));
}

function pop_center(w,h){
winToTop = (screen.height) ? (screen.height-h)/2 : 0;
winToLeft = (screen.width) ? (screen.width-w)/2 : 0;
window.resizeTo(w, h);
window.moveTo(winToLeft,winToTop);
}


