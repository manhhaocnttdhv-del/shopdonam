// Tăng giảm số lượng sản phẩm - FIXED VERSION
$(document).ready(function() {
    // Sử dụng event delegation để xử lý tất cả các button tăng/giảm
    $(document).on('click', '.decreaseButton', function(e) {
        e.preventDefault();
        var formContainer = $(this).closest('.form-add-to-cart');
        var numberInput = formContainer.find('.numberInput');
        var currentValue = parseInt(numberInput.val(), 10) || 0;
        var minValue = parseInt(numberInput.attr('min')) || 0;
        
        if (currentValue > minValue) {
            numberInput.val(currentValue - 1);
            // Trigger change event để cập nhật subtotal nếu có
            numberInput.trigger('change');
        }
    });
    
    $(document).on('click', '.increaseButton', function(e) {
        e.preventDefault();
        var formContainer = $(this).closest('.form-add-to-cart');
        var numberInput = formContainer.find('.numberInput');
        var currentValue = parseInt(numberInput.val(), 10) || 0;
        var maxValue = parseInt(numberInput.attr('max')) || 9999;
        
        if (currentValue < maxValue) {
            numberInput.val(currentValue + 1);
            // Trigger change event để cập nhật subtotal nếu có
            numberInput.trigger('change');
        }
    });
    
    // Cập nhật subtotal khi số lượng thay đổi (cho giỏ hàng)
    $(document).on('change', '.numberInput[data-cart-id]', function() {
        var cartId = $(this).data('cart-id');
        var newQuantity = parseInt($(this).val(), 10) || 0;
        var priceText = $(this).closest('.single-item-list').find('.price-product').text();
        var price = parseFloat(priceText.replace(/[^\d]/g, '')) || 0;
        var subtotal = newQuantity * price;
        
        // Cập nhật subtotal hiển thị
        $('#subtotal-' + cartId).text(formatNumber(subtotal) + ' VNĐ');
    });
});

// Thêm vào giỏ hàng
// Đảm bảo jQuery đã load
if (typeof jQuery === 'undefined') {
    console.error('jQuery is not loaded!');
} else {
    console.log('jQuery version:', jQuery.fn.jquery);
}

