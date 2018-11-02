<?php

function getAllGamesData()
{
    if (!file_exists(GAMES_FILE)) {
        file_put_contents(GAMES_FILE, serialize([]));
    }

    return unserialize(file_get_contents(GAMES_FILE));
}

function saveGameData($data)
{
    $gamesData = getAllGamesData();
    $lastIndex = count($gamesData) - 1;

    if (count($data) === 1) {
        $gamesData[] = $data;
    } else {
        $gamesData[$lastIndex] = $data;
    }

    file_put_contents(
        GAMES_FILE,
        serialize($gamesData)
    );

    return count($gamesData) - 1;
}


function getGameData()
{
    $gamesData = getAllGamesData();

    $gameData = [];

    $lastIndex = count($gamesData) - 1;
    if ($lastIndex > -1) {
        $lastGameData = $gamesData[$lastIndex];
        $lastCount = count($lastGameData);

        if ($lastCount === 1) {
            $gameData = $lastGameData;
        }
    }

    return $gameData;
}

function playRockPaperScissors($firstShape, $secondShape)
{
    if (!in_array($firstShape, SHAPES)) {
        if (!in_array($secondShape, SHAPES)) {
            return 'draw';
        }
        return 'second';
    }
    if (!in_array($secondShape, SHAPES)) {
        return 'first';
    }
    $firstIndex = array_search($firstShape, SHAPES);
    $secondIndex = array_search($secondShape, SHAPES);
    switch ($firstIndex - $secondIndex) {
        case -2:
            return 'first';
        case -1:
            return 'second';
        case 0:
            return 'draw';
        case 1:
            return 'first';
        case 2:
            return 'second';
    }
}

function outputHTML($vars, $template)
{
    $html = file_get_contents($template . '.html');

    echo str_replace(
        array_keys($vars),
        array_values($vars),
        $html
    );
}
