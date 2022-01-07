
@php
$page_title =  "Val Construction Supply | Cart";
@endphp

@include('header')

<!-- Navbar -->
@include('nav')
<!-- /.navbar -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="ftco-section">
        <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-5">
        </div>
        </div>
        <div class="row justify-content-center card p-3">
        <div class="col-md-10">
        <div class="wrapper">
        <div class="row no-gutters">
        <div class="col-md-6">
            <div id="map"></div>
        </div>
        <div class="col-md-6 d-flex align-items-stretch">
        <div class="info-wrap w-100 p-lg-5 p-4 img">
        <h3>Contact us</h3>
        <p class="mb-4">We're open for any suggestion or just to have a chat</p>
        <div class="dbox w-100 d-flex align-items-start">
        <div class="icon d-flex align-items-center justify-content-center">
        <span class="fa fa-map-marker"></span>
        </div>
        <div class="text pl-3">
        <p><span>Address:</span> Ped Plaza Business Centre
            Ermita, Balayan, Batangas
            Philippines
            </p>
        </div>
        </div>
        <div class="dbox w-100 d-flex align-items-center">
        <div class="icon d-flex align-items-center justify-content-center">
        <span class="fa fa-phone"></span>
        </div>
        <div class="text pl-3">
        <p><span>Smart: </span> +639485203705</p>
        </div>
        </div>
        <div class="dbox w-100 d-flex align-items-center">
            <div class="icon d-flex align-items-center justify-content-center">
      
            </div>
            <div class="text pl-3 ml-3">
            <p><span>Sun: </span> +639327662932</p>
            </div>
            </div>
        <div class="dbox w-100 d-flex align-items-center">
        <div class="icon d-flex align-items-center justify-content-center">
        <span class="fa fa-paper-plane"></span>
        </div>
        <div class="text pl-3">
        <p><span>Email:</span> <a href = "mailto: valconstructionsupply@gmail.com" target="_blank"><span>valconstructionsupply@gmail.com </span></a></p>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('footer')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8wVIr_ne8CDZ_NM_9RPkL5nBUa7TlVms&callback=initMap&v=weekly&channel=2" async></script>

<script>
    initMap();
    function initMap() { 

        $('#map').height(400);
        //let latlong = document.getElementsByName('map')[0].value;
   
        let myLatlng =  { lat: 13.945114, lng: 120.730135 };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 16,
            center: myLatlng,
        });


        const image = "https://img.icons8.com/color/48/000000/place-marker--v2.png";
        const beachMarker = new google.maps.Marker({
            position: myLatlng,
            map,
            icon: image,
        });

        infoWindow.open(map);
    }
</script>