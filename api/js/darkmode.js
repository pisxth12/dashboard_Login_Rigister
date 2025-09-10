
   const toggle = document.querySelector('.dark_mode');
    toggle.addEventListener('click', () => {
      document.body.classList.toggle('dark');



      if(document.body.classList.contains('dark')){
        localStorage.setItem('theme', 'dark');
      } else {
        localStorage.setItem('theme', 'light');
      }
    });

    window.onload = () => {
      if(localStorage.getItem('theme') === 'dark'){
        document.body.classList.add('dark');
      }
    }