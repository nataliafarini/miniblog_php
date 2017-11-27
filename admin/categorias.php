<?

// iniciamos session
session_start ();

// archivos necesarios
require_once 'config.php';
require_once 'conexion.php';


// obtengo puntero de conexion con la db
$dbConn = conectar();



// borramos una categoria
if ( !empty($_GET['del']) ) {
	
	$query  = "DELETE FROM `categoria` WHERE id_categoria = {$_GET['del']}";
	$result = mysql_query($query, $dbConn);
		
	header( 'Location: categorias.php?dele=true' );
	die;
	
}

// agregamos una categoria en la db
// si se envio el formulario
if ( !empty($_POST['submit']) ) {
	
	// definimos las variables
	if ( !empty($_POST['nombre']) ) 	$nombre 	= $_POST['nombre'];
	
	// completamos la variable error si es necesario
	if ( empty($nombre) ) 	$error['nombre'] 		= 'Es obligatorio completar el nombre de la categoria';
	
	// si no hay errores registramos al usuario
	if ( empty($error) ) {
		
		// inserto los datos de registro en la db
		$query  = "INSERT INTO `categoria` (valor) VALUES ('$nombre')";
		$result = mysql_query($query, $dbConn);
		
		header( 'Location: categorias.php?add=true' );
		die;
		
	}
		
}

if ( !empty($_POST['submitEdit']) ) {
	
	// definimos las variables
	if ( !empty($_POST['nombre']) ) 		$nombre 		= $_POST['nombre'];
	if ( !empty($_POST['id_categoria']) ) 	$id_categoria 	= $_POST['id_categoria'];
	
	// completamos la variable error si es necesario
	if ( empty($nombre) ) 		$error['nombre'] 		= 'Es obligatorio completar el nombre de la categoria';
	if ( empty($id_categoria) ) 	$error['id_categoria'] 	= 'Falta la ID de la categoria';
	
	// si no hay errores registramos al usuario
	if ( empty($error) ) {
		
		// inserto los datos de registro en la db
		$query  = "UPDATE `categoria` set valor = '$nombre' WHERE id_categoria = $id_categoria";
		$result = mysql_query($query, $dbConn);
		
		header( 'Location: categorias.php?edit=true' );
		die;
		
	}
		
}

// traemos listado de categorias
$arrCategorias = array();
$query = "SELECT id_categoria, valor FROM `categoria` ORDER BY valor ASC";
$resultado = mysql_query ($query, $dbConn);
while ( $row = mysql_fetch_assoc ($resultado)) {
	array_push( $arrCategorias,$row );
}

// si tenemos una categoria puntual
if ( !empty($_GET['id']) ) {
	// traemos una categoria
	$query = "SELECT id_categoria, valor FROM `categoria` WHERE id_categoria = {$_GET['id']}";
	$resultado = mysql_query ($query, $dbConn);
	$row = mysql_fetch_assoc ($resultado);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Mini Blog de prueba</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>


<div id="main">
	<h2>Categorias</h2>
	
	
	<div>
		<h3>Listado de Categorias</h3>
		<table style="width:90%;padding:5px;border:1px solid #cccccc">
			<tr>
				<th style="background-color:#cccccc;padding:5px;">id</th>
				<th style="width:90%;background-color:#cccccc;padding:5px;">categor&iacute;a</th>
				<th style="background-color:#cccccc;padding:5px;width:10%"></th>
			</tr>
			<? foreach ($arrCategorias as $categoria) { ?>
			<tr>
				<td style="padding:5px;"><? echo $categoria['id_categoria']; ?></td>
				<td style="padding:5px;"><? echo $categoria['valor']; ?></td>
				<td style="padding:5px;"><a href="categorias.php?id=<? echo $categoria['id_categoria']; ?>">Editar</a> - <a href="categorias.php?del=<?= $categoria['id_categoria'] ?>">Borrar</a>
			</tr>
			<? } ?>
		</table>
	</div>
	
	<? if ( empty($_GET['id']) ) { ?>
		<div>
			<h3 id="add">Agregar nueva categoria</h3>
			<? if (!empty($error)) { ?>
			
			<form action="categorias.php" method="post">
			
				<p>
					<label for="nombre">Nombre de la categoria</label><br />
					<input name="nombre" type="text" value="" />
				</p>
				<p>
					<input name="submit" type="submit" value="Agregar" />
				</p>
			</form>
		</div>
	<? } ?>
	
	<? if ( !empty($_GET['id']) ) { ?>
		<div style="background-color:#ff8800;padding:5px; margin-top:10px;">
			<h3 id="add">Editar categoria</h3>
			<? if (!empty($error)) { ?>
				
			<? } ?>
			<form action="categorias.php" method="post">
				<p>
					<label for="nombre">Nombre de la categoria</label><br />
					<input name="nombre" type="text"  />
				</p>
				<p>
					<input name="idCategoria" type="hidden" value="<? echo $row['idCategoria']; ?>" />
					<input name="submitEdit" type="submit" value="Editar" />
				</p>
			</form>
		</div>
	<? } ?>
	            <div id="footer">
  
        <!-- footer ends -->
</div>
	
</body>
</html>
