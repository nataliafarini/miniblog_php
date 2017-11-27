<?

// iniciamos session
session_start ();

// archivos necesarios
require_once 'admin/config.php';
require_once 'admin/conexion.php';


// obtengo puntero de conexion con la db
$dbConn = conectar();


		// inserto los datos de registro en la db
		$query  = "INSERT INTO `comentarios` (comentario, idUsuario, idNoticia) VALUES ('$comentario','$idUsuario','$idNoticia')";
		$result = mysql_query($query, $dbConn);
		
		header( 'Location: vernoticia.php?idNoticia='.$idNoticia );
		die;
		
	}
	
}

// traemos la noticia
$query = "SELECT noticias.id_noticia, noticias.titulo, noticias.cuerpo, categorias.valor as categoria FROM `noticias` 
INNER JOIN `categorias` ON categorias.id_categoria = noticias.id_categoria 

WHERE noticias.id_noticia = " . $_GET['id_noticia'] . " LIMIT 1";
$resultado = mysql_query ($query, $dbConn);
$noticia = mysql_fetch_assoc ($resultado);

// traemos los comentarios aprobados
$arrComentarios = array();
$query = "SELECT comentarios.id_comentario, comentarios.comentario 
FROM `comentarios` 
INNER JOIN `usuarios` ON comentarios.id_usuario = usuarios.id_usuario 
WHERE comentarios.estado = 'apto' AND comentarios.id_noticia = " . $_GET['id_noticia'] . " 
ORDER BY comentarios.id_comentario DESC";
$resultado = mysql_query ($query, $dbConn);
while ( $row = mysql_fetch_assoc ($resultado)) {
	array_push( $arrComentarios,$row );
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>MiniBlog</title>
</head>

<body>

	<h1>MiniBlog</h1>
	
	

	

	
	<h2>Comentarios</h2>
	<div>
		<? foreach ($arrComentarios as $comentario) { ?>
		<p>
			<b><? echo $comentario['usuario']; ?></b> <br />
			<i><? echo $comentario['comentario']; ?></i>
		</p>
		<? } ?>	
	</div>
	
	<div>
		<?php if ( !empty( $arrUsuario ) ) { ?>
		
			<form action="vernoticia.php?idNoticia=<?php echo $_GET['idNoticia']; ?>" method="post">
				<p>
					<label for="comentario">Dejar un comentario</label><br />
					<textarea rows="3" cols="50" name="comentario"></textarea>
				</p>
				<p>
					<input name="submit" type="submit" value="Enviar" />
				</p>
			</form>
		
		<?php } else { ?>
			
		<?php } ?>
	</div>
</body>
</html>
