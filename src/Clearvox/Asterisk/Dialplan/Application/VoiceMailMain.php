<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class VoiceMailMain implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $mailbox;

    /**
     * @var string
     */
    protected $context;

    /**
     * @var string
     */
    protected $options;

    /**
     * Enters the main voicemail system for the checking of voicemail.
     *
     * @param $mailbox
     * @param $context
     * @param $options
     */
    public function __construct($mailbox, $context, $options)
    {
        $this->mailbox = $mailbox;
        $this->context = $context;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getMailbox()
    {
        return $this->mailbox;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'VoiceMailMain';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        return "{$this->mailbox}@{$this->context},{$this->options}";
    }

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'mailbox' => $this->mailbox,
            'context' => $this->context,
            'options' => $this->options,
        ];
    }

    /**
     * Turns this Application into a json representation
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}