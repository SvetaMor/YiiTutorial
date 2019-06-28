<h1>Вывод телефонного номера</h1>

<?php
$phone = 71234567890;
echo Yii::$app->formatter->asPhone($phone);
