<?php


namespace App\Interfaces;


interface Auth
{
    public function allowedNotSecureActions(): array;
    public function usedMiddlewares(): array;
}