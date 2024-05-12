window.initMap = async function () {
  document.querySelectorAll(".map").forEach(function (mapElement) {
    var venueId = mapElement.id.split("-")[1];
    var latElement = document.getElementById("lat-" + venueId);
    var lngElement = document.getElementById("lng-" + venueId);

    if (!latElement || !lngElement) {
      console.error(
        "Latitude or longitude element not found for venue:",
        venueId
      );
      return; // Skip this map initialization
    }

    var lat = parseFloat(latElement.value);
    var lng = parseFloat(lngElement.value);

    var map = new google.maps.Map(mapElement, {
      zoom: 15,
      center: { lat: lat, lng: lng },
    });

    new google.maps.Marker({
      position: { lat: lat, lng: lng },
      map: map,
    });
  });
};

document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  form.addEventListener("submit", function (e) {
    const date = document.getElementById("date").value;
    const partySize = document.getElementById("partySize").value;
    const grade = document.getElementById("cateringGrade").value;

    if (!date || partySize <= 0 || grade < 1 || grade > 5) {
      e.preventDefault(); // Prevent form submission
      alert(
        "Please check your inputs. Make sure dates are selected and values are within the allowed ranges."
      );
      return false;
    }
  });
});

function updatePartySizeValue(value) {
  document.getElementById("partySizeValue").textContent = value;
}

function toggleModal(show, venueId = null) {
  const modal = document.getElementById("emailModal");
  document.getElementById("venueId").value = venueId || "";
  modal.style.display = show ? "block" : "none";
}

document
  .getElementById("emailForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const venueId = formData.get("venueId");

    fetch("send_confirmation_email.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        const messageDiv = document.getElementById("modalMessage");
        if (data.success) {
          messageDiv.innerHTML = `<span style="color: black;">Booking confirmed! A confirmation email has been sent to ${data.email}.</span>`;
        } else {
          messageDiv.innerHTML =
            '<span style="color: black;">Error sending confirmation email. Please try again.</span>';
        }
      })
      .catch((error) => console.error("Error:", error));
  });
