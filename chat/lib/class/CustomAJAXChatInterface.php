<?php
/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

class CustomAJAXChatInterface extends CustomAJAXChat
{

    public function initialize()
    {
        // Initialize configuration settings:
        $this->initConfig();

        // Initialize the DataBase connection:
        $this->initDataBaseConnection();
    }
}
?>
