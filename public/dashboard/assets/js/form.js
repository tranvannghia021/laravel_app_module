//add products
document.addEventListener('DOMContentLoaded', function () {
    Validator({
        form: '#form-add-products',
        formGroupSelector: '.form-group',
        errorSelector: '.form-message',
        rules: [
            Validator.isRequired('#products_name', 'Vui lòng nhập tên sản phẩm'),
            Validator.isRequired('#categorys', 'Vui lòng chọn tên danh mục'),
            Validator.isRequired('#Products_price', 'Vui lòng nhập giá sản phẩm'),
            Validator.isRequired('#products_quantity', 'Vui lòng nhập số lượng sản phẩm'),
            Validator.isRequired('#products_file', 'Vui lòng nhập chọn files'),
            Validator.isNumber('#Products_price', 'Trường này phải là số dương'),
            Validator.isNumber('#products_quantity', 'Trường này phải là số dương'),
            Validator.isImage('#products_file')
        ],
    });
});

// form-edit-producst
document.addEventListener('DOMContentLoaded', function () {
    Validator({
        form: '#form-edit-products',
        formGroupSelector: '.form-group',
        errorSelector: '.form-message',
        rules: [
            Validator.isRequired('#products_name', 'Vui lòng nhập tên sản phẩm'),
            Validator.isRequired('#categorys', 'Vui lòng chọn tên danh mục'),
            Validator.isRequired('#Products_price', 'Vui lòng nhập giá sản phẩm'),
            Validator.isRequired('#products_quantity', 'Vui lòng nhập số lượng sản phẩm'),
            Validator.isNumber('#Products_price', 'Trường này phải là số dương'),
            Validator.isNumber('#products_quantity', 'Trường này phải là số dương'),
          
        ],
    });
});


