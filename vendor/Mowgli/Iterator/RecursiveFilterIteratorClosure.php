<?php

namespace Mowgli\Iterator;

class RecursiveFilterIteratorClosure extends \RecursiveFilterIterator
{
    /**
     * @var Closure
     */
    private $closure;

    /**
     * @param \RecursiveIterator $iterator
     * @param Closure $closure
     */
    public function __construct(\RecursiveIterator $iterator, \Closure $closure)
    {
        parent::__construct($iterator);
        
        $this->setClosure($closure);
    }


    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Check whether the current element of the iterator is acceptable
     *
     * @link http://php.net/manual/en/filteriterator.accept.php
     * @return bool true if the current element is acceptable, otherwise false.
     */
    public function accept()
    {
        return $this->getClosure()->__invoke($this->getInnerIterator()->current());
    }

    /**
     *
     * @return Closure
     */
    public function getClosure()
    {
        return $this->closure;
    }

    /**
     * @param Closure $closure
     */
    public function setClosure(\Closure $closure)
    {
        $this->closure = $closure;

        return $this;
    }
}
