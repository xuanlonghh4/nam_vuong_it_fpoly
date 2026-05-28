<?php
namespace App\Models;
use PDO;

// Nạp class Database từ namespace Configs vào đây
use Configs\Database; 

class NamVuong {
    public $id;
    public $name;
    public $thumbnail;
    public $description;
    public $created_at;
    public $votes;
    public $status;

    public static function filter($search = '') {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM nam_vuong WHERE name LIKE ? ORDER BY votes DESC");
        $stmt->execute(["%$search%"]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getAll() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM nam_vuong ORDER BY votes DESC");
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function save() {
        $db = Database::connect();
        // Bật hiển thị lỗi để debug
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (isset($this->id)) {
            // Cập nhật
            $stmt = $db->prepare("UPDATE nam_vuong SET name = ?, votes = ?, description = ?, status = ? WHERE id = ?");
            return $stmt->execute([$this->name, $this->votes, $this->description, $this->status, $this->id]);
        } else {
            // Thêm mới
            $stmt = $db->prepare("INSERT INTO nam_vuong (name, thumbnail, description) VALUES (?, ?, ?)");
            return $stmt->execute([$this->name, $this->thumbnail, $this->description]);
        }
    }

    // public static function getFiltered($search = '', $page = 1, $limit = 10, $sort = 'votes', $order = 'DESC') {
    //     $db = Database::connect();
        
    //     // Ép kiểu để đảm bảo là số nguyên
    //     $page = max(1, (int)$page);
    //     $limit = max(1, (int)$limit);
    //     $offset = ($page - 1) * $limit;

    //     // 1. Xử lý WHERE
    //     $where = "";
    //     $params = [];
    //     if (!empty($search)) {
    //         $where = "WHERE name LIKE ?";
    //         $params[] = "%$search%";
    //     }

    //     // 2. Lấy tổng số bản ghi
    //     $countStmt = $db->prepare("SELECT COUNT(*) FROM nam_vuong $where");
    //     $countStmt->execute($params);
    //     $total_records = (int)$countStmt->fetchColumn();

    //     // 3. Lấy dữ liệu (Nối trực tiếp LIMIT và OFFSET vào chuỗi SQL)
    //     // Cách này an toàn vì $limit và $offset đã được ép kiểu (int) ở trên
    //     $sql = "SELECT * FROM nam_vuong $where ORDER BY votes DESC LIMIT $limit OFFSET $offset";
        
    //     $stmt = $db->prepare($sql);
    //     $stmt->execute($params);

    //     return [
    //         'data' => $stmt->fetchAll(PDO::FETCH_CLASS, self::class),
    //         'pagination' => [
    //             'current_page' => $page,
    //             'per_page' => $limit,
    //             'total_records' => $total_records,
    //             'total_pages' => (int)ceil($total_records / $limit)
    //         ]
    //     ];
    // }

    public static function getFiltered($search = '', $page = 1, $limit = 10, $order = 'DESC') {
        $db = Database::connect();
        
        // 1. Tính toán phân trang
        $page = max(1, (int)$page);
        $limit = max(1, (int)$limit);
        $offset = ($page - 1) * $limit;

        // 2. Bảo mật cho biến $order (Whitelist)
        $order = (strtoupper($order) === 'ASC') ? 'ASC' : 'DESC';

        // 3. Xử lý WHERE
        $where = "WHERE status = 1"; // Luôn chỉ lấy những bản ghi có status = 1
        $params = [];
        if (!empty($search)) {
            $where .= " AND name LIKE ?";
            $params[] = "%$search%";
        }

        // 4. Lấy tổng số bản ghi
        $countStmt = $db->prepare("SELECT COUNT(*) FROM nam_vuong $where");
        $countStmt->execute($params);
        $total_records = (int)$countStmt->fetchColumn();

        // 5. Lấy dữ liệu (Luôn sắp xếp theo votes)
        $sql = "SELECT * FROM nam_vuong $where ORDER BY votes $order LIMIT $limit OFFSET $offset";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        return [
            'data' => $stmt->fetchAll(PDO::FETCH_CLASS, self::class),
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total_records' => $total_records,
                'total_pages' => (int)ceil($total_records / $limit)
            ]
        ];
    }

    public static function getTop5() {
        $db = Database::connect();
        // Sắp xếp theo votes giảm dần (DESC) và chỉ lấy 5 bản ghi
        $stmt = $db->prepare("SELECT * FROM nam_vuong WHERE status = 1 ORDER BY votes DESC LIMIT 5");
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM nam_vuong WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchObject(self::class);
    }

    public static function congVote($id, $so_luong) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE nam_vuong SET votes = votes + ? WHERE id = ?");
        return $stmt->execute([$so_luong, $id]);
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM nam_vuong WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function update() {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE nam_vuong SET name = ?, votes = ?, status = ?, description = ?, thumbnail = ? WHERE id = ?");
        return $stmt->execute([$this->name, $this->votes, $this->status, $this->description, $this->thumbnail, $this->id]);
    }

}
