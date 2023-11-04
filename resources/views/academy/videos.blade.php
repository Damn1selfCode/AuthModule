<div class="card card-default color-palette-box videos" style="min-width: 1258px;">
    <div class="visorVideos">
       
        <h5 id="videoTitle" class="text-white p-2 p-md-3 text-light w-100 d-flex">
            <span id="videoTitleText"></span>
            <div class="speed-dropdown">
                <div class="speed-controls">
                    <button id="speed025" class="btn btn-sm btn-light" data-speed="0.25">0.25x</button>
                    <button id="speed05" class="btn btn-sm btn-light" data-speed="0.5">0.5x</button>
                    <button id="speed10" class="btn btn-sm btn-light" data-speed="1">1x</button>
                    <button id="speed15" class="btn btn-sm btn-light" data-speed="1.5">1.5x</button>
                    <button id="speed20" class="btn btn-sm btn-light" data-speed="2">2x</button>
                </div>

            </div>
            <i class="fas fa-cog"></i>
        </h5>
        <video id="videoPlayer" controls>
            <source id="videoSource" src="" type="video/mp4">
        </video>

    </div>

    <div class="botonesVideos">
        <ul class="list-group list-group-flush">
            @if (isset($categorias))
            @foreach ($categorias as $categoria)
            @foreach ($categoria->videos as $video)
            @if ($suscripcion || $video->vista_gratuita == 1)
            <li class="list-group-item list-group-item-action py-3 px-2 d-flex">
                <img src="{{ url('img/' . $categoria->ruta_categoria . '/' . $video->imagen_video) }}" style="max-width: 100%; height: auto;" data-video-src="{{ asset('videos/' . $categoria->ruta_categoria . '/' . $video->medios_video) }}">
                <a class="text-muted video-title" data-video-src="{{ asset('videos/' . $categoria->ruta_categoria . '/' . $video->medios_video) }}">
                    {{ $video->titulo_video }}
                </a>
            </li>
            @endif
            @endforeach
            @endforeach
            @endif
        </ul>
    </div>
</div>

<style>
    .speed-dropdown {
        display: flex;
        align-items: center;
        margin-left: auto;
        /* Esto alineará el menú de velocidad a la derecha */
    }
</style>

<!-- Resto del HTML se mantiene igual -->

<script>
    const videoPlayer = document.getElementById('videoPlayer');
    const videoSource = document.getElementById('videoSource');
    const videoTitle = document.getElementById('videoTitleText');
    const speedDropdown = document.querySelector('.speed-dropdown');
    const speedControls = document.querySelector('.speed-controls');
    const videoTitles = document.querySelectorAll('.video-title');
    const speedButtons = document.querySelectorAll('.speed-controls button');
    const botonesVideos = document.querySelectorAll('.botonesVideos li');

    // Variable para rastrear el índice del video actual
    let currentIndex = 0;
    let videoBlobUrl = null; // Almacenar el URL del Blob

    // Crear un Blob para el video actual
    function createVideoBlob(videoSrc) {
        fetch(videoSrc)
            .then(response => response.blob())
            .then(blob => {
                videoBlobUrl = URL.createObjectURL(blob);
                videoSource.src = videoBlobUrl;
                videoPlayer.load(); // Recarga el reproductor para cargar el nuevo video
                videoPlayer.play(); // Inicia la reproducción automáticamente
            });
    }

    function loadVideo(index) {
        // Obtén la fuente del video en base al índice proporcionado
        const videoSrc = botonesVideos[index].querySelector('a').getAttribute('data-video-src');
        if (videoBlobUrl) {
            URL.revokeObjectURL(videoBlobUrl); // Liberar el URL anterior del Blob
        }
        createVideoBlob(videoSrc);

        videoTitle.textContent = botonesVideos[index].querySelector('a').textContent; // Muestra el título del video actual
    }

    // Manejar el evento 'ended' para reproducir el siguiente video
    videoPlayer.addEventListener('ended', () => {
        // Incrementar el índice al siguiente video
        currentIndex++;
        if (currentIndex < botonesVideos.length) {
            loadVideo(currentIndex);
        }
    });

    videoTitles.forEach((title, index) => {
        title.addEventListener('click', () => {
            currentIndex = index;
            loadVideo(currentIndex);
        });
    });

    speedDropdown.addEventListener('click', () => {
        speedControls.classList.toggle('show');
    });

    speedButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            const speed = button.getAttribute('data-speed');
            videoPlayer.playbackRate = parseFloat(speed);
            speedControls.classList.remove('show');
        });
    });

    // Cargar y reproducir el primer video al cargar la página
    loadVideo(currentIndex);
</script>