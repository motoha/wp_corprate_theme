<footer class="bg-gray-800 text-gray-400 py-6">
    <div class="container mx-auto text-center">
     <p>
      © 2023 Oil &amp; Gas Co. All rights reserved.
     </p>
     <div class="mt-4 space-x-4">
      <a class="hover:text-white" href="#">
       <i class="fab fa-facebook-f">
       </i>
      </a>
      <a class="hover:text-white" href="#">
       <i class="fab fa-twitter">
       </i>
      </a>
      <a class="hover:text-white" href="#">
       <i class="fab fa-linkedin-in">
       </i>
      </a>
      <a class="hover:text-white" href="#">
       <i class="fab fa-instagram">
       </i>
      </a>
     </div>
    </div>
   </footer>


<?php wp_footer(); ?>
 <!-- Remaining sections (About Us, Services, Projects, Contact) remain unchanged -->
    <!-- ... [Keep your existing sections here] ... -->

    <!-- Scripts -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
          const swiper = new Swiper('.swiper-container', {
            loop: true,
            speed: 1000,
            autoplay: {
              delay: 5000,
              disableOnInteraction: false,
            },
            pagination: {
              el: '.swiper-pagination',
              clickable: true,
            },
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },
            on: {
              slideChangeTransitionStart: function () {
                // Pause all videos when slide changes
                document.querySelectorAll('.swiper-slide video').forEach(video => {
                  video.pause();
                });
              },
              slideChangeTransitionEnd: function () {
                // Autoplay video in active slide
                const activeSlide = document.querySelector('.swiper-slide-active');
                const video = activeSlide.querySelector('video');
                if (video) {
                  video.play();
                }
              }
            }
          });
        });
      </script>
      
      <!-- Additional CSS -->
      <style>
        .swiper-container {
          width: 100%;
          height: auto;
        }
        .swiper-slide {
          position: relative;
        }
        .swiper-slide video {
          object-fit: cover;
        }
        @media (max-width: 768px) {
          .swiper-slide {
            height: 60vh !important;
          }
        }
      </style>

 
  
  <!-- Additional CSS for Mobile Menu -->
  <style>
    /* Mobile menu animations */
    @keyframes slide-down {
      from { transform: translateY(-10px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
    
    #mobile-menu ul li.relative > ul {
      animation: slide-down 0.3s ease-out;
    }
    
    /* Chevron rotation */
    .rotate-180 {
      transform: rotate(180deg);
      transition: transform 0.3s ease;
    }
  </style>
</body>
</html>
