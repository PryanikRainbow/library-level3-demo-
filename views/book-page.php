<!DOCTYPE html>
<html lang="ru">

    <section id="main" class="main-wrapper">
        <div class="container">
            <div id="content" class="book_block col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <script id="pattern" type="text/template">
                    <div data-book-id="<?php echo $id ?>" class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
                        <div class="book">
                            <!-- todo (1-url)-->
                            <a href="<?php echo 'https://library-shpp-v1.local/public/images/' . $img ?>"><img src=<?php echo 'https://library-shpp-v1.local/public/images/'. $img ?> alt="<?php echo $title ?>">
                                <div data-title="<?php echo 'title' ?>" class="blockI">
                                    <div data-book-title="<?php echo 'title' ?>" class="title size_text"><?php echo $title; ?></div>
                                    <div data-book-author="<?php echo 'author' ?>" class="author"><?php echo 'author' ?></div>
                                </div>
                            </a>
                            <a href="<?php echo 'https://library-shpp-v1.local/views/book-page.php?id=' . $id ?>">
                                <button type="button" class="details btn btn-success">Читать</button>
                            </a>
                        </div>
                    </div>
                </script>
                <div id="id" book-id="<?php echo $id ?>">
                    <div id="bookImg" class="col-xs-12 col-sm-3 col-md-3 item" style="
    margin:0px;
"><img src="<?php echo 'https://library-shpp-v1.local/public/images/' . $img ?>" alt="Responsive image" class="img-responsive">
                        
                        <hr>
                    </div>
                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 info">
                        <div class="bookInfo col-md-12">
                            <div id="title" class="titleBook"></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="bookLastInfo">
                                <div class="bookRow"><span class="properties">автор:</span><span id="author"><?php echo $author ?></span></div>
                                <div class="bookRow"><span class="properties">год:</span><span id="year"><?php echo $year ?></span></div>
                                <div class="bookRow"><span class="properties">страниц:</span><span id="pages"> <?php echo $pages ?> </span></div>
                                <div class="bookRow"><span class="properties">isbn:</span><span id="isbn"><?php echo $isbn ?></span></div>
                            </div>
                        </div>
                        <div class="btnBlock col-xs-12 col-sm-12 col-md-12">
                            <button type="button" class="btnBookID btn-lg btn btn-success">Хочу читать!</button>
                        </div>
                        <div class="bookDescription col-xs-12 col-sm-12 col-md-12 hidden-xs hidden-sm">
                            <h4>О книге</h4>
                            <hr>
                            <p id="description"><?php echo $description ?></p>
                        </div>
                    </div>
                    <div class="bookDescription col-xs-12 col-sm-12 col-md-12 hidden-md hidden-lg">
                        <h4>О книге</h4>
                        <hr>
                        <p class="description"><?php echo $description ?></p>
                    </div>
                </div>
                <script src="https://library-shpp-v1.local/public/js/book.js" defer=""></script>
            </div>
        </div>
    </section>


</html>



