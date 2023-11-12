document.getElementById('login-button').addEventListener('click', function(event) {
    event.preventDefault();
    createUser();
});

function createUser() {
    var username = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('pass').value;
   

// http://localhost/api/signup_oop.php

    var user = {
        username: username,
        email: email,
        password: password
    };
    // Make a POST request using Fetch API
    fetch('http://localhost/api/signup_oop.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(user)
    })
    .then(response => {
        
        if (response.ok) {
            window.location.href = "login.html";
        } else {
           
            throw new Error('Network response was not ok.');
        }
    })
    .catch(error => {
        
        console.error('There was a problem with the fetch operation:', error);
       
    });
}



