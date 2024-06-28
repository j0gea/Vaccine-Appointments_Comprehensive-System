<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>백신예약종합시스템 : 서비스 선택</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
        </script>

    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic+Coding&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />




    <style>
        *:not(span) {
            font-family: 'Noto Sans KR', sans-serif;
        }

        .mainblock {
            width: 700px;
            padding-top: 50px;
            margin: 10px auto;
            text-align: center;

        }

        #adminbutton {
            display: none;
        }

        .material-symbols-outlined {
            font-size: 50px;
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 50
        }

        #buttons {
            width: 250px;
            margin: 0px auto;
        }
    </style>


    </style>

    <script>
        $(document).ready(function () {
            var myID = sessionStorage.getItem("myID");
            if (myID == "999") {
                $('#adminbutton').show();
                $('#btn1').hide();
                $('#btn2').hide();

            }
        });

        function submitform() {
            var myID = sessionStorage.getItem("myID");
            // Check if myID is not null or undefined
            if (myID) {
                // Redirect to "./조회.php" with myID as a query parameter
                window.location.href = './reserved.php?id=' + myID;
            } else {
                // Handle the case when myID is not set
                alert("비정상적인 접근입니다.");
            }
        }
    </script>

</head>

<body>
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    include_once("./oracle.php");
    ?>

    <div class="mainblock">
        <div class="jumbotron">
            <h1 class="display-6" id="hello">안녕하십니까</h1>
            <hr class="my-4">
            <p>이용하실 서비스를 선택해주세요.</p>
            <div id="buttons">
                <div>
                    <a id="btn1" class="btn btn-info btn-lg" onclick="location.href='./vaccine_order.php'"
                        role="button"><span class="material-symbols-outlined">vaccines</span><br />백신 예약</a>
                    <a id="btn2" class="btn btn-primary btn-lg" onclick="submitform()" role="button"><span
                            class="material-symbols-outlined">Demography</span> <br />기록 조회</a>
                    <a id="btn3" style="display: none;" class="btn btn-danger btn-lg" role="button"><span
                            class="material-symbols-outlined">Error</span> <br />예약 불가</a>
                    <a id="adminbutton" class="btn btn-primary btn-lg" onclick="location.href='./admin_page.php'"
                        role="button">관리자 페이지</a>
                </div>
                <br>
                <div><a class="btn btn-primary btn-lg" onclick="location.href='./index.php'" role="button">나가기</a></div>

            </div>
        </div>
    </div>

    <?php
    putenv("NLS_LANG=KOREAN_KOREA.UTF8");
    putenv("NLS_LANG=KOREAN_KOREA.AL32UTF8");

    $PATIENT_ID = $_GET["id"];
    if ($PATIENT_ID == '999') {
        echo "<script>$('#hello').text('안녕하십니까, 관리자님');</script>";
    } else {

        $sql = "SELECT * FROM PATIENT WHERE PATIENT_ID = $PATIENT_ID";

        $stid = oci_parse($connect, $sql);
        oci_execute($stid);
        $result1 = oci_fetch_assoc($stid);
        $result = $result1["PNAME"];

        if ($result1) {
            echo "<script>$('#hello').text('안녕하십니까, $result 님');</script>";
        } else {
            echo "<script>alert('존재하지 않는 사용자 입니다.\\n회원번호를 다시 확인해 주세요.');
            location.href = './index.php';</script>";
        }

    }


    oci_close($connect);
    ?>
</body>

</html>