<div data-book-id="<?= $id ?>" class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
    <div class="book">
        <a href="/book/<?= $id ?>">
            <img src="/public/images/<?= e($img) ?>" alt="<?= e($title) ?>">
            <div data-title="<?= e($title) ?>" class="blockI" style="height: 46px;">
                <div data-book-title="<?= e($title) ?>" class="title size_text"><?= e($title) ?></div>
                <div data-book-author="<?= e($author) ?>" class="author"><?= e($author) ?></div>
            </div>
            <a href="/book/<?= $id ?>">
                <button type="button" class="details btn btn-success">Читати</button>
            </a>
        </a>
    </div>
</div>
