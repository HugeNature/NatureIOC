<?php
namespace Test;

class Container
{
    public $singletons;
    protected $keys;
    protected $skeys;
    protected $values;

    public function __construct()
    {
        //$this->singletons = new \SplObjectStorage();
    }

    public function bind($id,$callable)
    {
        $this->values[$id] = $callable;
        $this->keys[$id] = true;
    }
    public function singleton($id,$callable)
    {
        if(!$this->skeys[$id]){
            $this->skeys[$id] = true;
            $this->singletons[$id] = call_user_func($callable);
        }
        //echo "<pre>";
        //var_dump($this->singletons);
        //echo "</pre>";
        return $this->singletons[$id];
    }
    public function has($id)
    {
        if(isset($this->keys[$id]) || isset($this->skeys[$id]))
        {
            return true;
        }
        return false;
    }
    public function make($id,$parameters=[])
    {
        if (!$this->has($id)  ) {
            throw new \InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
        }
        if (isset($this->skeys[$id])) {
            //echo  'hi';
            return $this->singletons[$id];
        }
        //echo 222;
        return $this->values[$id]($this);

    }
}

class User{
    private $age = 10;
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function add()
    {
        echo $this->db->add();
    }
}
class DB{


    /**
     * DB constructor.
     */
    public function __construct()
    {
        echo rand(1000,9000)."<br >";
    }

    public function add()
    {
        echo 'data added successfully';
    }
}
$container = new Container();
$container->singleton('db',function($c){
    return new DB();
});
$container->bind('user',function($c){
    return $c->make('db');
});
$user1  = $container->make('user');
$user2  = $container->make('user');
$user3  = $container->make('user');
$user1->add();
//$user->add();
