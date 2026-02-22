// Authentication Modal Functionality
document.addEventListener('DOMContentLoaded', function() {
    const authModal = document.getElementById('authModal');
    const loginBtn = document.getElementById('loginBtn');
    const signupBtn = document.getElementById('signupBtn');
    const closeModal = document.getElementById('closeModal');
    const modalTabs = document.querySelectorAll('.modal-tab');
    const modalForms = document.querySelectorAll('.modal-form');

    // Debug logging
    console.log('Auth.js loaded');
    console.log('Login button:', loginBtn);
    console.log('Signup button:', signupBtn);
    console.log('Auth modal:', authModal);

    // Open modal
    function openAuthModal() {
        console.log('Opening auth modal');
        if (authModal) {
            authModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    // Close modal
    function closeAuthModal() {
        console.log('Closing auth modal');
        if (authModal) {
            authModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    // Switch between login and signup tabs
    modalTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            console.log('Switching to tab:', targetTab);
            
            // Update active tab
            modalTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Show corresponding form
            modalForms.forEach(form => {
                form.classList.remove('active');
                if (form.id === targetTab + 'Form') {
                    form.classList.add('active');
                }
            });
        });
    });

    // Event listeners for modal
    if (loginBtn) {
        loginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openAuthModal();
            // Switch to login tab
            modalTabs[0].click();
        });
    }

    if (signupBtn) {
        signupBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openAuthModal();
            // Switch to signup tab
            modalTabs[1].click();
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', closeAuthModal);
    }
    
    // Close modal when clicking outside
    if (authModal) {
        authModal.addEventListener('click', function(e) {
            if (e.target === authModal) {
                closeAuthModal();
            }
        });
    }

    // Handle login form submission
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            console.log('Login form submitted');
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            
            // Show loading state
            submitButton.textContent = 'Logging in...';
            submitButton.disabled = true;
            
            try {
                const response = await fetch('login.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                console.log('Login response:', result);
                
                if (result.success) {
                    alert('Login successful!');
                    closeAuthModal();
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Login error:', error);
                alert('An error occurred. Please try again.');
            } finally {
                // Reset button
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }
        });
    }

    // Handle signup form submission - UPDATED TO USE signup_process.php
    const modalSignupForm = document.getElementById('signupForm');
    if (modalSignupForm) {
        modalSignupForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            console.log('Modal signup form submitted');
            
            const password = document.getElementById('signupPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Client-side validation
            if (password.length < 6) {
                alert('Password must be at least 6 characters long!');
                return;
            }
            
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            
            // Show loading state
            submitButton.textContent = 'Creating Account...';
            submitButton.disabled = true;
            
            try {
                const response = await fetch('signup_process.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                console.log('Signup response:', result);
                
                if (result.success) {
                    alert('Registration successful!');
                    closeAuthModal();
                    location.reload(); // Refresh to update login state
                } else {
                    // Show specific error messages
                    const errorMessages = {
                        'missing_fields': 'Please fill in all fields.',
                        'invalid_email': 'Please enter a valid email address.',
                        'password_short': 'Password must be at least 6 characters long.',
                        'password_mismatch': 'Passwords do not match.',
                        'email_exists': 'Email already exists. Please use a different email.',
                        'database_error': 'Database error. Please try again.',
                        'error': 'An error occurred. Please try again.'
                    };
                    
                    alert(errorMessages[result.message] || 'An error occurred.');
                }
            } catch (error) {
                console.error('Signup error:', error);
                alert('Network error. Please check your connection and try again.');
            } finally {
                // Reset button
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }
        });
    }

    // Handle booking navigation for non-logged in users
    function handleBookingNavigation() {
        const userInfo = document.getElementById('userInfo');
        if (!userInfo || userInfo.style.display === 'none' || window.getComputedStyle(userInfo).display === 'none') {
            console.log('User not logged in, opening auth modal');
            openAuthModal();
        } else {
            console.log('User logged in, navigating to booking');
            // Navigate to booking page
            const bookingLink = document.querySelector('a[data-page="booking"]');
            if (bookingLink) bookingLink.click();
        }
    }

    // Add event listeners for booking buttons
    const heroBookingBtn = document.getElementById('heroBookingBtn');
    const bookingSectionBtn = document.getElementById('bookingSectionBtn');
    const bookingNav = document.getElementById('bookingNav');

    if (heroBookingBtn) heroBookingBtn.addEventListener('click', handleBookingNavigation);
    if (bookingSectionBtn) bookingSectionBtn.addEventListener('click', handleBookingNavigation);
    if (bookingNav) bookingNav.addEventListener('click', handleBookingNavigation);

    console.log('Auth.js initialization complete');
});