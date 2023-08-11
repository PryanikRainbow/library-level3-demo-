<!DOCTYPE html>
<html lang="ru">

    <section id="main" class="main-wrapper">
        <div class="container">
            <div id="content" class="book_block col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <script id="pattern" type="text/template">
                    <div data-book-id="<?= $id ?>" class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
                        <div class="book">
                            <a href="<?= '/public/images/' . e($img) ?>"><img src=<?= '/public/images/'. $img ?> alt="<?= e($title) ?>">
                                    <div data-title="<?= 'title' ?>" class="blockI">
                                    <div data-book-title="<?= 'title' ?>" class="title size_text"><?= e($title) ?></div>
                                    <div data-book-author="<?= 'author' ?>" class="author"><?= e($author) ?></div>
                                </div>
                            </a>
                            <a href="<?= e('/views/book-page.php?id=' . $id) ?>">
                                <button type="button" class="details btn btn-success">Читать</button>
                            </a>
                        </div>
                    </div>
                </script>
                <div id="id" book-id="<?= $id ?>">
                    <div id="bookImg" class="col-xs-12 col-sm-3 col-md-3 item" style=" margin:0px;">
<img src="<?= e('/public/images/' . $img) ?>" alt="Responsive image" class="img-responsive">                     
                        <hr>
                    </div>
                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 info">
                        <div class="bookInfo col-md-12">
                            <div id="title" class="titleBook"><?= e($title) ?></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="bookLastInfo">
                                <div class="bookRow"><span class="properties">автор:</span><span id="author"><?= e($author) ?></span></div>
                                <div class="bookRow"><span class="properties">год:</span><span id="year"><?= $year ?></span></div>
                                <div class="bookRow"><span class="properties">страниц:</span><span id="pages"> <?= $pages ?> </span></div>
                                <div class="bookRow"><span class="properties">isbn:</span><span id="isbn"><?= e($isbn) ?></span></div>
                            </div>
                        </div>
                        <div class="btnBlock col-xs-12 col-sm-12 col-md-12">
                            <button type="button" class="btnBookID btn-lg btn btn-success">Хочу читать!</button>
                        </div>
                        <div class="bookDescription col-xs-12 col-sm-12 col-md-12 hidden-xs hidden-sm">
                            <h4>О книге</h4>
                            <hr>
                            <p id="description"><?= e($description) ?></p>
                        </div>
                    </div>
                    <div class="bookDescription col-xs-12 col-sm-12 col-md-12 hidden-md hidden-lg">
                        <h4>О книге</h4>
                        <hr>
                        <p class="description"><?= e($description) ?></p>
                    </div>
                </div>
                <script src="/public/js/book.js" defer=""></script>
            </div>
        </div>
    </section>


</html>



