<?php
// Obtener los datos del formulario
if (isset($_POST['play_count'])) {
    $playCount = $_POST['play_count'];

    // Configurar la conexión a la base de datos
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "";

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error al conectar a la base de datos: " . $conn->connect_error);
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO registros (play_count) VALUES ('$playCount')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Registro guardado correctamente";
    } else {
        echo "Error al guardar el registro: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiencia VR - Manejo del play/pausa con la mirada</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aframe/1.4.2/aframe.min.js"></script>
    <script>
        AFRAME.registerComponent('gaze-play', {
            schema: {
                target: {type: 'selector'}
            },
            init: function () {
                var videoEl = this.data.target;
                this.el.addEventListener('mouseenter', () => {
                    this.timer = setTimeout(() => {
                        videoEl.play();

                        // Enviar el conteo al servidor
                        var xhttp = new XMLHttpRequest();
                        xhttp.open("POST", "mysql.php", true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send("play_count=1");
                    }, 2000); // 2 segundos para activar
                });
                this.el.addEventListener('mouseleave', () => {
                    clearTimeout(this.timer);
                });
            }
        });

        AFRAME.registerComponent('gaze-pause', {
            schema: {
                target: {type: 'selector'}
            },
            init: function () {
                var videoEl = this.data.target;
                this.el.addEventListener('mouseenter', () => {
                    this.timer = setTimeout(() => {
                        videoEl.pause();
                    }, 2000); // 2 segundos para activar
                });
                this.el.addEventListener('mouseleave', () => {
                    clearTimeout(this.timer);
                });
            }
        });
    </script>
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
        <a-image src="#play-button" position="-1 1 -3" gaze-play="target: #myvideo"></a-image>

        <!-- Imagen de stop para pausar el video de fondo -->
        <a-image src="#stop-button" position="1 1 -3" gaze-pause="target: #myvideo"></a-image>

    </a-scene>
</body>
</html>