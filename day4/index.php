<?php

include 'data.php';

$datatest=[
	"Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53",
	"Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19",
	"Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1",
	"Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83",
	"Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36",
	"Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11"
];

$total=0;
$tab=[];
foreach($data as $key => $d){
	$actualKey=$key+1;

	if(!isset($tab[$actualKey]))
		$tab[$actualKey]=1;
	else
		$tab[$actualKey]+=1;

	$points=0;
	$split=explode(":", $d);
	$split=explode('|', $split[1]);
	$split[0]=str_replace("  ", " ", $split[0]);
	$split[1]=str_replace("  ", " ", $split[1]);
	$winList=explode(" ", trim($split[0]));
	$myList=explode(" ", trim($split[1]));
	$nbreWin=0;
	foreach($winList as $num){
		/*if(in_array($num, $myList)){
 			if($points)
 				$points*=2;
 			else
 				$points=1;
		}*/
		if(in_array($num, $myList))
			$nbreWin++;
	}

	if($nbreWin){
		for($i=1;$i<($nbreWin+1);$i++){
			if(isset($tab[$actualKey+$i]))
				$tab[$actualKey+$i]+=(isset($tab[$actualKey]))? $tab[$actualKey]:1;
			else
				$tab[$actualKey+$i]=(isset($tab[$actualKey]))? $tab[$actualKey]:1;
		}
	}
	
	/*$total+=$points;*/
}

foreach($tab as $t){
	$total+=$t;
}

var_dump($total);
?>