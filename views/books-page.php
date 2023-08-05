<!DOCTYPE html>

<!-- saved from url=(0054)file:///home/andy/Desktop/books-page/shpp-library.html -->
<html lang="ru">

    <section id="main" class="main-wrapper">
        <div class="container">
            <div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                foreach ($data as $dataBook) {
                    render(__DIR__ . '/book-container.php', $dataBook);
                }
                ?>
            </div>
        </div>
        <center>оопс... в этом хтмл не реализованы кнопки "вперед" и "назад", а книг на странице должно быть не больше 20
        </center>
    </section>


</html>
