<!DOCTYPE html>
<html lang="en">

<!-- <head>
    <title>Добавить книгу</title>
</head> -->

<body>
    <div class="container mt-5">
        <table class="table table-success table-striped table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Автор</th>
                    <th>Год</th>
                    <th>Просмотры</th>
                    <th>Клики "хочу"</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataBooks as $dataBook): ?>
                <tr>
                    <td>
                        <input type="checkbox" class="delete-checkbox" value="<?php // echo $i ?>">
                    </td>
                    <td><?php echo $dataBook['id'] ?></td>
                    <td><?= e($dataBook['title']) ?></td>
                    <td><?= e($dataBook['author']) ?></td>
                    <td><?= e($dataBook['year']) ?></td>
                    <td><?= e($dataBook['viewsCounter']) ?></td>
                    <td><?= e($dataBook['wantsCounter']) ?></td>
                    <td>
                    <a href="/admin/page/?id=<?= $dataBook['id'] ?>&action=view&offset=0" class="btn"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn"><i class="fa fa-trash"></i></button>

        <!-- <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav> -->

    </div>

    <?php if (isset($dataConteinerBook)) : ?>
    <div class="admin-book-info container mt-3 text-center d-flex justify-content-center">
        <div class="rounded-container">
        <div class="d-flex justify-content-end"> 
        <a href="/admin/page/?offset=0" class="btn btn-close"></a>
        </div>
            <div class="row">
                <div class="col-md-6">
                    <h2>Информация о книге</h2>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Название</th>
                                <td><?= e($dataConteinerBook['title'])?></td>
                            </tr>
                            <tr>
                                <th>Автор</th>
                                <td><?= e($dataConteinerBook['author'])?></td>
                            </tr>
                            <tr>
                                <th>Год</th>
                                <td><?= e($dataConteinerBook['year'])?></td>
                            </tr>
                            <tr>
                                <th>Описание</th>
                                <td><?= e($dataConteinerBook['description']) ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="text-center">
                        <img src="/public/images/<?= e($dataConteinerBook['img']) ?> " alt="Зображення книги" class="img-thumbnail">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <head>
        <title>Добавить книгу</title>
    </head>
    <div class="container-sm mt-5 rounded-container">
        <h2>Добавить книгу</h2>
        <form action="додати_книгу.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" class="form-control form-control-sm" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Год</label>
                        <input type="number" class="form-control form-control-sm" id="year" name="year" pattern="[0-9]*" value="1991">
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
    
</body>

</html>
