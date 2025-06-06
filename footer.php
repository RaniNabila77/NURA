<?php
// footer.php

// Define service hours
$serviceHours = [
    'Senin - Jumat: 08.00 - 16.00',
    'Sabtu: 08.00 - 12.00',
    'Minggu & Hari Libur: Tutup',
];

// Define contact information
$contactInfo = [
    ['icon' => 'img/instagram.svg', 'text' => 'Library_Nura', 'alt' => 'Instagram Icon'],
    ['icon' => 'img/phone.svg', 'text' => '0838-6754-3280', 'alt' => 'Phone Icon'],
    ['icon' => 'img/mark-email-unread.svg', 'text' => 'Nura3@gmail.com', 'alt' => 'Email Icon'],
    ['icon' => 'img/facebook.svg', 'text' => 'Library_Nura', 'alt' => 'Facebook Icon'],
];

// Get current year for copyright
$currentYear = date("Y");
?>

<footer class="main-footer">
    <div class="footer-content">
        <div class="footer-column">
            <h3 class="footer-heading">Jam Layanan</h3>
            <ul class="service-hours-list">
                <?php foreach ($serviceHours as $hour): ?>
                    <li><?= htmlspecialchars($hour) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="footer-column">
            <h3 class="footer-heading">Alamat</h3>
            <address class="address-info">
                <div class="address-item">
                    <img class="location-icon" src="img/location-on.svg" alt="Location Icon" />
                    <span class="address-text">Bincen, Perum Bumi Indah</span>
                </div>
            </address>
        </div>

        <div class="footer-column">
            <h3 class="footer-heading">Info Kontak</h3>
            <div class="contact-info-list">
                <?php foreach ($contactInfo as $info): ?>
                    <div class="contact-item">
                        <img class="contact-icon" src="<?= htmlspecialchars($info['icon']) ?>" alt="<?= htmlspecialchars($info['alt']) ?>" />
                        <span class="contact-text"><?= htmlspecialchars($info['text']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="copyright-info">
            <img class="copyright-icon" src="img/vector.svg" alt="Copyright Icon" />
            <span class="copyright-text">Copyright &copy; <?= $currentYear ?> Perpustakaan Nura</span>
        </div>
    </div>
</footer>

<style>
/* --- Footer Styling (di dalam footer.php) --- */
.main-footer {
    background-color: #003160;
    color: #ffffff;
    padding: 40px 20px;
    font-family: 'Outfit', sans-serif; /* MODIFIED: Font diubah ke Outfit */
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    font-weight: bold;
    
    width: 100%; 
    margin-left: 0; 
    box-sizing: border-box;
}

.footer-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    gap: 30px;
    max-width: 1200px; /* Konten di dalam footer memiliki lebar maksimal */
    margin: 0 auto 30px auto; /* Konten di dalam footer terpusat */
    padding-bottom: 30px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.footer-column {
    flex: 1;
    min-width: 250px;
    padding: 0 15px;
}

.footer-heading {
    font-size: 1.4em;
    color: #ffffff;
    margin-bottom: 20px;
    border-bottom: 2px solid #007bff; 
    padding-bottom: 5px;
    display: inline-block;
    font-weight: bold;
}

.service-hours-list {
    list-style: none;
    padding: 0;
    margin: 0;
    line-height: 1.8;
    font-size: 0.95em;
    font-weight: bold;
}

.address-info, .contact-info-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    font-style: normal;
    font-size: 0.95em;
    font-weight: bold;
}

.address-item, .contact-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.location-icon, .contact-icon {
    width: 20px;
    height: 20px;
    filter: invert(100%);
    flex-shrink: 0;
}

.location-icon {
    width: 22px;
    height: 22px;
}

.footer-bottom {
    text-align: center;
    padding-top: 20px;
}

.copyright-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 0.9em;
    color: #ffffff;
    font-weight: bold;
}

.copyright-icon {
    width: 16px;
    height: 16px;
    filter: invert(100%);
    opacity: 0.8;
}

/* --- Responsive Adjustments for Footer --- */

@media (max-width: 1024px) {
    .main-footer {
        padding: 30px 15px;
    }
    .footer-heading {
        font-size: 1.3em;
    }
}

@media (max-width: 767px) {
    .main-footer {
        padding: 25px 10px; 
        /* margin-left: 0; dan width: 100% sudah diatur di aturan dasar .main-footer */
    }

    .footer-content {
        flex-direction: column;
        align-items: flex-start; 
        gap: 25px;
        padding-bottom: 25px;
    }
    .footer-column {
        min-width: unset;
        width: 100%;
        padding: 0 10px; 
        text-align: left; 
    }
    .footer-heading {
        font-size: 1.2em;
        margin-bottom: 15px;
    }
    .service-hours-list, .address-info, .contact-info-list {
        font-size: 0.9em;
    }
}

@media (max-width: 479px) {
    .main-footer {
        padding: 20px 5px;
    }
    .footer-heading {
        font-size: 1.1em;
    }
    .service-hours-list, .address-info, .contact-info-list {
        font-size: 0.85em;
    }
    .location-icon, .contact-icon {
        width: 18px;
        height: 18px;
    }
    .copyright-info {
        font-size: 0.8em;
    }
}
</style>
