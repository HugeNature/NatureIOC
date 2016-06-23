simple php ioc  
usage:

```
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
```
