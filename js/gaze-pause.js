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