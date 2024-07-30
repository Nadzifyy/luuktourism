<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Basic styles for the contact page */
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .contact-form h2 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #333;
        }

        .contact-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .contact-form button {
            background: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .contact-form button:hover {
            background: #555;
        }

        /* Styles for success and error messages */
        .success-message,
        .error-message {
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeIn 1s forwards;
        }

        .success-message {
            color: green;
        }

        .error-message {
            color: red;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Contact Us</h1>
        <nav>
            <ul>
                <li><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="destinations.html"><i class="fas fa-map-marked-alt"></i> Destinations</a></li>
                <li><a href="delicacies.html"><i class="fas fa-utensils"></i> Local Delicacies</a></li>
                <li><a href="gallery.html"><i class="fas fa-images"></i> Gallery</a></li>
                <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <div class="contact-form">
                <h2>Get in Touch</h2>

                <!-- Success and error messages -->
                <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
                    <div class="success-message" id="successMessage">
                        <i class="fas fa-check-circle"></i> Your message has been sent successfully!
                    </div>
                <?php elseif (isset($_GET['error'])): ?>
                    <?php if ($_GET['error'] == 'invalid_email'): ?>
                        <div class="error-message" id="errorMessage">
                            <i class="fas fa-exclamation-circle"></i> Invalid email address. Please enter a valid email.
                        </div>
                    <?php elseif ($_GET['error'] == 'send_failure'): ?>
                        <div class="error-message" id="errorMessage">
                            <i class="fas fa-exclamation-circle"></i> There was an error sending your message. Please try again later.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <form action="submit_contact.php" method="POST" id="contactForm">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="6" required></textarea>

                    <button type="submit">Send Message</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Tourism Navigation System</p>
    </footer>

    <script>
        // JavaScript to trigger animations on form submission
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const success = urlParams.get('success');
            const error = urlParams.get('error');

            if (success === 'true') {
                const successMessage = document.getElementById('successMessage');
                successMessage.style.opacity = '1';
                successMessage.style.transform = 'translateY(0)';
            }

            if (error) {
                const errorMessage = document.getElementById('errorMessage');
                errorMessage.style.opacity = '1';
                errorMessage.style.transform = 'translateY(0)';
            }
        });
    </script>
</body>
</html>
