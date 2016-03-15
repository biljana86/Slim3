<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);


if (PHP_SAPI == 'cli-server') {
  
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';


@session_start();

$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

$container = $app->getContainer();
$container['view'] = function ($container){
  $view = new \Slim\Views\Twig('./templates');
  
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};
$container["db"] = new PDO('mysql:host=localhost;dbname=korisnici;', 'root', 'zezalica');



$app->get('/hello', function($request, $response, $args) {
    $response->write("Welcome to Slim!");
    return $response;
});
$app->get('/index2', function($request, $response, $args) {
 return $this->view->render($response, 'index2.php');
   
});
$app->get('/home', function($request, $response,array $args) {
$args['name']=$_SESSION['name'];
if(isset($_SESSION['name'])&& $_SESSION['name']!=''){
     return $this->view->render($response, 'home.php',$args);
      }
      else{return $response->withRedirect('/index2'); 
      }

 
   
});
$app->get('/logout', function($request, $response, $args) {
unset($_SESSION['user']);
@session_destroy();
   return $response->withRedirect('/index2'); 
});
$app->post('/registration', function($request, $response, $args) {
 $name =$request->getParam('tbname');
 $last =$request->getParam('tblastname');
 $email =$request->getParam('tbemail');
 $pass =md5($request->getParam('tbpasswd'));
 $date=date("Y-m-d H:i:s");
 $connection = $this->get("db");
 $stmt = $this->db->query("INSERT INTO user (name, surname, email,password,Date)
    VALUES ('$name', '$last', '$email','$pass','$date')");
 
   return $response->withRedirect('/index2'); 
});

$app->post('/login', function($request, $response,array $args) {
   $email =$request->getParam('email');
   $pass=md5($request->getParam('passwd'));
   $connection = $this->get("db");
    
	 $stmt = $this->db->query('SELECT * FROM user WHERE email="'.$email.'" AND password="'.$pass.'";');
 
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

$_SESSION['name']=$row['name'];

$args['name'] = $_SESSION['name'];

}
if(isset($_SESSION['name'])&& $_SESSION['name']!=''){
      return $this->view->render($response, 'home.php',$args);
      }
      else{return $response->withRedirect('/index2'); 
      }

});
$app->get('/users', function($request, $response,array $args) {
  
  $connection = $this->get("db");
    
	 $stmt = $this->db->query('SELECT * FROM user ORDER BY date DESC;');
	 $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$str='';
$result=array();
foreach($results as $row) {

$dates = explode(' ', $row['Date']);

$result[]=array('name'=>$row['name'],'surname'=>$row['surname'],'email'=>$row['email'],'date'=>$dates[0]);
   
  
}
 $params = array('data' => $result);
 
 if(isset($_SESSION['name'])&& $_SESSION['name']!=''){
     return $this->view->render($response,'users.php', $params);
      }
      else{return $response->withRedirect('/index2'); 
      }

});
// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
