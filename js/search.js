document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.search-form form');
    const boxContainer = document.querySelector('.box-container');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(form);
        fetch('search.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            boxContainer.innerHTML = ''; // Clear existing content

            if (data.length > 0) {
                data.forEach(package => {
                    const box = document.createElement('div');
                    box.classList.add('box');
                    box.innerHTML = `
                        <img src="${package.image}" alt="">
                        <div class="content">
                            <h3><i class="fas fa-map-marker-alt"></i>${package.location}</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero, eaque.</p>
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="price">${package.price}<span>${package.original_price}</span></div>
                            <a href="book.html" class="btn">book now</a>
                        </div>
                    `;
                    boxContainer.appendChild(box);
                });
            } else {
                boxContainer.innerHTML = '<p>No packages found.</p>';
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
