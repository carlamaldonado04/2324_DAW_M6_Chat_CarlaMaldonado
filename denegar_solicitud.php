<style>
    h2{
    color:#fe57b1;
}
input[type="submit"] {
    background-color: #fe57b1;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    border:solid 1px #fe57b1;
}

input[type="submit"]:hover {
    background-color:white;
    border: 1px solid #fe57b1;
    color:#fe57b1;
}   
</style> 
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    echo "Usuario vacío";
    exit();
    ?>
    <form action="home.php" method="get" style="padding: 15px;">
    <input type="submit"  value="Volver atrás" >
</form>
<?php
} else {
    include_once("./conexion.php");

    $emisor = mysqli_real_escape_string($conn, $_POST['id_emisor']);
    $receptor = mysqli_real_escape_string($conn, $_POST['id_receptor']);

    try {
        mysqli_autocommit($conn, false);
        mysqli_begin_transaction($conn);

        // Vaciar el campo "estado" solo para el receptor
        $estadoVacio = ""; // Aquí establecemos el campo estado como vacío
        $stmtVaciarReceptor = mysqli_stmt_init($conn);
        $sqlVaciarReceptor = "UPDATE tbl_solicitudesAmistad SET estado = ? WHERE id_emisor = ? AND id_receptor = ?";
        mysqli_stmt_prepare($stmtVaciarReceptor, $sqlVaciarReceptor);
        mysqli_stmt_bind_param($stmtVaciarReceptor, "sii", $estadoVacio, $receptor, $emisor);
        mysqli_stmt_execute($stmtVaciarReceptor);

        if (mysqli_stmt_affected_rows($stmtVaciarReceptor) > 0) {
            echo "<h2>Solicitud de amistad denegada para el receptor</h2>";
            echo '<a href="home.php"><input type="button" value="Ir a Home" style="width: auto;"></a>';
            
            mysqli_commit($conn);
        } else {
            echo "<h2>Error al denegar la solicitud de amistad para el receptor</h2>";
            echo '<a href="home.php"><input type="button" value="Ir a Home" style="width: auto;"></a>';
        }


        // Cerramos la declaración preparada
        mysqli_stmt_close($stmtVaciarReceptor);

        // Cerrar la conexión
        $conn->close();
    } catch (Exception $e) {
        // Deshacemos la actualización en caso de que se genere alguna excepción
        mysqli_rollback($conn);
        echo "<h2>Error al denegar la solicitud de amistad:</h2> " . $e->getMessage();
        echo '<a href="home.php"><input type="button" value="Ir a Home" style="width: auto;"></a>';
        die();
    }
}
?>
