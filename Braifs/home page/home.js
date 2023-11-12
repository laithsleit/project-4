

let signupButton =document.getElementById("sigup");
let login = document.getElementById("login");
let logout = document.getElementById("logout");

let loggedin = sessionStorage.getItem('isLoggedIn');
if (loggedin == 'true') {
    login.innerHTML = '<a id="logout" href="login.html">LOG OUT</a>';
    signupButton.innerHTML = '<a  href="profile.html">Profile</a>';
}


login.addEventListener('click',()=>{
  sessionStorage.setItem('isLoggedIn','false');
  window.location.href = 'login.html';
  if (loggedin == 'false') {
    login.innerHTML = '<a href="login.html">LOGIN</a>';
    signupButton.innerHTML = '<a  href="signup.html">Sign up</a>';
  }
  
});