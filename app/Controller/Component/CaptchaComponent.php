<?php

App::uses('Component', 'Controller');

class CaptchaComponent extends Component
{

    public $components = array('Session');

    public $settings = array();
    public $response;

    private $__defaults = array(
        'width'      => 65,
        'height'     => 25,
        'rotate'     => false,
        'fontSize'   => 16,
        'characters' => 4,
        'sessionKey' => 'Captcha.code'
    );

    /**
     * Default monospaced fonts available
     *
     * The font files (.ttf) are stored in app/Lib/Fonts
     *
     * @var array
     */
    private $__fontTypes = array('anonymous', 'droidsans', 'ubuntu');

    /**
     * Initializes CaptchaComponent for use in the controller
     *
     * @param Controller $controller A reference to the instantiating controller object
     * @return void
     */
    public function initialize(Controller $controller) {
        $this->response = $controller->response;
    }
    /**
     * Constructor
     *
     * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
     * @param array $settings Array of configuration settings.
     */
    public function __construct(ComponentCollection $collection, $settings = array())
    {
        parent::__construct($collection, array_merge($this->__defaults, $settings));
    }

    /**
     * Generate random alphanumeric code to specified character length
     *
     * @access private
     * @return string The generated code
     */
    private function __randomCode()
    {
        $valid = 'abcdefghijklmnpqrstuvwxyz123456789';
        return substr(str_shuffle($valid), 0, $this->settings['characters']);
    }

    /**
     * Generate and output the random captcha code image according to specified
     * settings and store the image text value in the session.
     *
     * @access public
     * @return void
     */
    public function generate()
    {
        $text = $this->__randomCode();

        $width  = (int) $this->settings['width'];
        $height = (int) $this->settings['height'];

        $image = imagecreatetruecolor($width, $height);

        $bkgColour = imagecolorallocate($image, 238,239,239);
        $borColour = imagecolorallocate($image, 208,208,208);
        $txtColour = imagecolorallocate($image, 96, 96, 96);

        imagefilledrectangle($image, 0, 0, $width, $height, $bkgColour);
        imagerectangle($image, 0, 0, $width-1, $height - 1, $borColour);

        $noiseColour = imagecolorallocate($image, 205, 205, 193);

        // Add random circle noise
        for ($i = 0; $i < ($width * $height) / 3; $i++)
        {
            imagefilledellipse($image, mt_rand(0, $width), mt_rand(0, $height),
                    mt_rand(0,3), mt_rand(0,3), $noiseColour);
        }

        // Add random rectangle noise
        for ($i = 0; $i < ($width + $height) / 5; $i++)
        {
            imagerectangle($image, mt_rand(0,$width), mt_rand(0,$height),
                    mt_rand(0,$width), mt_rand(0,$height), $noiseColour);
        }

        // Gets full path to fonts dir
        $fontsPath = dirname(dirname(dirname(__FILE__))) . DS . 'Lib' . DS . 'Fonts';

        // Randomize font selection
        $fontName = "{$this->__fontTypes[array_rand($this->__fontTypes)]}.ttf";

        $font = $fontsPath . DS . $fontName;

        // If specified, rotate text
        $angle = 0;
        if($this->settings['rotate'])
        {
            $angle = rand(-15, 15);
        }

        $box = imagettfbbox($this->settings['fontSize'], $angle, $font, $text);
        $x = ($width  - $box[4]) / 2;
        $y = ($height - $box[5]) / 2;

        imagettftext($image, $this->settings['fontSize'], $angle, $x, $y,
                $txtColour, $font, $text);

        $this->Session->delete($this->settings['sessionKey']);
        $this->Session->write($this->settings['sessionKey'], $text);

        $this->response->type('jpg');
        $this->response->body(imagejpeg($image));
        $this->response->disableCache();
    }

    /**
     * Get captcha code stored in Session
     *
     * @access public
     * @return string The generated captcha code text
     */
    public function getCode()
    {
        return $this->Session->read($this->settings['sessionKey']);
    }

}
