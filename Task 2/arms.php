<!DOCTYPE html>
<?php   require_once('Database_con.php');
if (isset($_POST['base_state'])) {
    $update= $mysqli->query("UPDATE base SET `state`=".$_POST['base_state']);
}
if (isset($_POST['arm_state'])) {
    $update= $mysqli->query("UPDATE arm SET `state`=".$_POST['arm_state']);
}
if (isset($_POST['array'])) {
    $update= $mysqli->query("UPDATE arm SET motor1=".$_POST['array'][0].",motor2=".$_POST['array'][1]."
    ,motor3=".$_POST['array'][2].",motor4=".$_POST['array'][3].",motor5=".$_POST['array'][4].",motor6=".$_POST['array'][5]);
}
if (isset($_POST['dir'])) {
    $update= $mysqli->query("UPDATE base SET direction='".$_POST['dir']."'");
}

?>
<html>

<head>
    <meta charset="UTF-8">
    <title>المحركات</title>
    <link rel="stylesheet" type=text/css href="motors.css">

</head>

<body>
<div style="display:flex">
    <div class="center">
        <?php $motors =  $mysqli->query("SELECT * FROM arm"); 
        $motors=$motors->fetch_All(); 

        for ($row = 0; $row < 6 ; $row++) {
        echo'<input class="motor_s" type="text" name="motor'.($row+1).'" value="'.$motors[0][$row].'" readonly>
        <input type="range" min="1" max="180" class="slider" id="slide'.$row.'">
        <h2 style="display: inline;">محرك '.($row+1).'</h2><br>';
        }
        
        echo'<input id="hid_toggle" type=hidden value="'.$motors[0][6].'">';?>

        <label class="switch">
            <input id="toggle" type="checkbox">
            <span class="slider2 round"></span>
        </label>
        <!-- <button id="save" class="button button--pan"><span>حــفــظ</span></button> -->
        <button id="save" class="arrow">حـفـظ</button>

    </div>
    <div class="center" style="padding: 136px 10px;">
            <?php 
            $query="SELECT direction from base";
            $query_result=mysqli_query($mysqli,$query) or die("Sorry there is no value" .mysql_error());
             while($row=mysqli_fetch_object($query_result)){
                echo'<input id="hid_dir" type=hidden value="'.$row->direction.'">';
            }
            $query2="SELECT `state` from base";
            $query_result2=mysqli_query($mysqli,$query2) or die("Sorry there is no value" .mysql_error());
             while($row2=mysqli_fetch_object($query_result2)){
                echo'<input id="hid_state" type=hidden value="'.$row2->state.'">';
            }
            ?>
            
            <div class="tr">
                <input type="radio" class="btnControl" name="dir" id="f"/>
                <label class="btn" for="f"><i class="arrow fas fa-arrow-circle-up"></i></label>
                
            </div>
            <div class="tr">
                <input type="radio" class="btnControl" name="dir" id="l"/>
                <label class="btn" for="l"><i style="transform: rotate(270deg);" class="arrow fas fa-arrow-circle-up"></i></label>

                <input type="checkbox" class="btnControl" id="s"/>
                <label class="btn" for="s"><i class="arrow fas fa-stop-circle"></i></label>

                <input type="radio" class="btnControl" name="dir" id="r"/>
                <label class="btn" for="r"><i style="transform: rotate(90deg);"class="arrow fas fa-arrow-circle-up"></i></label>
                
            </div>
            <div class="tr">
               
                <input type="radio" class="btnControl" name="dir" id="b"/>
                <label class="btn" for="b"> <i style="transform: rotate(180deg);"class="arrow fas fa-arrow-circle-up"></i></label>

            </div>



    </div>
</div>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.4.min.js"></script>
    <script>
    var s0 = document.getElementById("slide0");
    var s1 = document.getElementById("slide1");
    var s2 = document.getElementById("slide2");
    var s3 = document.getElementById("slide3");
    var s4 = document.getElementById("slide4");
    var s5 = document.getElementById("slide5");
    var toggle = document.getElementById("toggle");
    var s0_prev=s0.previousElementSibling;
    var s1_prev=s1.previousElementSibling;
    var s2_prev=s2.previousElementSibling;
    var s3_prev=s3.previousElementSibling;
    var s4_prev=s4.previousElementSibling;
    var s5_prev=s5.previousElementSibling;


    // use 'change' instead to see the difference in response
    s0.addEventListener('input', function() {
        s0_prev.value = s0.value;
    }, false);
    s1.addEventListener('input', function() {
        s1_prev.value = s1.value;
    }, false);
    s2.addEventListener('input', function() {
        s2_prev.value = s2.value;
    }, false);
    s3.addEventListener('input', function() {
        s3_prev.value = s3.value;
    }, false);
    s4.addEventListener('input', function() {
        s4_prev.value = s4.value;
    }, false);
    s5.addEventListener('input', function() {
        s5_prev.value = s5.value;
    }, false);

    function set_slides(){
        s0.value=s0_prev.value;
        s1.value=s1_prev.value;
        s2.value=s2_prev.value;
        s3.value=s3_prev.value;
        s0.value=s4_prev.value;
        s5.value=s5_prev.value;
    }
    function set_direction(){
        var current_dir=document.getElementById('hid_dir');
        document.getElementById(current_dir.value).checked=true;
        var current_state=document.getElementById('hid_state');
        var state_button=document.getElementById('s');
        if (current_state.value==1)
            state_button.checked=true;
        else
            state_button.checked=false;

    }

    window.onload= function(){
        set_slides();
        set_direction();
    if (document.getElementById("hid_toggle").value==0){
        document.getElementById("toggle").checked = false;

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
        console.log(toggleValue);
        var ajaxResp =$.ajax({
            url: 'arms.php',
            type: 'post',
            data: {arm_state:toggleValue}
        });

    })
    var save= document.getElementById("save");
    save.addEventListener('click',function(){
        var motorsArray= [s0.value,s1.value,s2.value,s3.value,s4.value,s5.value];
        var ajaxResp =$.ajax({
            url: 'arms.php',
            type: 'post',
            data: {array:motorsArray}
        });
    })
    var dir=document.querySelector('input[name="dir"]');
    document.querySelectorAll('input[name="dir"]').forEach((elem) => {
    elem.addEventListener("change", function(event) {

        var ajaxResp =$.ajax({
            url: 'arms.php',
            type: 'post',
            data: {dir:this.id}
        });

    });
  })


    var stop=document.getElementById("s");
    stop.addEventListener('change',function(){
        var base_state;
        if (stop.checked==true){
            base_state=1;
        }
        else{
            base_state=0;
        }
        var ajaxResp =$.ajax({
            url: 'arms.php',
            type: 'post',
            data: {base_state:base_state}
        });
    })
    </script>
</body>

</html>