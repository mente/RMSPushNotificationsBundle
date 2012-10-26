<?php

namespace RMS\PushNotificationsBundle\Message;

use RMS\PushNotificationsBundle\Device\Types;

use IteratorAggregate,
    Traversable,
    ArrayIterator;

/**
 * @author avasilenko
 */
class BulkiOSMessage implements MessageInterface, IteratorAggregate
{
    /**
     * @var iOSMessage[]
     */
    private $messages;
    /**
     * Current message to use
     * @var iOSMessage|null
     */
    private $current;

    public function __construct(array $messages = array())
    {
        $this->messages = $messages;
        $this->current = end($this->messages);
    }

    public function addMessage(iOSMessage $message)
    {
        $this->messages[] = $message;
        $this->current = end($this->messages);
    }

    public function addMessages(array $messages)
    {
        $this->messages += $messages;
        $this->current = end($this->messages);
    }

    public function setMessage($message)
    {
        if (false === $this->current) {
            throw new \BadMethodCallException("Current is not set");
        }

        $this->current->setMessage($message);
    }

    public function setData($data)
    {
        if (false === $this->current) {
            throw new \BadMethodCallException("Current is not set");
        }
        $this->current->setData($data);
    }

    public function setDeviceIdentifier($identifier)
    {
        if (false === $this->current) {
            throw new \BadMethodCallException("Current is not set");
        }
        $this->current->setDeviceIdentifier($identifier);
    }

    public function getMessageBody()
    {
        return $this->current->getMessageBody();
    }

    public function getDeviceIdentifier()
    {
        return $this->current->getDeviceIdentifier();
    }

    public function getTargetOS()
    {
        return Types::OS_IOS;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->messages);
    }
}
