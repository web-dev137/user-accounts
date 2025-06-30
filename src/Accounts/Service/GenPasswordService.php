<?php 

declare(strict_types=1); 

namespace App\Accounts\Service;

use Markei\PasswordGenerator\Generator as Generator;

class GenPasswordService
{
    protected array $symbols = [
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '`', '-', '=', '{', '}', '[', ']', ':', ';', '<', '>', ',', '.', '?', '/',
        '!', '@', '#', '$', '%', '&', '*', '(', ')', '+', '-', '{', '}', '[', ']', '<', '>', '.', '?'
    ];

    public function genPassword(int $length)
    {
        $password = [];
        for($i = 0; $i < $length; $i++) {
            $password[$i] = $this->symbols[array_rand($this->symbols,1)];
        }
        return implode('',$password);
    }
}