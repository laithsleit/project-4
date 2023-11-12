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
  
    fetch('http://localhost/ecommerce/API1/category/read_category.php')
      .then(response => response.json())
      .then(data => {
        data.forEach(comment => {
          const productRow = document.createElement('div');
          productRow.className = 'products-row';
  
          productRow.innerHTML = `
          <div class="product-cell category">
            <span class="cell-label">category Name:</span>${comment.category_id}
          </div>
          <div class="product-cell">
            <span class="cell-label">category Date:</span>${comment.category_name}
          </div>
         
          <div class="product-cell" ">
            <button style ="margin-left:10px"class="app-content-headerButton"><a style = "text-decoration: none;color:white;" href="http://localhost/ecommerce/API1/category/delete_category.php?id=${comment.category_id}">Delete</a></button>
          </div>
        `;
  
        eventContainer.appendChild(productRow);
        });
      })
      .catch(error => console.error('Error:', error));
  });
  