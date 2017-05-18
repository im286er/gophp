<p align="center">
    <b>📦GoPHP轻量级现代PHP框架</b>
</p>

## Feature

 - 基于 MVC 体系架构，确保了清晰分离逻辑层和表现层；
 - 遵循PSR-2、PSR-4规范，Composer及单元测试支持；
 - 惰性加载，仅在需要时再加载，并且只会加载一次；
 - 支持请求过滤器（中间件），使控制器专注于处理业务逻辑；
 - 提供大量的辅助函数、挂件来提高开发者的开发速度；
 - 核心类高度独立，最大程度的提高代码的复用性和最小程度的降低组件的耦合性；
 - 优雅的调用方式，支持静态调用、动态调用以及静动态混合链式调用；
 - 完美支持PHP7；
 - 内置验证机制；
 - 强大的缓存支持；

## Requirement

 - PHP >= 5.5.0
 - COMPOSER
 - PDO 拓展
 - GD 拓展
 - CURL 拓展
> 框架本身没有什么特别模块要求，具体的应用系统运行环境要求视开发所涉及的模块。

## Installation

1. 下载框架
2. 设置目录权限


    `public/upload`、`runtime`目录给予可读可写权限
    

3. 绑定域名


    将域名绑定到`public`目录下
    

4. 开启UrlRewrite来隐藏入口文件index.php
5. 更改配置信息

## Usage

#### 核心类库:

* ##### db(数据库查询类)
1. 查询单条数据:

```php
db::table('user')->where('id', '=', 1)->find(); //返回所有字段数组
db::table('user')->where('id', '=', 1)->find('title'); //返回指定字段的值
```

2. 查询多条数据:

3. 多表联查:

4. 聚合查询:

5. 添加单条数据:

```php
$data = ['title' => '勾国印', 'sex' => '男', 'qq' => '245629560'];
db::table('user')->add($data); //返回自增ID
```

6. 添加多条数据:

```php
$data1 = ['title' => '勾国印', 'sex' => '男', 'qq' => '245629560'];
$data2 = ['title' => '勾国磊', 'sex' => '男', 'qq' => '314418388'];
db::table('user')->addAll($data1, $data2); //返回影响行数
```

7. 更新数据:

8. 删除数据:

```php
db::table('user')->delete(1); //删除主键为1的用户
db::table('user')->where('id', '>', 100)->delete(); //删除id大于100的用户
```

9. 事务支持:

* ##### config(配置类)

* ##### cookie(COOKIE类)

* ##### session(会话类)

* ##### filter(过滤器)

* ##### validate(验证类)

* ##### request(请求类)

* ##### response(响应类)

* ##### route(路由类)

* ##### upload(上传类)

* ##### controller(控制器基类)

* ##### reflect(反射类)

* ##### cache(缓存类)

* ##### exception(异常基类)

* ##### log(日志类)

* ##### view(视图类)

* ##### mail(邮件类)

* ##### crypt(加密解密类)

* ##### captcha(验证码类)

#### 系统函数:

* ##### dump($arg...)(友好的打印调试)

* ##### input($key, $default)(获取输入参数)

* ##### config($name, $key)(获取配置信息)

* ##### url($uri = null, $arguments = [], $isAbsolute = false, $extension = null)(生成优化的URL)

#### 助手类:

* ##### helper/str(字符串助手类)

* ##### helper/arr(函数助手类)

* ##### helper/dir(目录助手类)

* ##### helper/file(文件助手类)

* ##### helper/url(URL助手类)

## Documentation

- 如果您有任何疑问，或有好的意见和想法，请通过以下途径联系我
- 官方网站：[frame.gouguoyin.cn](http://frame.gouguoyin.cn)
- 使用手册：www.gouguoyin.cn/doc
- 作者博客：www.gouguoyin.cn
- 官方QQ群：421537504 <a style="margin-left:10px" target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=d49826b55d1759513ce5d68253b3f0589b227587edf87059aa08125e620b73c0"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="GoPHP官方交流群" title="GoPHP官方交流群"></a>


