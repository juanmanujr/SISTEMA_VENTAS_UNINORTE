<?php

// La clase Producto hereda las funciones de la clase Conectar
class Producto extends Conectar
{
    // Obtiene todos los productos de la base de datos
    public function get_producto()
    {
        // Establece la conexión con la base de datos
        $conectar = parent::conexion();

        // Configura la codificación de caracteres
        parent::set_names();

        // Consulta SQL para obtener todos los productos
        $sql = "SELECT * FROM tm_producto WHERE est = 1";

        // Prepara la consulta SQL
        $sql = $conectar->prepare($sql);

        // Ejecuta la consulta
        $sql->execute();

        // Obtiene y retorna todos los registros encontrados
        $resultado = $sql->fetchAll();

        return $resultado;
    }

    // Obtiene un producto específico mediante su ID
    public function get_producto_x_id($prod_id)
    {
        // Establece la conexión con la base de datos
        $conectar = parent::conexion();

        // Configura la codificación de caracteres
        parent::set_names();

        // Consulta SQL utilizando un parámetro
        $sql = "SELECT * FROM tm_producto WHERE prod_id = ?";

        // Prepara la consulta
        $sql = $conectar->prepare($sql);

        // Asigna el ID recibido al parámetro de la consulta
        $sql->bindValue(1, $prod_id);

        // Ejecuta la consulta
        $sql->execute();

        // Obtiene y retorna el resultado
        $resultado = $sql->fetchAll();

        return $resultado;
    }

    // Elimina un producto según su ID
    public function delete_producto($prod_id)
    {
        // Establece la conexión con la base de datos
        $conectar = parent::conexion();

        // Configura la codificación de caracteres
        parent::set_names();

        // Consulta SQL para eliminar el producto
        $sql = "UPDATE tm_producto
                SET
                    est = 0,
                    fech_elim = now()
                WHERE
                    prod_id = ?";

        // Prepara la consulta
        $sql = $conectar->prepare($sql);

        // Asigna el ID del producto al parámetro
        $sql->bindValue(1, $prod_id);

        // Ejecuta la consulta
        $sql->execute();

        // Obtiene el resultado de la operación
        $resultado = $sql->fetchAll();

        return $resultado;
    }


    // Inserta un nuevo producto
    public function insert_producto($prod_nom)
    {
        // Establece la conexión con la base de datos
        $conectar = parent::conexion();

        // Configura la codificación de caracteres
        parent::set_names();

        // Consulta SQL para insertar un producto
        $sql = "INSERT INTO tm_producto
                (prod_id, prod_nom, fech_crea, fech_modi, fech_elim, est)
                VALUES (NULL, ?, now(), NULL, NULL, 1)";

        // Prepara la consulta
        $sql = $conectar->prepare($sql);

        // Asigna el nombre del producto al parámetro
        $sql->bindValue(1, $prod_nom);

        // Ejecuta la consulta
        $sql->execute();

        // Obtiene el resultado de la operación
        $resultado = $sql->fetchAll();

        return $resultado;
    }

    public function update_producto($prod_id, $prod_nom){
        $conectar=parent::conexion();
        parent::set_names();
        $sql="UPDATE tm_producto
            SET
                prod_nom=?,
                fech_modi=now()
            WHERE
                prod_id = ?;";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$prod_nom);
        $sql->bindValue(2, $prod_id);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }
}

?>