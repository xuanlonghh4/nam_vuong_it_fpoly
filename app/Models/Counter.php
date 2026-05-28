<?php
namespace App\Models;

use Configs\Database;

class Counter {
    
    // Hàm này sẽ chạy mỗi khi có người vào web
    public static function increment() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $db = Database::connect();

        // 1. Luôn luôn tăng Views (cứ tải trang là tăng)
        $db->query("UPDATE counter SET views = views + 1 WHERE id = 1");

        // 2. Kiểm tra Session để tăng Visits (Chỉ tăng khi là phiên làm việc mới)
        if (!isset($_SESSION['has_visited'])) {
            $_SESSION['has_visited'] = true;
            $db->query("UPDATE counter SET visits = visits + 1 WHERE id = 1");
        }
    }

    // Hàm lấy số liệu ra để hiển thị trên Admin Dashboard
    public static function getStats() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM counter WHERE id = 1");
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
}