document.addEventListener("DOMContentLoaded", function() {
  // Initialize Swiper
  var swiper = new Swiper('.content', {
      effect: 'coverflow',
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 'auto',
      coverflowEffect: {
          rotate: 50,
          stretch: 0,
          depth: 100,
          modifier: 1,
          slideShadows: true,
      },
      pagination: {
          el: '.swiper-pagination',
      },
  });

  document.querySelectorAll(".select-button").forEach(function(button) {
      button.addEventListener("click", function(event) {
          event.preventDefault(); // Prevent default label behavior
          const userId = this.getAttribute("data-user-id");

          var xhr = new XMLHttpRequest();
          xhr.open("POST", "../actions/room_selection.php", true);
          xhr.setRequestHeader("Content-Type", "application/json");

          xhr.onreadystatechange = function () {
              if (xhr.readyState === 4) {
                  if (xhr.status === 200) {
                      console.log("Success:", xhr.responseText);
                  } else {
                      console.error("Error:", xhr.statusText);
                  }
              }
          };

          var data = JSON.stringify({ userId: userId });
          xhr.send(data);
      });
  });
});
