<?php

use Phalcon\Flash\Direct as Flash;

class FlashCustom extends Flash
{
    /**
     * Messages collection
     * @var array
     */
    protected $messages;

    /**
     * Default css classes collection
     * You can add by contruct's params
     * @var array
     */
    protected $cssClasses = [
        'error'   => 'errorMessage',
        'success' => 'successMessage',
        'notice'  => 'noticeMessage',
        'warning' => 'warningMessage',
    ];

    /**
     * Constructor
     * @param array $cssClasses
     * @return FlashCustom
     */
    public function __construct(array $cssClasses = null)
    {
        if (!is_null($cssClasses))
        {
            if (count($cssClasses))
            {
                foreach ($cssClasses as $type => $class)
                {
                    $this->cssClasses[$type] = $class;
                }
            }
        }
    }

    /**
     * Returns current messages
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Adds message to stack
     * @param string $type
     * @param string $text
     * @return Flash
     */
    public function message($type, $text)
    {
        $this->messages[] = [
            'type' => $type,
            'text' => $text,
        ];
        return $this;
    }

    /**
     * Adds error message to stack
     * @param string $text
     * @return Flash
     */
    public function error($text)
    {
        $this->messages[] = [
            'type' => 'error',
            'text' => $text,
        ];
        return $this;
    }

    /**
     * Adds notice message to stack
     * @param string $text
     * @return Flash
     */
    public function notice($text)
    {
        $this->messages[] = [
            'type' => 'notice',
            'text' => $text,
        ];
        return $this;
    }

    /**
     * Adds success message to stack
     * @param string $text
     * @return Flash
     */
    public function success($text)
    {
        $this->messages[] = [
            'type' => 'success',
            'text' => $text,
        ];
        return $this;
    }

    /**
     * Adds warning message to stack
     * @param string $text
     * @return Flash
     */
    public function warning($text)
    {
        $this->messages[] = [
            'type' => 'warning',
            'text' => $text,
        ];
        return $this;
    }

    /**
     * Outputs messages from stack
     * @param
     * @return string
     */
    public function output($remove = null)
    {
        $output = '';
        if (count($this->messages))
        {
            foreach ($this->messages as $message)
            {
                // Configure css class
                $cssClass = '';
                if (!empty($this->cssClasses[$message['type']]))
                {
                    $cssClass = $this->cssClasses[$message['type']];
                }
                // Append custom output
                $output .= '<div class="' . $cssClass . '">'
                           . $message['text']
                           . '<a href="#" class="close" title="close" aria-label="close">&times;</a>'
                           . '</div>';
            }
        }
        return $output;
    }

    /**
     * Outputs all messages
     * @return string
     */
    public function __toString()
    {
        return $this->output();
    }
}
