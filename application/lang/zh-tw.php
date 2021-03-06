<?php

// 核心繁体语言包
return [
    // 系统错误提示
    'Undefined variable'                                        => '未定義變量',
    'Undefined index'                                           => '未定義數組索引',
    'Undefined offset'                                          => '未定義數組下標',
    'Parse error'                                               => '語法解析錯誤',
    'Type error'                                                => '類型錯誤',
    'Fatal error'                                               => '致命錯誤',
    'syntax error'                                              => '語法錯誤',

    // 框架核心错误提示
    'dispatch type not support'                                 => '不支持的調度類型',
    'method param miss'                                         => '方法參數錯誤',
    'method not exists'                                         => '方法不存在',
    'module not exists'                                         => '模塊不存在',
    'controller not exists'                                     => '控制器不存在',
    'class not exists'                                          => '類不存在',
    'property not exists'                                       => '類的屬性不存在',
    'template not exists'                                       => '模板文件不存在',
    'illegal controller name'                                   => '非法的控制器名稱',
    'illegal action name'                                       => '非法的操作名稱',
    'url suffix deny'                                           => '禁止的URL後綴訪問',
    'Route Not Found'                                           => '當前訪問路由未定義',
    'Undefined db type'                                         => '未定義數據庫類型',
    'variable type error'                                       => '變量類型錯誤',
    'PSR-4 error'                                               => 'PSR-4 規範錯誤',
    'not support total'                                         => '簡潔模式下不能獲取數據總數',
    'not support last'                                          => '簡潔模式下不能獲取最後一頁',
    'error session handler'                                     => '錯誤的SESSION處理器類',
    'not allow php tag'                                         => '模板不允許使用PHP語法',
    'not support'                                               => '不支持',
    'redisd master'                                             => 'Redisd 主服務器錯誤',
    'redisd slave'                                              => 'Redisd 從服務器錯誤',
    'must run at sae'                                           => '必須在SAE運行',
    'memcache init error'                                       => '未開通Memcache服務，請在SAE管理平台初始化Memcache服務',
    'KVDB init error'                                           => '沒有初始化KVDB，請在SAE管理平台初始化KVDB服務',
    'fields not exists'                                         => '數據表字段不存在',
    'where express error'                                       => '查詢表達式錯誤',
    'not support data'                                          => '不支持的數據表達式',
    'no data to update'                                         => '沒有任何數據需要更新',
    'miss data to insert'                                       => '缺少需要寫入的數據',
    'miss complex primary data'                                 => '缺少複合主鍵數據',
    'miss update condition'                                     => '缺少更新條件',
    'model data Not Found'                                      => '模型數據不存在',
    'table data not Found'                                      => '表數據不存在',
    'delete without condition'                                  => '沒有條件不會執行刪除操作',
    'miss relation data'                                        => '缺少關聯表數據',
    'tag attr must'                                             => '模板標籤屬性必須',
    'tag error'                                                 => '模板標籤錯誤',
    'cache write error'                                         => '緩存寫入失敗',
    'sae mc write error'                                        => 'SAE mc 寫入錯誤',
    'route name not exists'                                     => '路由標識不存在（或參數不夠）',
    'invalid request'                                           => '非法請求',
    'bind attr has exists'                                      => '模型的屬性已經存在',
    'relation data not exists'                                  => '關聯數據不存在',
    'relation not support'                                      => '關聯不支持',
    'chunk not support order'                                   => 'Chunk不支持調用order方法',
    'closure not support cache(true)'                           => '使用閉包查詢不支持cache(true)，請指定緩存Key',

    // 上传错误信息
    'unknown upload error'                                      => '未知上傳錯誤！',
    'file write error'                                          => '文件寫入失敗！',
    'upload temp dir not found'                                 => '找不到臨時文件夾！',
    'no file to uploaded'                                       => '沒有文件被上傳！',
    'only the portion of file is uploaded'                      => '文件只有部分被上傳！',
    'upload File size exceeds the maximum value'                => '上傳文件大小超過了最大值！',
    'upload write error'                                        => '文件上傳保存錯誤！',
    'has the same filename: {:filename}'                        => '存在同名文件：{:filename}',
    'upload illegal files'                                      => '非法上傳文件',
    'illegal image files'                                       => '非法圖片文件',
    'extensions to upload is not allowed'                       => '上傳文件後綴不允許',
    'mimetype to upload is not allowed'                         => '上傳文件MIME類型不允許！',
    'filesize not match'                                        => '上傳文件大小不符！',
    'directory {:path} creation failed'                         => '目錄 {:path} 創建失敗！',

    // Validate Error Message
    ':attribute require'                                        => ':attribute不能為空',
    ':attribute must be numeric'                                => ':attribute必須是數字',
    ':attribute must be integer'                                => ':attribute必須是整數',
    ':attribute must be float'                                  => ':attribute必須是浮點數',
    ':attribute must be bool'                                   => ':attribute必須是布爾值',
    ':attribute not a valid email address'                      => ':attribute格式不符',
    ':attribute not a valid mobile'                             => ':attribute格式不符',
    ':attribute must be a array'                                => ':attribute必須是數組',
    ':attribute must be yes,on or 1'                            => ':attribute必須是yes、on或者1',
    ':attribute not a valid datetime'                           => ':attribute不是一個有效的日期或時間格式',
    ':attribute not a valid file'                               => ':attribute不是有效的上傳文件',
    ':attribute not a valid image'                              => ':attribute不是有效的圖像文件',
    ':attribute must be alpha'                                  => ':attribute只能是字母',
    ':attribute must be alpha-numeric'                          => ':attribute只能是字母和數字',
    ':attribute must be alpha-numeric, dash, underscore'        => ':attribute只能是字母、數字和下劃線_及破折號-',
    ':attribute not a valid domain or ip'                       => ':attribute不是有效的域名或者IP',
    ':attribute must be chinese'                                => ':attribute只能是漢字',
    ':attribute must be chinese or alpha'                       => ':attribute只能是漢字、字母',
    ':attribute must be chinese,alpha-numeric'                  => ':attribute只能是漢字、字母和數字',
    ':attribute must be chinese,alpha-numeric,underscore, dash' => ':attribute只能是漢字、字母、數字和下劃線_及破折號-',
    ':attribute not a valid url'                                => ':attribute不是有效的URL地址',
    ':attribute not a valid ip'                                 => ':attribute不是有效的IP地址',
    ':attribute must be dateFormat of :rule'                    => ':attribute必須使用日期格式 :rule',
    ':attribute must be in :rule'                               => ':attribute必須在 :rule 範圍內',
    ':attribute be notin :rule'                                 => ':attribute不能在 :rule 範圍內',
    ':attribute must between :1 - :2'                           => ':attribute只能在 :1 - :2 之間',
    ':attribute not between :1 - :2'                            => ':attribute不能在 :1 - :2 之間',
    'size of :attribute must be :rule'                          => ':attribute長度不符合要求 :rule',
    'max size of :attribute must be :rule'                      => ':attribute長度不能超過 :rule',
    'min size of :attribute must be :rule'                      => ':attribute長度不能小於 :rule',
    ':attribute cannot be less than :rule'                      => ':attribute日期不能小於 :rule',
    ':attribute cannot exceed :rule'                            => ':attribute日期不能超過 :rule',
    ':attribute not within :rule'                               => '不在有效期內 :rule',
    'access IP is not allowed'                                  => '不允許的IP訪問',
    'access IP denied'                                          => '禁止的IP訪問',
    ':attribute out of accord with :2'                          => ':attribute和確認字段:2不一致',
    ':attribute cannot be same with :2'                         => ':attribute和比較字段:2不能相同',
    ':attribute must greater than or equal :rule'               => ':attribute必須大於等於 :rule',
    ':attribute must greater than :rule'                        => ':attribute必須大於 :rule',
    ':attribute must less than or equal :rule'                  => ':attribute必須小於等於 :rule',
    ':attribute must less than :rule'                           => ':attribute必須小於 :rule',
    ':attribute must equal :rule'                               => ':attribute必須等於 :rule',
    ':attribute has exists'                                     => ':attribute已存在',
    ':attribute not conform to the rules'                       => ':attribute不符合指定規則',
    'invalid Request method'                                    => '無效的請求類型',
    'invalid token'                                             => '令牌數據無效',
    'not conform to the rules'                                  => '規則錯誤',
];
