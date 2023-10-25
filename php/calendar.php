<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/./phpstuff/phpCalendar/css/calendar.css">
    <title>Calendar PHP</title>
</head>
<body>
    <div>
        <a href="/./phpstuff/phpCalendar/index.php">Home</a>
        <form method="post">
            <input type="submit" name="prev" value="Prev">
            <input type="submit" name="curr" value="Curr">
            <input type="submit" name="next" value="Next">
        </form>
    </div>
    <main>
        <div class="tableContainer">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Nr</th>
                        <th scope="col">Day</th>
                    </tr>
                </thead>
            <?php
            $imgLnks = ["jan", "feb", "march", "april", "may", "june", "july", "august", "sep", "oct", "nov", "dec"];
            $data = file_get_contents("namnsdagar.json");
            $dataDecoded = json_decode($data);
            $current_url = $_SERVER['REQUEST_URI'];
            if (strpos($current_url, "?date=") !== false) {
                $specialChars = htmlspecialchars($_GET["date"]);
            } else {
                $specialChars = date("Y-m-01");
                header("Location: https://localhost/phpstuff/phpCalendar/php/calendar.php/?date=" . $specialChars);
            }
            $specialCharsExploded = explode("-", $specialChars);
            $dateObj   = DateTime::createFromFormat('!m', $specialCharsExploded[1]);
            $monthName = $dateObj->format('F');
            echo("<h2>".$monthName ." - ". $specialCharsExploded[0]."</h2><img src='/../phpStuff/phpCalendar/img/".$monthName.".png'>");
            $day = 01;
            $month = $specialCharsExploded[1];
            $date = date("Y-$month-$day");

            while((strtotime($date)) <= strtotime(date(("Y-$month") . '-' . date('t', strtotime($date))))){
                $namnsdag = "";
                $day_num = date('j', strtotime($date));
                $day_name = date('l', strtotime($date));
                $week_nr = date('W', strtotime($date));
                $dayofyear = date("z", strtotime($date))+1; // +1 because start at index 0
                if(count($dataDecoded[$dayofyear]) >= 2){
                    foreach($dataDecoded[$dayofyear] as $namn){
                        $namnsdag .= ($namn . ", ");
                    }
                    $namnsdag = substr_replace($namnsdag, "", -2);
                }else{
                    if(count($dataDecoded[$dayofyear]) > 0){
                        $namnsdag = $dataDecoded[$dayofyear][0];
                    }else{
                        $namnsdag = "Ingen Namnsdag!";
                    }
                }
                $day = "$day_name $day_num";
                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                if($day_name == "Sunday"){
                    echo "<tr scope='row'><td>$dayofyear - ".$namnsdag."</td><td style='color:red;'>".$day. '</td></tr>';
                }else if($day_name == "Monday"){
                    echo "<tr scope='row'><td>$dayofyear - ".$namnsdag."</td><td>".$day." v.".$week_nr.'</td></tr>';
                }else{
                    echo "<tr scope='row'><td>$dayofyear - ".$namnsdag."</td><td>".$day. '</td></tr>';
                }
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {      
                if (isset($_POST['prev'])) {
                    if(($specialCharsExploded[1]-1) <= 0){
                        $specialCharsExploded[1] = 12;
                        $specialCharsExploded[0] -= 1;
                        header("Location: https://localhost/phpstuff/phpCalendar/php/calendar.php/?date=".($specialCharsExploded[0])."-".($specialCharsExploded[1])."-01");
                    }else{
                        header("Location: https://localhost/phpstuff/phpCalendar/php/calendar.php/?date=".($specialCharsExploded[0])."-".($specialCharsExploded[1]-1)."-01");
                    }
                } else if(isset($_POST['curr'])){
                    header("Location: https://localhost/phpstuff/phpCalendar/php/calendar.php/?date=".(date("Y-m-01")));
                }else{
                    echo($specialCharsExploded[1]);
                    if(($specialCharsExploded[1]+1) >= 13){
                        $specialCharsExploded[1] = 1;
                        $specialCharsExploded[0] += 1;
                        header("Location: https://localhost/phpstuff/phpCalendar/php/calendar.php/?date=".($specialCharsExploded[0])."-".($specialCharsExploded[1])."-01");
                    }else{
                        header("Location: https://localhost/phpstuff/phpCalendar/php/calendar.php/?date=".($specialCharsExploded[0])."-".($specialCharsExploded[1]+1)."-01");
                    }
                }
            }
            ?>
            </table>
        </div>
    </main>
</body>
</html>