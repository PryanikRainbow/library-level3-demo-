<!DOCTYPE html>
<html lang="en">

<body>
    <div class="container mt-5">
    <form action="/book/remove" method="POST">
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
                    <input type="checkbox" class="delete-checkbox" name="selectedBooks[]"
                        value="<?= $dataBook['id'] ?>">
                        <!-- <input type="checkbox" class="delete-checkbox" value="<?php // echo $i?>"> -->
                    </td>
                    <td><?php echo $dataBook['id'] ?></td>
                    <td><?= e($dataBook['title']) ?></td>
                    <td><?= e($dataBook['author']) ?></td>
                    <td><?= e($dataBook['year']) ?></td>
                    <td><?= e($dataBook['viewsCounter']) ?></td>
                    <td><?= e($dataBook['wantsCounter']) ?></td>
                    <td>
                        <a href="/admin/page/?id=<?= $dataBook['id'] ?>&action=view&page=<?= $page ?>"
                            class="btn"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button class="btn" name="deleteButton" id="confirmDelModalBtn" data-bs-toggle="modal"
            data-bs-target="#myModal">
            <i class="fa fa-trash"></i>
        </button>

        

        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Точно ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                   
                        Удалить выбранные книги?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
                        <button type="button" class="btn btn-danger">Да</button>
                    </div>
                </div>
            </div>
        </div>

        <ul class="pagination justify-content-center">
            <?php
               $prevPage = ($page > 1) ? ($page - 1) : false;
                $nextPage = ($page < $countPages) ? ($page + 1) : false;
                $currentLink = !isset($dataConteinerBook) ? "?page=" : "?id={$id}&action=view&page="
            ?>

            <li class="page-item <?= ($prevPage === false) ? 'disabled' : '' ?>">
                <?php if ($prevPage !== false): ?>
                <a class="page-link" href="<?= $currentLink . $prevPage ?>">Previous</a>
                <?php else: ?>
                <span class="page-link">Previous</span>
                <?php endif; ?>
            </li>

            <?php for ($i = 1; $i <= $countPages; $i++): ?>
            <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                <a class="page-link" href="<?= $currentLink . $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?= ($nextPage === false) ? 'disabled' : '' ?>">
                <?php if ($nextPage !== false): ?>
                <a class="page-link" href="<?= $currentLink . $nextPage ?>">Next</a>
                <?php else: ?>
                <span class="page-link">Next</span>
                <?php endif; ?>
            </li>
        </ul>
                </form>
    </div>

    <?php if (isset($dataConteinerBook)) : ?>
    <div class="admin-book-info container mt-3 text-center d-flex justify-content-center">
        <div class="rounded-container">
            <div class="d-flex justify-content-end">
                <a href="/admin/page/?page=<?= $page ?>" class="btn btn-close"></a>
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
                        <img src="/public/images/<?= e($dataConteinerBook['img']) ?> "
                            alt="Зображення книги" class="img-thumbnail">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php include(__DIR__ . "/add-book-container.php"); ?>

</body>

</html>
