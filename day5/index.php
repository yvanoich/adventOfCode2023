<?php

include 'data.php';

$seedsTest="seeds: 79 14 55 13";

$dataTest=[
    "seed-to-soil map:",
    "50 98 2",
    "52 50 48",
    "",
    "soil-to-fertilizer map:",
    "0 15 37",
    "37 52 2",
    "39 0 15",
    "",
    "fertilizer-to-water map:",
    "49 53 8",
    "0 11 42",
    "42 0 7",
    "57 7 4",
    "",
    "water-to-light map:",
    "88 18 7",
    "18 25 70",
    "",
    "light-to-temperature map:",
    "45 77 23",
    "81 45 19",
    "68 64 13",
    "",
    "temperature-to-humidity map:",
    "0 69 1",
    "1 0 69",
    "",
    "humidity-to-location map:",
    "60 56 37",
    "56 93 4"
];

$seeds=$seedsTest;
$data=$dataTest;

$seeds=explode(":", $seeds);
$seeds=str_replace("  ", " ", $seeds[1]);
$seeds=explode(" ", trim($seeds));

echo "<pre>";

$tab=[];
for($i=0;$i<count($seeds);$i+=2){
    $tab[$i]=[
        "start" => $seeds[$i],
        "length" => $seeds[$i+1]
    ];
}

function recursive($data, $tab){
    $splitSeed=[];
    $newSeeds=[];
    $lineTest=[];
    foreach($data as $key => $d){
        if(is_numeric(strpos($d, ":"))){
            if($splitSeed){
                
                foreach($splitSeed as $split){
                    $totalLength=0;
                    foreach($newSeeds as $new){
                        $totalLength-=$new["length"];
                    }

                    recursive($lineTest, [$split]);

                    foreach($newSeeds as $new){
                        $totalLength+=$new["length"];
                    }

                    if($totalLength==0);
                    $newSeeds[]=$split;
                }
            }
            var_dump($newSeeds);
            echo "<br/><br/>";
            /*if($key>7)
                exit;*/
            if($key>1)
                $tab=$newSeeds;
            $lineTest=[];
            $splitSeed=[];
        }
        elseif($d!=""){
            $lineTest[]=$d;
            foreach($tab as $key => $seed){
                $information=explode(" ", trim(str_replace("  ", " ", $d)));

                $startRange=intval($information[1]);
                $endRange=$startRange+intval($information[2]);

                $startSeed=intval($seed["start"]);
                $endSeed=$startSeed+intval($seed["length"]);

                $decalage=intval($information[0])-intval($information[1]);

                $newStartRange=0;
                $newLength=0;

                //si le début n'est pas dans la range
                if($startSeed<$startRange){
                    //si la fin seed est dans la range
                    if($endSeed>$startRange){
                        //si la fin seed est inférieur a la fin de la range
                        if($endSeed<$endRange){
                            $newLength=$endSeed-$startRange;
                            $newStartRange=$decalage+$startRange;
                            $splitSeed[]=[
                                "start" => $startSeed,
                                "length" => ($startRange-$startSeed),
                            ];
                        }
                        else{
                            $newLength=intval($information[2]);
                            $newStartRange=$decalage+$startRange;
                            $splitSeed[]=[
                                "start" => $startSeed,
                                "length" => $startRange-$startSeed,
                            ];
                            $splitSeed[]=[
                                "start" => $endRange,
                                "length" => $endSeed-$endRange,
                            ];
                        }
                    }
                }
                //si le début est dans la range
                elseif($startSeed>$startRange && $startSeed<$endRange){
                    //si la fin seed est inférieur a la fin de la range
                    if($endSeed<$endRange){
                        $newStartRange=$decalage+$startSeed;
                        $newLength=intval($seed["length"]);
                    }
                    elseif($endSeed>$endRange){
                        $newLength=$endRange-$startSeed;
                        $newStartRange=$decalage+$startSeed;
                        $splitSeed[]=[
                            "start" => $endRange,
                            "length" => $endSeed-$endRange,
                        ];

                        /*var_dump($splitSeed);
                        echo $startRange." - ".$endRange."<br/>";
                        echo $startSeed." - ".$endSeed."<br/>";exit;*/
                    }
                }

                //si il y a une nouvelle start range et nouvelle taille alors on l'ajoute au tableau des futurs soil, etc...
                if($newStartRange && $newLength){
                    if(isset($newSeeds[$key])){
                        unset($newSeeds[$key]);
                    }
                    $newSeeds[]=[
                        "start" => $newStartRange,
                        "length" => $newLength,
                    ];
                }
            }
        }
    }
}

$newSeeds=[];
recursive($data, $tab);
exit;

$min=false;
foreach($tab as $result){
    if($min==false || $min>$result["start"])
        $min=$result["start"];
}

var_dump($min);

exit;


$min=false;
foreach($seeds as $seed){
    $emplacementBase=0;
    foreach($data as $key => $d){
        if($d!=""){
            if(is_numeric(strpos($d, ":"))){
                if($emplacementBase==0)
                    $emplacementBase=intval($seed);

                $seed=$emplacementBase;
            }
            else{
                $information=explode(" ", trim(str_replace("  ", " ", $d)));
                if(intval($seed)>=intval($information[1]) && intval($seed)<intval($information[1])+intval($information[2])){
                    $emplacementBase=intval($information[0])-intval($information[1])+intval($seed);
                }
            }
        }
    }

    if(!$min || $min>$emplacementBase)
        $min=$emplacementBase;
}

var_dump($min);

?>