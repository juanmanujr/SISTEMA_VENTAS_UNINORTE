<?php

class Usuario extends Conectar
{
    public function get_usuario()
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Solo mostramos los que NO tienen fecha de eliminación
        $sql = "SELECT usu_id, usu_nom, usu_sesion, fech_crea, fech_modi 
                FROM tm_usuario 
                WHERE fech_elim IS NULL";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function get_usuario_x_id($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // No traemos la clave por seguridad
        $sql = "SELECT usu_id, usu_nom, usu_sesion 
                FROM tm_usuario 
                WHERE usu_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function existe_sesion($usu_sesion)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT COUNT(*) as total FROM tm_usuario WHERE usu_sesion = ? AND fech_elim IS NULL";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_sesion);
        $sql->execute();
        $row = $sql->fetch();
        return ($row["total"] > 0);
    }

    public function insert_usuario($usu_nom, $usu_sesion, $usu_clave)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "INSERT INTO tm_usuario (usu_id, usu_nom, usu_sesion, usu_clave, fech_crea, fech_modi, fech_elim) 
                VALUES (NULL, ?, ?, ?, now(), NULL, NULL)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_nom);
        $sql->bindValue(2, $usu_sesion);
        // Encriptamos la clave
        $sql->bindValue(3, password_hash($usu_clave, PASSWORD_DEFAULT));
        $sql->execute();
        return $sql->fetchAll();
    }

    public function update_usuario($usu_id, $usu_nom, $usu_sesion, $usu_clave = "")
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Si la clave está vacía, no la actualizamos
        if (!empty($usu_clave)) {
            $sql = "UPDATE tm_usuario SET usu_nom = ?, usu_sesion = ?, usu_clave = ?, fech_modi = now() WHERE usu_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_sesion);
            $sql->bindValue(3, password_hash($usu_clave, PASSWORD_DEFAULT));
            $sql->bindValue(4, $usu_id);
        } else {
            $sql = "UPDATE tm_usuario SET usu_nom = ?, usu_sesion = ?, fech_modi = now() WHERE usu_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_sesion);
            $sql->bindValue(3, $usu_id);
        }
        $sql->execute();
        return $sql->fetchAll();
    }

    public function delete_usuario($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Eliminación LÓGICA (solo guardamos la fecha)
        $sql = "UPDATE tm_usuario SET fech_elim = now() WHERE usu_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $sql->fetchAll();
    }
}
?>