<?php
// hack_traffic.php
set_time_limit(0); // Chạy vô hạn thời gian không sợ bị timeout ngắt giữa chừng

// ĐƯỜNG DẪN ĐẾN TRANG WEB CỦA BẠN (Sửa lại cho đúng cổng localhost hoặc domain)
$url = "http://localhost/nvtg/"; 

// Số lượt truy cập thực tế bạn muốn tăng thêm
$target_visits = 500; 

echo "<h2>Đang tiến hành bơm " . $target_visits . " lượt truy cập thực tế...</h2>";
flush();

for ($i = 1; $i <= $target_visits; $i++) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Giả lập các trình duyệt (User-Agent) khác nhau ngẫu nhiên để qua mặt các bộ lọc nâng cao
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/" . rand(110, 130) . ".0.0.0 Safari/537.36");
    
    // QUAN TRỌNG: Ép cURL không gửi và không lưu lại bất kỳ Cookie nào (Hủy Session liên tục)
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'php://memory');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'php://memory');
    
    curl_exec($ch);
    curl_close($ch);

    if ($i % 50 == 0) {
        echo "Đã bơm thành công: $i / $target_visits lượt.<br>";
        flush(); // Đẩy dữ liệu ra màn hình ngay lập tức để theo dõi
    }
}

echo "<h3>🎉 Hoàn thành! Kiểm tra ngay trang Admin Dashboard xem số nhảy chưa đồng chí!</h3>";