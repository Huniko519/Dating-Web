<?php if( isset( $_SESSION['JWT'] ) ){?>
<script>
        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    $.post( window.ajax + 'useractions/save_user_location', {lat: position.coords.latitude, lng:position.coords.longitude}, function(data, textStatus, xhr) {
                        if ( data.status == 200) {
                            return true;
                        }
                    });
                },
                function errorCallback(error) {
                    $.getJSON("https://extreme-ip-lookup.com/json/",
                    function(result) {
                        $.post( window.ajax + 'useractions/save_user_location', {lat: result.lat, lng:result.lon}, function(data, textStatus, xhr) {
                            if ( data.status == 200) {
                                return true;
                            }
                        });
                    }).fail(function() {
                        window.gps_is_not_enabled = true
                    });
                },
                {
                    maximumAge:Infinity,
                    timeout:5000
                }
            );

        }else{
            window.gps_is_not_enabled = true
        }
    </script>
<?php } ?>
