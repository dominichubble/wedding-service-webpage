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
});

function updatePartySizeValue(value) {
    document.getElementById('partySizeValue').textContent = value;
}

function initMap() {
    var venue = {lat: parseFloat(document.getElementById('venue-lat').value), lng: parseFloat(document.getElementById('venue-lng').value)};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: venue
    });
    new google.maps.Marker({position: venue, map: map});
}
