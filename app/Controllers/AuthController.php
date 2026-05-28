<?php
namespace App\Controllers;

use App\Models\History;
use App\Models\User;

class AuthController {
    
    // Xử lý Đăng Nhập & Đăng Ký
    public function handleAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Nếu đã login rồi thì quay về trang chủ
        if (isset($_SESSION['user_id'])) {
            header("Location: ?url=main");
            exit;
        }

        $error = "";
        $success = "";
        $username = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $error = "Vui lòng điền đầy đủ thông tin!";
            } else {
                if ($action === 'register') {
                    // Logic Đăng ký
                    if (User::checkExist($username)) {
                        $error = "Tài khoản này đã được sử dụng!";
                    } else {
                        if (User::register($username, $password)) {
                            $success = "Đăng ký thành công! Mời bạn đăng nhập.";
                            $username = ""; // Xóa trống input sau khi đăng ký thành công
                        } else {
                            $error = "Đã xảy ra lỗi hệ thống, thử lại sau!";
                        }
                    }
                } elseif ($action === 'login') {
                    // Logic Đăng nhập
                    $user = User::findByUsername($username);
                    if ($user && password_verify($password, $user->password)) {
                        $_SESSION['user_id'] = $user->id;
                        $_SESSION['username'] = $user->username;
                        
                        
                        if($user->username == 'admin'){
                            header("Location: ?url=admin");
                        }else{
                            header("Location: ?url=main");
                        }

                        exit;
                    } else {
                        $error = "Tài khoản hoặc mật khẩu không chính xác!";
                    }
                }
            }
        }
        require_once __DIR__ . '/../../views/Public/auth.php';
    }

    // Xử lý Đăng xuất
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        session_destroy();

        header("Location: ?url=main");
        exit;
    }

    public function showProfile() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Nếu chưa đăng nhập mà cố tình vào thì đá về trang login
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?url=login");
            exit;
        }

        $user_id = $_SESSION['user_id'];

        // 1. Lấy số dư Sò thời gian thực từ Model User
        $so_du_so = User::getSoDuSo($user_id);

        // 2. Lấy lịch sử ném Sò từ Model History 
        $lichSuVote = History::getByUserId($user_id);

        // 3. Trả dữ liệu ra file View riêng biệt
        require_once __DIR__ . '/../../views/Public/user_profile.php';
    }

}