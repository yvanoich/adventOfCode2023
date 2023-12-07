<?php

echo "<pre>";
include 'data.php';

$dataTest=[
    "Time:      71530",
    "Distance:  940200"
];

//$data=$dataTest;

function findTotal($timeStop, $distance, $timeTotal, $isNegative){
    $total=0;
    $isOut=false;
    while($isOut==false && $timeStop>0){
        $metre=($timeTotal-$timeStop)*$timeStop;
        if($metre>$distance)
            $total++;
        else
            $isOut=true;

        if($isNegative)
            $timeStop--;
        else
            $timeStop++;
    }
    return $total;
}

//formate le temps
$time=explode(":", $data[0]);
$time=explode(" ", $time[1]);
$time=array_filter($time, function($value) {
    return $value !== '';
});
$time=array_values($time);

//formate la distance parcouru
$distance=explode(":", $data[1]);
$distance=explode(" ", $distance[1]);
$distance=array_filter($distance, function($value) {
    return $value !== '';
});
$distance=array_values($distance);

$total=0;
foreach($time as $key => $t){
    //recup des variables
    $t=intval($t);
    $currentDistance=intval($distance[$key]);
    $max=round(intval($t)/2);

    //recup du total
    $totalOccurence=findTotal($max, $currentDistance, $t, true)+findTotal($max, $currentDistance, $t, false)-1;
    
    if($total)
        $total*=$totalOccurence;
    else
        $total=$totalOccurence;
}

echo $total;



?>