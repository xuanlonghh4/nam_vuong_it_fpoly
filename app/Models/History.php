<?php
namespace App\Models;

use Configs\Database;

class History {

    public static function getAllHistory() {
        $db = Database::connect();
        // Lấy lịch sử kèm theo tên User và tên Nam Vương để hiển thị 
        $stmt = $db->query("SELECT v.*, u.username, n.name as candidate_name 
                            FROM vote_history v 
                            JOIN users u ON v.user_id = u.id 
                            JOIN nam_vuong n ON v.candidate_id = n.id 
                            ORDER BY v.id DESC");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    // Hàm lưu vết lịch sử ném Sò vào bảng vote_history
    public static function create($user_id, $candidate_id, $so_luong) {
        $db = Database::connect();
        
        $stmt = $db->prepare("INSERT INTO vote_history (user_id, candidate_id, so_luong_vote) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $candidate_id, $so_luong]);
    }

    // Hàm lấy lịch sử của từng User 
    public static function getByUserId($user_id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT v.*, n.name as candidate_name 
                              FROM vote_history v 
                              JOIN nam_vuong n ON v.candidate_id = n.id 
                              WHERE v.user_id = ? 
                              ORDER BY v.id DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}