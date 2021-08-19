# PHP 常用内置函数

## PHP魔术
```php
一、魔术常量
概念：所谓的魔术常量就是PHP预定义的一些常量，这些常量会随着所在的位置而变化。
1、__LINE__  获取文件中的当前行号。
2、__FILE__  获取文件的完整路径和文件名。
3、__DIR__   获取文件所在目录。
4、__FUNCTION__  获取函数名称（PHP 4.3.0 新加）。
5、__CLASS__    获取类的名称（PHP 4.3.0 新加）。
6、__METHOD__  获取类的方法名（PHP 5.0.0 新加）。
7、__NAMESPACE__ 当前命名空间的名称（区分大小写）。
8、__TRAIT__  Trait 的名字（PHP 5.4.0 新加）。

二、超全局变量（9个）
1、$GLOBALS  ：储存全局作用域中的变量
2、$_SERVER  ：获取服务器相关信息
3、$_REQUEST ：获取POST和GET请求的参数
4、$_POST ： 获取表单的POST请求参数
5、$_GET： 获取表单的GET请求参数
6、$_FILES ：获取上传文件的的变量
7、$_ENV ： 获取服务器端环境变量的数组
8、$_COOKIE：获取浏览器的cookie
9、$_SESSION ： 获取session

三、魔术方法
__construct()，类的构造函数
__destruct()，类的析构函数
__call()，在对象中调用一个不可访问方法时调用
__callStatic()，用静态方式中调用一个不可访问方法时调用
__get()，获得一个类的成员变量时调用
__set()，设置一个类的成员变量时调用
__isset()，当对不可访问属性调用isset()或empty()时调用
__unset()，当对不可访问属性调用unset()时被调用。
__sleep()，执行serialize()时，先会调用这个函数
__wakeup()，执行unserialize()时，先会调用这个函数
__toString()，类被当成字符串时的回应方法
__invoke()，调用函数的方式调用一个对象时的回应方法
__set_state()，调用var_export()导出类时，此静态方法会被调用。
__clone()，当对象复制完成时调用
__autoload()，尝试加载未定义的类
__debugInfo()，打印所需调试信息
```
## 输出函数
```php
echo()【语言结构】
print()//【语言结构】
var_dump() //【有返回值】，若传输失败导致没有输出，它返回false
var_export()【有返回值，翻译一个合法的PHP代码】
printf()//类似与C语言的形式 printf("my name is %s, age %d", $name, $age);,打印出来
sprintf()//跟printf相似，但不打印，而是返回格式化后的文字，其他的与printf一样
```
## [数组](https://www.runoob.com/php/php-ref-array.html)
```php
array() // 生成一个数组
range() // 创建并返回一个包含指定范围的元素的数组
compact() // 创建一个由参数所带变量组成的数组
count() // 计算数组中的单元数目或对象中的属性个数
array_chunk() // 把一个数组分割为新的数组块
array_merge() // 把两个或多个数组合并为一个数组
array_slice() // 在数组中根据条件取出一段值，并返回
array_diff() // 返回两个数组的差集数组
array_search() // 在数组中查找一个值，返回一个键，没有返回返回假
array_sum() // 返回数组中所有值的总和
array_shift() // 删除数组中的第一个元素，并返回被删除元素的值
array_unshift() // 在数组开头插入一个或多个元素
array_push() // 向数组最后压入一个或多个元素
array_pop() // 取得（删除）数组中的最后一个元素
array_unique() // 删除重复值，返回剩余数组
array_intersect() // 返回两个或多个数组的交集数组
array_values() // 返回数组中所有值，组成一个数组
array_rand() // 从数组中随机抽取一个或多个元素,注意是键名!!!
array_reverse() // 返回一个元素顺序相反的数组 元素顺序相反的一个数组，键名和键值依然匹配
array_count_values() // 统计数组中所有的值出现的次数
array_flip() // 返回一个键值反转后的数组
in_array() // 在数组中搜索给定的值,区分大小写
array_key_exists() // 判断某个数组中是否存在指定的 key
key() // 返回数组内部指针当前指向元素的键名 　　　
current() // 返回数组中的当前元素(单元). 　　　
next() // 把指向当前元素的指针移动到下一个元素的位置,并返回当前元素的值 　　　
prev() // 把指向当前元素的指针移动到上一个元素的位置,并返回当前元素的值 　　　
end() // 将数组内部指针指向最后一个元素，并返回该元素的值(如果成功) 　　　
reset() // 把数组的内部指针指向第一个元素，并返回这个元素的值 　　　
list() // 用数组中的元素为一组变量赋值
sort() // 按升序对给定数组的值排序,不保留键名
asort() //按升序对给定数组的值排序,保留键名
shuffle() // 将数组打乱,保留键名
each() // 返回数组中当前的键／值对并将数组指针向前移动一步

array_filter($arr,"function");//把$arr放到函数function中处理，【返回判断为TRUE的数据组成新数组，键值保留】
array_walk($arr,"function"[,"data"]);//把$arr放到 function( & $v,$k,$data) 中处理【返回值为bool】
array_map("function",$arr,$arr2,$arr3,....);//把所有数组返回到回调函数统一处理，【返回数组】
array_reduce($arr,myfunction[,initial]);//把一维数组$arr中的值依次传到自定义函数myfunction($v1,$v2)的v2上，v1为累加值类似于( .= ),[如果有initial，先把其当v1传进去]【返回字符串】
```
## [字符串函数](https://www.runoob.com/php/php-ref-string.html)
```php
isset($a) // 当$a=NULL 或不存在，返回false，反之为true
empty($a) // 当$a=NULL/''/array()/0/'0'/不存在 时 返回true,反之为false

nl2br() // \n转义为<br>标签
strip_tags() // 剥去 HTML、XML 以及 PHP 的标签 echo strip_tags("Hello <b>world!</b>"); 
explode() // 使用一个字符串为标志分割另一个字符串
implode() // 同join,将数组值用预订字符连接成字符串
substr() // 截取字符串
str_replace() // 字符串替换操作,区分大小写
str_word_count() // 统计字符串含有的单词数
substr_count() // 统计一个字符串,在另一个字符串中出现次数
substr_replace() // 替换字符串中某串为另一个字符串
strtr() // 转换字符串中的某些字符
strstr() // 返回一个字符串在另一个字符串中开始位置到结束的字符串
stristr() // 返回一个字符串在另一个字符串中开始位置到结束的字符串，不区分大小写
strchr() // strstr()的别名,返回一个字符串在另一个字符串中首次出现的位置开始到末尾的字符串
strrchr() // 返回一个字符串在另一个字符串中最后一次出现位置开始到末尾的字符串
strpos() // 寻找字符串中某字符最先出现的位置
strrpos() // 寻找某字符串中某字符最后出现的位置
strripos() // 寻找某字符串中某字符最后出现的位置,不区分大小写
strcspn() // 返回字符串中不符合mask的字符串的长度
strlen() // 统计字符串长度int strlen(str $str)
str_repeat() // 重复使用指定字符串
strspn() // 返回字符串中首次符合mask的子字符串长度
str_split() // 把字符串分割到数组中
str_pad() // 把字符串填充为指定的长度
wordwrap() // 按照指定长度对字符串进行折行处理
strrev() // 反转字符串
str_shuffle() // 随机地打乱字符串中所有字符
strtolower() // 字符串转为小写
strtoupper() // 字符串转为大写
str_word_count() // 统计字符串含有的单词数
similar_text() // 返回两字符串相同字符的数量
parse_str() // 将字符串解析成变量
ucfirst() // 字符串首字母大写
ucwords() // 字符串每个单词首字符转为大写
md5() // 字符串md5编码
ucwords() // 字符串每个单词首字符转为大写
count_chars() // 统计字符串中所有字母出现次数
md5() // 字符串md5编码
trim() // 删除字符串两端的空格或其他预定义字符
rtrim() // 删除字符串右边的空格或其他预定义字符
chop() // rtrim()的别名
addcslashes() //在指定的字符前添加反斜线转义字符串中字符
stripcslashes() // 删除由addcslashes()添加的反斜线
addslashes() // 指定预定义字符前添加反斜线
stripslashes() // 删除由addslashes()添加的转义字符
quotemeta() // 在字符串中某些预定义的字符前添加反斜线
chr() // 从指定的 ASCII 值返回字符
ord() // 返回字符串第一个字符的ASCII值
strcasecmp() // 不区分大小写比较两字符串
strcmp() // 区分大小写比较两字符串
strncmp() // 比较字符串前n个字符,区分大小写
strncasecmp() // 比较字符串前n个字符,不区分大小写
strnatcmp() // 自然顺序法比较字符串长度,区分大小写
strnatcasecmp() // 自然顺序法比较字符串长度, 不区分大小写
chunk_split() // 将字符串分成小块
strtok() // 切开字符串
ltrim() // 删除字符串左边的空格或其他预定义字符
dirname() // 返回路径中的目录部分
number_format() // 通过千位分组来格式化数字 输入 // 要格式化的数字|规定多少个小数|规定用作小数点的字符 串|规定用作千位分隔符的字符串
htmlentities() // 把字符转为HTML实体
htmlspecialchars() // 预定义字符转html编码
```
## [时间函数](https://www.runoob.com/php/php-ref-date.html)
```php
date_default_timezone_set()('PRC');//设置时区为中国
date.timezone ="PRC";//PHP.INI
time();//默认获取当前时间，【返回时间戳格式】
micritime();//获取当前时间【返回毫秒的时间戳】
mktime(H,i,s,m,d,Y)//指定时间转为时间戳，参数为空的时候作用与time()相同【返回时间戳格式】
strtotime('2015-10-10 10:10:10');//指定时间转换为时间戳【返回时间戳】
date("Y-m-d H:i:s",time());//转换时间戳为日期格式【返回目标格式的字符串】
getdate()//获取当前时间，【返回一个数组，参数年，月，日等都有】
```
## 文件处理函数
```php
fopen() // 打开文件或者 URL
fclose() // 关闭一个已打开的文件指针
filesize() // 取得文件大小
is_readable() // 判断给定文件是否可读
is_writable() // 判断给定文件是否可写
is_executable() // 判断给定文件是否可执行
filectime() // 获取文件的创建时间
filemtime() // 获取文件的修改时间
fwrite() // 写入文件
fread() // 读取文件
file() // 把整个文件读入一个数组中
readdir() // 从目录句柄中读取条目
closedir() // 关闭目录句柄
rmdir() // 删除目录
unlink() // 删除文件
copy() // 拷贝文件
rename() // 重命名一个文件或目录
file_exists($file)//文件是否存在，【true/false】
is_executable($file)//是否可执行【返回bool】
filectime($file)//文件创建时间【时间戳】
filemtime($file)//文件修改时间【时间戳】
fileatime($file)//文件访问时间【时间戳】
stat($file)//返回文件的大部分信息【文件信息数组】

文件的上传与下载
s_uploaded_file() //判断文件是否是通过 HTTP POST上传的
move_uploaded_file() // 将上传的文件移动到新位置

遍历目录
opendir($file)//打开一个目录，参数为目录名或目录路径【返回资源型的目录句柄$dir_handle,无权限返false】
readdir($dir_handle);//读取目录，参数为目录句柄，while,返回当前指向对象的名字，目录指针后移【返回filename,没有是返false】
closedir($dir_handle)//关闭打开的目录
rewinddir($dir_handle) //倒回目录句柄，将目录指针重置到目录开始  
```
## [数学函数](https://www.runoob.com/php/php-ref-math.html)
```php
ceil()//向上取整
floor()//向下取整
round();//四舍五入
abs();//取绝对值
rand(10，100)//随机取值
mt_rand(10,100)//随机取值，算法不同，速度更快
fmod()//返回除法浮点形余数
max(int/$arr)//取最大值
min(int/$arr)//取最小值
pow(1024,2)//返回1021的2次幂
sqrt()// 求平方根
mt_rand()// 更好的随机数
rand()// 随机数 输入 // 最小|最大, 输出 // 随机数随机返回范围内的值
pi()// 获取圆周率值
```
## URL处理函数
```php
urlencode($url)//对该URL进行编码；原因：防止乱码，解决空格的呢个字符不能传递问题，form也是此编码格式传递
urldecode($url)//对该URL进行解码
parse_url($url)//返回该URL的所有信息，[scheme协议][host域名] [path路径][query参数]  【返回含信息的数组】
pathinfo($url)//["dirname"目录名] ["basename"文件名] ["extension"文件后缀]【返回含信息的数组，下标不同】
get_meta_tags($url)//获取该页面的所有META标签【返回关联数组】
```
## JSON
```php
json_encode($data);//对变量进行JSON编码
json_decode($data)//对JSON格式的字符串进行解码
json_last_error();//返回最后一次反生的错误
```
## [正则函数](https://www.runoob.com/php/php-pcre.html)
```php
字符串的匹配查找
1. preg_match($pattern,$subject,$arr);//按正则$pattern处理$subject ,第一次匹配结果返回到数组中【函数的返回值为匹配次数】
2.preg_match_all($pattern,$subject,$arr)//按正则$pattern处理$subject,全部匹配结果返回到数组中【函数的返回值为匹配次数】
3.strstr($str,"@"[,true]);
4.strpos,strrpos,substr($str,position)//联合使用

字符串的替换
1.preg_replace($pattenr,$replace,$str);//【强大的字符串处理函数】 在$str中,把$parrern匹配的值替换成$replcae【返回值为处理后的字符串】
2.str_replace($str,"aaa","bbb");//把$str中的aaa换成bbb

字符串的分割和链接
1.preg_split($pattern,$str); // 通过一个正则表达式分隔字符串【返回值为数组】                         
    举例： $keywords  =  preg_split ( "/[\s,]+/" ,  "hypertext language, programming" );
    结果Array([0] => hypertext,[1] => language[2] => programming)
2.explode(",",$str[,$limit_num]);//把$str按照"，"分割成一个数组[可选参数为返回数组的元素个数]【返回一个 分割后的数组】
3.impolde("+",$arr);//把$arr里的元素按照“+”链接成一个字符串
```
## [XML](https://www.runoob.com/php/php-ref-xml.html)
```php
xml_parser_create() //创建 XML 解析器
xml_parse_into_struct() //把 XML 数据解析到数组中
xml_parser_free() //释放 XML 解析器
```
## [图像处理](https://www.runoob.com/php/php-image-gd.html)
```php
gd_info(); // 取得当前安装的 GD 库的信息
getimagesize(); // 获取图像信息
getimagesizefromstring(); // 获取图像信息
image_type_to_extension(); // 获取图片后缀
image_type_to_mime_type(); // 返回图像的 MIME 类型
image2wbmp(); // 输出WBMP图片
imageaffine(); // 返回经过仿射变换后的图像
imageaffinematrixconcat(); // 连接两个矩阵
imageaffinematrixget(); // 获取矩阵
imagealphablending(); // 设定图像的混色模式
imageantialias(); // 是否使用抗锯齿（antialias）功能
imagearc(); // 画椭圆弧
imagechar(); // 写出横向字符
imagecharup(); // 垂直地画一个字符
imagecolorallocate(); // 为一幅图像分配颜色
imagecolorallocatealpha(); // 为一幅图像分配颜色和透明度
imagecolorat(); // 取得某像素的颜色索引值
imagecolorclosest(); // 取得与指定的颜色最接近的颜色的索引值
imagecolorclosestalpha(); // 取得与指定的颜色加透明度最接近的颜色的索引
imagecolorclosesthwb(); // 取得与指定的颜色最接近的色度的黑白色的索引
imagesx() 、imagesy(); // 获取图像宽度与高度
```
## PHP 可用的函数
```php
boolval() //获取变量的布尔值
debug_zval_dump() //查看一个变量在zend引擎中的引用计数、类型信息
doubleval() //floatval 的别名
empty() //检查一个变量是否为空
floatval() //获取变量的浮点值
get_defined_vars() //返回由所有已定义变量所组成的数组
get_resource_type() //返回资源（resource）类型
gettype() //获取变量的类型
import_request_variables() //将 GET／POST／Cookie 变量导入到全局作用域中
intval() //获取变量的整数值
is_array() //检测变量是否是数组
is_bool() //检测变量是否是布尔型
is_callable() //检测参数是否为合法的可调用结构
is_double() //is_float 的别名
is_float() //检测变量是否是浮点型
is_int() //检测变量是否是整数
is_integer() //is_int 的别名
is_iterable() //检测变量的内容是否是一个可迭代的值
is_long() //is_int 的别名
is_null() //检测变量是否为 NULL
is_numeric() //检测变量是否为数字或数字字符串
is_object() //检测变量是否是一个对象
is_real() //is_float 的别名
is_resource() //检测变量是否为资源类型
is_scalar() //检测变量是否是一个标量
is_string() //检测变量是否是字符串
isset() //检测变量是否已设置并且非 NULL
print_r() //打印变量，输出易于阅读的信息。
serialize() //序列化对象
settype() //设置变量的类型
strval() //获取变量的字符串值
unserialize() //从已存储的表示中创建 PHP 的值
unset() //释放给定的变量
var_dump() //打印变量的相关信息
var_export() //输出或返回一个变量，以字符串形式表示
```
## 其他函数
```php
sleep(10)//脚本执行到这里后，延迟10秒继续执行
serialize()// 返回字符串，此字符串包含了表示  value  的字节流，可以存储于任何地方。
unserialize()// 对单一的已序列化的变量进行操作，将其转换回 PHP 的值。
当序列化对象时，PHP 将试图在序列动作之前调用 该对象的成员函数  __sleep() 。这样就允许对象在被序列化之前做任何清除操作。
类似的，当使用  unserialize()  恢复对象时， 将调用  __wakeup()  成员函数。
```