$(document).ready(function() {
    console.log('Document ready - Add to cart handler initialized');
    // $('.product-infor-main').each(function() {
    //     var productMain = $(this).attr('id');
    //     var addToCart = $('#' + productMain + ' .add-to-cart');
    //     var checkAuth = $('.check-auth').text();

    //     addToCart.on('click', function(e) {
    //         e.preventDefault();
    //         if(checkAuth == 1){
    //             const Amount = $(this).data('quantity');
    //             if(Amount > 0){
    //                 var productId = $(this).data('product-id');
    //                 var userId = $(this).data('user-id');
    //                 var thumbProduct = $('#' + productMain + ' .thumb-product').attr("src");
    //                 var nameProduct = $('#' + productMain + ' .title-product').text();
    //                 var priceProduct = $('#' + productMain + ' .okPrice-product').text();
    //                 var quantity = $('#' + productMain + ' .quantity').val();
    //                 priceProduct =  parseFloat(priceProduct.replace(/,/g, ''))
    //                 var subtotal = parseInt(quantity) * priceProduct;

    //                     // Gửi yêu cầu Ajax
    //                 if(quantity > 0){
    //                     $.ajax({
    //                         headers: {
    //                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                         },
    //                         url: '/addToCart',
    //                         type: 'POST',
    //                         data: {
    //                             product_id: productId,
    //                             user_id: userId,
    //                             thumb: thumbProduct,
    //                             name: nameProduct,
    //                             price: priceProduct,
    //                             quantity: quantity,
    //                             subtotal: subtotal
    //                         },
    //                         success: function(response) {
    //                             toastr.success(response.message, 'Thông báo');
    //                             window.location.reload();
    //                         },
    //                         error: function(error) {
    //                             toastr.error('Lỗi thêm giỏ hàng !');
    //                         }
    //                     });
    //                 }else{
    //                     toastr.error('Vui lòng nhập số lượng sản phẩm !');
    //                 }
    //             }else{
    //                 toastr.error('Sản phẩm đã hết hàng !');
    //             }
    //         }else{
    //             window.location.href = '/login';
    //         }
    //     });
    // });
    $(document).on('click', '.add-to-cart', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        
        console.log('=== Add to cart clicked ===');
        
        // Kiểm tra auth
        var checkAuth = $('.check-auth').text().trim();
        console.log('Check auth:', checkAuth);
        
        if(checkAuth != '1' && checkAuth != 1){
            console.log('User not authenticated, redirecting to login...');
            toastr.warning('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!');
            setTimeout(function() {
                window.location.href = '/login';
            }, 1500);
            return false;
        }
        
        // Lấy dữ liệu từ button
        const Amount = parseInt($(this).data('quantity')) || 0;
        var productId = $(this).data('product-id');
        var userId = $(this).data('user-id');
        
        console.log('Product ID:', productId, 'User ID:', userId, 'Amount:', Amount);
        
        if(!productId || !userId){
            toastr.error('Thông tin sản phẩm không hợp lệ!');
            console.error('Missing productId or userId');
            return false;
        }
        
        if(Amount <= 0){
            toastr.error('Sản phẩm đã hết hàng!');
            return false;
        }
        
        // Lấy quantity từ input - button và input cùng trong .form-add-to-cart
        var formContainer = $(this).closest('.form-add-to-cart');
        var quantityInput = formContainer.find('.quantity');
        
        // Tìm container sản phẩm gần nhất
        var productContainer = $(this).closest('.product-info, .product-infor-main, .product__details__text');
        if(productContainer.length === 0) {
            productContainer = $(this).closest('.single-item-grid, .single-item-list');
        }
        
        // Lấy thông tin sản phẩm từ container gần nhất hoặc toàn trang
        var thumbProduct = productContainer.find('.thumb-product').first().attr("src") || $('.thumb-product').first().attr("src");
        var nameProduct = productContainer.find('.title-product-detail').first().text().trim() || 
                          productContainer.find('.title-product').first().text().trim() || 
                          $('.title-product-detail').first().text().trim() ||
                          $('.title-product').first().text().trim();
        var priceProduct = productContainer.find('.okPrice-product').first().text().trim() || 
                          $('.okPrice-product').first().text().trim();
        
        console.log('Form container found:', formContainer.length);
        console.log('Quantity input found:', quantityInput.length);
        console.log('Quantity input value:', quantityInput.val());
        
        var quantity = parseInt(quantityInput.val()) || 1;
        if(quantity < 1) quantity = 1;
        
        console.log('Final quantity:', quantity);
        
        // Parse giá sản phẩm
        priceProduct = parseFloat(priceProduct.replace(/[^\d]/g, '')) || 0;
        var subtotal = quantity * priceProduct;
        
        // Lấy size và color
        var size = $('input[name="sizes"]:checked').val() || '';
        var color = $('input[name="colors"]:checked').val() || '';
        
        // Debug log
        console.log('Add to cart data:', {
            productId: productId,
            userId: userId,
            thumb: thumbProduct,
            name: nameProduct,
            price: priceProduct,
            quantity: quantity,
            subtotal: subtotal,
            size: size,
            color: color
        });
        
        // Validate dữ liệu
        if (!thumbProduct || !nameProduct || priceProduct <= 0) {
            toastr.error('Không thể lấy thông tin sản phẩm! Vui lòng thử lại.');
            console.error('Validation failed:', {
                thumb: thumbProduct,
                name: nameProduct,
                price: priceProduct
            });
            return false;
        }
        
        if(quantity <= 0){
            toastr.error('Vui lòng nhập số lượng sản phẩm hợp lệ!');
            return false;
        }
        
        // Lấy CSRF token
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        if(!csrfToken){
            toastr.error('Lỗi bảo mật! Vui lòng refresh trang và thử lại.');
            console.error('CSRF token not found');
            return false;
        }
        
        // Gửi yêu cầu Ajax
        console.log('Sending AJAX request to /addToCart...');
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: '/addToCart',
            type: 'POST',
            data: {
                product_id: productId,
                user_id: userId,
                thumb: thumbProduct,
                name: nameProduct,
                price: priceProduct,
                quantity: quantity,
                subtotal: subtotal,
                sizes: size,
                colors: color 
            },
            beforeSend: function() {
                console.log('AJAX request started...');
            },
            success: function(response) {
                console.log('AJAX Success:', response);
                if(response.success){
                    toastr.success(response.message || 'Thêm giỏ hàng thành công!', 'Thông báo');
                    setTimeout(function() {
                        window.location.href = '/carts';
                    }, 1000);
                } else {
                    toastr.error(response.message || 'Có lỗi xảy ra!');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error Details:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    statusCode: xhr.status,
                    readyState: xhr.readyState
                });
                
                var errorMessage = 'Lỗi thêm giỏ hàng! Vui lòng thử lại.';
                
                if(xhr.status === 401 || xhr.status === 419){
                    errorMessage = 'Phiên đăng nhập đã hết hạn! Vui lòng đăng nhập lại.';
                    setTimeout(function() {
                        window.location.href = '/login';
                    }, 2000);
                } else if(xhr.status === 422){
                    var errors = xhr.responseJSON && xhr.responseJSON.errors;
                    if(errors){
                        var errorArray = Object.values(errors);
                        if(Array.isArray(errorArray[0])){
                            errorMessage = errorArray.map(function(arr) { return arr.join(', '); }).join(', ');
                        } else {
                            errorMessage = errorArray.join(', ');
                        }
                    }
                } else if(xhr.responseJSON && xhr.responseJSON.message){
                    errorMessage = xhr.responseJSON.message;
                }
                
                toastr.error(errorMessage);
            }
        });
        
        return false;
    });
});


