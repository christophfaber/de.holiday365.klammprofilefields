<?php
namespace wcf\system\option\user;
use wcf\data\user\option\UserOption;
use wcf\data\user\User;
use wcf\util\StringUtil;

/**
 * @author      Christoph Faber
 * @license     GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @copyright   2015 Christoph Faber
 * @package     de.holiday365.klammprofilefields
 */
class KlammUserOptionOutput implements IUserOptionOutput {
    public function getOutput(User $user, UserOption $option, $value) {
        if(empty($value)) return;
        
        $klammURL = StringUtil::encodeHTML('http://www.klamm.de/user/' . $value);
        $value = intval($value);
        
        return '<a href="' . $klammURL . '" class="externalURL"' . (EXTERNAL_LINK_REL_NOFOLLOW ? ' rel="nofollow"' : '') . (EXTERNAL_LINK_TARGET_BLANK ? 'target="_blank"' : '') . '>' . $value . '</a>';
    }
}