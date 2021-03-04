function validate() {
	var form = document.getElementById("f");
	var email = document.forms['f']['email'].value;
    var tos = document.forms['f']['tos'].checked;
	var tosDiv = document.getElementsByClassName("tos")[0];
    var oldError = document.getElementById("error");
	
	if(oldError){
		oldError.remove();
	}
	
	var valid = 1;

    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var reCo = /\S+@\S+\.co$/;
	
	var error = document.createElement("div");
	error.setAttribute('id', 'error');
	
	if(!email) {
		var message = document.createElement("p");
		message.setAttribute('id', 'message');
		message.innerText = 'Email address is required';
		error.appendChild(message);
		console.log('1');
    }
	if(!(re.test(email))) {
		var message = document.createElement("p");
		message.setAttribute('id', 'message');
		message.innerText = 'Please provide a valid e-mail address';
		error.appendChild(message);
		console.log('2');
    }
	if(reCo.test(email)) {
		var message = document.createElement("p");
		message.setAttribute('id', 'message');
		message.innerText = 'We are not accepting subscriptions from Colombia e-mails';
		error.appendChild(message);
		valid = 0;
    }
	if(!tos) {
		var message = document.createElement("p");
		message.setAttribute('id', 'message');
		message.innerText = 'You must accept the terms and conditions';
		error.appendChild(message);
		valid = 0;
    }
	if(valid == '0') {
		form.appendChild(error);
		valid = 1;	
		return false;
	}
}