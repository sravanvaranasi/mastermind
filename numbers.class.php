<?php
/**
 * Class contains the methods to validate the user input values against the value to be guessed. 
 * Author: Sravan Varanasi
 */
Class Numbers {

    private $randomNumber;
    private $numberToValidate;

    public function __construct(){
       // echo "Object Created;";
    }

    /**
     * A wrapper method which will call actual methods to do the validation againt the number provided by the user. Temporary data will be stored in the session to display the info to user.
     */
    public function validateNumber($numToValidate){
        $this->randomNumber = $_SESSION['RAND_NUM'];
        $this->numberToValidate = $numToValidate;
        $attemptsArray = array();
        $attemptsArray['GUESSED_NUM'] = $this->numberToValidate;
        $attemptsArray['MATCHED_NUMS'] = self::getMatchedNumbers();
        $posArray = self::getMatchedPositions();
        $attemptsArray['CORRNUM_CORRPOS'] = $posArray['corrNumCorrPlace'];
        $attemptsArray['CORRNUM_WROPOS'] = $posArray['corrNumWrongPlace'];
        
        if($posArray['corrNumCorrPlace'] == 3){
            $_SESSION['SUCCEEDED'] = true;
            $_SESSION['SUCCEEDED_NUM'] = $this->numberToValidate;
        } else {
            $_SESSION['SUCCEEDED'] = false;
        }
        
        $_SESSION['ATTEMPTS'][] = $attemptsArray;

    } 

    /**
     * This method is useful to find out number of matches found in the number provided by user
     */
    public function getMatchedNumbers(){
        $numArray = str_split($this->randomNumber);
        $tmpArray = str_split($this->numberToValidate);
        $matchedNumbers = count(array_intersect($numArray, $tmpArray));
        return $matchedNumbers;
    }

    
    /**
     * This method is useful to find out number of matches found and their positions in the number provided by user
     */

    public function getMatchedPositions(){
        $numArray = str_split($this->randomNumber);
        $tmpArray = str_split($this->numberToValidate);
        $diffarray = array_diff_assoc($numArray, $tmpArray);
        $matchedPos = (sizeof($tmpArray) - sizeof($diffarray));
        return array('corrNumCorrPlace'=>$matchedPos,'corrNumWrongPlace'=>sizeof($diffarray));
    }

    /**
     * This method will clear all the temporary date stored in the sessions and will reset to defaults.
     */
    public function clearAndRefresh(){
        $_SESSION['ATTEMPTS'] = array();
        $_SESSION['RAND_NUM'] = self::generateRandomNumber();
        $_SESSION['SUCCEEDED'] = false;
    }

    public function generateRandomNumber(){
        return rand ( 100 , 999 );
    }

    /**
     * Return the random number if it is already generated else will generate new one and return.
     */
    public function getRandomNumber(){
        if(!isset($_SESSION['RAND_NUM'])){
            $_SESSION['RAND_NUM'] = self::generateRandomNumber();
        }
        return $_SESSION['RAND_NUM'];
    }

}


?>