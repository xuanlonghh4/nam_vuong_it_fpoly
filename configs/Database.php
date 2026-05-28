<?php
namespace Configs;

use PDO;
use PDOException;

// Thiết lập múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

class Database {
    public static function connect() {
        $host = "127.0.0.1"; // Hoặc "localhost"
        $port = "3306";      // Đổi thành 3307 nếu Laragon của bạn báo cổng 3307
        $dbname = "namvuongthegioi";
        $user = "root";
        $pass = "";          // Mật khẩu mặc định trên Laragon là để trống

        try {
            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";
            $conn = new PDO($dsn, $user, $pass);
            
            // Cấu hình PDO báo lỗi dạng Exception khi gặp lỗi truy vấn
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Tự động trả dữ liệu về dạng mảng Associative (mảng với key là tên cột)
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            return $conn;
        } catch (PDOException $e) {
            die("Lỗi kết nối Cơ sở dữ liệu: " . $e->getMessage());
        }
    }
}