function loadProduct(category = ""){
    $('#productList').html("<center><p>Loading....</p></center>");
    let url = "https://fakestoreapi.com/products";
    if(category){
      url =  url = "https://fakestoreapi.com/products/category/" + encodeURIComponent(category);
    }
    $.ajax({
      url:url,
      method:"GET",
      success: function(products){
        $("#productList").empty();

        $.each(products , function(index , product){
          $("#productList").append(`
             <div class="col-md-3">
              <div class="card h-100 shadow-sm">
                <img src="${product.image}" class="card-img-top p-3" alt="${product.title}" style="height:200px; object-fit:contain;">
                <div class="card-body d-flex flex-column">
                  <h6 class="fw-bold">${product.title}</h6>
                  <p class="text-muted small">${product.description.substring(0, 60)}...</p>
                  <p class="fw-bold text-primary">$${product.price}</p>
                  <button id="" class="btn btn-dark mt-auto">Add to Cart</button>
                </div>
              </div>
            </div>
          `)
        })

      },
      error: function(){
         $("#productList").html("<p class='text-danger'>Failed to load products.</p>");
      }
    })
   }
   loadProduct();

   $("#main_content").on("change", "#genderFilter", function() {
  let selected = $(this).val();
  loadProduct(selected);
});