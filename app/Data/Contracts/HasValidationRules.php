<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 2.11.20
 * Time: 4:15 PM
 */

namespace Framework\Data\Contracts;


interface HasValidationRules
{
    public static function getValidationRules() : array;
}
