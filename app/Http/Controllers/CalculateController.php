<?php

namespace App\Http\Controllers;

class CalculateController extends Controller
{
    public $n1 = 5;
    public $n2 = 3;

    public function add()
    {
        return "The sum of $this->n1 and $this->n2 is " . $this->n1 + $this->n2;
    }

    public function subtract()
    {
        return "The difference of $this->n1 and $this->n2 is " . $this->n1 - $this->n2;
    }

    public function multiply()
    {
        return "The product of $this->n1 and $this->n2 is " . $this->n1 * $this->n2;
    }

    public function divide()
    {
        return "The quotient of $this->n1 and $this->n2 is " . $this->n1 / $this->n2;
    }

    public function modulo()
    {
        return "The remainder of $this->n1 and $this->n2 is " . $this->n1 % $this->n2;
    }
}
