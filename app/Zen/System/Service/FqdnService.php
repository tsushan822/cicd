<?php


namespace App\Zen\System\Service;


use Hyn\Tenancy\Models\Hostname;

trait FqdnService
{
    public function checkFqdn($companyName)
    {
        $newFirstWord = $firstWord = explode(' ', trim(strtolower($companyName)))[0];
        $numSubDomain = $this -> checkIfExist($firstWord);
        $i = 0;
        while ($numSubDomain) {
            $i++;
            $newFirstWord = $firstWord . $i;
            $numSubDomain = $this -> checkIfExist($newFirstWord);
        }
        return $newFirstWord;
    }

    public function checkIfExist($firstWord)
    {
        return Hostname ::where('main_sub_domain', $firstWord) -> count();
    }
}