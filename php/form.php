<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processed data</title>
</head>
<body>
    <a href="form.html">Go back!</a>
    <?php if(isset($_POST['date'])): ?>
        <h2>Next friday is in: </h2>
        <?php
        $date = $_POST['date'];
        $day_name = date('w', strtotime($date));
        $nextFriday = date("d", strtotime('next friday', strtotime($date)));
        if($day_name == 5){
            echo("<img src='../img/feel-that-thats-friday.gif'>");
        }else{
            echo($nextFriday-date("d", strtotime($date))." day(s)");
        }
        ?>
    <?php else : ?>
        <h2>You have to submit data before coming here >:(</h2>
        <a href="form.html">Go back!</a>
    <?php endif; ?>
</body>
</html>
