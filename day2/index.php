<?php

include 'data.php';

$datatest=[
	"Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green",
	"Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue",
	"Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red",
	"Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red",
	"Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green",
];

$total=0;
foreach($data as $key => $data){
	$split=explode(":", $data);
	$split=explode(";", $split[1]);
	//$isFind=true;
	$tab=[
		"red" => 0,
		"blue" => 0,
		"green" => 0
	];
	foreach($split as $s){
		$tirage=explode(",", $s);
		foreach($tirage as $t){
			$res=explode(" ", trim($t));
			/*if((intval($res[0])>12 && strpos($res[1], "red")!==false) || (intval($res[0])>13 && strpos($res[1], "green")!==false) || (intval($res[0])>14 && strpos($res[1], "blue")!==false))
				$isFind=false;*/
			if($tab[trim($res[1])]<$res[0])
				$tab[trim($res[1])]=$res[0];
		}
	}

	$total+=($tab["red"]*$tab["green"]*$tab["blue"]);

	/*if($isFind)
		$total+=($key+1);*/
}

var_dump($total);

?>