<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['play_count'])) {
    $playCount = $_POST['play_count'];

    try {
        // Crear la conexión
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar la consulta SQL
        $stmt = $conn->prepare("INSERT INTO registros (play_count) VALUES (:playCount)");
        $stmt->bindParam(':playCount', $playCount);

        // Ejecutar la consulta
        $stmt->execute();

        echo "Registro guardado correctamente";
    } catch (PDOException $e) {
        echo "Error al guardar el registro: " . $e->getMessage();
    }

    // Cerrar la conexión
    $conn = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiencia VR - Manejo del play/pausa con la mirada</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a-scene>
        <a-assets>
            <video id="myvideo" src="un-minuto-bosque.mp4"></video>
            <img id="play-button" src="imagenes/play.png">
            <img id="stop-button" src="imagenes/stop.png">
        </a-assets>
     
        <a-camera>
            <a-cursor color="yellow"></a-cursor>
        </a-camera>

        <a-videosphere src="#myvideo"></a-videosphere>

        <!-- Botones en png para reproducir y pausar el video // el primer número es el X el segundo el Y y el tercero la profundidad en "position" -->
        <a-image src="#play-button" position="-1 1 -3" class="gaze-play" data-target="#myvideo"></a-image>

        <!-- Imagen de stop para pausar el video de fondo -->
        <a-image src="#stop-button" position="1 1 -3" class="gaze-pause" data-target="#myvideo"></a-image>

    </a-scene>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aframe/1.4.2/aframe.min.js"></script>
    <script src="js/gaze-play.js"></script>
    <script src="js/gaze-pause.js"></script>
</body>
</html>