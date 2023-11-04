<div class="card card-default color-palette-box videos" style="min-width: 1258px;">
    <div class="visorVideos">
        <h5 id="videoTitle" class="text-white p-2 p-md-3 text-light w-100 d-flex">
            <span id="videoTitleText">Contenido del título</span>
            <div class="speed-dropdown">
                <div class="speed-controls">
                    <button id="speed025" class="btn btn-sm btn-light" data-speed="0.25">0.25x</button>
                    <button id="speed05" class="btn btn-sm btn-light" data-speed="0.5">0.5x</button>
                    <button id="speed10" class="btn btn-sm btn-light" data-speed="1">1x</button>
                    <button id="speed15" class="btn btn-sm btn-light" data-speed="1.5">1.5x</button>
                    <button id="speed20" class="btn btn-sm btn-light" data-speed="2">2x</button>

                </div>
            </div>
            <i id="configIcon" class="fas fa-cog"></i>
        </h5>

        <video id="videoPlayer" class="video-js vjs-default-skin" controls preload="auto" width="1154" height="auto" data-setup='{}' muted>
            <source id="videoSource" src="" type="application/x-mpegURL">
        </video>
    </div>
    <div class="botonesVideos">
        <ul class="list-group list-group-flush">
            @if (isset($categorias))
            @foreach ($categorias as $categoria)
            @foreach ($categoria->videos as $video)
            @if ($suscripcion || $video->vista_gratuita == 1)
            <li class="list-group-item list-group-item-action py-3 px-2 d-flex video-list-item" data-video-src="{{ asset('videos/' . $categoria->ruta_categoria . '/' . $video->medios_video) }}" data-video-title="{{ $video->titulo_video }}">
                <img src="{{ url('img/' . $categoria->ruta_categoria . '/' . $video->imagen_video) }}" style="max-width: 100%; height: auto;">
                <a class="text-muted video-title">{{ $video->titulo_video }}</a>
            </li>
            @endif
            @endforeach
            @endforeach
            @endif
        </ul>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const videoPlayer = document.getElementById('videoPlayer');
        const videoSource = document.getElementById('videoSource');
        const videoTitle = document.getElementById('videoTitleText');
        const speedButtons = document.querySelectorAll('.speed-controls button');
        const videoListItems = document.querySelectorAll('.video-list-item');
        let currentIndex = 0;
        let hlsInstance;

        function loadVideo(index) {
            if (hlsInstance) {
                hlsInstance.destroy();
            }

            // Quita la clase 'active' de todos los elementos de lista.
            videoListItems.forEach(item => {
                item.classList.remove('active');
            });

            // Agrega la clase 'active' al elemento de lista actual.
            videoListItems[index].classList.add('active');

            videoSource.src = videoListItems[index].getAttribute('data-video-src');
            videoTitle.textContent = videoListItems[index].getAttribute('data-video-title');
            hlsInstance = new Hls();
            hlsInstance.loadSource(videoSource.src);
            hlsInstance.attachMedia(videoPlayer);

            // Reproduce el video solo después de cargarlo y cuando el usuario haya interactuado.
            videoPlayer.oncanplay = () => {
                videoPlayer.play();
            };

            // Cuando el video actual termina, carga el siguiente video si está disponible.
            videoPlayer.onended = () => {
                if (currentIndex < videoListItems.length - 1) {
                    currentIndex++;
                    loadVideo(currentIndex);
                }
            };
        }

        function playFirstVideo() {
            if (videoListItems.length > 0) {
                currentIndex = 0;
                loadVideo(currentIndex);
            }
        }

        videoListItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                currentIndex = index;
                loadVideo(currentIndex);
            });
        });

        speedButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const speed = button.getAttribute('data-speed');
                videoPlayer.playbackRate = parseFloat(speed);
            });
        });

        playFirstVideo();
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#configIcon").click(function() {
            $("#videoTitleText, .speed-dropdown").toggleClass("hide");
        });
    });
</script>