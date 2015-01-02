<?php

/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2014 Digital Deals s.r.o. 
 * @license http://www.digitaldeals/license/
 */

namespace dlds\metronic;

use Yii;
use yii\web\AssetBundle;
use yii\base\InvalidConfigException;
use dlds\metronic\bundles\ThemeAsset;

/**
 * This is the class Metronic Component
 */
class Metronic extends \yii\base\Component {

    /**
     * @var AssetBundle
     */
    public static $assetsBundle;

    /**
     * Theme
     */
    const VERSION_1 = 'layout';
    const VERSION_2 = 'layout2';
    const VERSION_3 = 'layout3';
    const VERSION_4 = 'layout4';

    /**
     * Theme
     */
    const THEME_DARK = 'default';
    const THEME_LIGHT = 'light';

    /**
     * Style
     */
    const STYLE_SQUARE = 'default';
    const STYLE_ROUNDED = 'rounded';

    /**
     * Layout
     */
    const LAYOUT_FLUID = 'default';
    const LAYOUT_BOXED = 'boxed';

    /**
     * Header
     */
    const HEADER_DEFAULT = 'default';
    const HEADER_FIXED = 'fixed';

    /**
     * Header Dropdowns
     */
    const HEADER_DROPDOWN_DARK = 'dark';
    const HEADER_DROPDOWN_LIGHT = 'light';

    /**
     * Sidebar
     */
    const SIDEBAR_DEFAULT = 'default';
    const SIDEBAR_FIXED = 'fixed';

    /**
     * Sidebar menu
     */
    const SIDEBAR_MENU_ACCORDION = 'accordion';
    const SIDEBAR_MENU_HOVER = 'hover';

    /**
     * Sidebar position
     */
    const SIDEBAR_POSITION_LEFT = 'left';
    const SIDEBAR_POSITION_RIGHT = 'right';

    /**
     * Footer
     */
    const FOOTER_DEFAULT = 'default';
    const FOOTER_FIXED = 'fixed';

    /**
     * Search string
     */
    const PARAM_VERSION = '{version}';
    const PARAM_THEME = '{theme}';

    /**
     * @var string version
     */
    public $version = self::VERSION_4;

    /**
     * @var string Theme
     */
    public $theme = self::THEME_LIGHT;

    /**
     * @var string Theme style
     */
    public $style = self::STYLE_ROUNDED;

    /**
     * @var string Layout mode
     */
    public $layoutOption = self::LAYOUT_FLUID;

    /**
     * @var string Header display
     */
    public $headerOption = self::HEADER_FIXED;

    /**
     * @var string Header dropdowns
     */
    public $headerDropdown = self::HEADER_DROPDOWN_DARK;

    /**
     * @var string Sidebar display
     */
    public $sidebarOption = self::SIDEBAR_DEFAULT;

    /**
     * @var string Sidebar display
     */
    public $sidebarMenu = self::SIDEBAR_MENU_ACCORDION;

    /**
     * @var string Sidebar position
     */
    public $sidebarPosition = self::SIDEBAR_POSITION_LEFT;

    /**
     * @var string Footer display
     */
    public $footerOption = self::FOOTER_DEFAULT;

    /**
     * @var string Component name used in the application
     */
    public static $componentName = 'metronic';

    /**
     * Inits module
     */
    public function init()
    {
        if (self::SIDEBAR_FIXED === $this->sidebarOption && self::SIDEBAR_MENU_HOVER === $this->sidebarMenu)
        {
            throw new InvalidConfigException('Hover Sidebar Menu is not compatible with Fixed Sidebar Mode. Select Default Sidebar Mode Instead.');
        }

        Yii::$classMap['yii\helpers\Html'] = __DIR__ . '/helpers/Html.php';
    }

    public function parseAssetsParams(&$string)
    {
        if (preg_match('/\{[a-z]+\}/', $string))
        {
            $string = str_replace(static::PARAM_VERSION, $this->version, $string);

            $string = str_replace(static::PARAM_THEME, $this->theme, $string);
        }
    }

    /**
     * @return Metronic Get Metronic component
     */
    public static function getComponent()
    {
        return Yii::$app->{static::$componentName};
    }

    /**
     * Get base url to metronic assets
     * @param $view View
     * @return string
     */
    public static function getAssetsUrl($view)
    {
        if (static::$assetsBundle === null)
        {
            static::$assetsBundle = static::registerThemeAsset($view);
        }

        return (static::$assetsBundle instanceof AssetBundle) ? static::$assetsBundle->baseUrl : '';
    }

    /**
     * Register Theme Asset
     * @param $view View
     * @return AssetBundle
     */
    public static function registerThemeAsset($view)
    {
        return static::$assetsBundle = ThemeAsset::register($view);
    }

}