// Cập nhật giỏ hàng
$(document).ready(function () {
    $('#updateCartButton').on('click', function (e) {
        e.preventDefault();
        var cartUpdates = [];
    
        $('.quantity').each(function () {
            var cartId = $(this).data('cart-id');
            var newQuantity = $(this).val();
    
            cartUpdates.push({ id: cartId, quantity: newQuantity });
        });
    
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/carts/updateQuantities',
            data: { cart_updates: cartUpdates },
            success: function (data) {
                if (data.success) {
                    location.reload();
                }
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    errors.forEach(function (error) {
                        alert(error);
                    });
                } else {
                    console.log(xhr.responseText);
                }
            }
        });
    });
    
});

// Checkout - lấy Session
$(document).ready(function () {
    $('#buy-products').click(function(e) {
        e.preventDefault()
        // Lấy thông tin cần lưu vào sessionStorage
        var productInfos = [];
        var cartItems = $('.single-item-list');
        cartItems.each(function() {
            var thumb = $(this).find('.thumb-product').attr('src');
            var title = $(this).find('.title-product').text()
            var slug = $(this).find('.title-product').attr('href')
            var price = $(this).find('.price-product').text()
            var quantity = $(this).find('.quantity').val()
            var subtotal = $(this).find('.subtotal').text()
            var size_color = $(this).find('.size_color').text()
            productInfos.push({ thumb: thumb, title: title, slug: slug, price: price, quantity: quantity, subtotal:subtotal,size_color:size_color });
        });

        sessionStorage.setItem('productInfos', JSON.stringify(productInfos));
        window.location.href= '/checkout'
    });
});

