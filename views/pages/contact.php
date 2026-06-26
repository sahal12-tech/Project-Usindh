<?php
/**
 * Contact Page View
 */

// Set page title
$title = 'Contact Us';
?>
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Contact Us</h2>
            <p class="lead">
                Have questions or need assistance? We're here to help!
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Contact Form
                    <div class="card-body>
                        <form id="contactForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Our Information</h3>
                </div>
                <div class="card-body">
                    <p><i class="fas fa-map-marker-alt me-2"></i> University Campus, Main Street, City</p>
                    <p><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                    <p><i class="fas fa-envelope me-2"></i> info@university.edu</p>
                    <p><i class="fas fa-clock me-2"></i> Mon-Fri: 8:00 AM - 5:00 PM</p>

                    <div class="mt-4">
                        <h5>Follow Us:</h5>
                        <div>
                            <a href="#" class="btn btn-outline-primary btn-sm me-2 mb-2">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-sm me-2 mb-2">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm me-2 mb-2">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="btn btn-outline-secondary btn-sm me-2 mb-2">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    form.addEventListener('function(e) {
        e.preventDefault();

        // Simple form validation
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const subject = document.getElementById('subject').value.trim();
        const message = document.getElementById('message').value.trim();

        if (name === '' || email === '' || subject === '' || message === '') {
            alert('Please fill in all fields');
            return;
        }

        // Basic email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert('Please enter a valid email address');
            return;
        }

        // Here you would typically send the form data to a server-side script
        // For this demo, we'll just show a success message
        alert('Thank you for your message! We will get back to you soon.');
        form.reset();
    });
});
</script>