<?php
// index.php
// ==========================================
// 1. BỘ TỰ ĐỘNG NẠP FILE (AUTOLOAD) CHUẨN HÓA
// ==========================================

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\NamVuongController;
use App\Models\Counter;
use NamVuongController as GlobalNamVuongController;

spl_autoload_register(function ($className) {
    // Chuyển đổi Configs\Database -> Configs/Database.php
    $file = str_replace('\\', '/', $className) . '.php';

    // Tách chuỗi để xử lý chữ viết thường cho thư mục gốc (app, configs)
    $parts = explode('/', $file);
    if (!empty($parts)) {
        // Biến chữ đầu tiên (tên thư mục) thành chữ thường: 'Configs' -> 'configs', 'App' -> 'app'
        $parts[0] = strtolower($parts[0]); 
        $fileNormalized = implode('/', $parts);

        // Kiểm tra đường dẫn chuẩn này có tồn tại không và nạp vào
        if (file_exists($fileNormalized)) {
            require_once $fileNormalized;
            return;
        }
    }

    // Dự phòng: Nếu đường dẫn giữ nguyên chữ hoa chữ thường tồn tại thì nạp luôn
    if (file_exists($file)) {
        require_once $file;
    }
});

// ==========================================
// 2. PHÂN TÍCH URL ĐƯỜNG DẪN
// ==========================================
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
$url = ($url === '') ? '/' : $url;

// Bộ đếm lượt truy cập 
Counter::increment();

// ==========================================
// 3. BỘ ĐỊNH TUYẾN SWITCH-CASE
// ==========================================
switch ($url) {
    case '/':
    case 'main':
        $controller = new NamVuongController();
        $controller->index();
        break;

     case 'info':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id > 0) {
            $controller = new NamVuongController();
            $controller->show($id);
        } else {
            http_response_code(404);
            echo "<h1 style='text-align:center;margin-top:50px;'>404 - ID sản phẩm không hợp lệ!</h1>";
        }
        break;

    case 'login':
        $controller = new AuthController();
        $controller->handleAuth();
        break;

    // === ROUTE MỚI 2: ĐĂNG XUẤT ===
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

//    XỬ LÝ VOTE TRỪ SÒ (Gửi bằng POST từ form detail) ===
    case 'process-vote':
        $controller = new NamVuongController();
        $controller->vote();
        break;

    case 'my-profile':
        $authController = new AuthController();
        $authController->showProfile();
        break;

    case 'admin':
        $adminController = new \App\Controllers\AdminController();
        $adminController->index();
        break;

    case 'admin-ajax':
        $adminController = new \App\Controllers\AdminController();
        $adminController->handleAjax();
        break;

    case 'process-add-nam-vuong':
        $namVuongController = new NamVuongController();
        $namVuongController->store();
        break;

    case 'process-edit-nam-vuong':
        $namVuongController = new NamVuongController();
        $namVuongController->update();
        break;

    case 'delete-nam-vuong':
        $namVuongController = new NamVuongController();
        $namVuongController->delete();
        break;
 
    default:
        http_response_code(404);
        echo "<h1 style='text-align:center;margin-top:50px;'>404 - Không tìm thấy trang!</h1>";
        break;
}