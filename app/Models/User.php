<?php
namespace App\Models;
use PDO;
use Configs\Database;

class User {
    public $id;
    public $username;
    public $password;
    public $so_du_so;

    public static function getAllUsers() {
        $db = Database::connect();
        $stmt = $db->query("SELECT id, username, so_du_so, created_at FROM users ORDER BY id DESC");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    // Kiểm tra tài khoản tồn tại
    public static function checkExist($username) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch() ? true : false;
    }

    // Đăng ký tài khoản mới
    public static function register($username, $password) {
        $db = Database::connect();
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password, so_du_so) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $hashed, 10000]);
    }

    // Tìm user theo username phục vụ đăng nhập
    public static function findByUsername($username) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchObject(self::class);
    }

    // Lấy số dư sò mới nhất của User hiện tại
    public static function getSoDuSo($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT so_du_so FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user['so_du_so'] : 0;
    }

    public static function truSo($id, $so_luong) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE users SET so_du_so = so_du_so - ? WHERE id = ?");
        return $stmt->execute([$so_luong, $id]);
    }

    // Xóa tài khoản theo ID
    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function updateSoDu($id, $so_luong) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE users SET so_du_so = ? WHERE id = ?");
        return $stmt->execute([$so_luong, $id]); // Truyền trực tiếp số lượng sò mới vào dấu ? thứ nhất
    }

}