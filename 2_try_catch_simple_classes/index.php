<?php
declare(strict_types=1);
error_reporting(-1);
ini_set('display-errors', '1');
?>
<head>
    <meta charset="UTF-8">
    <title>Classes and tests</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,initial-scale=1.0,maximum-scale=1.0,user-scalable=no,viewport-fit=cover">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <style>
        .card {
            min-width: 300px;
        }
        input[type='file'] {
            opacity:0;
        }
        #val {
            display: none;
            pointer-events: none;
        }
        #button {
            cursor: pointer;
            display: inline-block;
            text-align: center;
            -webkit-transition: 500ms all;
            -moz-transition: 500ms all;
            transition: 500ms all;
        }
        #button:hover {
            background-color: blue;
        }
    </style>
</head>
<div class="content contact-form">
    <div class="card my-5 px-5 col-6 mx-auto bg-info">
        <div class="d-flex row card-title w-100 justify-content-center ">
            <h4 class="my-4">Image Resize Form</h4>
        </div>
        <div class="card-body">
            <div id="errors" class="alert alert-warning alert-dismissible fade show <?php echo ($_SESSION['id']['errors']) ? "" : "d-none"; ?>" role="alert">
                <p><?php echo ($_SESSION['id']['errors']) ? implode(' ', $_SESSION['id']['errors']) : '' ?></p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" action="/resize.php" method="POST" data-ajax="false">

                <div class="row">
                    <div class="form-group mx-1">
                        <label for="x-res">New x resolution</label>
                        <input type="number" name="x-res" id="x-res" min="20" max="3000">
                    </div>

                    <div class="form-group mx-1">
                        <label for="y-res">New y resolution</label>
                        <input type="number" name="y-res" id="y-res" min="15" max="2000">
                    </div>
                </div>


                <div class="row buttons">
                    <div class="form-group d-inline-flex justify-content-around  w-100">
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo ini_get('upload_max_filesize') ?>" />
                        <input class="d-none" name="userfile[]" id="userfile[]" type="file" /><span id='val'></span>
                            <span class="btn btn-primary d-block" id='button'>Select File</span>
                        <input class="btn btn-primary d-block" type="submit" id="btnResize"  value="Resize file" />
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    $('#button').click(function () {
        $("input[type='file']").trigger('click');
    });

    $("input[type='file']").change(function () {
        $('#val').text(this.value.replace(/C:\\fakepath\\/i, ''))
    });
    // $(document).on('change', 'input[type="file"]', function () {
    //     $('#button').text('Loaded');
    //     $('input[type="file"]').prop("disabled", true);
    // });
    $(document).on('click', '#btnResize', function () {
        let url = '/resize.php?x-res='+$('#x-res').val()+"&y-res="+$('#y-res').val();
        $.ajax({
            url,
            type: 'get',
            success: function(data){
                window.open(url)
            },
            error: function (data) {
                alert("Resize error"+JSON.stringify(data))
            }
        });
    });
</script>
</body>
</html>