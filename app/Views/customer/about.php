<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Starvan Coffee</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/menu.css') ?>">
    <style>
        .about-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Hero Section */
        .hero-banner {
            background: linear-gradient(135deg, rgba(66, 44, 29, 0.9), rgba(212, 165, 116, 0.8)), url('<?= base_url("images/auth-bg.png") ?>');
            background-size: cover;
            background-position: center;
            height: 400px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            margin-bottom: 4rem;
            position: relative;
            overflow: hidden;
        }

        .hero-banner h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            animation: fadeInDown 1s ease-out;
        }

        .hero-banner p {
            font-size: 1.3rem;
            max-width: 700px;
            opacity: 0.9;
            line-height: 1.6;
            animation: fadeInUp 1s ease-out 0.3s backwards;
        }

        /* Values Section */
        .values-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 5rem;
        }

        .value-card {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .value-icon {
            width: 70px;
            height: 70px;
            background: var(--main-bg);
            color: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }

        .value-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--side-bg);
        }

        .value-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Story Section */
        .story-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            margin-bottom: 5rem;
        }

        .story-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: var(--side-bg);
            margin-bottom: 1.5rem;
        }

        .story-content p {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .story-image {
            position: relative;
        }

        .story-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
            transition: transform 0.4s ease;
        }

        .story-image:hover img {
            transform: scale(1.02);
        }

        /* Stats Strip */
        .stats-strip {
            background: var(--side-bg);
            border-radius: 20px;
            padding: 4rem 2rem;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 2rem;
            color: white;
            text-align: center;
            margin-bottom: 5rem;
            background-image: linear-gradient(rgba(66, 44, 29, 0.95), rgba(66, 44, 29, 0.95)), url('<?= base_url("images/auth-bg.png") ?>');
            background-size: cover;
        }

        .stat-box h3 {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .stat-box span {
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.8;
        }

        /* CTA */
        .cta-section {
            text-align: center;
            padding: 4rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--side-bg);
        }

        .btn-visit {
            display: inline-block;
            background: var(--accent);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(212, 165, 116, 0.3);
        }

        .btn-visit:hover {
            background: var(--accent-dark);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(212, 165, 116, 0.4);
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 991px) {
            .story-section {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .hero-banner h1 {
                font-size: 3rem;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="<?= base_url('images/logo.png') ?>" alt="NextCafe" class="brand-logo">
        </div>
        <nav class="sidebar-nav">
            <a href="<?= base_url('customer/dashboard') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                </span>
                Dashboard
            </a>
            <a href="<?= base_url('customer/menu') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </span>
                Menu
            </a>
            <a href="<?= base_url('customer/orders') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                </span>
                My Orders
            </a>
            <a href="<?= base_url('customer/cart') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </span>
                Shopping Cart
            </a>
            <a href="<?= base_url('customer/about') ?>" class="nav-link active">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </span>
                About Us
            </a>
            <a href="<?= base_url('customer/contact') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </span>
                Contact Us
            </a>
            
            <a href="javascript:void(0)" onclick="confirmLogout('<?= base_url('customer/logout') ?>')" class="nav-link" style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem;">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                </span>
                Logout
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper" style="background: #ffffff !important;">
        <div class="header-top">
            <div style="display: flex; align-items: center;">
                <div class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </div>
                <h1>Our Story</h1>
            </div>
            <div class="user-avatar"><?= strtoupper(substr(session()->get('username') ?? 'G', 0, 1)) ?></div>
        </div>

        <div class="about-wrapper">
            <div class="hero-banner">
                <h1>Crafting moments, <br> One cup at a time.</h1>
                <p>Welcome to Starvan Coffee, where passion meets perfection. We are dedicated to delivering the finest coffee experience, sourced ethically and brewed with love.</p>
            </div>

            <div class="values-section">
                <div class="value-card">
                    <div class="value-icon">🌱</div>
                    <h3>Sustainably Sourced</h3>
                    <p>We work directly with farmers to ensure fair trade and the highest quality beans while respecting the environment.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">☕</div>
                    <h3>Masterfully Roasted</h3>
                    <p>Our beans are roasted in small batches to unlock their full potential, creating a rich and unique flavor profile.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">🤝</div>
                    <h3>Community First</h3>
                    <p>More than just a cafe, we are a gathering place for friends, families, and ideas to flourish.</p>
                </div>
            </div>

            <div class="story-section">
                <div class="story-image">
                    <img src="<?= base_url('images/cappuccino.jpg') ?>" alt="Our Barista">
                </div>
                <div class="story-content">
                    <h2>The Starvan Journey</h2>
                    <p>Founded in 2024, Starvan Coffee began with a simple dream: to redefine the coffee experience. What started as a small corner shop has grown into a beloved destination for coffee lovers.</p>
                    <p>We believe that every cup tells a story. From the careful selection of cherry to the precise pour of the barista, we are obsessed with every detail. Come join us and be part of our story.</p>
                </div>
            </div>

            <div class="stats-strip">
                <div class="stat-box">
                    <h3>100%</h3>
                    <span>Arabica Beans</span>
                </div>
                <div class="stat-box">
                    <h3>15+</h3>
                    <span>Coffee Blends</span>
                </div>
                <div class="stat-box">
                    <h3>5000+</h3>
                    <span>Happy Customers</span>
                </div>
            </div>

            <div class="cta-section">
                <h2>Ready to taste the difference?</h2>
                <p style="color:#777; margin-bottom: 2rem;">Visit our menu and order your favorite blend today.</p>
                <a href="<?= site_url('customer/menu') ?>" class="btn-visit">View Menu</a>
            </div>
        </div>
    </div>

    <?php include(APPPATH . 'Views/partials/logout_modal.php'); ?>
</body>
</html>
