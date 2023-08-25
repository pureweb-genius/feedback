<div class="container mt-5">
    <?php if ($_SESSION['admin']?? false): ?>
        <div class="alert alert-success" role="alert">
            Вы вошли как администратор
        </div>
    <?php endif; ?>
     <h1 class="mb-4">Отзывы покупателей </h1>

    <div class="review-sort">
        <div class="btn-group mb-4" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="sortBy" id="default" autocomplete="off" checked>
            <label class="btn btn-outline-primary" for="default">По умолчанию</label>

            <input type="radio" class="btn-check" name="sortBy" id="name" autocomplete="off">
            <label class="btn btn-outline-primary" for="name">По имени</label>

            <input type="radio" class="btn-check" name="sortBy" id="email" autocomplete="off">
            <label class="btn btn-outline-primary" for="email">По email</label>

            <input type="radio" class="btn-check" name="sortBy" id="date" autocomplete="off">
            <label class="btn btn-outline-primary" for="date">По дате</label>
        </div>
    </div>
    <div class=" d-flex flex-column align-items-baseline" id="review-list">

    </div>


        <div class="card mb-3 bg-danger">
            <div class="card-body text-white">
                <h3 class="card-title">Добавить отзыв</h3>
                <form id="review-form" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Имя</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="text" class="form-label">Отзыв</label>
                        <textarea class="form-control" id="text" name="text" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Прикрепить картинку</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-light">Отправить</button>
                </form>
            </div>
        </div>
    </div>
<div class="modal" id="edit-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body ">
                <input type="hidden" class="form-control" id="review-id">
                <label for="edited-name " class="text-danger">Имя:</label>
                <input type="text" class="form-control" id="edited-name"><br>
                <label for="edited-review-text " class="text-danger">Отзыв:</label>
                <textarea class="form-control" id="edited-review-text"></textarea><br>

            <div class="modal-footer">
                <button id="save-button" class="btn btn-primary">Сохранить</button>
                <button id="cancel-button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>


