<?php
/**
 * Footer Template for Clinic Management System
 * Author: Your Name
 * Description: Contains the common footer structure for all pages.
 */
?>
    </main> <!-- Closing main-content opened in header.php -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-info">
                <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($_SESSION['clinic_name'] ?? 'Your Clinic') ?>. <?= t('All rights reserved.') ?></p>
            </div>
            <div class="footer-links">
                <ul>
                    <li><a href="/about"><?= t('About Us') ?></a></li>
                    <li><a href="/contact"><?= t('Contact') ?></a></li>
                    <li><a href="/terms"><?= t('Terms of Service') ?></a></li>
                    <li><a href="/privacy"><?= t('Privacy Policy') ?></a></li>
                </ul>
            </div>
            <div class="footer-social">
                <a href="https://www.facebook.com" target="_blank" class="social-link"><img src="/assets/icons/facebook.svg" alt="Facebook"></a>
                <a href="https://www.twitter.com" target="_blank" class="social-link"><img src="/assets/icons/twitter.svg" alt="Twitter"></a>
                <a href="https://www.instagram.com" target="_blank" class="social-link"><img src="/assets/icons/instagram.svg" alt="Instagram"></a>
                <a href="https://www.linkedin.com" target="_blank" class="social-link"><img src="/assets/icons/linkedin.svg" alt="LinkedIn"></a>
            </div>
        </div>
    </footer>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/charts.js"></script>
    <script src="/assets/js/languageToggle.js"></script>
</body>
</html>
