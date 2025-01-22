const menu = document.querySelector('#mobile-menu')
const menuLinks = document.querySelector('.navbar__menu')

menu.addEventListener('click', function(){
    menu.classList.toggle('is-active');
    menuLinks.classList.toggle('active');
});


const feedbackForm = document.getElementById('feedbackForm');
const reviewsContainer = document.getElementById('reviewsContainer');

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