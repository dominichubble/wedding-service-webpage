document.addEventListener('DOMContentLoaded', function() {
    fetch('fetch_venue_booking.php')
    .then(response => response.json())
    .then(data => {
        const bookingCounts = countBookingsPerMonth(data);
        const labels = Object.keys(bookingCounts).sort();  // Sort months if necessary
        const counts = labels.map(label => bookingCounts[label]);  // Map sorted labels to counts

        createChart(labels, counts);
    })
    .catch(error => console.error('Error fetching data:', error));
});

function countBookingsPerMonth(bookings) {
    const counts = {};
    bookings.forEach(booking => {
        const month = new Date(booking.booking_date).toLocaleString('en-US', { month: 'long', year: 'numeric' });
        if (counts[month]) {
            counts[month] += 1;  // Increment the count for the month
        } else {
            counts[month] = 1;  // Initialize count for the month
        }
    });
    return counts;
}

function createChart(labels, data) {
    const ctx = document.getElementById('bookingChart').getContext('2d');
    const bookingChart = new Chart(ctx, {
        type: 'bar',  // 'line' could also be used
        data: {
            labels: labels,
            datasets: [{
                label: 'Bookings per Month',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
}
