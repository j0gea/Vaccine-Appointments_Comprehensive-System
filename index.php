<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>백신예약종합시스템</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
        </script>

    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic+Coding&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Noto Sans KR', sans-serif;
        }

        .mainblock {
            width: 1000px;
            padding-top: 50px;
            margin: 10px auto;

        }
    </style>

    <script>
        function jsID() {
            var myID = document.getElementById('jsid').value;
            sessionStorage.setItem("myID", myID);
        }

    </script>

</head>

<body>
    <?php
    include_once("./oracle.php");
    ?>
    <div class="mainblock">
        <div class="jumbotron">
            <h1 class="display-4">백신예약종합시스템</h1>
            <p class="lead">백신예약종합시스템에 오신 것을 환영합니다.</p>
            <hr class="my-4">

            <div class="btns">
                <p>
                    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button"
                        aria-expanded="false" aria-controls="collapseExample">
                        회원 접속</a>
                    <a class="btn btn-primary" data-toggle="collapse" onclick="location.href='./signup.php'"
                        role="button" aria-expanded="false" aria-controls="collapseExample">
                        회원 등록</a>
                </p>
                <div class="collapse" id="collapseExample" style>
                    <form action="./myinfo.php" method="get">
                        <div class="form-group">
                            <label>회원번호를 입력해주세요.</label>
                            <input id="jsid" type="text" name="id" class="form-control">
                            <small class="form-text text-muted"></small>
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="jsID()">접속</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>

</html>