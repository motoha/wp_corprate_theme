document.getElementById("menu-toggle").addEventListener("click", function () {
    const menu = document.getElementById("mobile-menu");
    menu.classList.toggle("-translate-y-full");
    menu.classList.toggle("opacity-0");
    menu.classList.toggle("top-16");
    menu.classList.toggle("opacity-100");
    menu.classList.toggle("translate-y-0");
});
document.addEventListener('DOMContentLoaded', function() {
    // Get loading overlay
    const loadingOverlay = document.querySelector('.loading-overlay');
    
    // Track loading status
    let videosLoaded = 0;
    let imagesLoaded = 0;
    const totalVideos = document.querySelectorAll('.swiper-container video').length;
    const totalImages = document.querySelectorAll('.swiper-container img').length;
    
    // Function to check if everything is loaded
    function checkAllLoaded() {
      if (videosLoaded >= totalVideos && imagesLoaded >= totalImages) {
        // Hide loading overlay with fade effect
        if (loadingOverlay) {
          loadingOverlay.classList.add('opacity-0');
          setTimeout(() => {
            loadingOverlay.style.display = 'none';
          }, 500); // Wait for transition to complete
        }
        
        // Initialize Swiper only after content is loaded
        initSwiper();
      }
    }
    
    // Add event listeners to all videos
    document.querySelectorAll('.swiper-container video').forEach(video => {
      // When metadata is loaded, video is ready to play
      video.addEventListener('loadedmetadata', function() {
        videosLoaded++;
        checkAllLoaded();
      });
      
      // Fallback if video fails to load
      video.addEventListener('error', function() {
        videosLoaded++;
        checkAllLoaded();
      });
    });
    
    // Add event listeners to all images
    document.querySelectorAll('.swiper-container img').forEach(img => {
      if (img.complete) {
        imagesLoaded++;
        checkAllLoaded();
      } else {
        img.addEventListener('load', function() {
          imagesLoaded++;
          checkAllLoaded();
        });
        
        // Fallback if image fails to load
        img.addEventListener('error', function() {
          imagesLoaded++;
          checkAllLoaded();
        });
      }
    });
    
    // Initialize Swiper function
    function initSwiper() {
      const swiper = new Swiper('.swiper-container', {
        loop: true,
        autoplay: {
          delay: 5000,
        },
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true
        },
      });
    }
    
    // If there are no videos or images, or if they've already loaded
    if (totalVideos === 0 && totalImages === 0) {
      loadingOverlay.style.display = 'none';
      initSwiper();
    } else if (videosLoaded >= totalVideos && imagesLoaded >= totalImages) {
      loadingOverlay.style.display = 'none';
      initSwiper();
    }
    
    // Fallback: If loading takes too long, initialize anyway
    setTimeout(() => {
      if (loadingOverlay && loadingOverlay.style.display !== 'none') {
        loadingOverlay.style.display = 'none';
        initSwiper();
      }
    }, 5000); // 5 seconds timeout
  });