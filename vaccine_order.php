<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>백신예약종합시스템 : 백신 예약</title>

  <!-- bootstrap, 제이쿼리, 구글 폰트 -->
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

    #hospitalBlock,
    #dateBlock,
    #timeBlock {
      display: none;
    }
  </style>

  <?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  include_once("./oracle.php");

  putenv("NLS_LANG=KOREAN_KOREA.UTF8");
  putenv("NLS_LANG=KOREAN_KOREA.AL32UTF8");
  ?>

  <script>
    let today = new Date(); let year = today.getFullYear(); let month = (today.getMonth() + 1).toString().padStart(2, '0');
    let day = today.getDate().toString().padStart(2, '0'); // 두자리수가 아니면 앞에 0 추가

    let todayStr = `${year}-${month}-${day}`;
    //alert(todayStr);

    let dayEnd = new Date(); dayEnd.setDate(today.getDate() + 14);
    year = dayEnd.getFullYear(); month = (dayEnd.getMonth() + 1).toString().padStart(2, '0');
    day = dayEnd.getDate().toString().padStart(2, '0'); // 두자리수가 아니면 앞에 0 추가

    let endStr = `${year}-${month}-${day}`;
    //alert(endStr);
  
    $(document).ready(function () {
      showTemplet()
    });

    
    function showTemplet() { // get 정보에 따라 Templet을 보여주는 함수

      // 1. get 파라메터 값을 받아온다. 
      var url = window.location.href; // 현재 주소
      var amper = 0; 

      url = url.split("php")[1]; // php 이후의 주소만 잘라냄

      // (1) vaccine이 파라메터 값으로 있을 때 -> 병원 공개
      if (url.includes("vaccine")) { 
        $("#hospitalBlock").show();

        // 2. 다음으로 값을 넘겨주기 위해 가공한다.
        url1 = url.split("?")[1].split("=")[1]; // 여러 파라메터 중 한 값만 선택

        // 만약 여러 개의 파라메터일 때. 값에 &가 붙기 때문에 제거해준다.
        if (url1.includes("&")) {
          amper = url1.indexOf('&');
          url1 = url1.slice(0, amper);
        }
        // 만약 URL 디코딩이 되어있을 때, 풀어준다.
        if (url1.startsWith("%")) {
          url1 = decodeURIComponent(url1);
        }

        // 3. 가공이 끝나면 값을 담아준다.
        var vaccine = (url1);

        // 4. 가공이 끝난 값을 다음에도 넘겨줄 수 있도록 보이지 않는 input 객체를 추가해준다.
        $('#hospitalForm').prepend(`
        <input style="display: none;" name="vaccine" type="text" value="${vaccine}">
        `);

        // (2) hospital이 파라메터 값으로 있을 때 -> 날짜 공개
        if (url.includes("hospital")) {
          $("#dateBlock").show();

          url2 = url.split("?")[1].split("=")[2];

          if (url2.includes("&")) {
            amper = url2.indexOf('&');
            url2 = url2.slice(0, amper);
          }
          if (url2.startsWith("%")) {
            url2 = decodeURIComponent(url2);
          }

          var hospital = (url2);

          $('#dateForm').prepend(`
          <input style="display: none;" name="vaccine" type="text" value=${vaccine}>
          <input style="display: none;" name="hospital" type="text" value=${hospital}>
          <div>

          <p>날짜를 선택해주세요</p>
          <input name="date" value=${todayStr} min=${todayStr} max=${endStr} type="date">
          </div>
          `);

          // (3) date가 파라메터 값으로 있을 때 -> 시간 공개
          if (url.includes("date")) {
            $("#timeBlock").show();

            url3 = url.split("?")[1].split("=")[3];

            if (url3.includes("&")) {
              amper = url3.indexOf('&');
              url3 = url3.slice(0, amper);
            }
            if (url3.startsWith("%")) {
              url3 = decodeURIComponent(url3);
            }

            var date = (url3);

            // 유저 아이디 session 에서 불러오기, 마지막으로 최종 전송할 준비
            var myID = sessionStorage.getItem("myID");

            $('#timeForm').prepend(`
            <input style="display: none;" name="vaccine" type="text" value=${vaccine}>
            <input style="display: none;" name="hospital" type="text" value=${hospital}>
            <input style="display: none;" name="id" type="text" value=${myID}>
            `);
          }
        }
      }
      // 선택한 부분을 보여주는 코드
      $('#status').append(`병원 선택 : ${hospital}<br>`);
      $('#status').append(`백신 선택 : ${vaccine}<br>`);
      $('#status').append(`날짜 선택 : ${date}<br>`);
    }

  </script>




