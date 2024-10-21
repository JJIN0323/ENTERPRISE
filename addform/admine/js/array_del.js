function array_del(index) {	
	var buffer;	
	if (index==0) {		
		if (this.length>1) buffer=this.slice(1);		
		else buffer=new Array();
	} else if(this.length==index+1) {		
		buffer=this.slice(0,this.length-1);
	} else {		
		buffer=this.slice(0,index);
		buffer=buffer.concat(this.slice(index+1));
	}
	return buffer;
}
//상속받은 객체 배열 원형속성에 array_del을 추가
Array.prototype.array_del=array_del;