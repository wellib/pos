<?php

/**
 * position in the cart
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.9
 * @package ShoppingCart
 *
 * Can be used with non-AR models.
 */
class ECartPositionBehaviour extends CActiveRecordBehavior {

    /**
     * Positions number
     * @var int
     */
    private $quantity = 0;
    private $product_roll = 0;
    private $price = 0.0;
    /**
     * Update model on session restore?
     * @var boolean
     */
    private $refresh = true;

    /**
     * Position discount sum
     * @var float
     */
    private $discountPrice = 0.0;

    /**
     */
    private $cart_id = 0;

    /**
     * Returns total price for all units of the position
     * @param bool $withDiscount
     * @return float
     *
     */
    public function getSumPrice($withDiscount = true) {
        $fullSum = $this->getOwner()->getPrice() * $this->quantity;
        if($withDiscount)
            $fullSum -=  $this->discountPrice;
        return $fullSum;
    }

    public function getPrice() {
        return (float)$this->price;
    }
    
    /**
     * Returns quantity.
     * @return int
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Updates quantity.
     *
     * @param int quantity
     */
    public function setQuantity($newVal) {
        $this->quantity = $newVal;
    }

    /**
     * Updates quantity.
     *
     * @param int quantity
     */
    public function setPrice($newVal) {
        $this->price = $newVal;
    }
    
    
    public function getRoll() {
        return $this->product_roll;
    }
    
    public function setRoll($newVal) {
        $this->product_roll = $newVal;
    }

    /**
     * Magic method. Called on session restore.
     */
    public function __wakeup() {
        if ($this->refresh === true)
            $this->getOwner()->refresh();
    }

    /**
     * If we need to refresh model on restoring session.
     * Default is true.
     * @param boolean $refresh
     */
    public function setRefresh($refresh) {
        $this->refresh = $refresh;
    }

    /**
     * Add $price to position discount sum
     * @param float $price
     * @return void
     */
    public function addDiscountPrice($price) {
        $this->discountPrice += $price;
    }

    /**
     * Set position discount sum
     * @param float $price
     * @return void
     */
    public function setDiscountPrice($price) {
        $this->discountPrice = $price;
    }
    
    /**
     */
    public function getCartId() {
        return $this->cart_id;
    }
    
    public function setCartId($cart_id) {
        $this->cart_id = $cart_id;
    }
}