<script>
    function loadReviewImage(imagePath, imageElementId) {
        console.log(imageElementId)
        const imageElement = document.getElementById('review-image-'+imageElementId);
        const buttonElement = document.getElementById('review-button-'+imageElementId);
        imageElement.src = imagePath;
        if (imageElement.classList.contains('d-none')) {
            imageElement.classList.remove('d-none');
            buttonElement.textContent = 'Скрыть картинку';
        }
        else {
            buttonElement.textContent = 'Показать картинку';
            imageElement.classList.add('d-none');
        }
    }

    $(document).ready(function() {
        $("#review-form").submit(function (event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this); // Use 'this' which refers to the form element
            $.ajax({
                url: "review/store",
                method: "POST",
                data: formData,
                processData: false, // Important for sending FormData
                contentType: false  // Important for sending FormData
            }).done(function (data) {
                console.log(data);
                loadReviews();
            });
        });
        loadReviews();
        $('input[type=radio][name=sortBy]').change(function () {
            var sortBy = $(this).attr('id')
            loadReviews(sortBy);

        })

        $(document).on('click', '.edit-btn', function() {
            var reviewElement = $(this).closest(".card");
            var reviewId = reviewElement.data("review-id"); // Используйте атрибут data-review-id
            var reviewName = reviewElement.find(".card-title").text();
            var reviewText = reviewElement.find(".card-text").eq(0).text();


            // Заполните поля модального окна данными отзыва
            $("#review-id").val(reviewId);
            $("#edited-name").val(reviewName);
            $("#edited-review-text").val(reviewText);
            debugger
            $("#edit-modal").modal("show");
        });

        $("#cancel-button").click(function() {
            $("#edit-modal").modal("hide");
        });

        $("#save-button").click(function() {
            var reviewId = $("#review-id").val();
            var reviewName = $("#edited-name").val();
            var reviewText = $("#edited-review-text").val();
            $.ajax({
                url: "review/update",
                method: "POST",
                data: {
                    id: reviewId,
                    name: reviewName,
                    text: reviewText
                }
            }).done(function (data) {
                console.log(data);
                loadReviews();
                $("#edit-modal").modal("hide");
            });
        });

    });
    function loadReviews(sortBy = 'default') {
        $.ajax({
            url: 'review/load?sortBy=' + sortBy,
            type: 'GET',
            success: function (data) {
                const reviews = JSON.parse(data);
                console.log(reviews.reviews);
               displayReviews(reviews.reviews)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Ошибка при загрузке отзывов:', errorThrown);
            }
        });
    }

    function displayReviews(reviews) {
        var reviewList = $('#review-list');
        reviewList.empty();

        reviews.forEach(function(review) {
            var card = $('<div class="card mb-3 bg-success col-12" data-review-id="' + review.id + '">');
            var cardBody = $('<div class="card-body text-white">');
            var cardFooter = $('<div class="card-footer d-flex flex-column col-6">');
            var cardFooterButtons = $('<div class="d-flex justify-content-start col-6 col-xs-12 col-sm-6">');
            var isAdmin = "<?php echo $_SESSION['admin']?? false; ?>";
            if (isAdmin) {
                card.append(cardFooterButtons);
                var deleteButton = $('<button type="button" class="btn btn-danger col-1 col-sm-2 col-xs-3" onclick="deleteReview('+review.id+')"><svg style="width:20px;height: 20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z"/></svg></button>');
                cardFooterButtons.append(deleteButton);
                var editButton = $('<button  type="button" class="edit-btn btn btn-warning col-1 col-sm-2 col-xs-3" > <svg style="width:20px;height: 20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M490.3 40.4C512.2 62.27 512.2 97.73 490.3 119.6L460.3 149.7L362.3 51.72L392.4 21.66C414.3-.2135 449.7-.2135 471.6 21.66L490.3 40.4zM172.4 241.7L339.7 74.34L437.7 172.3L270.3 339.6C264.2 345.8 256.7 350.4 248.4 353.2L159.6 382.8C150.1 385.6 141.5 383.4 135 376.1C128.6 370.5 126.4 361 129.2 352.4L158.8 263.6C161.6 255.3 166.2 247.8 172.4 241.7V241.7zM192 63.1C209.7 63.1 224 78.33 224 95.1C224 113.7 209.7 127.1 192 127.1H96C78.33 127.1 64 142.3 64 159.1V416C64 433.7 78.33 448 96 448H352C369.7 448 384 433.7 384 416V319.1C384 302.3 398.3 287.1 416 287.1C433.7 287.1 448 302.3 448 319.1V416C448 469 405 512 352 512H96C42.98 512 0 469 0 416V159.1C0 106.1 42.98 63.1 96 63.1H192z"/></svg></button>');
                cardFooterButtons.append(editButton);
            }
            card.append(cardBody);
            card.append(cardFooter);
            cardBody.append($('<h3 class="card-title">').text(review.name));
            cardBody.append($('<p class="card-text">').html(review.text));
            cardBody.append($('<p class="card-email">').html(review.email));
            cardBody.append($('<p class="card-text">').text(review.created_at));
            if (review.image_path) {
                var imageButton = $('<button type="button" id="review-button-'+review.id+'" class="btn btn-light col-5" onclick="loadReviewImage(\''+review.image_path+'\', '+review.id+')">Показать картинку</button>');
                var image = $('<img class="card-image d-none" id="review-image-'+review.id+'" onclick="loadReviewImage(\''+review.image_path+'\', '+review.id+')" src="" width="400">');
                cardFooter.append(imageButton);
                cardFooter.append(image);
            }

            reviewList.append(card);
        });
    }

        function deleteReview(id) {
            $.ajax({
                url: 'review/delete',
                type: 'POST',
                data: {id: id},
                success: function (data) {
                    console.log(data);
                    loadReviews();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Ошибка при удалении отзыва:', errorThrown);
                }
            });
        }






</script>
