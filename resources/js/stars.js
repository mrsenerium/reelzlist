document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star');
    const hiddenField = document.getElementById('selected-rating');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-rating');
            stars.forEach(star => star.classList.remove('checked'));
            hiddenField.value = rating;
            document.querySelectorAll('.star').forEach(star => {
                if (parseInt(star.getAttribute('data-rating')) <= parseInt(rating)) {
                    star.classList.add('checked');
                }
            });
        });
    });
});
