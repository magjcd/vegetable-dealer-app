function showPwd(){
	var pwd = document.getElementById("uPwd");
	 	if(pwd.type === 'password'){
	 		pwd.type = 'text';
	 		document.getElementById("eye").style.color = "#000000";
	 	}else{
	 		pwd.type = 'password';
	 		document.getElementById("eye").style.color = "#ff0066";
	 	}
	 }