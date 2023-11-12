
// Function to fetch comments from the API
function fetchComments() {

    // // Get the query string
    // const queryString = window.location.search;
    
    // // Parse the query string using the URLSearchParams object
    // const searchParams = new URLSearchParams(queryString);
    
    // // Get the value of the 'id' query parameter
    // const id = searchParams.get('product_id');
    
   
      

        // Replace 'your-api-endpoint' with the actual URL of your API
        const apiUrl = 'http://localhost/api/product_read.php';
    
        // const productId = data.product_id;
    
        // Make a POST request to your API
        fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            
            const root = document.getElementById('root');
    
            root.innerHTML = '';
    
            // Loop through the comments and append them to the commentsContainer
            data.forEach(pro => {
                const rootchild = document.createElement('div');
                rootchild.className = 'box';
                rootchild.innerHTML =`
                <div class='box'>
                 <div class='img-box'>
                     <img class='images' src=${pro.image}></img>
                 </div>
                 <div class='bottom'>
                     <p>${pro.name}</p>
                     <h2>$ ${pro.price}.00</h2>
                     <button class="deleteFromCart" data-product-id="${pro.product_id}"><a id="btn" href="addtocart.html#${pro.product_id}">Add to cart</a></button>
                 </div>
             </div>`;
             //fix
    
                root.appendChild(rootchild);
               
            });
            
        const deleteButtons = document.querySelectorAll('.deleteFromCart');
        deleteButtons.forEach(button => {
            let userId = sessionStorage.getItem('id');
            button.addEventListener('click', () => {
                const productId = button.dataset.productId;
                lol(userId, productId);
   
            });
            
            showincart(userId)
        });
        })
        .catch(error => console.error('Error fetching comments:', error));
    }
    
    
    document.addEventListener('DOMContentLoaded', fetchComments);











   

// Search functionality
document.getElementById('search').addEventListener('keyup', function () {
    const searchTerm = this.value.toLowerCase();
  
    const dataToSend = {
      content: searchTerm,
    };
  
    fetch('http://localhost/ecommerce/API1/prouduct/getEventByCD.php', {
      method: 'POST',
      body: JSON.stringify(dataToSend),
      headers: {
        'Content-Type': 'application/json',
      },
    })
      .then(response => response.json())
      .then(data => {
        const root = document.getElementById('root');
        root.innerHTML = '';
  
        data.forEach(product => {
          const productElement = createProductElement(product);
          root.appendChild(productElement);
        });
      })
      .catch(error => console.error('Error fetching and filtering products:', error));
  });
  
  function createProductElement(product) {
    const productElement = document.createElement('div');
    productElement.className = 'box';
  
    productElement.innerHTML = `
      <div class="box">
        <div class="img-box">
          <img class="images" src="${product.image}" />
        </div>
        <div class="bottom">
          <p>${product.name}</p>
          <h2>$${product.price}.00</h2>
          <button id="btn" onclick="lol(${pro.product_id})">
            <a  href="addtocart.html#${pro.product_id}">
              Add to cart
            </a>
          </button>
        </div>
      </div>
    `;
 
    
    return productElement;
  }
  

let signupButton =document.getElementById("sigup");
let login = document.getElementById("login");
let logout = document.getElementById("logout");

let loggedin = sessionStorage.getItem('isLoggedIn');
if (loggedin == 'true') {
    login.innerHTML = '<a id="logout" href="login.html">LOG OUT</a>';
    // signupButton.innerHTML = '<a  href="profile.html">Profile</a>';
}


login.addEventListener('click',()=>{
  sessionStorage.setItem('isLoggedIn','false');
  window.location.href = 'login.html';
  if (loggedin == 'false') {
    login.innerHTML = '<a href="login.html">LOGIN</a>';
    signupButton.innerHTML = '<a  href="profile.html">Sign up</a>';
  }
  
});

