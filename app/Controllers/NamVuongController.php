<?php
namespace App\Controllers;

use App\Models\History;
use App\Models\NamVuong;
use App\Models\User;
use Exception;
use App\Helpers\FileHelper;



class NamVuongController{
    
    public function index(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $search = $_GET['search'] ?? '';
        $page = $_GET['page'] ?? 1;
        $order = $_GET['order'] ?? 'DESC';
        $limit = 4; // Số lượng bản ghi trên mỗi trang
        $result = NamVuong::getFiltered($search, $page, $limit, $order);
        $listAll = $result['data'];
        $pagination = $result['pagination'];

        // $listAll = NamVuong::all();
        $listTop5 = NamVuong::getTop5();

        // Xử lý lấy số dư Sò từ Controller
        $so_du_so = 0;
        if (isset($_SESSION['user_id'])) {
            $so_du_so = User::getSoDuSo($_SESSION['user_id']);
        }

        $pageTitle = "Bảng Phong Thần - Nam Vương IT FPOLY";
        include 'views/Public/main.php';
    }

    public function show($id){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $item = NamVuong::find($id);

        // Xử lý lấy số dư Sò cho trang chi tiết
        $so_du_so = 0;
        if (isset($_SESSION['user_id'])) {
            $so_du_so = User::getSoDuSo($_SESSION['user_id']);
        }

        include 'views/Public/detail.php';
    }

    public function vote() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('Bạn phải đăng nhập mới có thể vote!'); window.location.href='?url=login';</script>";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $candidate_id = isset($_POST['candidate_id']) ? (int)$_POST['candidate_id'] : 0;
            $so_luong_vote = isset($_POST['so_luong_vote']) ? (int)$_POST['so_luong_vote'] : 0;

            // Kiểm tra dữ liệu đầu vào hợp lệ
            if ($candidate_id <= 0 || $so_luong_vote <= 0) {
                echo "<script>alert('Số lượng vote không hợp lệ!'); window.history.back();</script>";
                exit;
            }

            // 2. Kiểm tra số dư Sò của User hiện tại
            $so_du_hien_tai = User::getSoDuSo($user_id);
            if ($so_du_hien_tai < $so_luong_vote) {
                echo "<script>alert('Bạn không đủ Sò! Hãy liên hệ admin để nạp thêm.'); window.history.back();</script>";
                exit;
            }

            // 3. Tiến hành trừ Sò và cộng Vote bằng Transaction
            $db = \Configs\Database::connect();
            $db->beginTransaction();

