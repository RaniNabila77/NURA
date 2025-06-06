<?php
// sidebar.php

// Define sidebar menu items as an array for easy management
$menuItems = [
    [
        'text' => 'Dashboard',
        'icon' => 'img/layout-fluid.png',
        'link' => 'dashboard.php',
        'id' => 'dashboard-menu-item', // ID for JavaScript targeting
        'submenu' => [ // Example of a submenu (though your current dashboard item isn't a true submenu)
            // ['text' => 'Overview', 'link' => 'dashboard_overview.php'],
            // ['text' => 'Analytics', 'link' => 'dashboard_analytics.php'],
        ]
    ],
    [
        'text' => 'Pencarian',
        'icon' => 'img/search.svg',
        'link' => 'pencarian.php'
    ],
    [
        'text' => 'Sumbang Buku',
        'icon' => 'img/heart.png',
        'link' => 'SumbangBuku.php'
    ],
    [
        'text' => 'Riwayat',
        'icon' => 'img/history.svg',
        'link' => 'riwayat.php'
    ],
];

// Determine the current page to apply an 'active' class for styling
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <button type="button" class="sidebar-toggle" id="sidebar-toggle" aria-label="Toggle Sidebar">
            <img class="chevrons-left-icon" src="img/chevrons-left.svg" alt="Toggle Sidebar" />
        </button>
        <a href="dashboard.php" class="logo-link">
            <img class="logo" src="img/Logo.png" alt="Library Nura Logo" />
        </a>
    </div>

    <nav class="sidebar-nav">
        <ul class="menu-list">
            <?php foreach ($menuItems as $item): ?>
                <?php
                $isActive = ($currentPage === basename($item['link'])) ? 'active' : '';
                $hasSubmenuClass = !empty($item['submenu']) ? 'has-submenu' : '';
                ?>
                <li class="menu-item <?= $isActive ?> <?= $hasSubmenuClass ?>" id="<?= htmlspecialchars($item['id'] ?? '') ?>">
                    <a href="<?= htmlspecialchars($item['link']) ?>">
                        <img class="menu-icon" src="<?= htmlspecialchars($item['icon']) ?>" alt="<?= htmlspecialchars($item['text']) ?> Icon" />
                        <span class="menu-text"><?= htmlspecialchars($item['text']) ?></span>
                    </a>
                    <?php if (!empty($item['submenu'])): ?>
                        <ul class="submenu-list" id="<?= htmlspecialchars($item['id']) ?>-submenu">
                            <?php foreach ($item['submenu'] as $subItem): ?>
                                <li class="submenu-item">
                                    <a href="<?= htmlspecialchars($subItem['link']) ?>">
                                        <span class="submenu-text"><?= htmlspecialchars($subItem['text']) ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="logout.php" class="logout-button">
            <img class="logout-icon" src="img/log-out.svg" alt="Logout Icon" />
            <span class="menu-text">Log Out</span>
        </a>
    </div>
</div>

<style>
/* --- Sidebar Styling --- */
.sidebar {
    width: 250px; /* Default width */
    background-color: #003160; /* Darker background */
    color: #ffffff; /* **TEKS UMUM DI SIDEBAR JADI PUTIH** */
    padding: 20px 15px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    transition: width 0.3s ease, padding 0.3s ease;
    height: 100vh; /* Make sidebar take full viewport height */
    position: fixed; /* Keep sidebar fixed on scroll */
    top: 0;
    left: 0;
    overflow-y: auto; /* Enable scrolling if content overflows */
    z-index: 1000; /* Ensure it's above other content */
}

/* Collapsed state */
.sidebar.collapsed {
    width: 70px; /* Smaller width when collapsed */
    padding: 20px 0;
    transition: width 0.3s ease, padding 0.3s ease;
}

/* Header styling */
.sidebar-header {
    display: flex;
    flex-direction: column; /* Changed to column for vertical stacking */
    align-items: center; /* Center items horizontally */
    margin-bottom: 30px;
    padding: 0 10px;
}

/* Specific centering for logo in collapsed state */
.sidebar.collapsed .sidebar-header {
    align-items: center; /* Ensures logo is centered horizontally */
    justify-content: center; /* Centers items vertically in the header if space allows */
}

.sidebar-header .logo-link {
    margin-top: 15px; /* Add some space between toggle and logo */
    margin-bottom: 15px; /* Space between logo and menu items */
    display: flex;
    align-items: center;
}

.sidebar.collapsed .sidebar-header .logo-link {
     margin-top: 5px; /* Adjust margin when collapsed */
     margin-bottom: 5px; /* Adjust margin when collapsed */
}


.sidebar-header .logo {
    width: 40px; /* Adjust logo size */
    height: auto;
    transition: all 0.3s ease;
}

.sidebar.collapsed .sidebar-header .logo {
    width: 35px; /* Smaller logo when collapsed */
}

/* Adjusted sidebar toggle button for better centering and click area */
.sidebar-toggle {
    background: none;
    border: none;
    cursor: pointer;
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%; /* Make it take full width of its container (sidebar-header) */
}

