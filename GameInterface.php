<?php

namespace Bowling;

interface GameInterface
{
    public function getScore();

    public function setScore($score);

    public function roll();

    public function checkBonuses(Game $newGame, bool $strikeBonus, bool $spareBonus, $pins) : array;
}
