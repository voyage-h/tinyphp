<?php

namespace Core;

use Dispatcher\Container;

class Model extends Container
{
	private $db;
    private $stmt;

    public $table;

	/**
	 * 构造函数数据库初始化连连接接
	 *
	 *
	 */
	public function __construct()
    {
        $conf = Config::get('db.pdo');
        try {
            //初始化一个PDO对象
            $this->db = new \PDO($conf['ms'].":host=".$conf['host'].";dbname=".$conf['database'], 
                $conf['user'], 
                $conf['password']
            );
        } catch (\PDOException $e) {
            Error::fatal($e->getMessage());
        }
	}
    /**
     * 使用 prepare 语句
     *
     */
    protected function prepare($sql)
    {
        $this->stmt = $this->db->prepare($sql);
        return $this;
    }
    /**
     * 绑定参数
     *
     */
    public function bind(array $data)
    {
        $res = $this->stmt->execute($data);
        return $this;
    }

    public function exec(array $data) 
    {
        return $this->stmt->execute($data);
    }
    /**
     * 获取结果
     *
     */
    public function get()
    {
        return $this->stmt->fetchAll(\PDO::FETCH_CLASS);
    }

    protected function query($sql)
    {
        $this->db->exec($sql);
        if ( '00000' != $this->db->errorCode()) {
            return $this->db->errorInfo();
        }
        return true;
    }
}
