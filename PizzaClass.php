<?php
Class Pizza {

    public $crust = ['thin' => 1, 'thick' => 1.25];
    public $sauce = ['tomato' => 0.25, 'tomato-basil' => 0.50, 'tomato-garlic' => 0.75];
    public $topping = ['pepper' => 0.20, 'olive' => 0.40, 'mushroom' => 0.60, 'meatball' => 0.80];
    public $cheese = ['mozzarella' => 2, 'american' => 3, 'swiss' => 4];
    public $size = ['half' => 0.5, 'single' => 1, 'double' => 2, 'triple' => 3];
    public $price = [];
    public $message = [];

    public function __construct($crustType = "", $sauceArr = [], $toppingArr = [], $cheeseArr = []) {

        if ($this->validate($crustType, $sauceArr, $toppingArr, $cheeseArr)) {

            if ($crustType != "" && !is_null($crustType)) {
                array_push($this->price, $this->crust[$crustType]);
                array_push($this->message, $crustType . " crust, ");
            }
            if (!empty($sauceArr) && isset($sauceArr['type'])) {
                $sauceArr['size'] = !isset($sauceArr['size']) ? 'single' : $sauceArr['size'];
                foreach ($sauceArr['type'] as $k => $type) {
                    $discount = $this->applayDiscount($sauceArr['size'], $this->sauce[$type]);
                    array_push($this->price, $this->size[$sauceArr['size']] * ( $this->sauce[$type] - $discount));
                    array_push($this->message, $sauceArr['size'] . " " . $type . " sauce, ");
                }
            }
            if (!empty($toppingArr) && isset($toppingArr['type'])) {
                $toppingArr['size'] = !isset($toppingArr['size']) ? 'single' : $toppingArr['size'];
                foreach ($toppingArr['type'] as $k => $type) {
                    $discount = $this->applayDiscount($toppingArr['size'], $this->topping[$type]);
                    array_push($this->price, $this->size[$toppingArr['size']] * ($this->topping[$type] - $discount));
                    array_push($this->message, $toppingArr['size'] . " " . $type . " topping, ");
                }
            }
            if (!empty($cheeseArr) && isset($cheeseArr['type'])) {
                $cheeseArr['size'] = !isset($cheeseArr['size']) ? 'single' : $cheeseArr['size'];
                foreach ($cheeseArr['type'] as $k => $type) {
                    $discount = $this->applayDiscount($cheeseArr['size'], $this->cheese[$type]);
                    array_push($this->price, $this->size[$cheeseArr['size']] * ( $this->cheese[$type] - $discount));
                    array_push($this->message, $cheeseArr['size'] . " " . $type . " cheese, ");
                }
            }

            //swiss cheese is used with olive topping
            if (isset($toppingArr['type']) && isset($cheeseArr['type']) && in_array('olive', $toppingArr['type']) && in_array('swiss', $cheeseArr['type'])) {
                $addExtraFee = $this->extraFee($this->getPrice());
                array_push($this->price, $addExtraFee);
            }
        }
    }

    /**
     * Get Price
     * @return type number
     */
    public function getPrice() {
        if (!empty($this->price)) {
            return array_sum($this->price);
        }
    }

    /**
     * Get Message
     * @return type String
     */
    public function getMessage() {
        if (!empty($this->message)) {
            return ucfirst(rtrim(implode($this->message), ', '));
        }
    }

    /**
     * Apply 25% surcharge (extra fee) on the total price
     * @param type $price
     * @return type number
     */
    public function extraFee($price) {
        $extraFee = $price * 25 / 100;
        return $price;
    }

    /**
     *  Applay 20% discount to component for double and triple size
     * @param type $size
     * @param type $type
     * @return type number
     */
    function applayDiscount($size, $type) {
        $discount = 0;
        if ($size == 'double' || $size == 'triple') {
            $discount = $type * 20 / 100;
        }
        return $discount;
    }

    /**
     * Validate function
     * @param type $crustType
     * @param type $sauceArr
     * @param type $toppingArr
     * @param type $cheeseArr
     * @return boolean
     */
    public function validate($crustType, $sauceArr, $toppingArr, $cheeseArr) {
        $isValid = false;
        //crust and at least one additional component is required
        if ($crustType == "") {
            $isValid = false;
            array_push($this->message, "Crust is required for pizza.");
        } else {
            $isValid = true;
            if (empty($sauceArr) && empty($toppingArr) && empty($cheeseArr)) {
                $isValid = false;
                array_push($this->message, "A crust and at least one additional component is required for each pizza.");
            }
        }
        //Mozzarella cannot be used with tomato-garlic
        if (isset($sauceArr['type']) && isset($cheeseArr['type']) && in_array('tomato-garlic', $sauceArr['type']) && in_array('mozzarella', $cheeseArr['type'])) {
            $isValid = false;
            array_push($this->message, "Mozzarella cannot be used with tomato-garlic sauce.<br/>");
        }
        return $isValid;
    }
}