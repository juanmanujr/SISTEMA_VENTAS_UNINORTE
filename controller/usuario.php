<?php

require_once("../config/conexion.php");
require_once("../model/Usuario.php");

$usuario = new Usuario();

switch ($_GET["op"]) {

    case "listar":
        $datos = $usuario->get_usuario();
        $data = Array();

        foreach($datos as $row){
            $sub_array = array();

            $sub_array[] = $row["usu_nom"];
            $sub_array[] = $row["usu_sesion"];
            $sub_array[] = $row["fech_crea"];
            $sub_array[] = $row["fech_modi"];
            $sub_array[] = '<button type="button" onClick="editar('.$row["usu_id"].');" id="'.$row["usu_id"].'" class="btn btn-outline-primary btn-icon"><div class="fa fa-edit"></div></button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["usu_id"].');" id="'.$row["usu_id"].'" class="btn btn-outline-danger btn-icon"><div class="fa fa-trash"></div></button>';

            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        echo json_encode($results);
    break;

    case "guardaryeditar":
        $usu_nom = trim($_POST["usu_nom"]);
        $usu_sesion = trim($_POST["usu_sesion"]);
        $usu_clave = trim($_POST["usu_clave"]);
        
        if(empty($_POST["usu_id"])){
            // Es nuevo registro
            if ($usuario->existe_sesion($usu_sesion)) {
                echo json_encode(["ok" => false, "msg" => "El nombre de sesión ya existe."]);
                break;
            }
            $usuario->insert_usuario($usu_nom, $usu_sesion, $usu_clave);
            echo json_encode(["ok" => true, "msg" => "Usuario registrado correctamente."]);
        }else{
            // Es edición
            $usuario->update_usuario($_POST["usu_id"], $usu_nom, $usu_sesion, $usu_clave);
            echo json_encode(["ok" => true, "msg" => "Usuario actualizado correctamente."]);
        }
    break;

    case "mostrar":
        $datos = $usuario->get_usuario_x_id($_POST["usu_id"]);
        if(is_array($datos) == true and count($datos) > 0){
            foreach($datos as $row){
                $output["usu_id"] = $row["usu_id"];
                $output["usu_nom"] = $row["usu_nom"];
                $output["usu_sesion"] = $row["usu_sesion"];
            }
        }
        echo json_encode($output);
    break;

    case "eliminar":
        $usuario->delete_usuario($_POST["usu_id"]);
        break;
}
?>