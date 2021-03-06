<?php

/*
INAI / USUARIOS
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Webservices extends CI_Controller
{
    var $pnt_url;
     // Constructor que manda llamar la funcion is_logged_in
    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
        $this->pnt_url = "http://devcarga.inai.org.mx:8080/sipot-web/spring/";
    }

    // Funcion para revisar inicio de session 
    function is_logged_in() 
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            redirect('tpoadminv1/cms');
        }
    }
    
    // Funcion para cerrar session
    function logout() 
    {
        $this->session->sess_destroy();
        $this->session->sess_create();
        redirect('/');
    }
    
    
    function permiso_administrador()
    {
        //Revisamos que el usuario sea administrador
        if($this->session->userdata('usuario_rol') != '1')
        {
            redirect('tpoadminv1/securecms/sin_permiso');
        }
    }

    /**
     * Redirect with POST data.
     *
     * @param string $url URL.
     * @param array $post_data POST data. Example: array('foo' => 'var', 'id' => 123)
     * @param array $headers Optional. Extra headers to send.
     */
    private function redirect_post($url, array $data, array $headers = null) {
        $params = array(
            'http' => array(
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        if (!is_null($headers)) {
            $params['http']['header'] = '';
            foreach ($headers as $k => $v) {
                $params['http']['header'] .= "$k: $v\n";
            }
        }
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if ($fp) {
            echo @stream_get_contents($fp);
            die();
        } else {
            // Error
            throw new Exception("Error loading '$url', $php_errormsg");
        }
    }


    function entrar_pnt(){
        $URL = $this->pnt_url . "generaToken/";
        $data = array(
            "usuario" => $_POST["user"], 
            "password" => $_POST["password"] 
        );

        $options = array(
            'http' => array(
            'method'  => 'POST',
            'content' => json_encode( $data ),
            'header'=>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n"
            )
        );

        $response = json_encode($data);
        $context  = stream_context_create( $options );
        $result = file_get_contents( $URL, false, $context );
        $result = json_decode($result, true);

        
        if( $result["success"] ){
            $_SESSION["user_pnt"] = $data["usuario"];
            $_SESSION["pnt"] = $result;

            $stm  = "SELECT id_sujeto_obligado, nombre_sujeto_obligado, rol, nombre_unidad_administrativa 
                FROM unidades_so WHERE correo_unidad_administrativa = '" . $data["usuario"] . "'";
            $query = $this->db->query($stm);

            $_SESSION["sujeto_obligado"] = $query->row()->nombre_sujeto_obligado;
            $_SESSION["unidad_administrativa"] = $query->row()->nombre_unidad_administrativa;
            $_SESSION["id_sujeto_obligado"] = $query->row()->id_sujeto_obligado;
            $_SESSION["rol"] = $query->row()->rol;
        
         }

        $response = json_encode($result);

        header('Content-Type: application/json');
        echo  $response; 

    }

    function write_login(){
        $myfile = fopen($_SERVER["DOCUMENT_ROOT"] . "/publicidad-abierta/tpov1/data/archivo_conexion.txt", "w") or die("Unable to open file!");
        $txt = "conexión: " . $this->input->get('status_conn') . ", mensaje: " . $this->input->get('messagge') ;

        fwrite($myfile, $txt);
        echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . "/publicidad-abierta/tpov1/data/archivo_conexion.txt" );

        
        fclose($myfile); 

    }

    function salir_pnt(){
        $URL = $this->pnt_url . "generaToken/";
        $data = array('usuario' => '', 'password' => '' );

        $options = array(
            'http' => array(
            'method'  => 'POST',
            'content' => json_encode( $data ),
            'header'=>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n"
            )
        );
 
        $context  = stream_context_create( $options );
        $result = file_get_contents( $URL, false, $context );
        $result = json_decode($result, true);

        // Set session variables
        unset( $_SESSION["user_pnt"]);
        unset( $_SESSION["pnt"]);
        unset( $_SESSION["unidad_administrativa"]);
        unset( $_SESSION["sujeto_obligado"]);

        header('Content-Type: application/json');
        echo json_encode($result);

    }

    function ejercicios(){ 
        $query = $this->db->query("SELECT ejercicio FROM cat_ejercicios WHERE active = 1");
        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }
    
    function modificar_sujeto(){
        $_SESSION["unidad_administrativa"] = $_POST["unidad_administrativa"];
        $_SESSION["sujeto_obligado"] = $_POST["sujeto_obligado"];
        $query = false;
        
        $this->db->select('nombre_sujeto_obligado');
        $this->db->from('unidades_so');
        $this->db->where('correo_unidad_administrativa', $_SESSION["user_pnt"] );
        $q1 = $this->db->get();



        if ( $q1->num_rows() > 0 ){
            $stm  = "UPDATE unidades_so SET nombre_sujeto_obligado = '" . $_POST["sujeto_obligado"] . "', " .
                    "nombre_unidad_administrativa  = '" . $_POST["unidad_administrativa"] . "' " . 
                    "WHERE correo_unidad_administrativa = '" . $_SESSION["user_pnt"] . "'";
            
            $query = $this->db->query($stm);

        }else{
            $post_data = array(); 
            $post_data['nombre_sujeto_obligado'] =  $_POST["sujeto_obligado"];
            $post_data['nombre_unidad_administrativa'] =  $_POST["unidad_administrativa"];
            $post_data['correo_unidad_administrativa'] =  $_SESSION["user_pnt"];

            $this->db->insert('unidades_so', $post_data);
            $query =  $this->db->insert_id();
        }

        header('Content-Type: application/json');
        echo json_encode($query);
    }

    function date_format($dstring){
        if ( $dstring == "" ) return $dstring;

        try {
          $dstring = explode("-", (string)$dstring );  
          $dstring = array_reverse( $dstring );  
          $dstring = implode("/",  $dstring );  
          return $dstring;
        } catch (Exception $e) {  return $dstring; }
    } 

    function eliminar_pnt(){
        $URL = $this->pnt_url . "mantenimiento/elimina";
        $data = array( 
            "idFormato" => $_POST["idFormato"],
            "correoUnidadAdministrativa" => $_POST["correoUnidadAdministrativa"],  
            "token" => $_POST["token"],  
            "registros" => $_POST["registros"]
        );
        
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                            "Accept: application/json\r\n"
            )
        );

        $context  = stream_context_create( $options );
        $res = file_get_contents( $URL, false, $context );
        $result =    json_decode( $res, true );

        switch ($_POST["idFormato"]) {
            case 43322:
                $table = "rel_pnt_presupuesto";
                break;
            case 43320:
                $table = "rel_pnt_factura";
                break;
            case 43360:
                $table = "rel_pnt_campana_aviso2";
                break;
             case 43321:
                $table = "rel_pnt_campana_aviso";
                break;
        }



        if( $result["success"] ){
            $stm  = "DELETE FROM " . $table . " WHERE id_pnt = '" . $_POST["id_pnt"] . "'";
            $this->db->query($stm);                                                                                                                              
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        
    }

