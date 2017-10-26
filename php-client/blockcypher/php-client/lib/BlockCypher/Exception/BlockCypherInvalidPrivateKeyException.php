<?php

namespace BlockCypher\Exception;

/**
 * Class BlockCypherInvalidPrivateKeyException
 *
 * @package BlockCypher\Exception
 */
class BlockCypherInvalidPrivateKeyException extends \Exception
{
    /**
     * Default Constructor
     *
     * @param string|null $message
     * @param int $code
     */
    public function __construct($message = null, $code = 0)
    {
        parent::__construct($message, $code);
    }

    /**
     * prints error message
     *
     * @return string
     */
    public function errorMessage()
    {
        $errorMsg = 'Error on line ' . $this->getLine() . ' in ' . $this->getFile()
            . ': <b>' . $this->getMessage() . '</b>';
        return $errorMsg;
    }

}
