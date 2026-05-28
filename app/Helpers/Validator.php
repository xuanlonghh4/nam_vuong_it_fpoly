<?php
namespace App\Helpers;

class Validator {
    private $errors = [];

    // Hàm thực hiện kiểm tra dữ liệu dựa trên các quy tắc (rules)
    public function validate($data, $rules) {
        $this->errors = []; // Reset lỗi trước khi check

        foreach ($rules as $field => $fieldRules) {
            $value = trim($data[$field] ?? '');

            foreach ($fieldRules as $rule) {
                // Xử lý các rule có tham số dạng: tên_rule:tham_số (Ví dụ: between:5,100)
                $ruleName = $rule;
                $ruleArgs = [];
                if (strpos($rule, ':') !== false) {
                    list($ruleName, $argsString) = explode(':', $rule);
                    $ruleArgs = explode(',', $argsString);
                }

                // Gọi hàm kiểm tra tương ứng
                $methodName = 'check' . ucfirst($ruleName); // Ví dụ: checkRequired, checkAlpha...
                if (method_exists($this, $methodName)) {
                    $errorMessage = $this->$methodName($field, $value, $ruleArgs);
                    if ($errorMessage) {
                        $this->errors[$field] = $errorMessage;
                        break; // Nếu trường này đã dính 1 lỗi thì bỏ qua các rule sau của trường đó
                    }
                }
            }
        }

        return empty($this->errors);
    }

    // Lấy danh sách lỗi ra ngoài
    public function getErrors() {
        return $this->errors;
    }

    // --- CÁC QUY TẮC VALIDATE (RULES) THỰC TẾ ---

    // 1. Kiểm tra bắt buộc nhập
    private function checkRequired($field, $value) {
        return ($value === '') ? "Trường này không được để trống." : null;
    }

    // 2. Kiểm tra chỉ chứa chữ cái (Unicode tiếng Việt)
    private function checkAlpha($field, $value) {
        if ($value !== '' && !preg_match("/^[\p{L}\s]+$/u", $value)) {
            return "Trường này chỉ được chứa chữ cái.";
        }
        return null;
    }

    // 3. Kiểm tra độ dài ký tự (Min, Max)
    private function checkLengthBetween($field, $value, $args) {
        $min = (int)$args[0];
        $max = (int)$args[1];
        $length = mb_strlen($value, 'UTF-8');
        if ($value !== '' && ($length < $min || $length > $max)) {
            return "Độ dài phải từ {$min} đến {$max} ký tự.";
        }
        return null;
    }

    // 4. Kiểm tra khoảng giá trị số (Ví dụ: Điểm từ 0 đến 10)
    private function checkNumericBetween($field, $value, $args) {
        $min = (float)$args[0];
        $max = (float)$args[1];
        if ($value !== '') {
            if (!is_numeric($value) || (float)$value < $min || (float)$value > $max) {
                return "Giá trị phải là số nằm trong khoảng từ {$min} đến {$max}.";
            }
        }
        return null;
    }

    // 5. Kiểm tra định dạng email
    private function checkEmail($field, $value) {
        if ($value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "Trường này phải là một địa chỉ email hợp lệ.";
        }
        return null;
    }

    // Check số nguyên hoặc = 0
    private function checkIntegerOrZero($field, $value) {
        if ($value !== '' && (!ctype_digit($value) || (int)$value < 0)) {
            return "Trường này phải là số nguyên dương hoặc bằng 0.";
        }
        return null;
    }
}