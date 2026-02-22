// Main Application Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Page Navigation
    const navLinks = document.querySelectorAll('.nav-links a, .footer-links a');
    const pageSections = document.querySelectorAll('.page-section');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetPage = this.getAttribute('data-page');
            
            // Update active nav link
            navLinks.forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
            
            // Show target page
            pageSections.forEach(section => {
                section.classList.remove('active');
                if (section.id === targetPage) {
                    section.classList.add('active');
                }
            });
            
            // Scroll to top
            window.scrollTo(0, 0);
        });
    });

    // Room Selection
    const roomButtons = document.querySelectorAll('.select-room');
    roomButtons.forEach(button => {
        button.addEventListener('click', function() {
            const roomType = this.getAttribute('data-room');
            let roomId, roomName, roomPrice, roomImage;
            
            switch(roomType) {
                case 'deluxe':
                    roomId = 1;
                    roomName = 'Deluxe Room';
                    roomPrice = 199;
                    roomImage = 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80';
                    break;
                case 'executive':
                    roomId = 2;
                    roomName = 'Executive Suite';
                    roomPrice = 299;
                    roomImage = 'https://images.unsplash.com/photo-1586105251261-72a756497a11?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80';
                    break;
                case 'presidential':
                    roomId = 3;
                    roomName = 'Presidential Suite';
                    roomPrice = 599;
                    roomImage = 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80';
                    break;
            }
            
            // Set room in booking form
            const roomTypeSelect = document.getElementById('roomType');
            if (roomTypeSelect) {
                roomTypeSelect.value = roomId;
                updateBookingSummary();
            }
            
            // Navigate to booking page
            const bookingLink = document.querySelector('a[data-page="booking"]');
            if (bookingLink) bookingLink.click();
        });
    });

    // Booking Form Functionality
    const bookingForm = document.getElementById('bookingForm');
    const successMessage = document.getElementById('successMessage');
    const bookingFormContainer = document.getElementById('bookingFormContainer');
    const newBookingBtn = document.getElementById('newBookingBtn');
    
    // Set minimum dates for check-in and check-out
    const today = new Date().toISOString().split('T')[0];
    const checkInInput = document.getElementById('checkIn');
    const checkOutInput = document.getElementById('checkOut');
    
    if (checkInInput) {
        checkInInput.min = today;
        
        // Update check-out min date when check-in changes
        checkInInput.addEventListener('change', function() {
            if (checkOutInput) {
                checkOutInput.min = this.value;
                updateBookingSummary();
            }
        });
    }
    
    if (checkOutInput) {
        checkOutInput.addEventListener('change', updateBookingSummary);
    }
    
    const guestsSelect = document.getElementById('guests');
    const roomTypeSelect = document.getElementById('roomType');
    
    if (guestsSelect) {
        guestsSelect.addEventListener('change', updateBookingSummary);
    }
    
    if (roomTypeSelect) {
        roomTypeSelect.addEventListener('change', updateBookingSummary);
    }

    // Update booking summary
    function updateBookingSummary() {
        const checkIn = checkInInput ? checkInInput.value : '';
        const checkOut = checkOutInput ? checkOutInput.value : '';
        const guests = guestsSelect ? guestsSelect.value : '';
        const roomType = roomTypeSelect ? roomTypeSelect.value : '';
        
        let roomName, roomPrice, roomImage;
        
        switch(roomType) {
            case '1':
                roomName = 'Deluxe Room';
                roomPrice = 199;
                roomImage = 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80';
                break;
            case '2':
                roomName = 'Executive Suite';
                roomPrice = 299;
                roomImage = 'https://images.unsplash.com/photo-1586105251261-72a756497a11?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80';
                break;
            case '3':
                roomName = 'Presidential Suite';
                roomPrice = 599;
                roomImage = 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80';
                break;
            default:
                roomName = 'Select a Room';
                roomPrice = 0;
                roomImage = '';
        }
        
        // Update summary elements safely
        const summaryImage = document.getElementById('summaryImage');
        const summaryRoom = document.getElementById('summaryRoom');
        const summaryCheckIn = document.getElementById('summaryCheckIn');
        const summaryCheckOut = document.getElementById('summaryCheckOut');
        const summaryGuests = document.getElementById('summaryGuests');
        const summaryNights = document.getElementById('summaryNights');
        const summaryRate = document.getElementById('summaryRate');
        const summaryTaxes = document.getElementById('summaryTaxes');
        const summaryTotal = document.getElementById('summaryTotal');
        
        if (summaryImage) summaryImage.src = roomImage;
        if (summaryRoom) summaryRoom.textContent = roomName;
        if (summaryCheckIn) summaryCheckIn.textContent = checkIn || '-';
        if (summaryCheckOut) summaryCheckOut.textContent = checkOut || '-';
        if (summaryGuests) summaryGuests.textContent = guests ? guests + ' Guest(s)' : '-';
        
        // Calculate nights and total
        if (checkIn && checkOut) {
            const date1 = new Date(checkIn);
            const date2 = new Date(checkOut);
            const nights = Math.round((date2 - date1) / (1000 * 60 * 60 * 24));
            
            if (summaryNights) summaryNights.textContent = nights;
            
            const roomTotal = nights * roomPrice;
            const taxes = roomTotal * 0.1; // 10% tax
            const total = roomTotal + taxes;
            
            if (summaryRate) summaryRate.textContent = '$' + roomTotal.toFixed(2);
            if (summaryTaxes) summaryTaxes.textContent = '$' + taxes.toFixed(2);
            if (summaryTotal) summaryTotal.textContent = '$' + total.toFixed(2);
        } else {
            if (summaryNights) summaryNights.textContent = '-';
            if (summaryRate) summaryRate.textContent = '$0';
            if (summaryTaxes) summaryTaxes.textContent = '$0';
            if (summaryTotal) summaryTotal.textContent = '$0';
        }
    }

    // Handle booking form submission with comprehensive error handling
    if (bookingForm) {
        bookingForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Check if user is logged in
            const userInfo = document.getElementById('userInfo');
            const authModal = document.getElementById('authModal');
            
            if (!userInfo || userInfo.style.display === 'none' || window.getComputedStyle(userInfo).display === 'none') {
                alert('Please login to complete your booking.');
                if (authModal) {
                    authModal.style.display = 'flex';
                }
                return;
            }
            
            // Validate form before submission
            if (!validateBookingForm()) {
                return;
            }
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            
            // Show loading state
            submitButton.textContent = 'Processing Booking...';
            submitButton.disabled = true;
            
            try {
                const response = await fetch('process_booking.php', {
                    method: 'POST',
                    body: formData
                });
                
                // Check if response is OK
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                
                if (result.success) {
                    // Show success message with booking details
                    if (bookingFormContainer) bookingFormContainer.style.display = 'none';
                    if (successMessage) {
                        successMessage.style.display = 'block';
                        // Update success message with booking ID if available
                        if (result.booking_id) {
                            const successText = successMessage.querySelector('p');
                            if (successText) {
                                successText.innerHTML = `Your reservation has been successfully submitted!<br>
                                <strong>Booking ID:</strong> ${result.booking_id}<br>
                                <strong>Total Amount:</strong> $${result.total_price}<br>
                                A confirmation email has been sent to your inbox.`;
                            }
                        }
                    }
                } else {
                    // Show specific error message from server
                    showBookingError(result.message || 'Booking failed. Please try again.');
                }
            } catch (error) {
                console.error('Booking error:', error);
                
                // Handle different types of errors
                if (error.name === 'TypeError' && error.message.includes('fetch')) {
                    showBookingError('Network error. Please check your internet connection and try again.');
                } else if (error.name === 'SyntaxError') {
                    showBookingError('Server response error. Please try again.');
                } else {
                    showBookingError('An unexpected error occurred. Please try again.');
                }
            } finally {
                // Reset button
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }
        });
    }

    // Form validation function
    function validateBookingForm() {
        const checkIn = document.getElementById('checkIn').value;
        const checkOut = document.getElementById('checkOut').value;
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const cardName = document.getElementById('cardName').value;
        const cardNumber = document.getElementById('cardNumber').value;
        const expiryDate = document.getElementById('expiryDate').value;
        const cvv = document.getElementById('cvv').value;
        
        // Check required fields
        if (!checkIn || !checkOut || !firstName || !lastName || !email || !phone || !cardName || !cardNumber || !expiryDate || !cvv) {
            showBookingError('Please fill in all required fields.');
            return false;
        }
        
        // Validate dates
        if (new Date(checkIn) >= new Date(checkOut)) {
            showBookingError('Check-out date must be after check-in date.');
            return false;
        }
        
        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showBookingError('Please enter a valid email address.');
            return false;
        }
        
        // Validate phone (basic validation)
        if (phone.length < 10) {
            showBookingError('Please enter a valid phone number.');
            return false;
        }
        
        // Validate card number (basic validation)
        const cardRegex = /^[0-9\s]{13,19}$/;
        if (!cardRegex.test(cardNumber.replace(/\s/g, ''))) {
            showBookingError('Please enter a valid card number.');
            return false;
        }
        
        // Validate expiry date (MM/YY format)
        const expiryRegex = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
        if (!expiryRegex.test(expiryDate)) {
            showBookingError('Please enter a valid expiry date (MM/YY).');
            return false;
        }
        
        // Validate CVV
        const cvvRegex = /^[0-9]{3,4}$/;
        if (!cvvRegex.test(cvv)) {
            showBookingError('Please enter a valid CVV (3 or 4 digits).');
            return false;
        }
        
        return true;
    }

    // Function to show booking errors
    function showBookingError(message) {
        // You can replace this with a more sophisticated error display
        alert('Booking Error: ' + message);
        
        // Optional: Add error highlighting to form fields
        const errorFields = {
            'check-in date': 'checkIn',
            'check-out date': 'checkOut',
            'first name': 'firstName',
            'last name': 'lastName',
            'email': 'email',
            'phone': 'phone',
            'card name': 'cardName',
            'card number': 'cardNumber',
            'expiry date': 'expiryDate',
            'CVV': 'cvv'
        };
        
        // Remove previous error styles
        Object.values(errorFields).forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.style.borderColor = '';
            }
        });
        
        // Highlight relevant field based on error message
        for (const [fieldName, fieldId] of Object.entries(errorFields)) {
            if (message.toLowerCase().includes(fieldName)) {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.style.borderColor = '#e74c3c';
                    field.focus();
                }
                break;
            }
        }
    }

    // New booking button
    if (newBookingBtn) {
        newBookingBtn.addEventListener('click', function() {
            if (successMessage) successMessage.style.display = 'none';
            if (bookingFormContainer) bookingFormContainer.style.display = 'flex';
            if (bookingForm) {
                bookingForm.reset();
                updateBookingSummary();
                
                // Reset any error styles
                const inputs = bookingForm.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.style.borderColor = '';
                });
            }
        });
    }

    // Auto-fill user info if logged in - FIXED VERSION
    function autoFillUserInfo() {
        const userInfo = document.getElementById('userInfo');
        const firstNameInput = document.getElementById('firstName');
        const lastNameInput = document.getElementById('lastName');
        const emailInput = document.getElementById('email');
        
        if (userInfo && (userInfo.style.display === 'flex' || window.getComputedStyle(userInfo).display === 'flex')) {
            // User is logged in, we can auto-fill some fields
            const userName = document.getElementById('userName');
            
            if (userName && firstNameInput && lastNameInput) {
                const nameParts = userName.textContent.split(' ');
                
                if (nameParts.length >= 2) {
                    firstNameInput.value = nameParts[0];
                    lastNameInput.value = nameParts.slice(1).join(' ');
                }
            }
            
            // Note: We cannot access PHP session variables directly in JavaScript
            // The email field will remain empty for the user to fill in
            // In a real application, you would make an AJAX call to get user data
        }
    }

    // Initialize
    updateBookingSummary();
    autoFillUserInfo();
    
    console.log('Script.js initialization complete');
});