document.addEventListener('DOMContentLoaded', function() {
    // Other event listeners...

    const addPackageForm = document.getElementById('addPackageForm');

    addPackageForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const packageName = document.getElementById('packageName').value;
        const destination = document.getElementById('destination').value;
        const price = document.getElementById('price').value;
        const details = document.getElementById('details').value;

        fetch('add_package.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                packageName: packageName,
                destination: destination,
                price: price,
                details: details
            })
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            // Handle success - maybe clear the form or show a success message
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle error
        });
    });

    // Fetch and display packages
    function fetchPackages() {
        fetch('get_packages.php')
            .then(response => response.json())
            .then(packages => {
                const packageList = document.querySelector('.package-list');
                packageList.innerHTML = '';

                packages.forEach(package => {
                    const packageItem = document.createElement('div');
                    packageItem.className = 'package-item';
                    packageItem.innerHTML = `
                        <h3>${package.package_name}</h3>
                        <p>${package.destination}</p>
                        <p>${package.price}</p>
                        <p>${package.details}</p>
                        <button class="update-btn">Update</button>
                    `;
                    packageList.appendChild(packageItem);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    fetchPackages();
});

function editReview(name, date, comment) {
    // Set the values in the form
    document.getElementById('review_name').value = name;
    document.getElementById('review_email').value = ''; // Assuming email is not passed
    document.getElementById('review_content').value = comment;
    document.getElementById('review_id').value = ''; // Assuming you need to set review ID if any
}
