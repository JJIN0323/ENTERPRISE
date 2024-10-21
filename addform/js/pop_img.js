function pop_img(img)
{ 
  img1= new Image(); 
  img1.src=(img); 
  imgControll(img); 
} 

function imgControll(img)
{ 
  if((img1.width!=0)&&(img1.height!=0))
  { 
    popup_img(img); 
  } 
  else
  { 
    controller="imgControll('"+img+"')"; 
    intervalID=setTimeout(controller,20); 
  } 
} 

function popup_img(img)
{ 
		W=img1.width; 
        H=img1.height;
		LeftPosition = (screen.width) ? (screen.width-W)/2 : 0;
		TopPosition = (screen.height) ? (screen.height-H)/2 : 0;
         
        option="width="+W+",height="+H+",top="+TopPosition+",left="+LeftPosition+""; 
        imgWin=window.open("","",option); 
		imgWin.document.write("<html><head><title>PREVIEW IMAGE</title></head>");
        imgWin.document.write("<body style='margin:0;padding:0;'>");
        imgWin.document.write("<img src=\""+img+"\" onclick='self.close();' style='cursor:hand;'>");
		imgWin.document.write("</body></html>");
        imgWin.document.close();
} 