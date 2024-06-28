<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>백신예약종합시스템 : 백신 예약</title>
</head>
<body>
    
    <?php
    error_reporting(E_ALL); 
    ini_set("display_errors", 1);
    
    include_once("./oracle.php");

    putenv("NLS_LANG=KOREAN_KOREA.UTF8");
    putenv("NLS_LANG=KOREAN_KOREA.AL32UTF8");

    $PATIENT_ID = $_GET["id"]; 
    $RES_DATE = $_GET["time"];
    $HOSPITAL_ID = $_GET["hospital"];
    $VACCINE_ID = $_GET["vaccine"];


    $sql = "SELECT * FROM vaccination_history
    INNER JOIN vaccine
    ON vaccine.vaccine_id = vaccination_history.vaccine_id
    WHERE vaccine.vname = '$VACCINE_ID' AND vaccination_history.patient_id = '$PATIENT_ID'";
    $stid = oci_parse($connect, $sql);
    oci_execute($stid);
    $result = oci_fetch_assoc($stid);


    if ($result){
        echo"<script>alert('$VACCINE_ID 중복 접종입니다.');
        location.href = './myinfo.php?id=$PATIENT_ID';
        </script>";

    } else{



    $HOSPITAL_NAME = $HOSPITAL_ID;
    $VACCINE_NAME = $VACCINE_ID;

    // 1. vaccine id
    $sql = "SELECT * FROM hospital_has_vaccine
    INNER JOIN hospital
    ON hospital_has_vaccine.hospital_id = hospital.hospital_id
    INNER JOIN vaccine
    ON vaccine.vaccine_id = hospital_has_vaccine.vaccine_id
    WHERE hospital.hname = '$HOSPITAL_ID' AND vaccine.vname = '$VACCINE_ID'";
    $stid = oci_parse($connect, $sql);
    oci_execute($stid);
    $result = oci_fetch_assoc($stid);
    $VACCINE_ID = $result['VACCINE_ID'];
    oci_free_statement($stid);
    // echo("vaccine id: $VACCINE_ID <br>");
    
    // 2. hospital id
    $sql = "SELECT * FROM hospital WHERE hname = '$HOSPITAL_ID'";
    $stid = oci_parse($connect, $sql);
    oci_execute($stid);
    $result = oci_fetch_assoc($stid);
    $HOSPITAL_ID = $result['HOSPITAL_ID'];
    oci_free_statement($stid);
    // echo("hospital id: $HOSPITAL_ID <br>");




    $sql = "INSERT INTO TIME_RESERVED(PATIENT_ID, RES_DATE, HOSPITAL_ID, VACCINE_ID) 
    VALUES($PATIENT_ID, to_date('$RES_DATE', 'YYYY-MM-DD HH24:MI'), $HOSPITAL_ID, $VACCINE_ID)";
    $stid = oci_parse($connect, $sql);
    $re = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

    oci_free_statement($stid);
    oci_close($connect);

    

    if($re){
        echo"<script>alert('예약날짜: $RES_DATE\\n병원: $HOSPITAL_NAME\\n백신: $VACCINE_NAME\\n정상예약완료 되었습니다.\\n정해진 날짜에 꼭 병원을 찾아주세요.');
        location.href = './myinfo.php?id=$PATIENT_ID';
        </script>";
    } else{
        echo '<h2> 예약 실패 </h2>';
        echo"<script>alert('예약에 실패했습니다. 이미 예약하신 기록이 있으시거나 잘못된 요청일 수 있습니다.');
        location.href = './myinfo.php?id=$PATIENT_ID';
        </script>";
    }
}

    ?>    
</body>
</html>