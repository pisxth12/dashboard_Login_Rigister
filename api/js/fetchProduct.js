

                        $(document).ready(function(){

                             function loadProducts(){
                              $.ajax({
                                url:"http://localhost/dashboards/api/products/fetch_product.php",
                                type: "GET",
                                dataType:"JSON",
                                success: function(products){
                                  showHTML = "";
                                  if(products.length){
                                    products.forEach(product=>{
                                      showHTML += `
                                        <div class="card " style="width: 18rem;" >
                                            <img class="card-img-top object-fit-cover" src="${product.image_url}" alt="${product.productName}" >
                                            <div class="card-body">
                                              <div class="info d-flex justify-content-between py-3">
                                                <h5 class="card-title">${product.productName}</h5>
                                                <h5>$${parseFloat(product.price).toFixed(2)}</h5>
                                              </div>
                                              <p class="card-text">${product.description}</p>
                                            
                                            </div>
                                          </div>
                                      `
                                    })
                                  }else{
                                    showHTML = `<p>No products found.</p>`;
                                  }
                                  $("#productList").html(showHTML)
                                },
                                error: function(xhr){
                                  console.log(xhr.responseText);
                                }
                              });
                            }
                            loadProducts()
                        })
                    