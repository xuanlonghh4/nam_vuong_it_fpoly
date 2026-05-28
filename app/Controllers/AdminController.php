<?php
namespace App\Controllers;

use App\Models\Counter;
use App\Models\User;
use App\Models\NamVuong;
use App\Models\History;

class AdminController {
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // CHẶN BẢO MẬT: Chỉ cho phép admin truy cập
        if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
            echo "<script>alert('Quyền truy cập bị từ chối!'); window.location.href='?url=main';</script>";
            exit;
        }

        // 1. Kéo toàn bộ dữ liệu từ các bảng lên
        $adminSearch = $_GET['admin-search'] ?? '';
        $allUsers = User::getAllUsers();
        $allCandidates = NamVuong::filter($adminSearch); // Sử dụng hàm lấy tất cả có sẵn của NamVuong
        $allHistory = History::getAllHistory();

        // 2. Tính toán nhanh vài số liệu thống kê tổng quan
        $totalSo = array_sum(array_column($allUsers, 'so_du_so'));
        $totalVotes = array_sum(array_column(NamVuong::getAll(), 'votes'));
        $counterStats = Counter::getStats();

        // 3. Trả dữ liệu ra view admin
        require_once __DIR__ . '/../../views/Public/admin_dashboard.php';
    }

    // Hàm xử lý USER dùng Ajax : XÓA hoặc CẬP NHẬT SÒ

    public function handleAjax() {
        // Chỉ chấp nhận request POST truyền ngầm
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Phương thức không hợp lệ']);
            exit;
        }

        header('Content-Type: application/json');
        $action = $_GET['action'] ?? '';

        // HÀM XỬ LÝ AJAX XÓA USER
        if ($action === 'delete_user') {
            $id = intval($_POST['id'] ?? 0);
            
            // Gọi đến Model để xóa (Ví dụ: User::delete($id))
            User::delete($id);

            if ($id > 0) {
                // $db->query("DELETE FROM users WHERE id = $id");
                echo json_encode(['status' => 'success', 'message' => 'Đã trục xuất người dùng thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ']);
            }
            exit;
        }

        // HÀM XỬ LÝ AJAX CẬP NHẬT SÒ
        if ($action === 'update_so') {
            $id = intval($_POST['id'] ?? 0);
            $new_so = intval($_POST['so_du_so'] ?? 0);

            if ($id > 0 && $new_so >= 0) {
                // Gọi Model cập nhật (User::updateSo($id, $new_so))
                User::updateSoDu($id, $new_so);
                
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Đã cập nhật số dư Sò!',
                    'formatted_so' => number_format($new_so) // Trả về chuỗi định dạng để hiển thị luôn
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
            }
            exit;
        }
    }

}