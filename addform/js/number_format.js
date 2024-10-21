function number_format(x){
       var y = x.value;
       while(y.match(/^(-?\d+)(\d{3})/)){
		y = y.replace(/^(-?\d+)(\d{3})/,'$1,$2');
		}		
       x.value = y;
}