.sidebar-toggle:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.sidebar-toggle .chevrons-left-icon {
    width: 24px;
    height: 24px;
    filter: invert(100%); /* **IKON INI TETAP PUTIH** */
    transition: transform 0.3s ease;
}

/* Rotate toggle icon when sidebar is collapsed */
.sidebar.collapsed .sidebar-toggle .chevrons-left-icon {
    transform: rotate(180deg);
}

/* Navigation menu */
.sidebar-nav {
    flex-grow: 1; /* Allows navigation to take up available space */
}

.menu-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu-item {
    margin-bottom: 10px;
    position: relative;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.menu-item:last-child {
    margin-bottom: 0;
}

.menu-item a {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: #ffffff; /* **TEKS MENU JADI PUTIH** */
    text-decoration: none;
    font-size: 16px;
    border-radius: 8px;
    transition: background-color 0.3s ease, color 0.3s ease;
    white-space: nowrap; /* Prevent text wrapping */
    overflow: hidden; /* Hide overflow when collapsed */
}

.sidebar.collapsed .menu-item a {
    justify-content: center;
    padding: 12px 0; /* Adjust padding for collapsed state to center */
}


.menu-item a:hover {
    background-color: #34495e; /* Slightly lighter dark for hover */
}

/* Active menu item */
.menu-item.active a {
    background-color: #3498db; /* Blue for active state */
    font-weight: bold;
    color: #ffffff; /* **TEKS AKTIF JADI PUTIH** */
}

/* Icons */
.menu-icon, .logout-icon {
    width: 20px;
    height: 20px;
    margin-right: 15px;
    filter: invert(100%); /* **IKON MENU DAN LOGOUT JADI PUTIH** */
    flex-shrink: 0; /* Prevent icon from shrinking */
    transition: margin-right 0.3s ease;
}

.sidebar.collapsed .menu-icon,
.sidebar.collapsed .logout-icon {
    margin-right: 0; /* No margin when collapsed */
}

/* Text */
.menu-text {
    opacity: 1;
    visibility: visible;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.sidebar.collapsed .menu-text {
    opacity: 0;
    visibility: hidden;
    width: 0; /* Collapse width to hide text */
    overflow: hidden;
    position: absolute; /* Prevent text from pushing layout */
    pointer-events: none; /* Make text not clickable when hidden */
}

/* Submenu styling */
.submenu-list {
    list-style: none;
    padding: 0;
    margin: 5px 0 5px 35px; /* Indent submenu items */
    display: none; /* Hidden by default */
}

.submenu-list.active {
    display: block; /* Show when active */
}

.submenu-item a {
    padding: 8px 15px;
    font-size: 14px;
    color: #ffffff; /* **TEKS SUBMENU JADI PUTIH** */
}

.submenu-item a:hover {
    background-color: #4a6781; /* Darker hover for submenu */
}

/* Sidebar footer (for logout) */
.sidebar-footer {
    padding: 10px 15px;
    margin-top: auto; /* Pushes the footer to the bottom */
    border-top: 1px solid rgba(255, 255, 255, 0.1); /* Separator line */
    padding-top: 20px;
}

.logout-button {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: #ffffff; /* **TEKS LOGOUT JADI PUTIH** */
    text-decoration: none;
    font-size: 16px;
    border-radius: 8px;
    transition: background-color 0.3s ease, color 0.3s ease;
    white-space: nowrap;
    overflow: hidden;
}

/* Center logout icon when collapsed */
.sidebar.collapsed .logout-button {
    justify-content: center;
    padding: 12px 0; /* Adjust padding for collapsed state to center */
}

.logout-button:hover {
    background-color: rgba(231, 76, 60, 0.2); /* Tetap merah transparan untuk hover */
    color: #ffffff;
}

</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const sidebarToggle = document.getElementById("sidebar-toggle");
    const sidebar = document.getElementById("sidebar");
    const menuItemsWithSubmenu = document.querySelectorAll(".menu-item.has-submenu");

    // Function to toggle sidebar collapsed state
    sidebarToggle.addEventListener("click", function () {
        sidebar.classList.toggle("collapsed");
        // Optionally store state in local storage
        if (sidebar.classList.contains("collapsed")) {
            localStorage.setItem("sidebarCollapsed", "true");
        } else {
            localStorage.removeItem("sidebarCollapsed");
        }
    });

    // Check for collapsed state on page load
    if (localStorage.getItem("sidebarCollapsed") === "true") {
        sidebar.classList.add("collapsed");
    }

    // Handle submenu toggling (if you decide to implement actual submenus)
    menuItemsWithSubmenu.forEach(item => {
        item.addEventListener("click", function(event) {
            const submenuId = this.id + "-submenu";
            const submenu = document.getElementById(submenuId);
            if (submenu) {
                // Prevent default link behavior if you want to only toggle submenu
                // event.preventDefault(); 
                submenu.classList.toggle("active");
            }
        });
    });
});
</script>
