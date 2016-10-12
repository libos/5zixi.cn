<?php
/**
<<<<<<< HEAD
 * CakeResque bootstrap file.
 *
 * Used to load CakeResque class and initialize it.
=======
 * CakeResque configuration file
 *
 * Use to set the default values for the workers settings
>>>>>>> 9294f37036299dd969ffbd84171d97325984a705
 *
 * PHP version 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        Wan Qi Chen <kami@kamisama.me>
 * @copyright     Copyright 2012, Wan Qi Chen <kami@kamisama.me>
 * @link          http://cakeresque.kamisama.me
 * @package       CakeResque
 * @subpackage	  CakeResque.Config
 * @since         0.5
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

require_once dirname(__DIR__) . DS . 'Lib' . DS . 'CakeResque.php';

CakeResque::init();
