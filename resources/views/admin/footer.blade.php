<script>
    CKEDITOR.replace("ckeditor-desc");
    CKEDITOR.replace("ckeditor-content");
</script>
<script src="/temp/js/admin.js?v={{ time() }}"></script>
{{-- <script src="/temp/build/js/main.min.js"></script> --}}
<script src="/temp/js/validate.js?v={{ time() }}"></script>
<script src="/temp/admin/assets/js/owl.carousel.min.js"></script>
<script src="/temp/admin/assets/vendor/libs/jquery/jquery.js"></script>
<script src="/temp/admin/assets/vendor/libs/popper/popper.js"></script>
<script src="/temp/admin/assets/vendor/js/bootstrap.js"></script>
<script src="/temp/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="/temp/admin/assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="/temp/admin/assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="/temp/admin/assets/js/main.js"></script>

<!-- Page JS -->
<script src="/temp/admin/assets/js/dashboards-analytics.js"></script>
<script src="/ckeditor/ckeditor.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        $('#btn-submit').click(function (e) {
            e.preventDefault();

            let formData = new FormData($('#form_product_store')[0]);
            CKEDITOR.instances['content_textarea_create'].updateElement();

            // Sau đó lấy nội dung từ textarea
            let content = document.getElementById('content_textarea_create').value;
            formData.append('content', content);
            $.ajax({
                url: "/admin/products",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === 'success') {
                        // alert(response.message);
                        $('#form_product_store')[0].reset(); // Reset form sau khi thành công
                        $('#createProduct').modal('hide'); // Ẩn modal
                    }
                    window.location.reload();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorHtml = '';
                        for (let field in errors) {
                            errorHtml += errors[field][0] + '<br>';
                        }
                        $('#form-errors').html(errorHtml);
                    } else {
                        alert('Đã xảy ra lỗi, vui lòng thử lại sau!');
                    }
                }
            });
        });
    });

</script>


