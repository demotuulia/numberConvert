<?php
/**
 * A class to hold a car position
 *
 * @author Tuulia <tuulia@tuulia.nl>
 */

namespace Lib\Models;

class Convert
{   
    
    /**
     * Translations
     * 
     * @var array
     */
    private $translations = [
        'en' => [
            1 => [
                'one',
                'two',
                'three',
                'four',
                'five',
                'six',
                'seven',
                'eight',
                'nine',
                'ten',
                'eleven',
                'twelve',
                'thirteen',
                'fourteen',
                'fiveteen',
                'sixteen',
                'seventeen',
                'eightteen',
                 'nineteen',
            ],
             10 => [
                'ten',
                'twenty',
                'thirty',
                'fourty',
                'fifty',
                'sixty',
                'seventy',
                'eighty',
                'ninety'
            ],
           
        ]
    ];

   
    


    /**
     * Convert string to number
     * 
     * @param string $numberStr
     * @return float 
     */
    public function toNumber($numberStr, $separator= ' ') {
        
        // Read parts to array
        $parts = explode($separator, $numberStr);
        $parts = array_reverse($parts);
       
        
        //
        // Read array parts and convert
        //s
        $result = 0;
        $index = 0;
        $current = $parts[$index];
       
        // Check numbers <100
        foreach ([1, 10] as $factor) {
            if (array_search($current, ($this->translations['en'][$factor]))) {
                $value = array_search($current, ($this->translations['en'][$factor]));
                $result = $result + ($value + 1 ) * $factor;
                $index ++;
                $current = isset($parts[$index]) ? $parts[$index] : 'x';
            }
        }

        // Check numbers >= 100
        $bigNumbers = [
            '100' => 'hundred',
            '1000' => 'thousand'
        ];
        foreach ($bigNumbers as $factor => $string) {
            if ($current == $string || $current == $string) {
                
                // Convert strings having X hundred thousand .... 
                if ($string == 'thousand' ) {
                    $subParts = [];
                    for ($i = $index + 1; $i < count($parts); $i++) {
                        $subParts[] = $parts[$i];
                    }
                    $subParts = array_reverse($subParts);
                    $subParts = implode(' ', $subParts);
                    // Here happens something strange
                    // If With implode below I get for example 'two hundred twenty'
                    // I get result with the to number 20
                    // If I hard code the follwoing : $subParts = 'two hundred twenty'
                    // It works
                    $number = $this->toNumber($subParts, ' ') * 1000;
                } else {
                    
                } $number = $parts[$index + 1];
               
                
                if (strpos($number, '-')) {
                    // Convert - serated number like 'twenty-four'
                    $number = $this->toNumber($number, '-');
                    $value = $number * $factor;
                    $result = $result + ($value );
                } else {
                    $value = array_search($number, ($this->translations['en'][1]));
                    $result = $result + ($value + 1) * $factor;
                }

                $index = $index + 2;
                $current = isset($parts[$index]) ? $parts[$index] : 'x';
            }
        }
        return number_format($result);
    }

}
