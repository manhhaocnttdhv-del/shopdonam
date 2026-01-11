<!-- Js Plugins -->
<!-- jQuery - chỉ load 1 lần từ CDN (nhanh hơn) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/temp/assets/js/bootstrap.min.js"></script>
<script src="/temp/assets/js/jquery.nice-select.min.js"></script>
<script src="/temp/assets/js/jquery.nicescroll.min.js"></script>
<script src="/temp/assets/js/jquery.magnific-popup.min.js"></script>
<script src="/temp/assets/js/jquery.countdown.min.js"></script>
<script src="/temp/assets/js/jquery.slicknav.js"></script>
<script src="/temp/assets/js/mixitup.min.js"></script>
<script src="/temp/assets/js/owl.carousel.min.js"></script>
<script src="/temp/assets/js/main.js"></script>
<!-- Custom JS for add to cart functionality -->
<script src="/temp/js/main.js"></script>
<!-- Toastr notifications -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Loading overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>

<script>
// Loading overlay cho form submissions
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    const loadingOverlay = document.getElementById('loadingOverlay');
    
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            if (loadingOverlay) {
                loadingOverlay.classList.add('active');
            }
        });
    });
    
    // Ẩn loading sau khi page load
    window.addEventListener('load', function() {
        if (loadingOverlay) {
            loadingOverlay.classList.remove('active');
        }
    });
    
    // Toastr configuration
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
});
</script>
