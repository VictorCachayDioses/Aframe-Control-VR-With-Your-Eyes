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