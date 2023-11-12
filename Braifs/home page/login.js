// function submitForm() {
//     const formData = {
//         first: document.getElementById('first').value,
//         email: document.getElementById('email').value,
//         pass: document.getElementById('pass').value,
//         errorEmail: document.getElementById('error-email'),
//         errorPass: document.getElementById('error-pass'),
//     };

//     // Remove red border from all elements initially
//     for (const key in formData) {
//         document.getElementById(key).style.border = "1px solid #ccc"; // Adjust the border style as needed
//     }

//     if (formData.email.match(/[^\s@]+@[^\s@]+\.[^\s@]+/gi)) {
//         formData.errorEmail.style.display = "none";
//     } else {
//         formData.errorEmail.style.display = "block";
//         document.getElementById('email').style.border = "1px solid red";
//         return false;
//     }

//     if (formData.pass.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/)) {
//         formData.errorPass.style.display = "none";
//     } else {
//         formData.errorPass.style.display = "block";
//         document.getElementById('pass').style.border = "1px solid red";
//         return false;
//     }

//     for (const key in formData) {
//         if (formData[key] === "") {
//             document.getElementById(key).style.border = "1px solid red";
//             return false;
//         }
//     }

//     document.querySelector('.form').submit();
// }


// // Submit

var loginButton = document.getElementById("Login");
loginButton.addEventListener('click', function (event) {
    event.preventDefault();
    // let isEmailValid = validationEmail();
    // let isPassValid = validationPass();

    // if (isEmailValid && isPassValid) {
        let email = document.getElementById("email").value;
        let password = document.getElementById("pass").value;

        var user = {
            username: email,
            password: password
        };

        fetch('http://localhost/api/login_oop.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(user)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse the response body as JSON
            })
            .then(data => {
                console.log(data);
                let idname = data.user_id;
                if (data.STATUS == true) {
                    if (data.role == 2) {
                        sessionStorage.setItem("isLoggedIn", "true");
                        sessionStorage.setItem("id", idname);
                        window.location.href = "Home.html";

                    } else if (data.role == 1) {
                        sessionStorage.setItem("isLoggedIn", "true");
                        sessionStorage.setItem("id", idname);
                        window.location.href = "index.html";
                        // need edit


                    } else {
                        alert('Error: Invalid user');
                    }
                } else {
                    alert('Error: Invalid stats');


                }
            })

            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                // Display an error message on the page if needed
            });
        // }
});




