<!DOCTYPE html>
<?php   require_once('Database_con.php');

if (isset($_GET['state'])) {
    $update= $mysqli->query("UPDATE motors SET state=".$_GET['state']);
}
if (isset($_GET['array'])) {
    $update= $mysqli->query("UPDATE motors SET motor1=".$_GET['array'][0].",motor2=".$_GET['array'][1]."
    ,motor3=".$_GET['array'][2].",motor4=".$_GET['array'][3].",motor5=".$_GET['array'][4].",motor6=".$_GET['array'][5]);
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <title>المحركات</title>
    <link rel="stylesheet" type=text/css href="motors.css">

</head>

<body>

    <div class="center">
        <?php $motors =  $mysqli->query("SELECT * FROM motors"); 
        $motors=$motors->fetch_All(); 

        for ($row = 0; $row < 6 ; $row++) {
        echo'<input class="motor_s" type="text" name="motor'.($row+1).'" value="'.$motors[0][$row].'" readonly>
        <input type="range" min="1" max="180" class="slider" id="slide'.$row.'">
        <h2 style="display: inline;">محرك '.($row+1).'</h2><br>';
        }
        
        echo'<input id="hidtoggle" type=hidden value="'.$motors[0][6].'">';?>

        <label class="switch">
            <input id="toggle" type="checkbox">
            <span class="slider2 round"></span>
        </label>
        <button id="save" class="button button--pan"><span>حــفــظ</span></button>

    </div>

    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.4.min.js"></script>
    <script>
    var s0 = document.getElementById("slide0");
    var s1 = document.getElementById("slide1");
    var s2 = document.getElementById("slide2");
    var s3 = document.getElementById("slide3");
    var s4 = document.getElementById("slide4");
    var s5 = document.getElementById("slide5");
    var toggle = document.getElementById("toggle");

    // use 'change' instead to see the difference in response
    s1.addEventListener('input', function() {
        s1.previousElementSibling.value = s1.value;
    }, false);
    s2.addEventListener('input', function() {
        s2.previousElementSibling.value = s2.value;
    }, false);
    s3.addEventListener('input', function() {
        s3.previousElementSibling.value = s3.value;
    }, false);
    s4.addEventListener('input', function() {
        s4.previousElementSibling.value = s4.value;
    }, false);
    s5.addEventListener('input', function() {
        s5.previousElementSibling.value = s5.value;
    }, false);
    s0.addEventListener('input', function() {
        s0.previousElementSibling.value = s0.value;
    }, false);
    
    window.onload= function(){
    if (document.getElementById("hidtoggle").value==0){
        document.getElementById("toggle").checked = false;
        console.log(document.getElementById('hidtoggle').checked);

    }
    else
        document.getElementById("toggle").checked=true;
    }
    toggle.addEventListener('change', function(){
        var toggleValue;
        if (toggle.checked==true)
            toggleValue=1;
         else 
            toggleValue=0

        var ajaxResp =$.ajax({
            url: 'arms.php',
            type: 'get',
            data: {state:toggleValue}
        });

    })
    var save= document.getElementById("save");
    save.addEventListener('click',function(){
        var motorsArray= [s0.value,s1.value,s2.value,s3.value,s4.value,s5.value];
        var ajaxResp =$.ajax({
            url: 'arms.php',
            type: 'get',
            data: {array:motorsArray}
        });
    })

    </script>
</body>

</html>