<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Starvan Coffee</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/menu.css') ?>">
    <style>
        .contact-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Hero Section */
        .hero-banner {
            background: linear-gradient(135deg, rgba(66, 44, 29, 0.9), rgba(212, 165, 116, 0.8)), url('<?= base_url("images/auth-bg.png") ?>');
            background-size: cover;
            background-position: center;
            height: 350px;
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
            font-size: 3.5rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            animation: fadeInDown 1s ease-out;
        }

        .hero-banner p {
            font-size: 1.2rem;
            max-width: 600px;
            opacity: 0.9;
            line-height: 1.6;
            animation: fadeInUp 1s ease-out 0.3s backwards;
        }

        /* Contact Grid */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 3rem;
            margin-bottom: 4rem;
        }

        /* Contact Info Card */
        .contact-info-card {
            background: white;
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        .contact-info-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--side-bg);
            margin-bottom: 2rem;
        }

        .info-item {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            align-items: flex-start;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: rgba(212, 165, 116, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--accent);
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .info-item:hover .info-icon {
            background: var(--accent);
            color: white;
            transform: scale(1.1);
        }

        .info-text h4 {
            margin: 0 0 0.5rem 0;
            color: #333;
            font-size: 1.1rem;
        }

        .info-text p {
            margin: 0;
            color: #666;
            line-height: 1.5;
        }

        /* Form Card */
        .contact-form-card {
            background: white;
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .contact-form-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--side-bg);
            margin-bottom: 0.5rem;
        }

        .contact-form-card p {
            color: #888;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.8rem;
            font-weight: 500;
            color: #555;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.2rem;
            border: 1px solid #eee;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
            background: #fdfdfd;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(212, 165, 116, 0.1);
            background: white;
        }

        .btn-send {
            background: var(--accent);
            color: white;
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-send:hover {
            background: var(--accent-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(212, 165, 116, 0.3);
        }

        /* Map Section */
        .map-section {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            height: 400px;
            margin-top: 1rem;
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
            .contact-grid {
                grid-template-columns: 1fr;
            }
            .hero-banner h1 {
                font-size: 2.5rem;
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
            <a href="<?= base_url('customer/about') ?>" class="nav-link">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </span>
                About Us
            </a>
            <a href="<?= base_url('customer/contact') ?>" class="nav-link active">
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
                <h1>Get in Touch</h1>
            </div>
            <div class="user-avatar"><?= strtoupper(substr(session()->get('username') ?? 'G', 0, 1)) ?></div>
        </div>

        <div class="contact-wrapper">
            <div class="hero-banner">
                <h1>We'd Love to Hear From You</h1>
                <p>Have a question, feedback, or just want to say hello? We're always here to help you get the best coffee experience.</p>
            </div>

            <div class="contact-grid">
                <!-- Contact Info -->
                <div class="contact-info-card">
                    <h2>Reach Out</h2>
                    
                    <div class="info-item">
                        <div class="info-icon">📍</div>
                        <div class="info-text">
                            <h4>Our Location</h4>
                            <p>123 Coffee Street, Metro Manila, Philippines</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📞</div>
                        <div class="info-text">
                            <h4>Phone Number</h4>
                            <p>+63 912 345 6789</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">✉️</div>
                        <div class="info-text">
                            <h4>Email Address</h4>
                            <p>hello@starvancoffee.ph</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">⏰</div>
                        <div class="info-text">
                            <h4>Opening Hours</h4>
                            <p>Mon - Sun: 7:00 AM - 10:00 PM</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-card">
                    <h2>Send a Message</h2>
                    <p>We'll get back to you as soon as possible.</p>
                    
                    <form action="#" class="contact-form" onsubmit="event.preventDefault(); alert('Message sent! We will get back to you shortly.');">
                        <div class="form-group">
                            <label>Your Name</label>
                            <input type="text" class="form-control" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" class="form-control" placeholder="What's this about?" required>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea rows="5" class="form-control" placeholder="How can we help you?" required></textarea>
                        </div>
                        <button type="submit" class="btn-send">Send Message</button>
                    </form>
                </div>
            </div>

            <div class="map-section">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.352425712398!2d120.9842!3d14.577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTTCsDM0JzM3LjIiTiAxMjDCsDU5JzAzLjEiRQ!5e0!3m2!1sen!2sph!4v1634567890123!5m2!1sen!2sph" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>

    <?php include(APPPATH . 'Views/partials/logout_modal.php'); ?>
</body>
</html>
