document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();  // Prevent the default form submission

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        xhr.open('POST', 'submit_contact.php', true);
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById('formFeedback').innerHTML = '<p style="color: green;">Message sent successfully!</p>';
                form.reset();  // Reset form fields after successful submission
            } else {
                document.getElementById('formFeedback').innerHTML = '<p style="color: red;">Error sending message. Please try again.</p>';
            }
        };
        xhr.onerror = function() {
            document.getElementById('formFeedback').innerHTML = '<p style="color: red;">Error sending message. Please check your connection.</p>';
        };

        xhr.send(formData);  // Send the form data
    });
});