function lol(userId, productId) {
      const dataToSend = {
          product_id: productId,
          user_id: userId, 
          AddorSub: 'add'
      };

      fetch('http://localhost/api/Cart_Add.php', {
          method: 'POST',
          body: JSON.stringify(dataToSend),
          headers: {
              'Content-Type': 'application/json',
          },
      })
      .then(response => {
          if (!response.ok) {
              throw new Error('Network response was not ok');
          }
         
          return response.json();
          
      })
      .then(data => {
          // Handle the data as needed
      
      })
      .catch(error => {
          console.error('Error fetching and filtering products:', error);
          // Handle the error, e.g., display an error message to the user
      });

}




function showincart(userId) {
    const dataToSend = {
        "id": userId
    };

    fetch('http://localhost/api/cart_read.php', {
        method: 'POST',
        body: JSON.stringify(dataToSend),
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        return response.json();
    })
    .then(data => {
        const root = document.getElementById('cartItem');

        // Check if the element with ID 'cartItem' exists
        if (!root) {
            console.error("Element with ID 'cartItem' not found.");
            return;
        }

        root.innerHTML = '';

        // Loop through the comments and append them to the commentsContainer
        data.forEach(pro => {
            const rootchild = document.createElement('div');
            rootchild.className = 'row-img';
            rootchild.innerHTML = `
                <div class='row-img'>
                    <img class='rowimg' src=${pro.image}>
                </div>
                <p style='font-size:12px;'>${pro.name}</p>
                <h2 style='font-size:15px;'>$ ${pro.price}.00 x ${pro.quantity}</h2>
            `;

            root.appendChild(rootchild);
        });
    })
    .catch(error => console.error('Error fetching cart items:', error));
}


/* <div class='cart-item'>
                    <div class='row-img'>
                        <img class='rowimg' src=${image}>
                    </div>
                    <p style='font-size:12px;'>${title}</p>
                    <h2 style='font-size:15px;'>$ ${price}.00 x ${quantity}</h2>
                    <p class="pl" id="pl" style='font-size:17px;' onclick='updateQuantity(${index}, "add")'>+</p>
                    <p class="pl" id="mi" style='font-size:17px;' onclick='updateQuantity(${index}, "subtract")'>-</p>
                    <i class='fa-solid fa-trash' onclick='delElement(${index})'></i>
                </div> */



//                 // Fetch the API
// fetch('http://localhost/your_api_endpoint.php', {
//   method: 'GET', // You mentioned it's a GET request
//   headers: {
//     'Content-Type': 'application/json',
//   },
// })
//   .then(response => response.json())
//   .then(data => {
//     // Get the container where you want to display the fetched data
//     const cartContainer = document.getElementById('cartContainer');

//     // Loop through the data and create HTML elements for each item
//     data.forEach((item, index) => {
//       const cartItem = document.createElement('div');
//       cartItem.className = 'cart-item';

//       cartItem.innerHTML = `
//         <div class='row-img'>
//           <img class='rowimg' src=${item.image}>
//         </div>
//         <p style='font-size:12px;'>${item.title}</p>
//         <h2 style='font-size:15px;'>$ ${item.price}.00 x ${item.quantity}</h2>
//         <p class="pl" id="pl" style='font-size:17px;' onclick='updateQuantity(${index}, "add")'>+</p>
//         <p class="pl" id="mi" style='font-size:17px;' onclick='updateQuantity(${index}, "subtract")'>-</p>
//         <i class='fa-solid fa-trash' onclick='delElement(${index})'></i>
//       `;

//       cartContainer.appendChild(cartItem);
//     });
//   })
//   .catch(error => console.error('Error fetching cart data:', error));

// // Example functions for the onclick events
// function updateQuantity(index, action) {
//   // Your logic for updating quantity
//   console.log(`Update quantity for item at index ${index}, action: ${action}`);
// }

// function delElement(index) {
//   // Your logic for deleting an item
//   console.log(`Delete item at index ${index}`);
// }
