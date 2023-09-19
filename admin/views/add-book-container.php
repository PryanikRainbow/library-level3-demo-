
<head>
        <title>Добавить книгу</title>
    </head>
    <div class="container-sm mt-5 rounded-container">
        <h2>Добавить книгу</h2>
        <form action="/book/add" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" class="form-control form-control-sm" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Год</label>
                        <input type="number" class="form-control form-control-sm" id="year" name="year"
                            pattern="[0-9]*" value="1991">
                    </div>
                    <?php for ($i = 1; $i <= 3; $i++) : ?>
                    <div class="mb-3">
                        <label for="author<?= $i ?>" class="form-label">Автор <?= $i ?></label>
                        <input type="text" class="form-control form-control-sm" id="author<?= $i ?>"
                            name="authors[]">
                    </div> 
                    <?php endfor; ?>
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control form-control-sm" id="description" name="description"
                            rows="6"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="image" class="form-label">Загрузить изображение</label>
                        <input type="file" class="form-control form-control-sm" id="image" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="imagePreview" class="form-label">Превью изображения</label>
                        <img src="" alt="Превью" id="imagePreview" class="img-thumbnail">
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
 
        </form>

    </div>

    <div class="container-space"></div>

    <script>
        document.getElementById("image").addEventListener("change", function() {
            const preview = document.getElementById("imagePreview");
            const file = this.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        });
    </script>