<!DOCTYPE html>

<!-- переписати лінки -->
<!-- saved from url=(0054)file:///home/andy/Desktop/books-page/shpp-library.html -->
<html lang="ru">

    <section id="main" class="main-wrapper">

        <div class="container">
            <div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <?php
                foreach ($dataBooks as $dataBook) {
                    render(__DIR__ . '/book-container.php', $dataBook);
                }
                ?>
                
            </div>
        </div>
        <center>
           <a href=" <?= '/offset/' . $pre ?>">
           <button type="button" class="details btn btn-success">Назад</button>
            </a>
            <a href=" <?= '/offset/' . $next ?>"> 
            <button type="button" class="details btn btn-success">Вперед</button>
            </a>
        </center>

    </section>


</html>
