<?php

/**
 * FormException
 */
class FormException extends Exception
{
    /**
     * attributName
     * @var string
     */
    private string $attributName;
    public function __construct(string $message, string $attributName, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->attributName = $attributName;
    }

    /**
     * return attributName
     * @return string
     */
    public function getAttributName(): string
    {
        return $this->attributName;
    }
}
