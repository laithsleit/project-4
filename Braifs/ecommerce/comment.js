// Function to fetch comments from the API
function fetchComments() {

// Get the query string
// const queryString = window.location.search;

// // Parse the query string using the URLSearchParams object
// const searchParams = new URLSearchParams(queryString);

// // Get the value of the 'id' query parameter
// const id = searchParams.get('product_id');


    // Replace 'your-api-endpoint' with the actual URL of your API
    const apiUrl = 'https://localhost/ecommerce/API1/rate/reedrate.php';
    // Replace 'your-product-id' with the actual product ID you want to fetch comments for
    const data = {
        "product_id": 7
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
            commentsContainer.className = 'commented-section mt-2';
            commentsContainer.innerHTML = `
                <div class="commented-section mt-2">
                    <div class="d-flex flex-row align-items-center commented-user">
                        <h5 class="mr-2">${comment.username}</h5><span class="dot mb-1"></span><span class="mb-1 ml-2">rate ${comment.rate}/5</span>
                    </div>
                    <div class="comment-text-sm"><span>${comment.comment_content}</span></div>
                    <div class="reply-section">
                        <hr>                           
                    </div>
                </div>
            `;
            // {
            //     "comment_id": "2",
            //     "comment_content": "Nice item, but a bit expensive.",
            //     "rate": "4",
            //     "user_id": "18",
            //     "product_id": "7"
            // },

            
         cont.appendChild(commentsContainer);
        });
    })
    .catch(error => console.error('Error fetching comments:', error));
}

// Call the fetchComments function when the page loads
document.addEventListener('DOMContentLoaded', fetchComments);



document.addEventListener("DOMContentLoaded", function () {
    const commentButton = document.getElementById("commentButton");

    commentButton.addEventListener("click", function () {
        const commentInput = document.getElementById("commentInput").value;
        const rateInput = document.getElementById("rateInput").value;

        
        // Replace the following values with your actual data
        const commentData = {
            "comment_content": commentInput,
            "rate": rateInput,
            "product_id": 7,
            "user_id": 19
        };

        fetch('http://localhost/ecommerce/API1/rate/insert.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(commentData),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            // Update the UI or perform any other actions on success
        })
        .catch((error) => {
            console.error('Error:', error);
            // Handle errors here
        });
    });
});
