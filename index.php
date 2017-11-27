<?


session_start ();

require_once 'admin/config.php';
require_once 'admin/conexion.php';


$dbConn = conectar();
	
}

// listado de noticias
// traemos listado de noticias
$arrNoticias = array();
$query = "SELECT id_noticias, titulo FROM `noticias` WHERE fpublicacion < '".date('Y-m-d H:i:s')."' ORDER BY fpublicacion DESC";
$resultado = mysql_query ($query, $dbConn);
while ( $row = mysql_fetch_row ($resultado)) {
	array_push( $arrNoticias,$row );
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

<div id="header">
	<div id="buttons">
      <a href="index.php" class="but"  title="">Home</a><div class="razd_b"></div>
      <a href="vernoticia.php" class="but" title="">Entradas</a><div class="razd_b"></div>
      <a href="admin/index.php"  class="but" title="">Panel de control</a><div class="razd_b"></div>
      
      <a href="contacto.html" class="but" title="">Contacto</a>
    </div>
	<div id="logo">
    
    	<div class="logo_l">
    	
      	
      	</div>
      <div class="logo_r">
       
		
         
      </div>    
    </div>  
 </div>
<!-- header ends -->
        <!-- content begins -->
       			<div id="content">
                    <div id="right">
                      <h1>Noticias</h1>
                         <div class="text">
                           <class="img" width="122"  height="92" alt="" /><span><h2>Aqui encontraras las noticias que te interesan</h2></span><br />
                            <br /><br />
					
                          <div class="read"><a href="vernoticia.php"><img src="images/read_more.png" alt=""/></a></div>
                        </div>
						
						
                
                    </div>
                    <div id="left">
                   	   		<h1>Categorias</h1>
             				<div class="list">
                            	 <div class="opt"><div class="opt_a">
                                    <a  href="admin/categorias.php">Administrar Categoria</a>
                                 </div></div>
                                 <div class="opt"><div class="opt_a">
                                 	<a href="admin/noticias.php">Administrar Noticias</a>
                                 </div>
                              	</div>
                                 <div class="opt"><div class="opt_a">
                                    <a  href="admin/comentarios.php">Administrar comentarios</a>
                                 </div>
                                 </div>
                            
                            </div>
                           
                  		
							<div style="height:7px"></div>
                         
                     </div>
          			<div style="clear: both"></div>
        		</div>
    <!-- content ends --> 
<!-- footer begins -->
            <div id="footer">
  
        <!-- footer ends -->
</div>


</body>
</html>