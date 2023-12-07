@extends('layout')

@section('styles')
    <link href="{{ asset('css/mapa.css') }}" rel="stylesheet">
@endsection

@section('content')
<body>
    <h1> Nestro punto de abastecimiento</h1>
    <div class="container-mapa">
        <div class="image-container">
            <img src="{{ asset('img/plaza.jpg') }}" alt="Imagen">
        </div>
        <div class="map-container">
            <div id="map"></div>
        </div>
    </div>

    <script>
        function initMap() {
            // Coordenadas del Barrio Bolívar en Popayán
            var bolivar = { lat: 2.4472, lng: -76.6032 };
         
            // Crea un nuevo mapa en el elemento con el id 'map'
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: bolivar
            });
    
            // Añade un marcador en el Barrio Bolívar
            var marker = new google.maps.Marker({
                position: bolivar,
                map: map,
                title: 'Barrio Bolívar, Popayán'
            });
        }
    </script>
    
<footer>
  
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" id="wave">
        <path fill="#35ea35" fill-opacity="1" d="M0,224L26.7,218.7C53.3,213,107,203,160,213.3C213.3,224,267,256,320,261.3C373.3,267,427,245,480,218.7C533.3,192,587,160,640,170.7C693.3,181,747,235,800,245.3C853.3,256,907,224,960,192C1013.3,160,1067,128,1120,128C1173.3,128,1227,160,1280,170.7C1333.3,181,1387,171,1413,165.3L1440,160L1440,0L1413.3,0C1386.7,0,1333,0,1280,0C1226.7,0,1173,0,1120,0C1066.7,0,1013,0,960,0C906.7,0,853,0,800,0C746.7,0,693,0,640,0C586.7,0,533,0,480,0C426.7,0,373,0,320,0C266.7,0,213,0,160,0C106.7,0,53,0,27,0L0,0Z"></path>
        <image href="{{ asset('img/logoofi2.png') }}" x="20" y="80" width="300" height="90" />
        <text x="300" y="120" font-size="30" font-weight="bold" fill="#000"> Descárgate nuestra app</text>
        <a href="#" x="500" y="120" style="text-decoration: none;">
            <rect x="750" y="100" rx="10" ry="10" width="170" height="50" style="fill:#fcf8f8ea;" />
            <text x="830" y="130" font-size="20" fill="#060606" text-anchor="middle">Descargar ahora</text>
        </a>
    </svg>

    <div class="social-icons">
       
        <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
        <a href="#" class="social-icon">
            <img src="{{ asset('img/twitter.jpg') }}" alt="Twitter" class="social-icon-img">
        </a>
        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
    </div>

   <!-- Agrega la imagen "playstore.png" al frente y en la misma línea de los iconos -->
   <img src="{{ asset('img/playstore.png') }}" alt="Play Store" class="playstore-icon">

   <!-- Línea divisoria -->
   <hr class="footer-divider">

   <!-- Enlaces de políticas y logo con versión en la misma línea -->
   <div class="footer-links">
       <a href="#">Política de Privacidad</a>
       <a href="#">Términos y Condiciones</a>
       <a href="#">Protección  Datos Personales</a>
       <img src="{{ asset('img/logoofi.png') }}" alt="Logo Versión" class="footer-logo">
       <span class="version">2023 frutivegetal</span>
    </div>
</footer>
    <!-- Llama a la función initMap() cuando se cargue la página -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYXdwZsYi1q1R6SPwnVxGfBVm_f3Uvf7o&callback=initMap"></script>
</body>
    @endsection
