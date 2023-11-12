// Function to fetch comments from the API
function fetchComments() {

// // Get the query string
// const queryString = window.location.search;

// // Parse the query string using the URLSearchParams object
// const searchParams = new URLSearchParams(queryString);

// // Get the value of the 'id' query parameter
// const id = searchParams.get('product_id');



    // Replace 'your-api-endpoint' with the actual URL of your API
    const apiUrl = 'http://localhost/api/comment_read.php';

    // Replace 'your-product-id' with the actual product ID you want to fetch comments for
    const data = {
        "product_id": 6
    };

    const productId = data.product_id;

    // Make a POST request to your API
    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(comments => {
        // Get the commentsContainer element
        const cont = document.getElementById('cont');

        cont.innerHTML = '';

        // Loop through the comments and append them to the commentsContainer
        comments.forEach(comment => {
            const commentsContainer = document.createElement('div');
            commentsContainer.className = 'comment mt-4 text-justify float-left';
            commentsContainer.innerHTML = `
                <div class="comment mt-4 text-justify float-left" style="min-width: 540px;min-height: 235px;background:black;color:white">
                    <img src="https://i.imgur.com/yTFUilP.jpg" alt="" class="rounded-circle" width="40" height="40">
                    <h4>${comment.username}</h4>
                    <span>&nbsp&nbsp${comment.rate}/5</span>
                    <br>
                    <p>${comment.comment_content}</p>
                </div>
            `;

            cont.appendChild(commentsContainer);
        });
    })
    .catch(error => console.error('Error fetching comments:', error));
}

// Call the fetchComments function when the page loads
document.addEventListener('DOMContentLoaded', fetchComments);



    const commentButton = document.getElementById("post");

    commentButton.addEventListener("click", function () {
        const commentInput = document.getElementById("commentInput").value;
        const rateInput = document.getElementById("rateInput").value;

        
      
        const commentData = {
            "comment_content":commentInput,
            "rate": rateInput,
            "product_id": 6,
            "user_id": 5
          };

        fetch('http://localhost/api/comment_insert.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(commentData),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);

        })
        .catch((error) => {
            console.error('Error:', error);
            // Handle errors here
        });
    });
