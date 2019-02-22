<?php

namespace Core;

use Dispatcher\Container;

class Controller extends Container 
{
    /**
     * @param string $file 
     * @param array $data
     *
     */
    public function render(string $file, array $data = [])
    {
        return $this->display($file, $data);
    }

    /**
     * 不加载公共资源
     *
     * @param string $file 
     * @param array $data
     */
    public function renderFile(string $file, array $data = [])
    {
        return $this->display($file, $data, false);
    }
    
    /**
     * 调用 View 类
     * @param string $file 
     * @param array $data
     * @param bool $userLayout
     */
    private function display(string $file, array $data, bool $useLayout = true)
    {
        //默认使用控制器名作为视图目录
        $controller = get_called_class();
        
        $folder = substr($controller,strripos($controller,'\\')+1,-10);
        
        return View::display(strtolower($folder), $file, $data, $useLayout);
    }
}
