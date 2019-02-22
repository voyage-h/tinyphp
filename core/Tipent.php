<?php

namespace Core;

use Dispatcher\Box;

class Tipent extends Box
{
    private $_where;
    private $_select;
    private $_limit;
    private $_sql;
    private $_params = [];
    private $_action;

    //public $table;

    public function __construct()
    {
        if (!$this->table) {
            $tmp = explode('\\', get_called_class());
            $this->table = strtolower($tmp[1]).'s';
        }
    }

    /**
     * select
     *
     *
     */
	protected function find()
	{
        $this->_action = 'select';

        $this->_sql = 'SELECT * FROM '.$this->table;
	    return $this;    
	}

    /**
     * column
     *
     */
	public function select($select)
	{
        if (is_array($select)) {
            $select = implode(',',$select);
        }
		$this->_sql = str_replace('*',trim($select),$this->_sql);
	    return $this;
	}

	public function one() 
	{
		$this->_limit = ' LIMIT 1';
        $res = $this->fetch();
	    return is_array($res) ? current($res) : $res;
	}

	public function all() 
	{
		return $this->fetch();
    }

    public function fetch()
    {
        $sql = $this->_sql.($this->_where ?? '').($this->_limit ?? '');

        $res = Model::prepare($sql);

        if ($this->_action == 'select') {
            $res = $res->bind($this->_params)->get();
            return empty($res) ? [] : $res;
        }
        return $res->exec($this->_params);
    }

    public function and($where)
    {
         $this->_where .= $this->setCondition($where,'AND');
         return $this;
    }

    public function or($where)
    {
        $this->_where .= $this->setCondition($where,'OR');
        return $this;
    
    }
    public function where($where) 
    {
        $this->_where = $this->setCondition($where,'WHERE');
        return $this;
    }
    private function setCondition($where, $type)
    {
        if (is_string($where)) {
            return " $type $where";
        }
        if (is_array($where) && count($where) == 1) {
            $where = ['=', key($where), current($where)];
        }
        if (!is_array($where) || count($where) != 3) {
            Error::fatal("Invalid where condition");
        }
        $keyword = strtoupper($where[0]);
        $field = $where[1];
        $value = $where[2];
        switch($keyword) {
            case 'BETWEEN':
                if (!is_array($value) || count($value) != 2) {
                    Error::fatal("Invalid value in between");
                }
                $tag = '? and ?';
                $value = [$value[0],$value[1]];
            break;
            default:
                $tag = '?';
                if (is_array($value)) {
                    while(next($value)) {
                        $tag .= ', ?';
                    }
                    $tag = "($tag)";
                }
        }
        is_array($value) or $value = [$value];
        $this->_params = array_merge($this->_params, $value);
        return " $type $field $keyword $tag";
    }

    /**
     * insert
     *
     */
    protected function insert($data)
    {
        $columns = implode(array_keys($data), ', ');

        $tag = '?';
        while(next($data)) {
            $tag .= ', ?';
        }
        $sql = "INSERT INTO `$this->table` ($columns) VALUES ($tag)";

        return Model::prepare($sql)->exec(array_values($data));
    }

    /**
     * update
     *
     *
     */
    protected function update($set)
    {
        $tag = ' = ?, ';
        $columns = trim(implode(array_keys($set), $tag). $tag, ', ');

        $this->_sql = "UPDATE `$this->table` SET $columns";
        $this->_params = array_values($set);

        return $this;
    }
    /**
     * 
     * @param string $class
     * @param array $on
     * @throws Error
     * @return \system\Object
     */
    public function hasMany(string $class,array $on) {
        $this->_hasOne = false;
        return $this->has($class,$on);
    }
    /**
     * 
     * @param string $class
     * @param array $on
     * @throws Error
     * @return \system\Object
     */
    public function hasOne(string $class,array $on) {
        return $this->has($class,$on);
    }
    private function has(string $class,array $on) {
        if (!class_exists($class)) {
            Error::fatal("class [ $class ] doesn't exist");
        }
        $obj = new $class;
        if($this->_hasOne) {
            $obj->limit(1);
        }
        //执行匿名函数
        if(isset($this->_obj)) {
            $this->_obj->__invoke($obj);
        }
        if(!empty($this->_join)) {
            $this->_join .= '`'.$obj->dbTable."` ON ".$obj->dbTable.".".key($on)." = ".$this->dbTable.".".current($on).$obj->_and;
            return $this;
        }
        $obj->and(key($on).' = ?');
        $sql = $obj->_buildquery($obj->dbTable,$this->_action);
        $this->_preparesql = $sql;
        $this->_stmt = $this->db->prepare($sql);
        $this->_key = current($on);
        return $obj;
    }    
    /**
     * 
     * @param string $objectName
     * @param string $on
     * @throws Error
     * @return \system\Object
     */
    public function with($object) {
        if(is_array($object)){
            $model = key($object);        
            $this->_obj = current($object);
        } else {
            $model = $object;
        }
        $this->_withObj = $model;
        $method = 'get'.ucfirst($model);
        if (!method_exists($this, $method)) {
            Error::fatal("method [ $method ] doesn't exist in model ".get_called_class());
        }
        call_user_func_array([$this, $method], []);
        return $this;
    }
    public function joinWith($object) {
        $this->_join .= ' LEFT JOIN ';
        return $this->with($object);    
    }
    public function innerJoinWith($object) {
        $this->_join .= ' INNER JOIN ';
        return $this->with($object);    
    }
    public function rightJoinWith($object) {
        $this->_join .= ' RIGHT JOIN ';
        return $this->with($object);    
    }
}

