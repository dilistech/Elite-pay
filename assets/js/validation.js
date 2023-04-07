const signUpForm= document.querySelector('#sign-up-form');
const firstName= document.querySelector('#first-name');
const lastName= document.querySelector('#last-name');
const phone = document.querySelector('#phone');
const email= document.querySelector('#email');
const pass = document.querySelector('#pass');
const comfirmPass = document.querySelector('#comfirm-pass');
const walletAdderess = document.querySelector('#wallet-address');


signUpForm.addEventListener('submit', e => {

const emailVal = email.value.toLowerCase().trim();
const passVal = pass.value.trim();
const comfirmPassVal = comfirmPass.value.trim();


    let messages = [];        
    const regex = new RegExp(' /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/');
if (regex.test(emailVal)) {
    email.style.border = '1px solid green'; 
} else {
    email.style.border = '1px solid red'; 
    
}
console.log(pass,comfirmPass);

signUpForm.querySelectorAll('input').forEach(i => {
if (i.value === ''){
    i.style.border = '1px solid red';   
    messages.push('This field cannot be empty'); 
}else{
    i.style.border = '1px solid green';
}
});
if (passVal === comfirmPassVal) {
    pass.style.border = '1px solid green'; 
    comfirmPass.style.border = '1px solid green'; 
} else {
    messages.push('Password do not match');
    pass.style.border = '1px solid red'; 
    comfirmPass.style.border = '1px solid red'; 
}
if (messages.length > 0) {
    e.preventDefault();
}


});
