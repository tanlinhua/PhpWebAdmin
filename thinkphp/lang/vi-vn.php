<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 核心中文语言包
return [
    // 系统错误提示
    'Undefined variable'                                        => 'định nghĩa không thể biến đổi',
    'Undefined index'                                           => 'chỉ mục nhóm chưa thể xác định',
    'Undefined offset'                                          => 'Chỉ số dưới mảng không thể xác định',
    'Parse error'                                               => 'Lỗi phân tích ngữ pháp',
    'Type error'                                                => 'các loại lỗi',
    'Fatal error'                                               => 'Lỗi nghiêm trọng',
    'syntax error'                                              => 'sai ngữ pháp',

    // 框架核心错误提示
    'dispatch type not support'                                 => 'Loại lập lịch không được hỗ trợ',
    'method param miss'                                         => 'sai tham số phương pháp',
    'method not exists'                                         => 'Phương pháp không tồn tại',
    'module not exists'                                         => 'Mô-đun không tồn tại',
    'controller not exists'                                     => 'Bộ điều khiển không tồn tại',
    'class not exists'                                          => 'loại không tồn tại',
    'property not exists'                                       => 'Thuộc tính  không tồn tại',
    'template not exists'                                       => 'Tệp mẫu không tồn tại',
    'illegal controller name'                                   => 'Tên người kiểm soát không hợp pháp',
    'illegal action name'                                       => 'Tên hoạt động không hợp pháp',
    'url suffix deny'                                           => 'Truy cập hậu tố URL bị cấm',
    'Route Not Found'                                           => 'Tuyến đường truy cập hiện tại không được xác định',
    'Undefined db type'                                         => 'Loại cơ sở dữ liệu không xác định',
    'variable type error'                                       => 'lỗi dữ liệu',
    'PSR-4 error'                                               => 'PSR-4 Lỗi đặc điểm kỹ thuật',
    'not support total'                                         => 'Tổng số dữ liệu không thể lấy được ở chế độ ngắn gọn',
    'not support last'                                          => 'Không thể lấy trang cuối cùng ở chế độ ngắn gọn',
    'error session handler'                                     => 'Lớp bộ xử lý SESSION không chính xác',
    'not allow php tag'                                         => 'Các mẫu không cho phép cú pháp PHP',
    'not support'                                               => 'không hỗ trợ',
    'redisd master'                                             => 'Redisd Lỗi máy chủ chính',
    'redisd slave'                                              => 'Redisd lỗi từ máy chủ dịch vụ',
    'must run at sae'                                           => 'Phải chạy trong SAE',
    'memcache init error'                                       => 'Dịch vụ Memcache chưa được kích hoạt，Vui lòng khởi chạy dịch vụ Memcache trên nền tảng quản lý SAE',
    'KVDB init error'                                           => 'KVDB không được khởi tạo，Vui lòng khởi chạy dịch vụ KVDB trên nền tảng quản lý SAE',
    'fields not exists'                                         => 'Trường bảng dữ liệu không tồn tại',
    'where express error'                                       => 'lỗi biểu đạt kiểm tra',
    'not support data'                                          => 'Biểu thức dữ liệu không được hỗ trợ',
    'no data to update'                                         => 'Không có cập nhật dữ liệu',
    'miss data to insert'                                       => 'Thiếu dữ liệu được ghi',
    'miss complex primary data'                                 => 'Dữ liệu chính tổng hợp bị thiếu',
    'miss update condition'                                     => 'Thiếu điều kiện cập nhật',
    'model data Not Found'                                      => 'Dữ liệu mô hình không tồn tại',
    'table data not Found'                                      => 'Dữ liệu bảng không tồn tại',
    'delete without condition'                                  => 'Không có điều kiện sẽ không thực hiện thao tác xóa',
    'miss relation data'                                        => 'Thiếu dữ liệu bảng liên quan',
    'tag attr must'                                             => 'phải Thuộc tính thẻ mẫu ',
    'tag error'                                                 => 'Lỗi thẻ mẫu',
    'cache write error'                                         => 'Lỗi ghi vào bộ nhớ key',
    'sae mc write error'                                        => 'SAE mc Viết sai',
    'route name not exists'                                     => 'ID định tuyến không tồn tại (hoặc các tham số không đủ',
    'invalid request'                                           => 'Yêu cầu không hợp pháp',
    'bind attr has exists'                                      => 'Các thuộc tính của mô hình đã tồn tại',
    'relation data not exists'                                  => 'Dữ liệu được liên kết không tồn tại',
    'relation not support'                                      => 'Hiệp hội không ủng hộ',
    'chunk not support order'                                   => 'Chunk không hỗ trợ điều chỉnh Sử dụng phương thức đặt hàng',
    'closure not support cache(true)'                           => 'Sử dụng truy vấn đóng không hỗ trợ bộ nhớ key (true)，Vui lòng chỉ định khóa bộ nhớ key',

    // 上传错误信息
    'unknown upload error'                                      => 'Lỗi tải lên không xác định！',
    'file write error'                                          => 'Ghi tệp không thành công！',
    'upload temp dir not found'                                 => 'Không thể tìm thấy thư mục tạm thời!！',
    'no file to uploaded'                                       => 'Không co tập tin nao được tải lên！',
    'only the portion of file is uploaded'                      => 'Chỉ một phần của tệp được tải lên！',
    'upload File size exceeds the maximum value'                => 'Kích thước tệp tải lên vượt quá kích thước tối đa！',
    'upload write error'                                        => 'Lỗi tải lên và lưu tệp！',
    'has the same filename: {:filename}'                        => 'Tệp có cùng tên tồn tại：{:filename}',
    'upload illegal files'                                      => 'Tải lên không hợp pháp các tệp',
    'illegal image files'                                       => 'Tệp hình ảnh không hợp pháp',
    'extensions to upload is not allowed'                       => 'Không cho phép tải lên hậu tố tệp',
    'mimetype to upload is not allowed'                         => 'Loại tệp MIME tải lên không được phép！',
    'filesize not match'                                        => 'Kích thước tệp tải lên không khớp！',
    'directory {:path} creation failed'                         => 'mục lục {:path} Tạo không thành công！',

    // Validate Error Message
    ':attribute require'                                        => ':attribute Không được để trống',
    ':attribute must be numeric'                                => ':attributePhải là số',
    ':attribute must be integer'                                => ':attributePhải là nguyên số ',
    ':attribute must be float'                                  => ':attributePhải là một số dấu phẩy động',
    ':attribute must be bool'                                   => ':attributePhải là một giá trị ',
    ':attribute not a valid email address'                      => ':attribute Định dạng không khớp',
    ':attribute not a valid mobile'                             => ':attribute Định dạng không khớp',
    ':attribute must be a array'                                => ':attributePhải là số',
    ':attribute must be yes,on or 1'                            => ':attribute cần phải yes、on hoặc là 1',
    ':attribute not a valid datetime'                           => ':attribute Không phải là một định dạng ngày hoặc giờ hợp lệ',
    ':attribute not a valid file'                               => ':attribute Không phải là tệp tải lên hợp lệ',
    ':attribute not a valid image'                              => ':attribute Không phải là một tệp hình ảnh hợp lệ',
    ':attribute must be alpha'                                  => ':attribute Chỉ có thể là chữ cái ',
    ':attribute must be alpha-numeric'                          => ':attributeChỉ có thể là chữ cái và số',
    ':attribute must be alpha-numeric, dash, underscore'        => ':attribute Chỉ có thể là chữ cái、Số và dấu gạch dưới_ và dấu gạch ngang-',
    ':attribute not a valid domain or ip'                       => ':attributeKhông phải là một tên miền hoặc IP hợp lệ',
    ':attribute must be chinese'                                => ':attribute Chỉ có thể là ký tự viet nam',
    ':attribute must be chinese or alpha'                       => ':attributeChỉ có thể là chữ việt, chữ cái',
    ':attribute must be chinese,alpha-numeric'                  => ':attributeChỉ có thể là ký tự, chữ cái và số vietnam',
    ':attribute must be chinese,alpha-numeric,underscore, dash' => ':attributeChỉ có thể là chữ viet, chữ cái、Số và dấu gạch dưới_ và dấu gạch ngang-',
    ':attribute not a valid url'                                => ':attribute Không phải là địa chỉ URL hợp lệ',
    ':attribute not a valid ip'                                 => ':attribute Không phải là địa chỉ IP hợp lệ',
    ':attribute must be dateFormat of :rule'                    => ':attribute Định dạng ngày tháng phải được sử dụng :rule',
    ':attribute must be in :rule'                               => ':attribute phải là :rule Trong phạm vi',
    ':attribute be notin :rule'                                 => ':attribute Không thể ở :rule Trong phạm vi',
    ':attribute must between :1 - :2'                           => ':attribute Chỉ trong :1 - :2 giữa',
    ':attribute not between :1 - :2'                            => ':attribute Không thể trong :1 - :2 giữa',
    'size of :attribute must be :rule'                          => ':attribute Chiều dài không đáp ứng yêu cầu :rule',
    'max size of :attribute must be :rule'                      => ':attribute Chiều dài không được vượt quá :rule',
    'min size of :attribute must be :rule'                      => ':attribute Chiều dài không được nhỏ hơn :rule',
    ':attribute cannot be less than :rule'                      => ':attribute Ngày không được nhỏ hơn :rule',
    ':attribute cannot exceed :rule'                            => ':attribute Ngày không được vượt quá :rule',
    ':attribute not within :rule'                               => 'Không trong thời hạn hiệu lực :rule',
    'access IP is not allowed'                                  => 'Quyền truy cập IP không được phép',
    'access IP denied'                                          => 'Quyền truy cập IP bị cấm',
    ':attribute out of accord with :2'                          => ':attributeVà trường xác nhận: 2 không phù hợp',
    ':attribute cannot be same with :2'                         => ':attribute Và trường so sánh: 2 không được giống nhau',
    ':attribute must greater than or equal :rule'               => ':attribute Phải lớn hơn hoặc bằng :rule',
    ':attribute must greater than :rule'                        => ':attribute Phải lớn hơn :rule',
    ':attribute must less than or equal :rule'                  => ':attributePhải nhỏ hơn hoặc bằng :rule',
    ':attribute must less than :rule'                           => ':attribute Phải nhỏ hơn :rule',
    ':attribute must equal :rule'                               => ':attributePhải bằng nhau:rule',
    ':attribute has exists'                                     => ':attribute đã tồn tại',
    ':attribute not conform to the rules'                       => ':attribute Không đáp ứng các quy tắc được chỉ định',
    'invalid Request method'                                    => 'Loại yêu cầu không hợp lệ',
    'invalid token'                                             => 'Dữ liệu mã thông báo không hợp lệ',
    'not conform to the rules'                                  => 'Lỗi quy tắc',
];
