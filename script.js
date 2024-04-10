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
