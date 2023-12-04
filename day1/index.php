<?php

include 'data.php';

$numAlpha=["one", "two", "three", "four", "five", "six", "seven", "eight", "nine"];

function total($data, $numAlpha){
	$total=0;
	foreach($data as $d){

		//recup des position a modifier
		$pos=[];
		foreach($numAlpha as $key => $num){
			$start=0;
			$ind=0;
			while(strpos($d, $num, $start)!==false){
				$ind=strpos($d, $num, $start);
				if($ind!==false){
					$pos[$ind]=$key+1;
					$start=$ind+strlen($num);
				}
			}
		}

		//modification de la chaine
		foreach($pos as $key => $p){
			$d[$key]=$p;
		}

		$first=null;
		$last=null;
		for($i=0; $i<strlen($d);$i++){
			if(is_numeric($d[$i])){
				if(!$first)
					$first=$d[$i];
				$last=$d[$i];
			}
		}
		$total+=intval($first.$last);
	}
	var_dump($total);
}

total($data, $numAlpha);

?>