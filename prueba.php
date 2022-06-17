<html>
<head>
    <meta charset="utf-8">
    <title>Multiple uploads con php</title>
</head>
<body>
    <form action="http://localhost/multiUpload/upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <label>Archivo 1:</label><input type="file" name="userfile[]" /><br /><br />
        <label>Archivo 2:</label><input type="file" name="userfile[]" /><br /><br />
        <label>Archivo 3:</label><input type="file" name="userfile[]" /><br /><br />
        <label>Archivo 4:</label><input type="file" name="userfile[]" /><br /><br />
        <input type="submit" value="Subir imágenes" />
    </form>
</body>
</html>


<?php
//solo se puede acceder si es una peticion post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //llamamos a la clase multiupload
    require_once("multiupload.php");
    //array de campos file del formulario
    $files = $_FILES['userfile']['name'];
    //creamos una nueva instancia de la clase multiupload
    $upload = new Multiupload();
    //llamamos a la funcion upFiles y le pasamos el array de campos file del formulario
    $isUpload = $upload->upFiles($files);
    
}else{
    throw new Exception("Error Processing Request", 1);
} ?>

<?php
class Multiupload
{

    /**
    *sube archivos al servidor a través de un formulario
    *@access public
    *@param array $files estructura de array con todos los archivos a subir
    */
    public function upFiles($files = array())
    {
        //inicializamos un contador para recorrer los archivos
        $i = 0;

        //si no existe la carpeta files la creamos
        if(!is_dir("files/")) 
            mkdir("files/", 0777);
         
        //recorremos los input files del formulario
        foreach($files as $file) 
        {
            //si se está subiendo algún archivo en ese indice
            if($_FILES['userfile']['tmp_name'][$i])
            {
                //separamos los trozos del archivo, nombre extension
                $trozos[$i] = explode(".", $_FILES["userfile"]["name"][$i]);

                //obtenemos la extension
                $extension[$i] = end($trozos[$i]);

                //si la extensión es una de las permitidas
                if($this->checkExtension($extension[$i]) === TRUE)
                {

                    //comprobamos si el archivo existe o no, si existe renombramos 
                    //para evitar que sean eliminados
                    $_FILES['userfile']['name'][$i] = $this->checkExists($trozos[$i]);           

                    //comprobamos si el archivo ha subido
                    if(move_uploaded_file($_FILES['userfile']['tmp_name'][$i],"files/".$_FILES['userfile']['name'][$i]))
                    {
                        echo "subida correctamente";
                        //aqui podemos procesar info de la bd referente a este archivo
                    } 
                //si la extension no es una de las permitidas
                }else{
                    echo "la extension no esta permitida";
                }
            //si ese input file no ha sido cargado con un archivo
            }else{
                echo "sin imagen";
            }
            echo "<br />";
            //en cada pasada por el loop incrementamos i para acceder al siguiente archivo
            $i++;     
        }   
    }

    /**
    *funcion privada que devuelve true o false dependiendo de la extension
    *@access private
    *@param string 
    *@return boolean - si esta o no permitido el tipo de archivo
    */
    private function checkExtension($extension)
    {
        //aqui podemos añadir las extensiones que deseemos permitir
        $extensiones = array("jpg","png","gif","pdf");
        if(in_array(strtolower($extension), $extensiones))
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
    *funcion que comprueba si el archivo existe, si es asi, iteramos en un loop 
    *y conseguimos un nuevo nombre para el, finalmente lo retornamos
    *@access private
    *@param array 
    *@return array - archivo con el nuevo nombre
    */
    private function checkExists($file)
    {
        //asignamos de nuevo el nombre al archivo
        $archivo = $file[0] . '.' . end($file);
        $i = 0;
        //mientras el archivo exista entramos
        while(file_exists('files/'.$archivo))
        {
            $i++;
            $archivo = $file[0]."(".$i.")".".".end($file);       
        }
        //devolvemos el nuevo nombre de la imagen, si es que ha 
        //entrado alguna vez en el loop, en otro caso devolvemos el que
        //ya tenia
        return $archivo;
    }
}