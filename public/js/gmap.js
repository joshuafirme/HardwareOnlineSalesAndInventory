let map;
let markers = [];

async function initMap() {
    let existing_lat_long = document.getElementsByName('map')[0].value;

    let myLatlng =  { lat: 13.9376, lng: 120.7005 };

    let init_message = "Click the map to get Lat/Lng!";

    if (existing_lat_long.length > 0) {

        existing_lat_long = existing_lat_long.replace(/[()\ \s-]+/g, '');
        let d = existing_lat_long.split(",");

        myLatlng =  { lat: parseFloat(d[0]), lng: parseFloat(d[1]) };

        init_message = "Your delivery address will be here!";
    }
    // Create the initial InfoWindow.
    let infoWindow = new google.maps.InfoWindow({
        content: init_message,
        position: myLatlng,
    });
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 16,
        center: myLatlng,
    });


    infoWindow.open(map);

    map.addListener("click", (mapsMouseEvent) => {setMapOnAll(null);
        infoWindow.close();
        deleteMarkers();

        infoWindow = new google.maps.InfoWindow({
        position: mapsMouseEvent.latLng,
        });
        infoWindow.setContent(
        JSON.stringify('Your delivery address will be here!', null, 2)
        );
        addMarker(mapsMouseEvent.latLng);
        document.getElementsByName('map')[0].value = mapsMouseEvent.latLng;
        //document.getElementsByName('map')[0].value = document.getElementsByName('map')[0].value.replace(/[()\ \s-]+/g, '');
        /*const image = "https://img.icons8.com/color/48/000000/place-marker--v2.png";
        const beachMarker = new google.maps.Marker({
        position: mapsMouseEvent.latLng,
        map,
        icon: image,
        });*/

        infoWindow.open(map);
    });
}

function addMarker(position) {
    const marker = new google.maps.Marker({
      position,
      map,
    });
  
    markers.push(marker);
  }

  function setMapOnAll(map) {
    for (let i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
    }
  }
  
  function hideMarkers() {
    setMapOnAll(null);
  }

  function deleteMarkers() { 
    hideMarkers();
    markers = [];
  }


  async function render() {
    const google_maps = await initMap();
  }

  render()