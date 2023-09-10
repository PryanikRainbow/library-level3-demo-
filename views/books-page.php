<!DOCTYPE html>

<?php render(__DIR__ . '/header.php');?>

<!-- saved from url=(0054)file:///home/andy/Desktop/books-page/shpp-library.html -->
<html lang="ru">

    <section id="main" class="main-wrapper">

       <?php 
       if ($searchMessage !== false){
        echo '<div class="searchMessage">' . e($searchMessage) . '</div>';
       }
       ?>
    
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
           <?php if ($searchMessage != false) : ?>
               <a href="/?select-by=<?= urlencode($_GET['select-by']) ?>&search-book=<?= urlencode($_GET['search-book']) ?>&offset=<?= $pre ?>">
                    <button type="button" class="details btn btn-success" <?= $isFirstPage == true ? 'disabled' : '' ?>>Назад</button>
                </a>
                <a href="/?select-by=<?= urlencode($_GET['select-by']) ?>&search-book=<?= urlencode($_GET['search-book']) ?>&offset=<?= $next ?>"> 
                   <button type="button" class="details btn btn-success" <?= $isLastPage == true ? 'disabled' : '' ?>>Вперед</button>
                </a>
            <?php else : ?>
                <a href="/?offset=<?= urlencode($pre) ?>">
                    <button type="button" class="details btn btn-success" <?= $isFirstPage == true ? 'disabled' : '' ?>>Назад</button>
                 </a>
                 <a href="/?offset=<?= urlencode($next) ?>"> 
                    <button type="button" class="details btn btn-success" <?= $isLastPage == true ? 'disabled' : '' ?>>Вперед</button>
                 </a>
             <?php endif; ?>
             </center>
 
    </section>

    <?php render(__DIR__ . '/footer.php');?>

</html>
