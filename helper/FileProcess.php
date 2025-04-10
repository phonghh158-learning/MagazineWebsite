<?php

    namespace Helper;

    use Exception;

    class FileProcess {

        public static function uploadImage($file, $dir, $name) {
            try {
                $targetDir = "upload/images/" . $dir; // Sửa lỗi đường dẫn tuyệt đối
        
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true); // Tạo thư mục nếu chưa có
                }
        
                $imageType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
                $imageName = time() . "-" . $name . "." . $imageType;
                $imagePath = $targetDir . "/" . $imageName;

                // Kiểm tra dung lượng (<= 4MB)
                if ($file["size"] > 4 * 1024 * 1024) {
                    throw new Exception("File quá lớn, chỉ chấp nhận <= 4MB.");
                }
        
                // Chỉ cho phép một số định dạng ảnh
                $allowedTypes = ["jpg", "jpeg", "png", "gif"];
                if (!in_array($imageType, $allowedTypes)) {
                    throw new Exception("Chỉ chấp nhận file PNG, JPG, JPEG hoặc GIF.");
                }
        
                // Kiểm tra MIME type để tránh upload file giả mạo
                $mimeType = mime_content_type($file["tmp_name"]);
                if (!str_starts_with($mimeType, "image/")) {
                    throw new Exception("Chỉ chấp nhận file PNG, JPG, JPEG hoặc GIF.");
                }
        
                // Upload file
                if (move_uploaded_file($file["tmp_name"], $imagePath)) {
                    return $imagePath;
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
                throw new Exception($e->getMessage());
            }
        }
        
        public static function deleteImage($imagePath) {
            if (file_exists($imagePath)) {
                if (unlink($imagePath)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        
    }

?>