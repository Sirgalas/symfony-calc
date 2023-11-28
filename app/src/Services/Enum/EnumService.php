<?php

namespace App\Services\Enum;

class EnumService
{
    public function returnValue(array $cases, string $search): ?string
    {
        $returnArray = array_filter(
            array_map(
                function ($case) use ($search) {
                    if($case->value == $search){
                        return $case->choice();
                    }
                    return null;
                },
                $cases
            ),
            function ($element) {
                return !empty($element);
            }
        );
        return array_shift($returnArray );
    }
    public function returnChildValue(array $cases, string $search): ?string
    {
        $returnArray = array_filter(
            array_map(
                function ($case) use ($search) {
                    if($case->value >= $search){
                        return $case->choice();
                    }
                    return null;
                },
                $cases
            ),
            function ($element) {
                return !empty($element);
            }
        );
        return array_shift($returnArray );
    }
}
