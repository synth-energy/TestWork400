document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('city-search');
    const tableBody = document.querySelector('#weather-table tbody');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value;

            fetch(ajax_object.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                },
                body: new URLSearchParams({
                    action: 'search_cities',
                    keyword: query
                })
            })
                .then(response => response.text())
                .then(data => {
                    tableBody.innerHTML = data;
                });
        });
    }
});
