<?php 
namespace App\Helpers;

class PermutationDigit {
    public function PerDigit($str, $original) {
        if (strlen($str) == 1) {
            return $str === $original ? [] : [$str];
        } else {
            $perms = [];
            for ($i = 0; $i < strlen($str); $i++) {
                $char = $str[$i];
                $remainingChars = substr($str, 0, $i) . substr($str, $i + 1);
                foreach ($this->PerDigit($remainingChars, $original) as $subPerm) {
                    $perm = $char . $subPerm;
                    if ($perm !== $original) { // Check if permutation is not the original string
                        $perms[] = $perm;
                    }
                }
            }
            return array_values(array_unique($perms));
        }
    }
}