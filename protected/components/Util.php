<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Util
 *
 * @author sahanj
 */
class Util {

    public static function is_element_empty($element) {
        if (is_array($element)) {
            $all_elements_empty = true;
            foreach ($element as $elmnt) {
                if ($elmnt != "") {
                    $all_elements_empty = false;
                    break;
                }
            }
            return $all_elements_empty;
        } else {
            if ($element == null || str_replace(' ','',strip_tags($element)) == '' || $element == 'null') {
                return TRUE;
            } else {
                return false;
            }
        }
    }

    public static function getRandomID($str = '') {
        if ($str !== '') {
            return $str . '-' . uniqid() . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
        } else {
            return uniqid() . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
        }
    }
    
    public static function getShoppingCartQuantity(){
        $shopping_cart_exams = Yii::app()->session[Consts::STR_SHOPPING_CART][Consts::STR_EXAMS];
        return sizeof($shopping_cart_exams);
    }

}