            try {
                // Trừ Sò bên model User
                User::truSo($user_id, $so_luong_vote);
                
                // Cộng vote cho lam vương
                NamVuong::congVote($candidate_id, $so_luong_vote);

                // Lưu vào lịch sử vote
                History::create($user_id, $candidate_id, $so_luong_vote);

                // Xác nhận hoàn thành giao dịch
                $db->commit();

                // echo "<script>alert('Bình chọn thành công! Đã trừ " . $so_luong_vote . " Sò.'); window.location.href='?url=info&id=" . $candidate_id . "';</script>";

                // Vote thành công thì chuyển về trang lịch sử giao dich
                echo "<script>
                        alert('Bình chọn thành công! Đã trừ " . $so_luong_vote . " Sò.'); 
                        window.location.href = '?url=my-profile';
                    </script>";
                exit;

            } catch (Exception $e) {
                // Nếu có lỗi hệ thống, hủy bỏ toàn bộ thao tác để tránh mất Sò oan
                $db->rollBack();
                echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại!'); window.history.back();</script>";
                exit;
            }
        }
    }

   public function store() {
        // if (!isset($_SESSION['user_id'])) {
        //     echo "<script>alert('Bạn phải đăng nhập!'); window.location.href='?url=login';</script>";
        //     exit;
        // }

        $errors = [];
        $oldData = [];

        if (isset($_POST['add'])) {
            // 1. Lấy dữ liệu từ POST trước (chưa upload ảnh)
            $data = [
                'name'        => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'status'      => $_POST['status'] ?? 0,
                // Thêm field thumbnail vào đây để validator kiểm tra sự tồn tại
                'thumbnail'   => $_FILES['thumbnail']['name'] ?? ''
            ];
            
            $oldData = $data;

            $rules = [
                'name'        => ['required'],
                'description' => ['required'],
                'thumbnail'   => ['required'] // Rule này đảm bảo file phải được chọn
            ];

            $validator = new \App\Helpers\Validator();

            // 2. Kiểm tra dữ liệu (bao gồm cả việc file có được chọn hay chưa)
            if ($validator->validate($data, $rules)) {
                
                // 3. CHỈ KHI VALIDATE THÀNH CÔNG MỚI UPLOAD ẢNH
                $thumbnail = '';
                if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                    $thumbnail = FileHelper::uploadImage($_FILES['thumbnail'], 'Upload/');
                }

                // 4. Lưu vào Database
                $namVuong = new NamVuong();
                $namVuong->name        = $data['name'];
                $namVuong->description = $data['description'];
                $namVuong->status      = $data['status'];
                $namVuong->votes       = 0;
                $namVuong->thumbnail   = $thumbnail;

                if ($namVuong->save()) {
                    echo "<script>alert('Thêm mới thành công!'); window.location.href='?url=main';</script>";
                    exit;
                } else {
                    echo "<script>alert('Lỗi lưu Database!');</script>";
                }
            } else {
                // 5. Nếu sai, lấy lỗi và hiển thị lại form (Ảnh chưa hề được upload)
                $errors = $validator->getErrors();
            }
        }

        include 'views/Components/add-nam-vuong.php';
    }
    

    // // Hàm update trả ra view edit-nam-vuong.php để admin sửa thông tin thí sinh
    // public function update() {
    //     if(isset($_SESSION['username']) && $_SESSION['username'] !== 'admin') {
    //         echo "<script>alert('Quyền truy cập bị từ chối!'); window.location.href='?url=main';</script>";
    //         exit;
    //     }
    //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //         $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    //         $item = NamVuong::find($id);
    //         if (!$item) {
    //             echo "<script>alert('Không tìm thấy thí sinh!'); window.history.back();</script>";
    //             exit;
    //         }
    //         include 'views/Admin/edit-nam-vuong.php';
    //         return;
    //     }

    //     $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    //     $namVuong = NamVuong::find($id);    
    //     if (!$namVuong) {
    //         echo "<script>alert('Không tìm thấy thí sinh!'); window.history.back();</script>";
    //         exit;
    //     }
    //     try{
    //         $namVuong->id = $id;
    //         $namVuong->name = $_POST['name'];
    //         $namVuong->description = $_POST['description'] ?? '';
    //         $namVuong->votes = isset($_POST['votes']) ? (int)$_POST['votes'] : $namVuong->votes;
    //         $namVuong->status = isset($_POST['status']) ? (int)$_POST['status'] : $namVuong->status;
    //         // nếu có ảnh mới thì thay thế và xóa ảnh cũ đi, nếu không thì giữ nguyên
    //         if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
    //             // Xóa ảnh cũ nếu có
    //             if (!empty($namVuong->thumbnail)) {
    //                 FileHelper::deleteImage($namVuong->thumbnail, 'Upload/');
    //             }
    //             // Upload ảnh mới
    //             $filePath = FileHelper::uploadImage($_FILES['thumbnail'], 'Upload/');
    //             $namVuong->thumbnail = $filePath; 
    //         }



    //         if ($namVuong->save()) {
    //             echo "<script>alert('Cập nhật thành công!'); window.location.href='?url=admin#tab-candidates';</script>";
    //             exit;
    //         } else {
    //             throw new \Exception("Không thể cập nhật vào cơ sở dữ liệu.");
    //         }
    //     } catch (\Exception $e) {
    //         echo "<script>alert('Lỗi hệ thống: " . $e->getMessage() . "'); window.history.back();</script>";
    //         exit;
    //     }
    // }

    public function delete(){
        if(isset($_SESSION['username']) && $_SESSION['username'] !== 'admin') {
            echo "<script>alert('Quyền truy cập bị từ chối!'); window.location.href='?url=main';</script>";
            exit;
        }
        if(isset($_GET['id'])){
            $namVuong = NamVuong::find($_GET['id']);
            if($namVuong){
                if(NamVuong::delete($namVuong->id)){
                    FileHelper::deleteImage($namVuong->thumbnail, 'Upload/');
                    echo "<script>alert('Xóa thành công!'); window.location.href='?url=admin#tab-candidates';</script>";
                    exit;
                }
            }else{

            }
        }
    }

    public function update(){
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        if(isset($_SESSION['username']) && $_SESSION['username'] !== 'admin') {
            echo "<script>alert('Quyền truy cập bị từ chối!'); window.location.href='?url=main';</script>";
            exit;
        }

        if(isset($_GET['id'])){
            $oldData = [];
            $errors = [];
            $id = $_GET['id'];
            $item = NamVuong::find($id);
            if($item){
                $oldData = [
                    'name' => $item->name,
                    'votes' => $item->votes,
                    'status' => $item->status,
                    'description' => $item->description,
                    'created_at' => $item->created_at
                ];
                if(isset($_POST['update'])){
                    $data = [
                        'id' => $id,
                        'name' => trim($_POST['name']),
                        'votes' => trim($_POST['votes']),
                        'status' => (int)$_POST['status'],
                        'description' => trim($_POST['description']),
                        'created_at' => $item->created_at
                    ];

                    $oldData = $data; // Lưu lại dữ liệu cũ để hiển thị lại form nếu có lỗi

                    $rules = [
                        'name' => ['required'],
                        'votes' => ['required', 'integerorzero', 'numericbetween:0,10000000'],
                        'status' => ['required'],
                        'description' => ['required']
                    ];
                    $validator = new \App\Helpers\Validator();
                    if($validator->validate($data, $rules)){
                        $item->id = $data['id'];
                        $item->name = $data['name'];
                        $item->votes = $data['votes'];
                        $item->status = $data['status'];
                        $item->description = $data['description'];
                        if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                            // Xóa ảnh cũ nếu có
                            if (!empty($item->thumbnail)) {
                                FileHelper::deleteImage($item->thumbnail, 'Upload/');
                            }
                            // Upload ảnh mới
                            $filePath = FileHelper::uploadImage($_FILES['thumbnail'], 'Upload/');
                            $item->thumbnail = $filePath; 
                        }
                        try{
                                if($item->update()){
                                    echo "<script>alert('Cập nhật thành công!'); window.location.href='?url=admin#tab-candidates';</script>";
                                    exit;
                                }else{
                                    throw new \Exception("Không thể cập nhật vào cơ sở dữ liệu.");
                                }
                            }catch(\Exception $e){
                                echo "<script>alert('Lỗi hệ thống: " . $e->getMessage() . "'); window.history.back();</script>";
                                exit;
                            }
                    }else{
                        $errors = $validator->getErrors();
                    }
                }

                include 'views/Admin/edit-nam-vuong.php';
            }else{
                echo "No Data";
            }
        }

    }

}
?>