<?php

namespace test;

define('APP_PATH',dirname(__DIR__));

use PHPUnit\Framework\TestCase;
use core\Router;
use core\Config;

class RouterTest extends TestCase 
{
    private static $controllers;
    private static $actions;
    private static $routes;

    private $controller;
    private $action;

    private static $default;

    public static function setUpBeforeClass()
    {
        self::$routes = "Router::get('/', '".self::$controllers[0][0]."@".self::$actions[0][0]."');".PHP_EOL;
        self::$default = file_get_contents(APP_PATH.'/app/routes.php');
    }
    public static function tearDownAfterClass()
    {
        file_put_contents(APP_PATH.'/app/routes.php', self::$default);
    }

    public function setUp()
    {
        $route = self::$routes;
        $content = <<<EOT
<?php

use core\Router;

$route
EOT;
        file_put_contents(APP_PATH.'/app/routes.php', $content);
        extract(Router::start());
        $this->controller = $controller;
        $this->action = $action;
    }
    /**
     * @dataProvider controllerProvider
     */
    public function testController($controller)
    {
        $this->assertEquals($this->controller, $controller);
    }

    /**
     * @dataProvider actionProvider
     */
    public function testAction($action)
    {
        $this->assertEquals($this->action, $action);
    }

    public function controllerProvider()
    {
        static::$controllers = [
            ['CsController'],
        ];
        return static::$controllers;
    }

    public function actionProvider()
    {
        static::$actions = [
            ['getCndex'],
        ];
        return static::$actions;
    }
}
