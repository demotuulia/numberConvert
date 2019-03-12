<?php
/**
 * A class to test the car
 *
 *
 * @author Tuulia <tuulia@tuulia.nl>
 */


require_once(__DIR__ . '/Test.php');
use Lib\Models\Convert; 

class TestConvert extends Test
{
    /**
     * testLessThan100
     *
     */
    public function testLessThan100() {

        
        $convert = new Convert();
        $result = $convert->toNumber('five');
        $this->assertEquals('5', $result);

        $result = $convert->toNumber('fifty');
        $this->assertEquals('50', $result);

        $result = $convert->toNumber('twenty five');
        $this->assertEquals('25', $result);
    }

    /**
     * between 100 and 1000
     *
     */
    public function testBetween100And1000() {
      
        $convert = new Convert();

        $result = $convert->toNumber('two hundred');
        $this->assertEquals('200', $result);

        $result = $convert->toNumber('two hundred five');
        $this->assertEquals('205', $result);

        $result = $convert->toNumber('two hundred twenty');
        $this->assertEquals('220', $result);

        $result = $convert->toNumber('two hundred twenty five');
        $this->assertEquals('225', $result);
    }

    /**
     * between 1000 and 100 000
     *
     */
    public function testBetween1000And100000() {
        
        $convert = new Convert();
        $result = $convert->toNumber('two thousand');
        $this->assertEquals('2,000', $result);

        $result = $convert->toNumber('two thousand six');
        $this->assertEquals('2,006', $result);

        $result = $convert->toNumber('two thousand thirty six');
        $this->assertEquals('2,036', $result);

        $result = $convert->toNumber('five thousand four hundred thirty six');
        $this->assertEquals('5,436', $result);
        
        $result = $convert->toNumber('fiveteen thousand four hundred thirty six');
        $this->assertEquals('15,436', $result);
        
        $result = $convert->toNumber('twenty-four thousand four hundred thirty six');
        $this->assertEquals('24,436', $result);
      
        $result = $convert->toNumber('two hundred twenty thousand four hundred thirty five');
        $this->assertEquals('220,435', $result);
    }

}
