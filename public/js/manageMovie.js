var updateMovieModal = document.getElementById('updateMovieModal');
    updateMovieModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Nút "Update"
        var movieId = button.getAttribute('data-id');
        var title = button.getAttribute('data-title');
        var description= button.getAttribute('data-description');
        var movieUrl = button.getAttribute('data-url');
        var poster = button.getAttribute('data-poster');
        var typeId = button.getAttribute('data-type');


        var modalTitle = updateMovieModal.querySelector('.modal-title');
        var movieIdInput = updateMovieModal.querySelector('#movie_id');
        var titleInput = updateMovieModal.querySelector('#title');
        var descriptionInput = updateMovieModal.querySelector('#description');
        var urlInput = updateMovieModal.querySelector('#movie_url');
        var posterInput = updateMovieModal.querySelector('#poster');
        var typeSelect = updateMovieModal.querySelector('#type_id');

        modalTitle.textContent = 'Update Movie - ' + title;
        movieIdInput.value = movieId;
        titleInput.value = title;
        descriptionInput.value=description;
        urlInput.value = movieUrl;
        posterInput.value = poster;
        typeSelect.value = typeId;

        
    });