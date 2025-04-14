document.addEventListener('DOMContentLoaded', function() {
    const menu = document.querySelector('#mobile-menu');
    const menuLinks = document.querySelector('.navbar__menu');
    
    if (menu && menuLinks) {
        menu.addEventListener('click', function() {
            menu.classList.toggle('is-active');
            menuLinks.classList.toggle('active');
        });
    }

    let prevScrollpos = window.pageYOffset;
    const navbar = document.querySelector(".navbar");

    window.onscroll = function() {
        let currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            navbar.style.top = "0";
        } else {
            navbar.style.top = "-100px"; // Adjust this based on the navbar height
        }
        prevScrollpos = currentScrollPos;
    };
});

    

    const feedbackForm = document.getElementById('feedbackForm');
    const reviewsContainer = document.getElementById('reviewsContainer');

    if (feedbackForm && reviewsContainer) {
        feedbackForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const feedback = document.getElementById('feedback').value;
            const rating = document.querySelector('input[name="rating"]:checked');

            if (name && feedback && rating) {
                const review = document.createElement('div');
                review.classList.add('review');
                review.innerHTML = `<h3>${name} (${rating.value} ★)</h3><p>${feedback}</p>`;
                reviewsContainer.appendChild(review);

                feedbackForm.reset(); // Clear the form after submission
            } else {
                alert('Please fill in all fields and provide a rating.');
            }
        });
    }


