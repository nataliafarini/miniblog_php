<?

// iniciamos session
session_start ();

// archivos necesarios
require_once 'config.php';
require_once 'conexion.php';
require_once 'esUsuario.php';

// obtengo puntero de conexion con la db
$dbConn = conectar();





// borramos una noticia si obtenemos la variable GET del
if ( !empty($_GET['del']) ) {
	
	$query  = "DELETE FROM `noticias` WHERE idNoticia = {$_GET['del']}";
	$result = mysql_query($query, $dbConn);
		
	header( 'Location: noticias.php?dele=true' );
	die;
	
}

// agregamos una noticia en la db
// si se envio el formulario
if ( !empty($_POST['submit']) ) {
	
	// definimos las variables
	if ( !empty($_POST['titulo']) ) 		$titulo 		= $_POST['titulo'];
	if ( !empty($_POST['cuerpo']) ) 		$cuerpo 		= $_POST['cuerpo'];
	if ( !empty($_POST['id_categoria']) ) 	$id_categoria 	= $_POST['id_categoria'];
	if ( !empty($_POST['fpublicacion']) ) 	$fpublicacion 	= $_POST['fpublicacion'];	
	
	// completamos la variable error si es necesario
	if ( empty($titulo) ) 	$error['titulo'] 		= 'Es obligatorio completar el t&iacute;tulo de la noticia';
	if ( empty($cuerpo) ) 	$error['cuerpo'] 		= 'Es obligatorio completar el cuerpo de la noticia';
	if ( empty($id_categoria) ) 	$error['id_categoria'] 	= 'Es obligatorio seleccionar una categor&iacute;a para la noticia';
	
	// si no hay errores registramos al usuario
	if ( empty($error) ) {
		
		// inserto los datos de registro en la db
		$fCreacion = date("Y-m-d H:i:s");
		$fModificacion = date("Y-m-d H:i:s");
		if ( empty($fpublicacion) ) $fpublicacion = date("Y-m-d H:i:s");
		$id_usuario = $arrUsuario['id_usuario'];
		$query  = "INSERT INTO `noticias` (titulo,cuerpo,id_categoria,id_usuario,fcreacion,fmodificacion,fpublicacion) VALUES ('$titulo',$cuerpo','$id_categoria','$id_usuario','$fcreacion','$fmodificacion','$fpublicacion')";
		$result = mysql_query($query, $dbConn);
		header( 'Location: noticias.php?add=true' );
		die;
		
	}
		
}

