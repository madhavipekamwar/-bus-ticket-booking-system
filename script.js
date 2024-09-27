document.querySelectorAll('.seat').forEach(seat => {
    seat.addEventListener('click', function() {
        // Check if seat is available
        if (this.classList.contains('available')) {
            // Mark seat as booked and disable it
            this.classList.remove('available');
            this.classList.add('booked');
            this.disabled = true;
            alert('You have booked seat number ' + this.dataset['seatNumber']);
        }
    });
});
