<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Calendar PHP</title>
</head>
<body>
    <div>
        <form method="post">
            <input type="submit" name="prev" value="Prev">
            <input type="submit" name="curr" value="Curr">
            <input type="submit" name="next" value="Next">
        </form>
    </div>
    <table>
    <?php
    $specialChars = htmlspecialchars($_GET["date"]);
    $specialCharsExploded = explode("-", $specialChars);
    echo($specialCharsExploded[0]."-".$specialCharsExploded[1]."-".$specialCharsExploded[2]);
    $day = 01;
    $month = $specialCharsExploded[1];
    $date = date("Y-$month-$day");

    while((strtotime($date)) <= strtotime(date(("Y-$month") . '-' . date('t', strtotime($date))))){
        $day_num = date('j', strtotime($date));//Day number
        $day_name = date('l', strtotime($date));//Day name
        $week_nr = date('W', strtotime($date));
        $day = "$day_name $day_num";
        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));//Adds 1 day onto current date
        if($day_name == "Sunday"){
            echo "<tr><td style='color:red;'>".$day. '</td></tr>';
        }else if($day_name == "Monday"){
            echo "<tr><td>".$day." v.".$week_nr.'</td></tr>';
        }else{
            echo "<tr><td>".$day. '</td></tr>';
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {      
        if (isset($_POST['prev'])) {
            if(($specialCharsExploded[1]-1) <= 0){
                $specialCharsExploded[1] = 12;
                $specialCharsExploded[0] -= 1;
                header("Location: https://localhost/phpCalendar/?date=".($specialCharsExploded[0])."-".($specialCharsExploded[1])."-01");
            }else{
                header("Location: https://localhost/phpCalendar/?date=".($specialCharsExploded[0])."-".($specialCharsExploded[1]-1)."-01");
            }
        } else if(isset($_POST['curr'])){
            header("Location: https://localhost/phpCalendar/?date=".($specialCharsExploded[0])."-".($specialCharsExploded[1])."-01");
        }else{
            echo($specialCharsExploded[1]);
            if(($specialCharsExploded[1]+1) >= 13){
                $specialCharsExploded[1] = 1;
                $specialCharsExploded[0] += 1;
                header("Location: https://localhost/phpCalendar/?date=".($specialCharsExploded[0])."-".($specialCharsExploded[1])."-01");
            }else{
                header("Location: https://localhost/phpCalendar/?date=".($specialCharsExploded[0])."-".($specialCharsExploded[1]+1)."-01");
            }
        }
      }
    ?>
    </table>
</body>
</html>