// si se envio el formulario de edicion
if ( !empty($_POST['submitEdit']) ) {
	
	// definimos las variables
	if ( !empty($_POST['id_noticia']) ) 		$id_noticia 		= $_POST['id_noticia'];
	if ( !empty($_POST['titulo']) ) 		$titulo 		= $_POST['titulo'];
	if ( !empty($_POST['cuerpo']) ) 		$cuerpo 		= $_POST['cuerpo'];
	if ( !empty($_POST['id_categoria']) ) 	$id_categoria 	= $_POST['id_categoria'];
	if ( !empty($_POST['fpublicacion']) ) 	$fpublicacion 	= $_POST['fpublicacion'];	
	
	// completamos la variable error si es necesario
	if ( empty($id_noticia) ) 	$error['id_noticia'] 		= 'Es obligatorio tener la id de la noticia que se desea modificar';
	if ( empty($titulo) ) 		$error['titulo'] 			= 'Es obligatorio completar el t&iacute;tulo de la noticia'
	if ( empty($copete) ) 		$error['copete'] 			= 'Es obligatorio completar el copete de la noticia';
	if ( empty($cuerpo) ) 		$error['cuerpo'] 			= 'Es obligatorio completar el cuerpo de la noticia';
	if ( empty($idCategoria) ) 	$error['id_categoria'] 		= 'Es obligatorio seleccionar una categor&iacute;a para la noticia';
	
	// si no hay errores editamos la noticia
	if ( empty($error) ) {
		
		
		// actualizamos la fecha de modificacion y de publicacion
		$fmodificacion = date("Y-m-d H:i:s");
		if ( empty($fpublicacion) ) $fpublicacion = date("Y-m-d H:i:s");
		$idusuario = $arrUsuario['id_usuario'];
		
		// inserto los datos de registro en la db
		$query  = "UPDATE `noticias` set titulo = '$titulo', cuerpo = '$cuerpo', id_categoria = $id_categoria, id_usuario = $id_usuario, fmodificacion = '$fmodificacion', fpublicacion = '$fpublicacion' WHERE id_noticia = $id_noticia";
		$result = mysql_query($query, $dbConn);
		
		header( 'Location: noticias.php?edit=true' );
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

// traemos listado de noticias
$arrNoticias = array();
$query = "SELECT id_noticia, titulo FROM `noticias` ORDER BY id_noticia DESC";
$resultado = mysql_query ($query, $dbConn);
while ( $row = mysql_fetch_assoc ($resultado)) {
	array_push( $arrNoticias,$row );
}
	
// si tenemos una categoria puntual
if ( !empty($_GET['id']) ) {
	
	// traemos una categoria
	$query = "SELECT id_noticia, titulo, cuerpo, id_categoria, fpublicacion FROM `noticias` WHERE id_noticia = {$_GET['id']}";
	$resultado = mysql_query ($query, $dbConn);
	$row = mysql_fetch_assoc ($resultado);
} 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>MiniBlog</title>
</head>

<body>

	<h1>Miniblog</h1>
	
	<h2>Noticias</h2>
	
	
	<div>
		<h3>Listado de Noticias</h3>
		<table style="width:90%;padding:5px;border:1px solid #cccccc">
			<tr>
				<th style="background-color:#cccccc;padding:5px;">id</th>
				<th style="width:90%;background-color:#cccccc;padding:5px;">titulo</th>
				<th style="background-color:#cccccc;padding:5px;width:10%"></th>
			</tr>
			<? //foreach ($arrNoticias as $noticias) { 

				?>
			<tr>
				<td style="padding:5px;"><? echo $noticias['id_noticia']; ?></td>
				<td style="padding:5px;"><? echo $noticias['titulo']; ?></td>
				<td style="padding:5px;"><a href="noticias.php?id=<? echo $noticias['id_noticia']; ?>">Editar</a> - <a href="noticias.php?del=<?= $noticias['id_noticia'] ?>">Borrar</a>
			</tr>
			<? } ?>
		</table>
	</div>
	
	<? if ( empty($_GET['id']) ) { ?>
		<div>
			<h3 id="add">Agregar nueva noticia</h3>
		
			<form action="noticias.php" method="post">
			
				<p>
					<label for="titulo">Titulo de la noticia</label><br />
					<input name="titulo" type="text" value="" />
				</p>
				<p>
					<label for="id_categoria">Categoria</label><br />
					<select name="id_categoria">
						<option value="">Seleccione una categoria</option>
						<option value="">------------------------</option>
						<? foreach ( $arrCategorias as $categoria ) { ?>
						<option value="<? echo $categoria['id_categoria']; ?>"><? echo $categoria['valor']; ?></option>
						<? } ?>
					</select>
				</p>
				<p>
					<label for="fpublicacion">Fecha de publicacion </label><br />
					<input name="fpublicacion" type="text" value="" />
				</p>
				
				<p>
					<label for="cuerpo">Cuerpo</label><br />
					<textarea rows="10" cols="50" name="cuerpo"></textarea>
				</p>
				<p>
					<input name="submit" type="submit" value="Agregar" />
				</p>
			</form>
		</div>
	<? } ?>
	
	<? if ( !empty($_GET['id']) ) { ?>
		<div style="background-color:#ff8800;padding:5px; margin-top:10px;">
			<h3 id="add">Editar noticia</h3>
			<? if (!empty($error)) { ?>
		
			<form action="noticias.php" method="post">
				<p>
					<label for="titulo">Titulo de la noticia</label><br />
					<input name="titulo" type="text" />
				</p>
				<p>
					<label for="idCategoria">Categoria</label><br />
					<select name="idCategoria">
						<option value="">Seleccione una categoria</option>
						<option value="">------------------------</option>
						<? foreach ( $arrCategorias as $categoria ) { ?>
						<option value="<? echo $categoria['id_categoria']; ?>" <? if ( $categoria['id_categoria'] == $row['id_categoria'] ) echo 'selected="selected"' ?>><? echo $categoria['valor']; ?></option>
						<? } ?>
					</select>
				</p>
				<p>
					<label for="fpublicacion">Fecha de publicacion </label><br />
					<input name="fpublicacion" type="text" 
			
				<p>
					<label for="cuerpo">Cuerpo</label><br />
					<textarea rows="10" cols="50" name="cuerpo"></textarea>
				</p>
				<p>
					<input name="id_noticia" type="hidden" value="<? echo $row['id_noticia']; ?>" />
					<input name="submitEdit" type="submit" value="Editar" />
				</p>
				
				
			</form>
		</div>
	<? } ?>
	
</body>
</html>
