<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.3 (2013-05-19)
 * @info $Id: class.theme.php 2643 2013-03-26 17:13:31Z slaver7 $
 * @link http://2moons.cc/
 */
 
class Theme
{
    public static $Themes;
    private $THEMESETTINGS;
    
    public function __construct()
    {
        $this->skininfo = array();
        $this->skin        = isset($_SESSION['dpath']) ? $_SESSION['dpath'] : DEFAULT_THEME;
        $this->setUserTheme($this->skin);
    }
    
    public function isHome()
    {
        $this->template        = ROOT_PATH.'styles/home/';
        $this->customtpls    = array();
    }
    
    public function setUserTheme($Theme)
    {
        if (!file_exists(ROOT_PATH.'styles/theme/'.$Theme.'/style.cfg')) {
            return false;
        }
            
        $this->skin        = $Theme;
        $this->parseStyleCFG();
        $this->setStyleSettings();
    }
        
    public function getTheme()
    {
        return './styles/theme/'.$this->skin.'/';
    }
    
    public function getThemeName()
    {
        return $this->skin;
    }
    
    public function getTemplatePath()
    {
        return ROOT_PATH.'/styles/templates/'.$this->skin.'/';
    }
        
    public function isCustomTPL($tpl)
    {
        if (!isset($this->customtpls)) {
            return false;
        }
            
        return in_array($tpl, $this->customtpls);
    }
    
    public function parseStyleCFG()
    {
        require(ROOT_PATH.'styles/theme/'.$this->skin.'/style.cfg');
        $this->skininfo        = $Skin;
        $this->customtpls    = (array) $Skin['templates'];
    }
    
    public function setStyleSettings()
    {
        if (file_exists(ROOT_PATH.'styles/theme/'.$this->skin.'/settings.cfg')) {
            require(ROOT_PATH.'styles/theme/'.$this->skin.'/settings.cfg');
        }
        
        $this->THEMESETTINGS    = array_merge(array(
            'PLANET_ROWS_ON_OVERVIEW' => 2,
            'SHORTCUT_ROWS_ON_FLEET1' => 2,
            'COLONY_ROWS_ON_FLEET1' => 2,
            'ACS_ROWS_ON_FLEET1' => 1,
            'TOPNAV_SHORTLY_NUMBER' => 0,
        ), $THEMESETTINGS);
    }
    
    public function getStyleSettings()
    {
        return $this->THEMESETTINGS;
    }
    
    public static function getAvalibleSkins()
    {
        if (!isset(self::$Themes)) {
            if (file_exists(ROOT_PATH.'cache/cache.themes.php')) {
                self::$Themes    = unserialize(file_get_contents(ROOT_PATH.'cache/cache.themes.php'));
            } else {
                $Skins    = array_diff(scandir(ROOT_PATH.'styles/theme/'), array('..', '.', '.svn', '.htaccess', 'index.htm'));
                $Themes    = array();
                foreach ($Skins as $Theme) {
                    if (!file_exists(ROOT_PATH.'styles/theme/'.$Theme.'/style.cfg')) {
                        continue;
                    }
                        
                    require(ROOT_PATH.'styles/theme/'.$Theme.'/style.cfg');
                    $Themes[$Theme]    = $Skin['name'];
                }
                file_put_contents(ROOT_PATH.'cache/cache.themes.php', serialize($Themes));
                self::$Themes    = $Themes;
            }
        }
        return self::$Themes;
    }
}
