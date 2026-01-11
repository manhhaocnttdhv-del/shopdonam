<meta charset="UTF-8">
<meta name="description" content="Male_Fashion Template">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="keywords" content="Male_Fashion, unica, creative, html">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{$title}}</title>
<link rel="icon" type="image/x-icon" href="/temp/assets/img/products.png" />

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<!-- Css Styles -->
<link rel="stylesheet" href="/temp/assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="/temp/assets/css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="/temp/assets/css/elegant-icons.css" type="text/css">
<link rel="stylesheet" href="/temp/assets/css/magnific-popup.css" type="text/css">
<link rel="stylesheet" href="/temp/assets/css/nice-select.css" type="text/css">
<link rel="stylesheet" href="/temp/assets/css/owl.carousel.min.css" type="text/css">
<link rel="stylesheet" href="/temp/assets/css/slicknav.min.css" type="text/css">
<link rel="stylesheet" href="/temp/assets/css/style.css" type="text/css">

<!-- Custom UI/UX Improvements -->
<style>
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Loading animation */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .loading-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Button improvements */
    .primary-btn, .btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .primary-btn:hover, .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .primary-btn:active, .btn:active {
        transform: translateY(0);
    }
    
    /* Card hover effects */
    .product-item, .card {
        transition: all 0.3s ease;
    }
    
    .product-item:hover, .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    
    /* Input focus improvements */
    input:focus, textarea:focus, select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    /* Scrollbar styling */
    ::-webkit-scrollbar {
        width: 10px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 5px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #764ba2;
    }
</style>