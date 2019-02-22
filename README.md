# tinyphp
tinyphp 是一个轻量级的php框架，该框架集合了yaf，laravel和yii2的一些特点，如yaf的插件功能，laravel自定义路由文件以及yii2的数据对象操作。此外该框架最大的特点是，使用分发器管理类的实例，将类的实例存储在容器中，可以重复使用，避免多次new操作。

## 目录结构
tinyphp
  - app
    - Bootstrap.php
    - conf
    - controllers
    - library
    - migrations
    - models
    - plugins
    - routes.php
    - views
  - core
  - public
  - vendor
  - tip
app 为应用程序目录，包含控制器，视图，模型，路由等文件
core 为框架目录以及自带操作类Config，Table等
public 为应用启动目录，如index.php
vendor 为自动加载以及扩展包目录，使用composer进行管理
tip 为命令行执行工具
## 分发器
core/dispatcher 目录为分发器目录，包含三个文件，其中 Container，Box为
Dispatcher的子类，都是进行类实例的管理，区别在于继承 Container，所有实例
可以重复使用，也就是说子类只在第一次进行new操作。而继承 Box，则每次都需要进行
new操作。
项目中所有类都继承Container或Box，最终交予Dispathcer处理。

## 启动项
框架启动后，第一个执行的文件 app/Bootstrap.php。
## 插件

## 路由

## 控制器

## 方法

## Tipent

## 视图
## 命令行操作 tip
