<?php
if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

    <link rel="stylesheet" href="index.css" />
</head>
<script src="index.js" defer></script>

<body>
    <?php
    include(ROOT_DIR . './shared/nav-toolbar.php')
    ?>

    <!-- BootStrap form -->
    <div class="login-form container-fluid">
        <h1>Insert Product</h1>
        <div class="container-fluid">
            <form action="insert.php" method="post" class="product-form w-100" enctype="multipart/form-data">
                <div class="form-group row w-100">
                    <label for="pictureTitle" class="col-sm-1-12 col-form-label">Picture Title</label>
                    <div class="col-sm-1-12">
                        <input type="text" class="form-control" name="pictureTitle" id="pictureTitle"
                            placeholder="title">
                    </div>
                </div>
                <div class="form-group row w-100">
                    <label for="picturePrice" class="col-sm-1-12 col-form-label">Picture Price</label>
                    <div class="col-sm-1-12">
                        <input type="number" class="form-control" name="picturePrice" id="picturePrice" value=0.05
                            min="0" max="100" step="0.01">
                    </div>
                </div>
                <div class="form-group row w-100">
                    <label for="pictureDescription" class="col-sm-1-12 col-form-label">Picture Details</label>
                    <div class="col-sm-1-12">
                        <input type="text" class="form-control" name="pictureDescription" id="pictureDescription">
                    </div>
                </div>
                <div class="form-group row w-100">
                    <label for="pictureImage" class="col-sm-1-12 col-form-label">Picture Image</label>
                    <div class="col-sm-1-12">
                        <input type="file" class="form-control" name="pictureImage" id="pictureImage" value=0.05
                            min="0" max="100" step="0.01">
                    </div>
                </div>
                <div class="form-group row w-100">
                    <?php 
                        include ROOT_DIR.'./utils/php/dao.php';
                        $tags = retrieve_all_tags();
                    ?>
                    <label for="tags" class="col-sm-1-12 col-form-label">Picture Tags</label>
                    <div class="col-sm-1-12">
                        <select name="tags[]" id="tags" multiple>
                            <?php foreach ($tags as $tag) : ?>
                                <option value=<?php echo $tag['tag_id']?>><?php echo $tag['name'];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Add Picture</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>