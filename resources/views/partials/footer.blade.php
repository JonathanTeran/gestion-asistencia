<footer class="custom-footer">
    <div class="footer-background">
        <div class="footer-container">
            <!-- Logo -->
            <div class="footer-logo">
                <a href="https://communityday.awsugecuador.com">
                    <img src="https://communityday.awsugecuador.com/wp-content/uploads/2022/11/logo-aws-ug-ecuador.svg" alt="AWS User Group Ecuador Logo" width="200">
                </a>
            </div>

            <!-- Divider -->
            <div class="footer-divider"></div>

            <!-- Social Media Icons -->
            <div class="footer-social-icons">
                <a href="#" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            </div>

            <!-- Copyright -->
            <p class="footer-copyright">
                Copyright © 2024, AWS User Group Ecuador. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>


<style>

    /* Footer styles */
.custom-footer {
    position: relative;
    color: white;
    text-align: center;
    background-color: #ffffff; /* Fondo oscuro similar al de la imagen */
    padding: 40px 0; /* Eliminé los márgenes y añadí solo padding vertical */
    padding-bottom: 10px;
    margin: 0; /* No más margen */
}

.footer-background {
    background-image: url('https://communityday.awsugecuador.com/wp-content/uploads/2024/09/banner-web.jpg');
    background-size: cover;
    background-position: center;
    padding: 50px 0;
    position: relative;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.footer-logo img {
    width: 200px;
    height: auto;
}

.footer-divider {
    width: 80px;
    height: 1px;
    background-color: rgba(255, 255, 255, 0.3);
    margin: 20px 0;
}

/* Social Media Icons */
.footer-social-icons {
    display: flex;
    gap: 30px;
    justify-content: center;
    margin-bottom: 20px;
}

.social-icon {
    color: white;
    font-size: 1.5rem;
    text-decoration: none;
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 10px;

    transition: transform 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}

.social-icon:hover {
    color: #FB9902;
    border-color: #FB9902;
    transform: translateY(-5px);
}

/* Copyright text */
.footer-copyright {
    font-size: 0.875rem;
    margin-top: 10px;
    opacity: 0.7;
}

/* Responsiveness */
@media (max-width: 768px) {
    .footer-container {
        padding: 20px;
    }

    .footer-logo img {
        width: 150px;
    }

    .footer-social-icons {
        gap: 15px;
    }

    .social-icon {
        font-size: 1.25rem;
        padding: 8px;
    }
}



</style>
