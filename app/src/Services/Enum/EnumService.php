<?php

namespace App\Services\Enum;

enum EnumService
{
    public function returnValue(array $cases, string $search): string
    {
        $returnArray = array_filter(
            array_map(
                function ($case) use ($search) {
                    if($case->value == $search){
                        return $case->discount();
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
