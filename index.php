<!DOCTYPE html>
<html>
<head>
<title>Mastermind</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8">
        <h2>Mastermind</h2>
        <p></p>
        <?php
        session_start();
        include 'numbers.class.php';
        $numObj = new Numbers();

        if (isset($_POST['validate']) && $_POST['validate'] == 'Validate Number') {
            $guessedNum = $_POST['guessed_num'];
            $res = $numObj->validateNumber($guessedNum);

        } else if (isset($_POST['clearVals'])) {
            $numObj->clearAndRefresh();
        }

        $randNumber = $numObj->getRandomNumber();

        ?>
        <div class="form-group">
        <label >Number to guess:</label>
        <?=$randNumber?> (Demo Purpose. This number is not visible to the user in real scenario)
        </div>
        <form method="post">
        <div class="form-group">
        <label >Enter your number</label>
        <input type ="text" name="guessed_num" class="form-control" id="guessed_num" value="" required/>
        </div>
        <div class="form-group">
            <input type="submit" name="validate" value="Validate Number" class="btn btn-sm btn-success" />
            
            </div>
        </form>
        <form method="post">
        <div class="form-group">

        <button type="" class="btn btn-sm btn-primary" name="clearVals">Clear Attempts & Refresh Number</button>
        </div>
        </form>
        <?php
        if (isset($_SESSION['SUCCEEDED']) && $_SESSION['SUCCEEDED']) { ?>
        <div class="alert alert-success">
        <strong>Success!</strong>
        <?php
            echo "Your guess " . $_SESSION['SUCCEEDED_NUM'] . " is a perfect match.";
        ?>
        </div>
    <?php } ?>

        <?php

        if (isset($_SESSION['ATTEMPTS']) && sizeof($_SESSION['ATTEMPTS']) > 0) {?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Three digit number</th>
                    <th>Matched Digits</th>
                    <th>Wrong place</th>
                    <th>Correct place</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['ATTEMPTS'] as $attempt) {?>
                    <tr>
                        <td><?=$attempt['GUESSED_NUM']?></td>
                        <td><?=$attempt['MATCHED_NUMS']?></td>
                        <td><?=$attempt['MATCHED_NUMS'] - $attempt['CORRNUM_CORRPOS']?></td>
                        <td><?=$attempt['CORRNUM_CORRPOS']?></td>
                    </tr>
            <?php }?>
            </tbody>
        </table>

        <?php }

        ?>
        </div>
        <div class="col-md-4">
        <h2>Instructions</h2>
        <p></p>
                <div class="panel panel-primary">
            <div class="panel-heading">How to play?</div>
            <div class="panel-body">
                            <ul class="list-group">
                <li class="list-group-item">1) Please enter the 3 digit number and click on validate to check against the number to be guessed.</li>
                <li class="list-group-item">2) Below table will show the count of matched numbers and their positions.</li>
                <li class="list-group-item">3) Once the actual number is guessed correctly, a success message will be shown.</li>
                <li class="list-group-item">4) To reset all attempts and start fresh click on Clear attempts button.</li>
                </ul>
            </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>