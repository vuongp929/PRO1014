function selectSize(productId, buttonElement) 
{
    const sizeButtons = buttonElement.parentElement.querySelectorAll('.size-button');
    sizeButtons.forEach(button => button.classList.remove('selected'));
    buttonElement.classList.add('selected');

    const price = buttonElement.getAttribute('data-price');
    document.getElementById('product-price-' + productId).textContent = new Intl.NumberFormat().format(price) + ' VND';

    const sizeId = buttonElement.getAttribute('data-size-id');
    document.getElementById('selected-size-' + productId).value = sizeId;
}

function validateSizeSelection(productId) 
{
    const selectedSize = document.getElementById('selected-size-' + productId).value;
    if (!selectedSize) {
        alert('Vui lòng chọn size sản phẩm trước khi thêm vào giỏ hàng!');
        return false;
    }
    return true;
}