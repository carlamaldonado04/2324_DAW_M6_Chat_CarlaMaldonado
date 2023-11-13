<style>
h2{
    color:#fe57b1;
}

input[type="submit"] {
    display: block;
    margin: 10px auto;
    padding: 10px 20px;
    border: none;
    background-color: #fe57b1;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color:white;
    border: 1px solid #CB458D;
    color:#fe57b1;
}   
td{
        text-align: center;
    }

</style> 
<?php
// iniciamos la sesion
session_start();

if (!isset($_SESSION['id_user'])) {
    echo "Usuario vacío";
    exit();
} else {
    // añadimos la conexion
    include_once("./conexion.php");

    // recuperamos los id que hemos enviamos y los guardamos en variables
    $emisor = mysqli_real_escape_string($conn, $_SESSION['id_user']);
    $receptor = mysqli_real_escape_string($conn, $_POST['id_receptor']); // Asume que se recibe el ID del receptor por algún medio, como un formulario POST

    try {
        mysqli_autocommit($conn, false);
        mysqli_begin_transaction($conn);

        // Verifica si ya existe una solicitud pendiente entre estos dos usuarios
        $stmtCheck = mysqli_stmt_init($conn);
        // con la funcion COUNT verificamos si existe alguna solicitud con estado "pendiente" entre estos dos users 
        $sqlCheck = "SELECT COUNT(*) FROM tbl_solicitudesAmistad WHERE id_emisor = ? AND id_receptor = ? AND estado = 'pendiente'";
        mysqli_stmt_prepare($stmtCheck, $sqlCheck);
        mysqli_stmt_bind_param($stmtCheck, "ii", $emisor, $receptor);
        mysqli_stmt_execute($stmtCheck);
        mysqli_stmt_store_result($stmtCheck);

        // Obtenemos el resultado de la consulta
        mysqli_stmt_bind_result($stmtCheck, $count);
        mysqli_stmt_fetch($stmtCheck);

        // si hay el resultado es más grande que 0 es porque ya existe ese estado
        if ($count > 0) {
            echo "<h2>Ya existe una solicitud pendiente entre estos dos usuarios</h2>";
            echo '<a href="home.php"><input type="button" value="Ir a Home" style="width: 100%;"></a>';

        } else {
            // sino existe ese estado crea las sentencias para que haya ese estado
            // Inserta una nueva solicitud de amistad con estado 'pendiente'
            $estado = 'pendiente';
            $stmtInsert = mysqli_stmt_init($conn);
            $sqlInsert = "INSERT INTO tbl_solicitudesAmistad (id_emisor, id_receptor, estado) VALUES (?, ?, ?)";
            mysqli_stmt_prepare($stmtInsert, $sqlInsert);
            mysqli_stmt_bind_param($stmtInsert, "iis", $emisor, $receptor, $estado);
            mysqli_stmt_execute($stmtInsert);

            if (mysqli_stmt_affected_rows($stmtInsert) == 1) {
                echo "<h2>Solicitud de amistad enviada correctamente</h2>";
                echo '<a href="home.php"><input type="button" value="Ir a Home" style="width: auto;"></a>';

                

                // Commit para confirmar la transacción
                mysqli_commit($conn);
            } else {
                echo "<h2>Error al enviar la solicitud de amistad</h2>";
                echo '<a href="home.php"><input type="button" value="Ir a Home" style="width: auto;"></a>';

            }

        }

        // Cerramos las declaraciones preparadas
        mysqli_stmt_close($stmtCheck);
        mysqli_stmt_close($stmtInsert);

        // Cerrar la conexión
        $conn->close();

    } catch (Exception $e) {
        // Deshacemos la inserción en caso de que se genere alguna excepción
        mysqli_rollback($conn);
        echo "Error al enviar la solicitud de amistad: " . $e->getMessage();
        die();
    }
}

?>
