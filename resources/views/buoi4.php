<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buổi học 4</title>
</head>
<body>
    <!-- 
        - File view (hiển thị) là file bắt buộc phải đặt trong 
            thư mục resources/views
        - Có thể sử dụng file view bằng 2 cách
            + Trỏ trực tiếp từ Route
            + Gọi qua hàm trong Controller
     -->
    <h1>Chào mừng đến với bình nguyên vô tận</h1>
    <p>Hôm nay là ngày <?= date('d/m/Y') ?></p>
    <p><?= $title ?></p>
    <p><?= $des ?></p>
</body>
</html>