<?php
define('nl',"\n");
$sqRows=3; $sqCols=3;

$grille='040053102;208100700;501420600;814030207;060205019;050740063;000074581;185902000;403008026';

solve($grille,$sqRows,$sqCols);

function solve($grille,$sqRows,$sqCols)
{
	global	$globalPossibles,$squareRows,$squareCols;
	$squareRows=$sqRows;
	$squareCols=$sqCols;
	$lines=explode(';',$grille);
	$board=array();
	
	foreach($lines as $line)
	{
	$board[]=str_split($line);
	}	
$globalPossibles=array();
for($i=0;$i<=count($board); $i++)
	{
		$globalPossibles[]=$i;
	}
	printBoard($board);
	solveBoard($board,0,0);
}

function printBoard(&$board)
{
	foreach($board as $row)
	{
		echo(implode('',$row).nl);
	}
echo(nl);
}

function solveBoard(&$board, $r, $c)
{
	if($r==count($board))
	{
		echo('solved'.nl);
		printBoard($board);
		return true;
	}
	
	$nextC=($c+1<count($board[0]))?$c+1:0;
	$nextR=($nextC==0)?$r+1:$r;
	
if($board[$r][$c]>0)
	{
		return solveBoard($board,$nextR,$nextC);
	}
	$possibles=getPossibles($board,$r,$c);
	foreach($possibles as $possible)
	{
		if($possible>0)
		{
			$board[$r][$c]=$possible;
			
			if(solveBoard($board,$nextR,$nextC))
			{
				return true;
			}
		}
		
	}
	$board[$r][$c]=0;
	return false;
}

function getPossibles(&$board,$r0,$c0)
{
	global	$globalPossibles,$squareRows,$squareCols;
	
	$possibles = $globalPossibles;
	
	//test col
	for($r=0;$r<count($board);$r++)
	{
		$possibles[$board[$r][$c0]]=0;
	}
	
	//test row
	for($c=0;$c<count($board);$c++)
	{
		$possibles[$board[$r0][$c]]=0;
	}
	//check 3x3
	$r=0;
	while($r0-$r>=$squareRows)
	{
		$r+=$squareRows;
	}
	$c=0;
	while($c0-$c>=$squareCols)
	{
		$c+=$squareCols;
	}
	
	for($dr=0; $dr<$squareRows; $dr++)
	{
			for($dc=0; $dc<$squareCols; $dc++)
			{
				$possibles[$board[$r+$dr][$c+$dc]]=0;
			}
	}
	return $possibles;
}
?>