// Hiển thị các sản phẩm ở session lên html
$(document).ready(function () {
    var total = 0;
    // Kiểm tra xem có dữ liệu trong sessionStorage hay không
    var productInfos = sessionStorage.getItem('productInfos');
    if (productInfos) {
        // Chuyển dữ liệu từ JSON về đối tượng JavaScript
        productInfos = JSON.parse(productInfos);
        // Lặp qua mỗi phần tử trong mảng và thêm vào bảng
        productInfos.forEach(function (product,index) {
            var subtotal =  parseFloat(product.subtotal.replace(/,/g, ''))
            total += subtotal;
            var row='<div class="single-item-list text-center border-bottom py-2">'+
                        '<div class="row align-items-center">'+
                            '<div class="col-1">'+index+'</div>'+
                            '<div class="col-md-1 col-12">'+
                                '<img class="w-100" src="' + product.thumb + '" alt="' + product.title + '">'+
                                '</div>'+
                                '<div class="col-md-4 col-12">'+
                                '<a href="'+product.slug+'"><h6 class="title text-start text-primary">' + product.title + '</h6></a>'+
                            '</div>'+
                            '<div class="col-md-2 col-12">'+
                                '<span class="price">'+product.size_color +'</span>'+
                            '</div>'+
                            '<div class="col-md-2 col-12 product-infor form-add-to-cart" >'+
                                '<p class="mb-0">'+product.quantity+'</p>'+
                            '</div>'+
                            '<div class="col-md-2 col-12">'+
                                '<span class="subtotal">'+product.subtotal+'</span>'+
                            '</div>'+
                        '</div>'+
                    '</div>'
            ;
            $('.infor-product-session').append(row);
        });
        $('.total').append(formatNumber(total) + ' VNĐ')
        // Cập nhật tổng tiền ban đầu
        var originalTotalElement = document.querySelector('.original-total');
        if (originalTotalElement) {
            originalTotalElement.textContent = formatNumber(total) + ' VNĐ';
            originalTotalElement.dataset.initialized = 'true';
        }
        var input_total = '<input type="text" name="total" hidden class="total-input" value="'+formatNumber(total) + ' VNĐ'+'">'
        var input_total2 = '<input type="text" name="total2" hidden class="total-input" value="' + total + '">'
        $('#total-price').append(input_total)
        $('#total-price2').append(input_total2)
    }
});

function formatNumber(number) {
    // Sử dụng hàm toLocaleString để thực hiện định dạng số
    return number.toLocaleString('en-US');
}

// Helper function để format số (sử dụng ở nhiều nơi)
if (typeof window.formatNumber === 'undefined') {
    window.formatNumber = formatNumber;
}

// Lấy địa chỉ đã có
$('.address-exist').each(function () {
    var addressExist = $(this);
    addressExist.click(function () {
        var sdt = addressExist.find('.sdt').text();
        var name = addressExist.find('.name').text();
        var country = addressExist.find('.country').text();
        var district = addressExist.find('.district').text();
        var province = addressExist.find('.province').text();
        var wards = addressExist.find('.wards').text();
        var address = addressExist.find('.address').text();

        $('#form-process-checkout .input-sdt').val(sdt)
        $('#form-process-checkout .input-name').val(name)
        $('#form-process-checkout .input-country').val(country)
        $('#form-process-checkout .input-province').val(province)
        $('#form-process-checkout .input-district').val(district)
        $('#form-process-checkout .input-wards').val(wards)
        $('#form-process-checkout .input-address').val(address)
    })
})

// Đưa đỉa chỉ vào session và thanh toán thành công
$('.btn-checkout').click(function () {
    var sdt = $('#form-process-checkout .input-sdt').val();
    var name = $('#form-process-checkout .input-name').val();
    var country = $('#form-process-checkout .input-country').val();
    var province = $('#form-process-checkout .input-province').val();
    var district = $('#form-process-checkout .input-district').val();
    var wards = $('#form-process-checkout .input-wards').val();
    var address = $('#form-process-checkout .input-address').val();
    var addressInfors = [];
    addressInfors.push({ sdt: sdt, name: name, country: country, province: province, district: district, wards:wards, address:address });
    sessionStorage.setItem('addressInfors', JSON.stringify(addressInfors));
})

// Hiển thị địa chỉ lên HTML khi thanh toán thành công
$(document).ready(function () {
    // Kiểm tra xem có dữ liệu trong sessionStorage hay không
    var addressInfors = sessionStorage.getItem('addressInfors');
    if (addressInfors) {
        // Chuyển dữ liệu từ JSON về đối tượng JavaScript
        addressInfors = JSON.parse(addressInfors);
        // Lặp qua mỗi phần tử trong mảng và thêm vào bảng
        addressInfors.forEach(function (address,index) {
            var row='<h6>' + address.sdt +',' + address.name + address.address + address.wards + address.district + address.province + address.country +    '</h6>';
            $('.infor-address-session').append(row);
        });
    }
});
