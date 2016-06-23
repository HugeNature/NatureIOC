simple php ioc
usage:

class User
{
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

class DB
{
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
`
