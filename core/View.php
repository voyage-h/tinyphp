<?php

namespace Core;

use Dispatcher\Container;

class View extends Container
{
    /**
     * 加载页面，提取数据
     *
     */
    protected function display(string $folder, string $filename, array $data, $useLayout = true)
    {
        $view_path = APP_PATH.'/app/views/';

        $file = $view_path.$folder.'/'.$filename.'.php';

        if (!empty($data)) {
            extract($data);
        }

        ob_start();
        require $file;
        $content = ob_get_clean();

        //加载公共页面
        if ($useLayout) {
            $conf = Config::get('view');

            $common = $view_path.'/'.($conf['dir'] ?? 'layout') .'/'.($conf['file'] ?? 'base').'.php';

            ob_start();
            require $common;
            $content = ob_get_clean();
        }
        return $content;
    }
}
