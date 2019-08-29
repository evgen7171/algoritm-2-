<?php

include __DIR__ . DIRECTORY_SEPARATOR . 'Tree.php';

//$string = '(((42+5)-(1*8))-((2*8.1)^(3/2)))';
//$string = '((9-0)+(((42+5)-(1*8))-((2*8.1)^(3/2))))';
//$string = '(((9-0)+(((42+5)-(1*8))-((2*8.1)^(3/2))))-(80/13))';
//$string = '((4+0)-(3*5))/((8-17)^(0+2))';
$string = '((2^(2^(2^2)))-(10*(10+10)*(10*10)))';
//var_dump($string);

$tree = new MathOperationTree($string);
//var_dump($tree->getResult());

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Калькулятор примера</title>
</head>
<style>
    .column{
        display: flex;
        flex-direction: column;
    }
    .gray{
        color: #ccc;
    }
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<body>
<form action="#">
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body column">
                Пример
                <input id="express" type="text" name="input" value="((2^(2^(2^2)))-(10*(10+10)*(10*10)))">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body column">
                Обработка
                <input id="treat" type="text">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <a id="button" href="#" class="btn btn-primary">Посчитать</a>
                <p id="result" class="card-text gray">Ответ</p>
            </div>
        </div>
    </div>
</div>
</form>
</body>
<script src="script.js"></script>
</html>
