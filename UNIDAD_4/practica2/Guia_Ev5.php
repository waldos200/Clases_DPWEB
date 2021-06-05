<HTML LANG="es">

<HEAD>
   <TITLE>Insercion de vivienda</TITLE>
   <LINK REL="stylesheet" TYPE="text/css" HREF="estilo.css">
</HEAD>

<BODY>
   <?PHP
   // Obtener valores introducidos en el formulario
   if (isset($_REQUEST['insertar'])) {
      $insertar = $_REQUEST['insertar'];
      $tipo = $_REQUEST['tipo'];
      $departamento = $_REQUEST['departamento'];
      $direccion = $_REQUEST['direccion'];
      $dormitorios = $_REQUEST['dormitorios'];
      $precio = $_REQUEST['precio'];
      $tamano = $_REQUEST['tamano'];
      $extras = $_REQUEST['extras'];
      $observaciones = $_REQUEST['observaciones'];
   }
   $error = false;
   $errores["tipo"] = "";
   $errores["departamento"] = "";
   $errores["direccion"] = "";
   $errores["dormitorios"] = "";
   $errores["precio"] = "";
   $errores["tamano"] = "";
   $errores["extras"] = "";
   $errores["imagen"] = "";
   $errores["observaciones"] = "";

   if (isset($_REQUEST['insertar'])) {
      // Comprobar que se han introducido todos los datos obligatorios
      // tipo           
      if (trim($tipo) == "") {
         $errores["tipo"] = "Debe seleccionar el tipo de vivienda";
         $error = true;
      } else
         $errores["tipo"] = "";
      // departamento
      if (trim($departamento) == "") {
         $errores["departamento"] = "Debe seleccionar el departamento";
         $error = true;
      } else
         $errores["departamento"] = "";
      // direccion
      if (trim($direccion) == "") {
         $errores["direccion"] = "Se requiere la direccion de la vivienda";
         $error = true;
      } else
         $errores["direccion"] = "";
      // dormitorios
      if (trim($dormitorios) == "") {
         $errores["dormitorios"] = "Debe seleccionar un numero de dormitorios";
         $error = true;
      } else
         $errores["dormitorios"] = "";

      // precio
      if (trim($precio) == "") {
         $errores["precio"] = "Se requiere un precio para la vivienda";
         $error = true;
      } else
         $errores["precio"] = "El precio debe ser un valor numerico";
      // tamano
      if (trim($tamano) == "") {
         $errores["tamano"] = "Se requiere un tamaño para la vivienda";
         $error = true;
      } else
         $errores["tamano"] = "El tamaño debe ser un valor numerico";

      // Subir fichero
      $copiarFichero = false;
      if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
         $nombreDirectorio = "fotos/";
         $nombreFichero = $_FILES['imagen']['name'];
         $copiarFichero = true;
         // Si ya existe un fichero con el mismo nombre, renombrarlo
         $nombreCompleto = $nombreDirectorio . $nombreFichero;
         if (is_file($nombreCompleto)) {
            $idUnico = time();
            $nombreFichero = $idUnico . "-" . $nombreFichero;
         }
      }
      // El fichero introducido supera el límite de tamaño permitido
      else if ($_FILES['imagen']['error'] == UPLOAD_ERR_FORM_SIZE) {
         $maxsize = $_REQUEST['MAX_FILE_SIZE'];
         $errores["imagen"] = "¡El tamaño del fichero supera el l&iacutemite permitido ($maxsize bytes)!";
         $error = true;
      }
      // No se ha introducido ningún fichero
      else if ($_FILES['imagen']['name'] == "")
         $nombreFichero = '';
      // El fichero introducido no se ha podido subir
      else {
         $errores["imagen"] = "No se ha podido subir el fichero!";
         $error = true;
      }
   }
   
   //CADENA DE CONEXION
   if (isset($_REQUEST['insertar']) && $error == false) {
      // Insertar la vivienda en la Base de Datos
      $conexion = mysqli_connect("localhost", "root", "") or die("No se puede conectar con el servidor");
      mysqli_select_db($conexion, "practica2") or die("No se puede seleccionar la base de datos");

      $instruccion = "INSERT INTO vivienda (tipo, departamento, direccion, dormitorios, precio, tamano, extras, foto, observaciones) 
            VALUES ('$tipo', '$departamento', '$direccion', '$dormitorios', $precio, $tamano, '$extras', '$nombreFichero', '$observaciones');";
      
      //consulta
      $consulta = mysqli_query($conexion, $instruccion) or die("Fallo en la consulta de vivienda");
      
      //cerrar conexion
      mysqli_close($conexion);
      
      // Mover fichero de imagen a su ubicación definitiva
      if ($copiarFichero)
         move_uploaded_file($_FILES['imagen']['tmp_name'], $nombreDirectorio . $nombreFichero);
      
      // Mostrar datos introducidos
      print("<H1>Inserci&oacute;n de vivienda</H1>\n");
      print("<H2>Estos son los datos introducidos:</H2>\n");
      print("<UL>");
      print("<LI>Tipo: " . $tipo);
      print("<LI>Departamento: " . $departamento);
      print("<LI>Direccion: " . $direccion);
      print("<LI>Numero de dormitorios: " . $dormitorios);
      print("<LI>Precio: " . $precio);
      print("<LI>Tamaño: " . $tamano);
      print("<LI>Extras: " . $extras);

      if ($nombreFichero != "")
         print("<LI>Foto: <A TARGET='_blank' HREF='" . $nombreDirectorio . $nombreFichero . "'>" . $nombreFichero . "</A>");
      else
         print("<LI>Foto: (no hay)");
      print("<LI>Observaciones: \n" . $observaciones);
      print("</UL>");
      print("<BR>");
      print("[<A HREF='Guia_Ev5.php'>Insertar otra vivienda</A>]");
   } else {
   ?>
      <!-- ENCABEZADO -->
      <H1>Inserci&oacuten de vivienda</H1>
      <H3>Introduzca los datos de la vivienda:</H1>
         <FORM CLASS="borde" ACTION="Guia_Ev5.php" NAME="insertar" METHOD="POST" ENCTYPE="multipart/form-data">
            <!-- CAPTURA DE CAMPOS -->

            <!-- Tipo de vivienda-->
            <P><LABEL>Tipo de vivienda</LABEL>
               <SELECT NAME="tipo">
                  <OPTION SELECTED>Seleccione
                  <OPTION>Casa
                  <OPTION>Apartamento
                  <OPTION>Rancho de playa
                  <OPTION>Terreno
               </SELECT>
            </P>

            <!-- Departamento-->
            <P><LABEL>Departamento</LABEL>
               <SELECT NAME="departamento">
                  <OPTION SELECTED>Seleccione
                  <OPTION>Ahuachapan
                  <OPTION>Cabañas
                  <OPTION>Chalatenango
                  <OPTION>Cuscatlan
                  <OPTION>Morazan
                  <OPTION>La Libertad
                  <OPTION>La Paz
                  <OPTION>La Union
                  <OPTION>San Miguel
                  <OPTION>San Salvador
                  <OPTION>San Vicente
                  <OPTION>Santa Ana
                  <OPTION>Sonsonate
                  <OPTION>Usulutan
               </SELECT>
            </P>

            <!-- Direccion -->
            <P><LABEL>Direccion:</LABEL>
               <TEXTAREA COLS="53" ROWS="2" NAME="direccion">
            <?PHP
            if (isset($insertar))
               print("$direccion");
            print("</TEXTAREA>");
            if ($errores["direccion"] != "")
               print("<BR><SPAN CLASS='error'>" . $errores["direccion"] . "</SPAN>");
            ?>
         </P>

         <!-- Dormitorios -->
         <P> <LABEL>Número de dormitorios</LABEL>
            <INPUT TYPE="radio" NAME="dormitorios" VALUE="1">1
            <INPUT TYPE="radio" NAME="dormitorios" VALUE="2">2
            <INPUT TYPE="radio" NAME="dormitorios" VALUE="3">3
            <INPUT TYPE="radio" NAME="dormitorios" VALUE="4">4
            <INPUT TYPE="radio" NAME="dormitorios" VALUE="5">5
         </P>

         <!-- Precio -->
         <P><LABEL>Precio </LABEL>
            <INPUT TYPE="number" NAME="precio" SIZE="25" MAXLENGTH="50"> $
            <?PHP
            if (isset($_REQUEST['insertar']))
               print("VALUE='$precio'>\n");
            else
               print("\n");
            if ($errores["precio"] != "")
               print("<BR><SPAN CLASS='error'>" . $errores["precio"] . "</SPAN>");
            ?>
         </P>

         <!-- Tamaño -->
         <P><LABEL>Tamaño</LABEL> 
            <INPUT TYPE="number" NAME="tamano" SIZE="25" MAXLENGTH="50">  metros cuadrados
            <?PHP
            if (isset($_REQUEST['insertar']))
               print("VALUE='$tamano' ");
            else
               print("\n");
            if ($errores["tamano"] != "")
               print("<BR><SPAN CLASS='error'>" . $errores["tamano"] . "</SPAN>");
            ?>
         </P>

         <!-- Extras -->
         <P><LABEL>Extras (marque las que procedan):</LABEL>
            <INPUT TYPE="checkbox" NAME="extras" VALUE="1"> Piscina
            <INPUT TYPE="checkbox" NAME="extras" VALUE="2"> Jardin
            <INPUT TYPE="checkbox" NAME="extras" VALUE="3"> Garage
            <br />               
            <?PHP
            if (isset($_REQUEST['insertar']))
               print("VALUE='$extras'>\n");
            else
               print("\n");
            if ($errores["extras"] != "")
               print("<BR><SPAN CLASS='error'>" . $errores["extras"] . "</SPAN>");
            ?>
            <br />
         </P>

         <!-- Imagen asociada al tipo de vivienda -->
         <P><LABEL>Foto</LABEL>
            <INPUT TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="102400">
            <INPUT TYPE="FILE" SIZE="44" NAME="imagen">
            <?PHP
            if ($errores["imagen"] != "")
               print("<BR><SPAN CLASS='error'>" . $errores["imagen"] . "</SPAN>");
            ?>
         </P>
         <br />

         <!-- Observaciones -->
         <P><LABEL>Observaciones</LABEL>
            <TEXTAREA COLS="53" ROWS="5" NAME="observaciones">
            <?PHP
            if (isset($insertar))
               print("$observaciones");
            print("</TEXTAREA>");
            if ($errores["observaciones"] != "")
               print("<BR><SPAN CLASS='error'>" . $errores["observaciones"] . "</SPAN>");
            ?>
         </P>

         <!-- Botón de envío -->
         <P><INPUT TYPE="SUBMIT" NAME="insertar" VALUE="Insertar vivienda"></P>
         <?PHP
      }
         ?>
      </FORM>
   </BODY>
</HTML>