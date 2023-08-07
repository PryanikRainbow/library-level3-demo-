<div data-book-id="<?php $id ?>" class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
    <div class="book">
    <a href="https://library-shpp-v1.local/views/book-page.php?id=<?php echo $id ?>">
    <img src="https://library-shpp-v1.local/public/images/<?php echo $img ?>" alt="<?php echo $title ?>">
    <div data-title="<?php echo $title ?>" class="blockI" style="height: 46px;">
        <div data-book-title="<?php echo $title ?>" class="title size_text"><?php echo $title ?></div>
        <div data-book-author="<?php echo $author ?>" class="author"><?php echo $author ?></div>
    </div>
    <a href="https://library-shpp-v1.local/views/book-page.php?id=<?php echo $id ?>">
        <button type="button" class="details btn btn-success">Читать</button>
    </a>
</a>
    </div>
</div> 
