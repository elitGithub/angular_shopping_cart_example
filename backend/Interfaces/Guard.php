<?php


namespace App\Interfaces;


interface Guard
{
    public function expectedFields(): array;

    public function removeUnexpectedFields(&$input): void;


}