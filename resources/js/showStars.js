document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star');
    const selectedRating = document.getElementById('selected-rating').value;

    stars.forEach(star => {
        const rating = star.getAttribute('data-rating');
        star.classList.toggle('checked', rating <= selectedRating);
    });
});