/*


    function eliminar_pnt(){
        $URL = $this->pnt_url . "mantenimiento/elimina";
        $data = array( æ
            "idFormato" => $_POST["idFormato"],
            "correoUnidadAdministrativa" => $_POST["correoUnidadAdministrativa"],  
            "token" => $_POST["token"],  
            "registros" => $_POST["registros"]
        );
        
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                            "Accept: application/json\r\n"
            )
        );

        $context  = stream_context_create( $options );
        $res = file_get_contents( $URL, false, $context );
        $result = json_decode( $res, true );

         switch ($_POST["idFormato"]) {
            case 43322:
                $table = "rel_pnt_presupuesto";
                break;
            case 43320:
                $table = "rel_pnt_factura";
                break;
            case 43360:
                $table = "rel_pnt_campana_aviso2";
                break;
             case 43321:
                $table = "rel_pnt_campana_aviso";
                break;
        }



        if( $result["success"] ){
            $stm  = "DELETE FROM " . $table . " WHERE id_pnt = '" . $_POST["id_pnt"] . "'";
            $this->db->query($stm);                                                                                                                              
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        
    }

    /**/

    function agregar_pnt($table, $id){
        $URL = $this->pnt_url . "mantenimiento/agrega";
        $data = array(
            'idFormato' => $_POST["idFormato"], 
            'token' => $_POST["token"], 
            'correoUnidadAdministrativa' => $_POST["correoUnidadAdministrativa"], 
            'unidadAdministrativa' => $_POST["unidadAdministrativa"], 
            'SujetoObligado' => $_POST["SujetoObligado"], 
            'registros' => $_POST["registros"]
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                            "Accept: application/json\r\n"
            )
        );

        $context  = stream_context_create( $options );
        $res = file_get_contents( $URL, false, $context );

        $result = json_decode( $res, true );

        $post_data = array();
        $post_data[$id] = $_POST["_id_interno"];
        $post_data['id_pnt'] = $result['mensaje']['registros'][0]['idRegistro'];
        $post_data['estatus_pnt'] ='SUBIDO';
        
        if( $result["success"] ){
            $this->db->insert($table, $post_data);
            $result['id_tpo'] = $this->db->insert_id();
        }

        $response = json_encode($result);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function traer_formatos(){
        $URL = $this->pnt_url . "informacionFormato/obtenerFormatos";
        $request = array( "token" => strval($_SESSION['pnt']->token->token) );

        // Al parecer no necesita "concentradora" ni "codigoSO" 
        //$request = array("token" => strval($_SESSION['pnt']->token->token), "concentradora" => 2, "codigoSO" => "INAI" );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($request),
                'header'=>  "Content-Type: application/json\r\n" . "Accept: application/json\r\n"
            )
        );
        
        $context  = stream_context_create($options);
        $result = file_get_contents($URL, false, $context);

        //session_start();

        $data["formatos"] = json_decode($result);

        header('Content-Type: application/json');
        echo json_encode( $data["formatos"] ); 

        //$this->load->view('/tpoadminv1/logo/ver_formatos', $data);

    }
    function traer_campos(){
        $URL = $this->pnt_url . "informacionFormato/camposFormato";

        $idFormato = ( isset($_GET["idFormato"]) )? $_GET["idFormato"] : 22532; 

        $request = array("token" => strval($_SESSION['pnt']->token->token), "idFormato" => $idFormato );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($request),
                'header'=>  "Content-Type: application/json\r\n" . "Accept: application/json\r\n"
            )
        );
        
        $context  = stream_context_create($options);
        $result = file_get_contents($URL, false, $context);

        //session_start();

        $data["formatos"] = json_decode($result);

        header('Content-Type: application/json');
        echo json_encode( $data["formatos"] ); 
    }

    function traer_campo(){
        $URL = $this->pnt_url . "informacionFormato/campoCatalogo";

        $idCampo = ( isset($_GET["idCampo"]) )? $_GET["idCampo"] : 10658; 

        $request = array("token" => strval($_SESSION['pnt']->token->token), "idCampo" => $idCampo );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($request),
                'header'=>  "Content-Type: application/json\r\n" . "Accept: application/json\r\n"
            )
        );
        
        $context  = stream_context_create($options);
        $result = file_get_contents($URL, false, $context);


        $data["formatos"] = json_decode($result);

        header('Content-Type: application/json');
        echo json_encode( $data["formatos"] ); 
    }


}
