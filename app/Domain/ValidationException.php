<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 06/12/20
 * Time: 14:55
 */

namespace App\Domain;


class ValidationException extends \Exception
{
    protected $arrError;

    public function __construct($arrError, $message, $code = 0, Exception $previous = null) {
        $this->arrError = $arrError;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getArrError()
    {
        return $this->arrError;
    }

    /**
     * @param mixed $arrError
     */
    public function setArrError($arrError): void
    {
        $this->arrError = $arrError;
    }

}