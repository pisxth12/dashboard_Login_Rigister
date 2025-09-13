
                          $(document).ready(function(){


                            function loadProducts(){
                              $.ajax({
                                url:"http://localhost/dashboards/api/products/fetch_product.php",
                                type: "GET",
                                dataType:"JSON",
                                success: function(products){
                                  showHTML = ""
                                  if(products.length){
                                    products.forEach(product=>{
                                      showHTML += `
                                        <div class="card flex-grow-1" style="width: 18rem;" >
                                            <img class="card-img-top object-fit-cover" src="${product.image_url}" alt="${product.productName}" style="height: 300px!important;">
                                            <div class="card-body">
                                              <div class="info d-flex justify-content-between py-3">
                                                <h5 class="card-title">${product.productName}</h5>
                                                <h5>$${parseFloat(product.price).toFixed(2)}</h5>
                                              </div>
                                              <p class="card-text">${product.description}</p>
                                              <button class="remove_product_btn btn btn-danger" data-product="${product.productName}">Remove</button>
                                            </div>
                                          </div>
                                      `
                                    })
                                  }else{
                                    showHTML = `<p>No products found.</p>`;
                                  }
                                  $("#product-display").html(showHTML)
                                },
                                error: function(xhr){
                                  console.log(xhr.responseText);
                                }
                              });
                            }

                            loadProducts()




                            $("#addProductForm").on('submit' , function(e){
                              e.preventDefault();
                              var formData = new FormData(this);

                              $.ajax({
                                url:"http://localhost/dashboards/api/admin/add_product.php",
                                type: "POST",
                                data: formData,
                                contentType:false,
                                processData:false,
                                dataType:"JSON",
                                success: function(response){
                                  if(response.status ==="success"){
                                    alert(response.message);
                                    $("#addProductForm")[0].reset();
                                    var productModal = bootstrap.Modal.getInstance(document.getElementById('modal1'));
                                    productModal.hide();
                                    loadProducts()


                                  }else{
                                    alert("Faild" + response.message);
                                  }
                                },
                                error: function(xhr){
                                  console.log(xhr.responseText);
                                  alert("Error Uploding data");
                                }
                              })

                            })

                            });

                      