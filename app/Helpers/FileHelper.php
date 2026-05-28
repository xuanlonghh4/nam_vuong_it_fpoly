<?php
namespace App\Helpers;

class FileHelper {
    /**
     * Upload ảnh và trả về tên file nếu thành công
     * @param array $fileData $_FILES['tên_input']
     * @param string $uploadDir Thư mục lưu trữ
     */
    public static function uploadImage(array $fileData, $uploadDir = 'Upload/') {
        // 1. Kiểm tra lỗi hệ thống của file
        if ($fileData['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception("Lỗi upload file: " . $fileData['error']);
        }

        // 2. Kiểm tra định dạng file (Whitelist)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fileData['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            throw new \Exception("Chỉ chấp nhận file ảnh (JPG, PNG, WEBP).");
        }

        // 3. Kiểm tra kích thước (Ví dụ tối đa 2MB)
        if ($fileData['size'] > 2 * 1024 * 1024) {
            throw new \Exception("Kích thước ảnh không được quá 2MB.");
        }

        // 4. Tạo tên file duy nhất để tránh trùng lặp
        $extension = pathinfo($fileData['name'], PATHINFO_EXTENSION);
        $newFileName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $extension;

        // 5. Kiểm tra và tạo thư mục nếu chưa có
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // 6. Di chuyển file vào thư mục đích
        if (move_uploaded_file($fileData['tmp_name'], $uploadDir . $newFileName)) {
            return $newFileName; // Trả về tên file để lưu vào Database
        }

        throw new \Exception("Không thể di chuyển file đã upload.");
    }
    public static function deleteImage($fileName, $uploadDir = 'Upload/') {
        $filePath = $uploadDir . $fileName;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}