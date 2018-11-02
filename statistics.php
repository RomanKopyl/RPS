<?php

$statWinLose = [];

// Table#1 "Statistics"

$resHTML = '<h1>Statistics</h1>' . PHP_EOL . 
'<h2>You are <b>' . $username . '</b></h2>' . PHP_EOL . 
'<a href="/?new=1">Play again!</a>' . PHP_EOL .
'<table border="1">
<caption>Statistics</caption>
<tr>
    <th>N of game</th>
    <th colspan="2">Player A</th>
    <th colspan="2">Player B</th>
    <th>Results</th>
</tr>' . PHP_EOL;

foreach (getAllGamesData() as $numberOfGame => $game) {
    $resHTML .= '<tr><td align="center">' . $numberOfGame . '</td>';
    $shapes = [];
    $players = [];

    foreach ($game as $player => $shape) {
        $shapes[] = $shape;
        $players[] = $player;
        //add $player only one time
        if (!array_key_exists($player, $statWinLose)) {  
            // $win = 0; $drow = 0; $lose = 0;   
            $statWinLose[$player] = [0, 0, 0];
        }

        //audit current player
        if ($player === $username) {
            $resHTML .= '<td><b>' . $player . '</b></td>';
        } else {
            $resHTML .= '<td>' . $player . '</td>';
        }

        //it will show shape of ONLY ended games
        if (count($game) === 2) {
            $resHTML .= '<td>' . $shape . '</td>';
        }
    }

    // mathematical calculations

    // $statWinLose[$plater[i]] = [$win, $drow, $lose];
    if (count($shapes) === 2) {
        $result = playRockPaperScissors($shapes[0], $shapes[1]);
        if ($result === 'first') {
            $result = $players[0] . ' win';      // create Result in Table #1
            $statWinLose[$players[0]][0]++;             // add $win + 1  player[0] for Table #2
            $statWinLose[$players[1]][2]++;             // add $lose + 1  player[1] for Table #2
        } elseif ($result === 'second') {
            $result = $players[1] . ' win';
            $statWinLose[$players[0]][2]++;             // add $lose + 1  player[0]
            $statWinLose[$players[1]][0]++;             // add $win + 1  player[1]
        } else {
            $result = 'Draw';
            $statWinLose[$players[0]][1]++;             // $drow++
            $statWinLose[$players[1]][1]++;             // $drow++
        }
        $resHTML .= '<td>' . $result . '</td></tr>' . PHP_EOL;
    }
}
$resHTML .= '</table>';
$resHTML .= PHP_EOL;
$resHTML .= PHP_EOL;

//-------------------------------------------------------
// Table#2 "Statistics 2"

$resHTML .= '<table border="1">
<caption>Statistics 2</caption>
<tr>
    <th>Player</th>
    <th>Wins</th>
    <th>Drows</th>
    <th>Loses</th>
</tr>' . PHP_EOL;
foreach ($statWinLose as $player => $WDL) {
    $resHTML .= '<tr><td>' . $player . '</td>' 
                . '<td align="center">' . $WDL[0] . '</td>'
                . '<td align="center">' . $WDL[1] . '</td>'
                . '<td align="center">' . $WDL[2] . '</td></tr>' 
                . PHP_EOL;
}
$resHTML .= '</table>';

file_put_contents('statistics.html', $resHTML);
//--------------------------------------------------------