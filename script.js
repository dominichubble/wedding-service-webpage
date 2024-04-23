document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const date = document.getElementById('date').value;
        const partySize = document.getElementById('partySize').value;
        const grade = document.getElementById('cateringGrade').value;
        
        if (!date || partySize <= 0 || grade < 1 || grade > 5) {
            e.preventDefault(); // Prevent form submission
            alert("Please check your inputs. Make sure dates are selected and values are within the allowed ranges.");
            return false;
        }
    });

    // Map initialization code here
    var maps = document.querySelectorAll('.map');
    maps.forEach(function(mapElement) {
        var venueId = mapElement.id.split('-')[1];
        var lat = parseFloat(document.getElementById('lat-' + venueId).value);
        var lng = parseFloat(document.getElementById('lng-' + venueId).value);

        var map = new google.maps.Map(mapElement, {
            zoom: 15,
            center: {lat: lat, lng: lng}
        });

        new google.maps.Marker({
            position: {lat: lat, lng: lng},
            map: map
        });
    });
});


function updatePartySizeValue(value) {
    document.getElementById('partySizeValue').textContent = value;
}


function initMap() {
    document.querySelectorAll('.map').forEach(function(mapElement) {
        var venueId = mapElement.id.split('-')[1];
        var latElement = document.getElementById('lat-' + venueId);
        var lngElement = document.getElementById('lng-' + venueId);

        if (!latElement || !lngElement) {
            console.error('Latitude or longitude element not found for venue:', venueId);
            return; // Skip this map initialization
        }

        var lat = parseFloat(latElement.value);
        var lng = parseFloat(lngElement.value);

        var map = new google.maps.Map(mapElement, {
            zoom: 15,
            center: {lat: lat, lng: lng}
        });

        new google.maps.Marker({
            position: {lat: lat, lng: lng},
            map: map
        });
    });
}

