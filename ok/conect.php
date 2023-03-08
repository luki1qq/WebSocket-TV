
<?php
//codigo para conectarse con Base de datos MYSQL
// los parametros de entrada son host(servidor), usuario, contraseña y base de >
//creamos la variable conex

$db_host="127.0.0.1:80";
$db_name="chat";
$db_login="root";
$db_pswd="156299502";



// $db_host="database-1.cg9nndbqelzc.sa-east-1.rds.amazonaws.com";
// $db_name="mydb";
// $db_login="admin";
// $db_pswd="keke2028";



$conex = new mysqli($db_host,$db_login,$db_pswd,$db_name);
//valida si esta correcta la conexion y muestra el mensaje
if($conex){
// echo "Conexion Correcta!";
}
else{ echo "error en la conexion!";}
?>

