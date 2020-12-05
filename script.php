<?php
session_start();

if(isset($_POST["action"]))
{
  if($_POST["action"] == "fetch")
  {
    $_SESSION['ruta'] = getcwd().'/'.'carpetas';
    chdir($_SESSION['ruta']);
    $folder = glob('*');

   /* $output = '<div class=content-box-testshadow>'.$_SESSION['ruta'].'</div>';*/
    if(count($folder) > 0)
    {
      foreach($folder as $name)
      {
        if (is_dir($name))
        {
          $output .= "<div class = grid-item>
                <img src = 'icono_carpeta.png' style ='width:80px;height:80;'/>
                <h6>".$name."</h6> 
                </div>";
        }
    else
    {
      $output .= "<div class = grid-item>
                <img src = 'icono_archivo.png' style ='width:80px;height:80;'/>
                <h6>".$name."</h6> 
                </div>";
    }
     
   }
  }
 
  echo $output;
 }

 if($_POST["action"] == "fetch_files")
 {  
  if(strpos($_POST["folder_name"],'.') != false){
    echo "no";
  }
  else{
  $_SESSION['ruta'] = trim($_SESSION['ruta']);
  $_SESSION['ruta'] .='/'.trim($_POST["folder_name"]);
  $_SESSION['ruta'] = rtrim($_SESSION['ruta'],'/');

  chdir($_SESSION['ruta']);
  
  $folder = glob('*');
  
  /* $output = '<div class=content-box-testshadow>'.$_SESSION['ruta'].'</div>';*/
  if(count($folder) > 0)
  {
   foreach($folder as $name)
   {
      if (is_dir($name)) {
      $output .= "<div class = grid-item>
                <img src = 'icono_carpeta.png' style ='width:80px;height:80;'/>
                <h6>".$name."</h6> 
                </div>";
    }
    else{
      $output .= "<div class = grid-item>
                <img src = 'icono_archivo.png' style ='width:80px;height:80;'/>
                <h6>".$name."</h6> 
                </div>";
    }
   }
  }
  echo $output;
 }}

 if($_POST["action"] == "back")
 {  
    chdir($_SESSION['ruta']);
    if(getcwd() == "/var/www/html/proyecto/carpetas"){
      $_SESSION['ruta'] = getcwd();
      echo "ya estas en la carpeta de inicio";
    }
    else{
      chdir('..');
    $_SESSION['ruta'] = getcwd();
    }

 }

 if ($_POST["action"] == "consultar_permisos") {
   chdir($_SESSION['ruta']);
   clearstatcache();
   $permisos = fileperms(trim($_POST['consulta']));
   $info='';
   // Propietario
$info .= (($permisos & 0x0100) ? 'r' : '-');
$info .= (($permisos & 0x0080) ? 'w' : '-');
$info .= (($permisos & 0x0040) ?
            (($permisos & 0x0800) ? 's' : 'x' ) :
            (($permisos & 0x0800) ? 'S' : '-'));

// Grupo
$info .= (($permisos & 0x0020) ? 'r' : '-');
$info .= (($permisos & 0x0010) ? 'w' : '-');
$info .= (($permisos & 0x0008) ?
            (($permisos & 0x0400) ? 's' : 'x' ) :
            (($permisos & 0x0400) ? 'S' : '-'));

// Mundo
$info .= (($permisos & 0x0004) ? 'r' : '-');
$info .= (($permisos & 0x0002) ? 'w' : '-');
$info .= (($permisos & 0x0001) ?
            (($permisos & 0x0200) ? 't' : 'x' ) :
            (($permisos & 0x0200) ? 'T' : '-'));
   echo $info;
 }
 
 if($_POST["action"] == "create")
 {
  chdir($_SESSION['ruta']);
  $new_name = trim($_POST["new_name"]);
  if(!file_exists($new_name)) 
  {
   mkdir($new_name);
   echo 'Carpeta '.$new_name.' creada';
  }
  else
  {
   echo 'Carpeta ya existe';
  }
 }


 if($_POST["action"] == "create_file")
 {
  chdir($_SESSION['ruta']);
  $new_name = trim($_POST["new_name"]);
  if(!file_exists($new_name)) 
  {
   //mkdir($new_name);
    shell_exec('touch '.$new_name);
   echo 'archivo '.$new_name.' creado';
  }
  else
  {
   echo 'Archivo ya existe';
  }
 }

if ($_POST["action"] == "editar_permisos") {
  chdir($_SESSION['ruta']);
  $name = trim($_POST['name']);
  $permisos = trim($_POST['permisos']);
  if (is_dir($name)) {
    shell_exec('chmod -R '.$permisos.' '.$name);
    echo 'permisos cambiados a '.$name;
  }
  
  else{
  shell_exec('chmod '.$permisos.' '.$name);

}
  
}


 if($_POST["action"] == "change")
 {
  
   chdir($_SESSION['ruta']);
   $old_name = trim($_POST["old_name"]);
   shell_exec('mv '.$old_name.' '.$_POST["new_name"]);
   echo 'nombre cambiado a '.$_POST["new_name"];
  
 }

 if($_POST["action"] == "copiar"){
  chdir($_SESSION['ruta']);
  $_SESSION['ruta'] = trim($_SESSION['ruta']);
  $_POST['copy_name'] = trim($_POST['copy_name']);
  $_SESSION['copiar'] = $_SESSION['ruta'].'/'.$_POST['copy_name'];
  $_SESSION['bool_copiar'] = $_POST['bool'];
 }

 if ($_POST["action"] == "pegar") {
   chdir($_SESSION['ruta']);
   $_SESSION['copiar'] = trim($_SESSION['copiar']);
   $explode = explode('/',$_SESSION['copiar']);
   //$nombre[0] = nombre, $nombre[1] = extension, agregar punto
   if($_SESSION['bool_copiar'] == 'true')
   {
     if(strpos($explode[sizeof($explode)-1],'.') === false)
     {
        
        $nombre = $explode[sizeof($explode)-1];
        $nombre = trim($nombre);
        $cont = 1;
        $nuevo_nombre = $nombre;
        
        while (file_exists($nuevo_nombre)) {
          $nuevo_nombre = $nombre.$cont;
          $cont++;
        }
         $nuevo_nombre = trim($nuevo_nombre);
        $ruta_salida = getcwd().'/'.$nuevo_nombre;
        $_SESSION['copiar'] = trim($_SESSION['copiar']);
        $ruta_salida = trim($ruta_salida);

        shell_exec('cp -r '.$_SESSION['copiar'].'/ '.$ruta_salida);
        echo 'cp -r '.$_SESSION['copiar'].'/ '.$ruta_salida;
        

     }
     else
     {
       $nombre = explode('.',$explode[sizeof($explode)-1]);
       $cont = 1;
       $nuevo_nombre = $nombre[0];
       $nombre[1] = trim($nombre[1]);

       while (file_exists($nuevo_nombre.'.'.$nombre[1])) {
         $nuevo_nombre = $nombre[0].$cont;
         $cont++; 
       }
       $nuevo_nombre .= '.'.$nombre[1];
       $ruta_salida = getcwd().'/'.$nuevo_nombre;
       shell_exec('cp '.$_SESSION['copiar'].' '.$ruta_salida);
       echo 'archivo copiado';
    }
  }
  else
  {
    $file = trim($_SESSION['copiar']);
    shell_exec('mv '.$file.' '.getcwd());
    echo 'cortado';
  }
  
  
 }
 
 if($_POST["action"] == "delete")
 {
  chdir($_SESSION['ruta']);
  $file = trim($_POST["folder_name"]);

  if(is_dir($file)){
    shell_exec('rm -r '.$file.'/');
  }
  else{
    shell_exec('rm -r '.$file);
  }

  
 }
 

}
?>
