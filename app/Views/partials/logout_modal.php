<?php
/**
 * Shared Logout Confirmation Modal
 * Usage: Include this in any view that has a logout link.
 * Change logout links to: <a href="javascript:void(0)" onclick="confirmLogout('<?= site_url('logout') ?>')" ...>
 */
?>

<!-- Logout Modal HTML -->
<div id="logoutModal" class="modal-overlay" style="display: none;">
    <div class="modal-card">
        <div id="modal-content-default">
            <div class="modal-icon">☕</div>
            <h3>Are you sure you want to log out?</h3>
            <p>You can always log back in to get your perfect cup of coffee.</p>
            <div class="modal-buttons">
                <button onclick="closeLogoutModal()" class="btn-cancel">Stay</button>
                <button id="confirmLogoutBtn" onclick="processLogout()" class="btn-confirm">Yes, Log Out</button>
            </div>
        </div>
        
        <div id="modal-content-success" style="display: none;">
            <div class="modal-icon">✅</div>
            <h3>Logged out successfully!</h3>
            <p>See you again soon for another brew.</p>
            <div style="margin-top: 2rem;">
                <div class="loader" style="margin: 0 auto;"></div>
            </div>
        </div>
    </div>
</div>

<style>
/* ... existing styles ... */
.loader {
    width: 30px;
    height: 30px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #422c1d;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-overlay.active {
    opacity: 1;
}

.modal-card {
    background: white;
    padding: 2.5rem;
    border-radius: 20px;
    text-align: center;
    max-width: 400px;
    width: 90%;
    transform: translateY(20px);
    transition: transform 0.3s ease;
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.modal-overlay.active .modal-card {
    transform: translateY(0);
}

.modal-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.modal-card h3 {
    font-family: 'Playfair Display', serif;
    color: #422c1d;
    font-size: 1.5rem;
    margin-bottom: 0.8rem;
}

.modal-card p {
    color: #666;
    margin-bottom: 2rem;
    font-size: 0.95rem;
}

.modal-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-cancel {
    padding: 0.8rem 2rem;
    border: 1px solid #ddd;
    background: white;
    color: #666;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-confirm {
    padding: 0.8rem 2rem;
    border: none;
    background: #422c1d;
    color: white;
    text-decoration: none;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-cancel:hover {
    background: #f8f8f8;
    color: #333;
}

.btn-confirm:hover {
    background: #5d3f2a;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(66, 44, 29, 0.3);
}
</style>

<script>
let currentLogoutUrl = '';

function confirmLogout(logoutUrl) {
    currentLogoutUrl = logoutUrl;
    const modal = document.getElementById('logoutModal');
    
    // Reset state
    document.getElementById('modal-content-default').style.display = 'block';
    document.getElementById('modal-content-success').style.display = 'none';
    
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.classList.add('active');
    }, 10);
}

function processLogout() {
    // Show success state
    document.getElementById('modal-content-default').style.display = 'none';
    document.getElementById('modal-content-success').style.display = 'block';
    
    // Wait briefly then redirect
    setTimeout(() => {
        window.location.href = currentLogoutUrl;
    }, 1500);
}

function closeLogoutModal() {
    const modal = document.getElementById('logoutModal');
    modal.classList.remove('active');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

// Close modal if clicking outside the card
document.getElementById('logoutModal').addEventListener('click', function(e) {
    if (e.target === this && document.getElementById('modal-content-default').style.display !== 'none') {
        closeLogoutModal();
    }
});
</script>
