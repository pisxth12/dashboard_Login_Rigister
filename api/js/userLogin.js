$(document).ready(function(){


    function showUser(){
      const username = localStorage.getItem('username');
      const image = localStorage.getItem('image');
      const role = localStorage.getItem('role'); 

      let imagePath = role === "admin" ? 'api/admin/profile/admin.jpg' : `api/upload/${image}`;

      if(username && image){
        $('.user_account').html(`
           <div class="user_profile d-flex align-items-center">
                <img src="${imagePath}" alt="profile" style="border-radius: 50%; object-fit: cover;" width="40px" height="40px">
                <p class="fw-bolder text-uppercase m-auto px-2">${username} ${role === 'admin' ? '(Admin)' : ''}</p>
                <button id="btnSignout" class="btn btn-outline-danger">Sign out</button>
           </div>
        `);

        $("#btnSignout").click(function(){
          localStorage.removeItem('username');
          localStorage.removeItem('image');
          localStorage.removeItem('role'); 

          $.get("logout.php", function(){
            location.reload();
          });
          location.reload();
        });
      }
    }

    showUser();

    $("#registerForm").on('submit', function(e){
      e.preventDefault();

      var formData = new FormData(this);
      $.ajax({
        url:"http://localhost/dashboard/api/register.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(response){
          if(response.status === "success"){
            alert("Register successfully");
            localStorage.setItem('username', response.username);
            localStorage.setItem('image', response.image);
            localStorage.setItem('role', response.role); // save role
            
            var modalEl = document.getElementById('exampleModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            $("#registerForm")[0].reset();
            showUser();

          } else {
            alert("fail register: " + response.message);
            $("#registerForm")[0].reset();
          }
        },
        error: function(error){
          alert("Error connect");
          $("#registerForm")[0].reset();
        }
      });
    });

    $("#loginForm").on('submit', function(e){
      e.preventDefault();
      
      var formData2 = new FormData(this);

      $.ajax({
        url:"http://localhost/dashboard/api/login.php",
        method: "POST",
        data: formData2,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(response){
          if(response.status === "success"){
            alert("Login successfully");
            localStorage.setItem('username', response.username);
            localStorage.setItem('image', response.image);
            localStorage.setItem('role', response.role); // save role
            showUser();

            var modalEl = document.getElementById('loginModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            if(modal) modal.hide();

            var formEl = document.getElementById('loginForm');
            if(formEl) formEl.reset();

          } else {
            alert("Error: " + response.message);
            var formEl = document.getElementById('loginForm');
            if(formEl) formEl.reset();
          }
        },
        error: function(xhr, textStatus, errorThrown){
            alert("Login failed: " + textStatus + " - " + errorThrown);
            var formEl = document.getElementById('loginForm');
            if(formEl) formEl.reset();
        }
      });

    });
  });