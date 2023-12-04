<?php

include 'data.php';

function isMoteur($matrice, $x, $y){
	$x-=1;
	$y-=1;

	$isMoteur=false;
	$total=0;
	$nbreFind=0;
	$tabVerifie=[];
	for($i=0; $i<3;$i++){
		for($j=0; $j<3;$j++){
			/*if((isset($matrice[$x+$i][$y+$j]) && $matrice[$x+$i][$y+$j]!="." && !is_numeric($matrice[$x+$i][$y+$j])))
				$isMoteur=true;*/
			if((isset($matrice[$x+$i][$y+$j]) && is_numeric($matrice[$x+$i][$y+$j]))){
				$column=($y+$j);
				$temp="";
				$ind="";
				while((isset($matrice[$x+$i][$column]) && is_numeric($matrice[$x+$i][$column]))){
					$column--;
				}
				$column++;
				
				while((isset($matrice[$x+$i][$column]) && is_numeric($matrice[$x+$i][$column]))){
					$temp.=$matrice[$x+$i][$column];
					$ind.=$x+$i.$column;
					$column++;
				}

				if(!array_key_exists($ind, $tabVerifie)){
					$nbreFind++;
					$tabVerifie[$ind]=$temp;
				}
			}
		}
	}

	if($nbreFind>1){
		$total=1;
		foreach($tabVerifie as $amount){
			$total*=$amount;
		}
	}

	return $total;
	//return $isMoteur;
}

$datatest=[
	"467..114..",
	"...*......",
	"..35..633.",
	"......#...",
	"617*......",
	".....+.58.",
	"..592.....",
	"......755.",
	"...$.*....",
	".664.598.."
];

$matrice=[];
foreach($data as $key => $d){
	$d=trim($d);
	for($i=0;$i<strlen($d);$i++){
		$matrice[$key][]=$d[$i];
	}
}

$total=0;
foreach($matrice as $line => $l){
	$isFind=false;
	$temp="";
	foreach($l as $column =>  $c){
		/*if(is_numeric($c)){
			$temp.=$c;
			if(!$isFind)
				$isFind=isMoteur($matrice, $line, $column);
		}
		else{
			if($isFind){
				//var_dump($temp);
				$total+=intval($temp);
				$isFind=false;
			}
			$temp="";
		}*/

		if($c=="*")
			$total+=isMoteur($matrice, $line, $column);
	}
}
var_dump($total);

?>