<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js"></script>

<div class="panel panel-default">

    <div class="panel-heading">
        <?php echo Yii::t('DirectoryModule.views_directory_members', '<strong>Services</strong>'); ?>
    </div>

    <div class="panel-body">

        <!-- search form -->

        <?php echo Html::beginForm(Url::to(['/services/services/find']), 'get', array('class' => 'form-search')); ?>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-group form-group-search">
                    <?php echo Html::textInput("keyword", $keyword, array("class" => "form-control form-search", "placeholder" => Yii::t('DirectoryModule.views_directory_members', 'search for services'))); ?>
                    <?php echo Html::submitButton(Yii::t('DirectoryModule.views_directory_members', 'Search'), array('class' => 'btn btn-default btn-sm form-button-search')); ?>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <?php echo Html::endForm(); ?>

        <?php if (count($services) == 0): ?>
            <p><?php echo Yii::t('DirectoryModule.views_directory_members', 'No services found into the net!'); ?></p>
        <?php endif; ?>

        <!-- map -->
        <?php
        /*
            use \dosamigos\leaflet\types\LatLng;
            use \dosamigos\leaflet\layers\Marker;
            use \dosamigos\leaflet\layers\TileLayer;
            use \dosamigos\leaflet\LeafLet;
            use \dosamigos\leaflet\widgets\Map;

            $center = new dosamigos\leaflet\types\LatLng(['lat' => 51.508, 'lng' => -0.11]);
            $marker = new Marker(['latLng' => $center, 'popupContent' => 'Hi!']);
            // The Tile Layer (very important)
            $tileLayer = new TileLayer([ 'urlTemplate' => 'https://a.tiles.mapbox.com/v4/acaristia.cifwfsxqe0241tdm0n5oaavk6/page.html', 'clientOptions' => [ 'attribution' => 'Tiles Courtesy of MapQuest ' . ', ' . 'Map data © OpenStreetMap contributors, CC-BY-SA', 'subdomains' => '1234' ] ]);
            // now our component and we are going to configure it
            $leaflet = new LeafLet([ 'center' => $center,]); // set the center
            // // Different layers can be added to our map using the `addLayer` function.
            $leaflet->addLayer($marker); // add the marker ->addLayer($tileLayer);
            // add the tile layer
            // finally render the widget
            echo Map::widget(['leafLet' => $leaflet]);
            // we could also do
            // echo $leaflet->widget();
        */
        
        ?>
    
    <div id="map" style="width: 600px; height: 400px"></div>
    </div>
    <hr>


</div>


<script>

    var map = L.map('map').setView([51.505, -0.09], 13);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6IjZjNmRjNzk3ZmE2MTcwOTEwMGY0MzU3YjUzOWFmNWZhIn0.Y8bhBaUMqFiPrDRW9hieoQ', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
        '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="http://mapbox.com">Mapbox</a>',
        id: 'mapbox.streets'
    }).addTo(map);


    L.marker([51.5, -0.09]).addTo(map)
        .bindPopup("<b>Hello world!</b><br />I am a popup.").openPopup();

    L.circle([51.508, -0.11], 500, {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5
    }).addTo(map).bindPopup("I am a circle.");

    L.polygon([
        [51.509, -0.08],
        [51.503, -0.06],
        [51.51, -0.047]
    ]).addTo(map).bindPopup("I am a polygon.");


    var popup = L.popup();

    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);
    }

    map.on('click', onMapClick);

</script>
