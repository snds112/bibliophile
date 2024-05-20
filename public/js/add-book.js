$(document).ready(function () {

    // Initialize an empty array to store selected genre objects
    var selectedgenres = [];

    // Basic client-side validation (optional)
    function isValidname(name) {
        return name.trim().length >= 3; // Enforce minimum name length
    }

    function addUser(name) {
        // Check if user already exists
        var found = false;
        if (selectedgenres.includes(name)) { found = true; }


        if (!found) {
            // name not found, add genre
            selectedgenres.push(name); // Assuming name is the unique identifier
            $('#genre-message').text("Genre added successfully!");
            updateSelectedgenresList(); // Update genre list (optional)
        } else {
            $('#genre-message').text("Genre already added.");
        }
    }

    $('#add-genre').on('click', function (e) {
        e.preventDefault(); // Prevent default form submission

        var name = $('#genre-name').val().trim(); // Trim leading/trailing spaces

        if (isValidname(name)) {
            // Send AJAX request to validate name
            $.ajax({
                url: '/search-genre', // Replace with your actual route
                data: { name: name },
                dataType: 'json',
                success: function (data) {
                    if (data.valid) {
                        // name is valid, add genre (assuming server response includes genre data)
                        // Assuming name is in genre data
                        // name is valid, add genre data (assuming data.genres holds genre objects)


                        addUser(data.genres[0].name);

                        updateSelectedgenresList(); // Update genre list (optional)

                        console.log(JSON.stringify(selectedgenres));
                    } else {
                        $('#genre-message').text("Genre doesn't exist.");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Handle errors during AJAX request
                    console.error("Error validating genre:", textStatus, errorThrown);
                    $('#genre-message').text("An error occurred. Please try again.");
                }
            });
        } else {
            $('#genre-message').text("Genre name must be at least 3 characters.");
        }
    });

    $('#reset-genre').on('click', function (e) {
        e.preventDefault(); // Prevent default form submission

        selectedgenres = []; // Clear selected genres
        $('#genre-name').val(''); // Clear name input
        $('#genre-message').text(""); // Clear message
        updateSelectedgenresList(); // Update genre list (optional)
        console.log(selectedgenres);
    });

    // Function to update the list of selected genres (optional)
    function updateSelectedgenresList() {
        var html = '';
        for (var i = 0; i < selectedgenres.length; i++) {
            var name = selectedgenres[i]; // Assuming name is stored directly in the array
            html += '<li>' + name + '</li>';
        }

        $('#selected-genres').html(html);
    }

    // Triggering the Save Action (modified)
    $('#store-book').on('click', function (e) {
        e.preventDefault(); // Prevent default form submission





        // Convert names to a string (modify if needed)
        var selectednames = selectedgenres.join(',');
        console.log(selectednames);

        // Set the hidden input value
        $('#genres').val(selectednames);

        // Submit the form
        $('#book-form').submit(); // Replace with your form ID
    });
});
/* const postTypeSelect = document.getElementById('postType');
const imageUpload = document.getElementById('image-upload');
const mediaAndThumbnail = document.getElementById('media-and-thumbnail');

postTypeSelect.addEventListener('change', function () {
    const selectedType = this.value;
    if (selectedType === 'image') {
        imageUpload.classList.remove('d-none');
        mediaAndThumbnail.classList.add('d-none');
    } else {
        imageUpload.classList.add('d-none');
        mediaAndThumbnail.classList.remove('d-none');
    }
}); */
