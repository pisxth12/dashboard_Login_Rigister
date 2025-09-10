$(document).ready(function(){
  $('#add_product').on('submit', function(e){
    e.preventDefault(); // Prevent page reload

    var formData = new FormData(this); // Handle file upload

    $.ajax({
      url: 'http://localhost/dashboard/api/products/add_product.php',  // PHP script to handle form
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response){
        alert(response); // Show message from PHP
        $('#add_product')[0].reset(); // Reset form
        $('#addProductModal').modal('hide'); // Close modal
      },
      error: function(){
        alert('Error adding product.');
      }
    });
  });
});