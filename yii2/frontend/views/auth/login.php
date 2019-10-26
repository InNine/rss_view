<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.10.2019
 * Time: 14:26
 */
$array1 = ["a" => "green", "pink", "blue", "red", "brown", "r" => "red", "red"];
$array2 = ["b" => "green", "brown", "black", "yellow", "pink",];
$result = array_keys(array_diff($array1, $array2));
?>

<?= json_encode($result) ?>
