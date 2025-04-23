
    document.addEventListener('DOMContentLoaded', function() {
        const scrollToReservationBtn = document.getElementById('scrollToReservation');
        
        if (scrollToReservationBtn) {
            scrollToReservationBtn.addEventListener('click', function() {
                document.getElementById('poytavaraukset').scrollIntoView({
                    behavior: 'smooth'
                });
            });
        }

        const poytavarauksetText = document.getElementById('poytavarauksetText');
        
        if (poytavarauksetText) {
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    // If the element is in the viewport (50% visible or more)
                    if (entry.isIntersecting) {
                        entry.target.classList.add('highlight-text');
                    } else {
                        entry.target.classList.remove('highlight-text');
                    }
                });
            }, {
                threshold: 0.1  // Trigger the observer when 10% of the element is in view
            });

            observer.observe(poytavarauksetText);
        }
    });
