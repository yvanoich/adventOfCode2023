<?php

echo "<pre>";
include 'data.php';

$dataTest=[
    "3JJAJ 765",
    "T55J5 684",
    "KK677 28",
    "KTJJT 220",
    "QQQJA 483"
];

$tabTri=[
    "A"     => 1, 
    "K"     => 2, 
    "Q"     => 3, 
    "T"     => 5, 
    "9"     => 6, 
    "8"     => 7, 
    "7"     => 8, 
    "6"     => 9, 
    "5"     => 10, 
    "4"     => 11, 
    "3"     => 12, 
    "2"     => 13,
    "J"     => 14
];

function customSort($a, $b, $order){
    $a=$a["cartes"];
    $b=$b["cartes"];
    $charA=$a[0];
    $charB=$b[0];
    for($i=0;$i<strlen($a);$i++){
        if($a[$i]!=$b[$i]){
           $charA=$a[$i];
           $charB=$b[$i];
           break;
        }
    }

    return $order[$charA]-$order[$charB];
}

//$data=$dataTest;

$typeTab=[
    "cinq"      => [],
    "carre"     => [],
    "full"      => [],
    "brelan"    => [],
    "2paires"   => [],
    "paire"     => [],
    "haute"     => []
];

foreach($data as $d){
    $currentData=explode(" ", $d);

    $cartes=$currentData[0];
    $mise=$currentData[1];
    $paire=[];
    for($i=0;$i<strlen($cartes);$i++){
        if(isset($paire[$cartes[$i]]))
            $paire[$cartes[$i]]++;
        else
            $paire[$cartes[$i]]=1;
    }

    $nbreJoker=(isset($paire["J"]))? $paire["J"] : 0;
    unset($paire["J"]);

    $type="haute";
    if(array_keys($paire, 5))
        $type="cinq";
    elseif(array_keys($paire, 4)){
        $type="carre";
        if($nbreJoker)
            $type="cinq";
    }
    elseif(array_keys($paire, 3) && array_keys($paire, 2)){
        $type="full";
        if($nbreJoker==1)
            $type="carre";
        elseif($nbreJoker==2)
            $type="cinq";
    }
    elseif(array_keys($paire, 3) && !array_keys($paire, 2)){
        $type="brelan";
            if($nbreJoker==1)
                $type="carre";
            elseif($nbreJoker==2)
                $type="cinq";
    }
    elseif(count(array_keys($paire, 2))==2){
        $type="2paires";
            if($nbreJoker==1)
                $type="full";
    }
    elseif(array_keys($paire, 2)){
        $type="paire";
            if($nbreJoker==1)
                $type="brelan";
            elseif($nbreJoker==2)
                $type="carre";
            elseif($nbreJoker==3)
                $type="cinq";
    }
    elseif($nbreJoker){
        if($nbreJoker==1)
            $type="paire";
        if($nbreJoker==2)
            $type="brelan";
        elseif($nbreJoker==3)
            $type="carre";
        elseif($nbreJoker==5 || $nbreJoker==4)
            $type="cinq";
    }

    $typeTab[$type][]=[
        "cartes"    => $cartes,
        "mise"      => $mise
    ];
}

$rang=count($data);
$totalMise=0;
foreach($typeTab as $personnes){
    if(count($personnes)>0){
        usort($personnes, function($a, $b) use ($tabTri){
            return customSort($a, $b, $tabTri);
        });

        foreach($personnes as $personne){
            $totalMise+=$personne["mise"]*$rang;
            $rang--;
        }
    }
}

var_dump($totalMise);

?>