<?php
/**
 * A class to hold a car position
 *
 * @author Tuulia <tuulia@tuulia.nl>
 */

namespace Lib\Models;

class Convert
{   
    
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
     * 
     * @param string $numberStr
     */
    public function toNumber($numberStr, $separator= ' ') {
        $parts = explode($separator, $numberStr);
        $parts = array_reverse($parts);
        $factor = 1;
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
                if ($string == 'thousand'  && 1==2) {
                    
                   
                     $subParts = [];
                    for($i = $index + 1; $i < count($parts); $i++) {
                        $subParts[] = $parts[$i] ;
                    }
                   $subParts  = array_reverse($subParts);
                     $subParts = implode('#', $subParts);
                     
                    
                    
                      $number = $this->toNumber($subParts, '#');
                        var_dump($number);
                     
                }
                $number = $parts[$index + 1];
                if (strpos($number, '-')) {
                   
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
