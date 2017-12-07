<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class VoiceMailMain implements ApplicationInterface
{
    use StandardApplicationTrait;

    const SKIP_PASSWORD = 's';
    const MAIILBOX_AS_PREFIX = 'p';
    const GAIN_AMOUNT = 'g({option_value})';
    const START_WITH_FOLDER = 'a({option_value})';

    /**
     * @var string
     */
    protected $mailbox;

    /**
     * @var string
     */
    protected $context;

    /**
     * $options could be an array containing separate options or key => value pairs of options (as a key) and its arguments
     * ```php
     *  [
     *      self::SKIP_PASSWORD,
     *      self::GAIN_AMOUNT => 3,
     *      self::START_WITH_FOLDER => 1,
     *  ];
     * ```
     * Also $options could be a string of single or multiple comma separated options
     * ```php
     *  self::SKIP_PASSWORD
     *  's,p,a(0)'
     * ```
     * @var array|string
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
        if (is_array($this->options)) {
            $options = [];
            foreach ($this->options as $key => $option) {
                if (is_numeric($key)) {
                    $options[] = $option;
                } else {
                    if (in_array($key, [self::GAIN_AMOUNT, self::START_WITH_FOLDER])) {
                        $options[] = strtr($key, ['{option_value}' => $option]);
                    }
                }
            }
            return implode(',', $options);
        } else {
            return $this->options;
        }
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
        return "{$this->mailbox}@{$this->context},{$this->getOptions()}";
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