</head>

<body>

  <!-- 구조: mainblock > vaccineBlock, hospitalBlock, dateBlock, timeBlock -->
  <div class="mainblock">
    <div class="jumbotron">
      <h1 class="display-6">백신 접종 예약</h1>
      <hr class="my-4">
      <div id="status"></div>
      <hr class="my-4">

      <!-- 백신 블록 -->
      <div id="vaccineBlock">
        <form action="./vaccine_order.php" method="GET">
          <div class="form-group">
            <label id="vaccineText" for="Select1">백신을 선택해주세요</label>
            <select name="vaccine" class="form-control" id="Select1">

              <?php
              $sql = "SELECT DISTINCT VNAME FROM VACCINE";
              $result = oci_parse($connect, $sql);
              oci_execute($result);

              while (($row = oci_fetch_array($result, OCI_BOTH)) != false) {
                echo ("<option>$row[0]</option>");
              }
              ?>

            </select>
            <br>
            <button type="submit" class="btn btn-primary">백신 선택</button>
          </div>
        </form>
      </div>

      <!-- 병원 블록 -->
      <div id="hospitalBlock">
        <hr class="my-4">
        <form action="./vaccine_order.php" method="GET">
          <div id="hospitalForm" class="form-group">
            <label id="hospitalText" for="Select2">병원을 선택해주세요</label>
            <select name="hospital" class="form-control" id="Select2">

              <?php
              $VACCINE = $_GET["vaccine"];
              $sql = "SELECT hospital.hname FROM hospital_has_vaccine
                INNER JOIN hospital
                ON hospital_has_vaccine.hospital_id = hospital.hospital_id
                INNER JOIN vaccine
                ON vaccine.vaccine_id = hospital_has_vaccine.vaccine_id
                WHERE vaccine.vname = '$VACCINE'";
              $result = oci_parse($connect, $sql);
              oci_execute($result);

              while (($row = oci_fetch_array($result, OCI_BOTH)) != false) {
                echo ("<option >$row[0]</option>");
              }
              ?>

            </select>
            <br>
            <button type="submit" class="btn btn-primary">병원 선택</button>
          </div>
        </form>
      </div>

      <!-- 날짜 블록 -->
      <div id="dateBlock">
        <hr class="my-4">
        <form action="./vaccine_order.php" method="GET">
          <div id="dateForm" class="form-group">
            <div>
              <br>
              <button type="submit" class="btn btn-primary">날짜 선택</button>
            </div>
          </div>
        </form>
      </div>

      <!-- 시간 블록 -->
      <div id="timeBlock">
        <hr class="my-4">
        <form action="./getvaccine_order.php" method="GET">
          <div id="timeForm" class="form-group">
            <label for="Select2">시간을 선택해주세요</label>
            <select name="time" class="form-control" id="Select2">

              <?php
              $HOSPITAL = $_GET["hospital"];
              $date = $_GET["date"];
              $sql = "SELECT to_char(time_reserved.res_date, 'YYYY-MM-DD HH24:MI') FROM time_reserved
                INNER JOIN hospital
                ON hospital.hospital_id = time_reserved.hospital_id
                WHERE hospital.hname ='$HOSPITAL' AND
                to_char(time_reserved.res_date, 'YYYY-MM-DD') = '$date'";
              $result = oci_parse($connect, $sql);
              oci_execute($result);
              $times = array("10:00", "11:00", "12:00", "14:00", "15:00", "16:00", "17:00", "18:00");

              while (($row = oci_fetch_array($result, OCI_BOTH)) != false) {
                $timeHtml = substr($row[0], 11, 5);
                $times = array_diff($times, array("$timeHtml"));
                #echo("<option>$timeHtml</option>");
              }
              
              $space = " ";
              foreach ($times as $t) {
                $valuet = $date . $space . $t;
                echo ("<option value = '$valuet'>$t</option>");
              }
              ?>

            </select>
            <br>
            <button type="submit" class="btn btn-primary">접종 예약</button>
          </div>
        </form>

      </div>
    </div>
  </div>

</body>

</html>