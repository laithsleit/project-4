document.querySelector(".jsFilter").addEventListener("click", function () {
    document.querySelector(".filter-menu").classList.toggle("active");
  });
  
  document.querySelector(".grid").addEventListener("click", function () {
    document.querySelector(".list").classList.remove("active");
    document.querySelector(".grid").classList.add("active");
    document.querySelector(".products-area-wrapper").classList.add("gridView");
    document
      .querySelector(".products-area-wrapper")
      .classList.remove("tableView");
  });
  
  document.querySelector(".list").addEventListener("click", function () {
    document.querySelector(".list").classList.add("active");
    document.querySelector(".grid").classList.remove("active");
    document.querySelector(".products-area-wrapper").classList.remove("gridView");
    document.querySelector(".products-area-wrapper").classList.add("tableView");
  });
  
  var modeSwitch = document.querySelector('.mode-switch');
  modeSwitch.addEventListener('click', function () {                      
  document.documentElement.classList.toggle('light');
   modeSwitch.classList.toggle('active');
  });
  
  
  document.addEventListener("DOMContentLoaded", function() {
    const eventContainer = document.querySelector('.products-area-wrapper');
  
    fetch('http://localhost/ecommerce/API1/user/readorder.php')
      .then(response => response.json())
      .then(data => {
        data.forEach(comment => {
          const productRow = document.createElement('div');
          productRow.className = 'products-row';
  
          productRow.innerHTML = `
          <div class="product-cell category">
            <span class="cell-label">Event Name:</span>${comment.username}
          </div>
          <div class="product-cell">
            <span class="cell-label">Event Date:</span>${comment.order_date}
          </div>
          <div class="product-cell">
            <span class="cell-label">Event Date:</span>${comment.total_price}
          </div>
        
         
         
        `;
  
        eventContainer.appendChild(productRow);
        });
      })
      .catch(error => console.error('Error:', error));
  });
  