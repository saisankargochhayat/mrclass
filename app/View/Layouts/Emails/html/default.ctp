<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts.Email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
    <head><title><?php echo $this->fetch('title'); ?></title></head>
    <body>
        <p><img src="<?php echo HTTP_ROOT?>img/logo.png" alt="" height="35" width="140" /></p>
        <div style="width:100%;background:#F0F0F0;padding:0px;">
            <div style="position:relative;width:100%;background:#fff;padding:20px;margin:0 auto;border-top:7px solid #6CC487;">
                <?php echo $this->fetch('content'); ?>
                <p>&nbsp;</p>
                <p style="line-height: 20px;"><?php echo Configure::read('COMPANY.FOOTER'); ?></p>
            </div>	
        </div>	
        <p style="text-align: left;font-size: 12px;color:#666">&copy; <?php echo date("Y"); ?> <?php echo Configure::read('COMPANY.NAME'); ?>. All Rights Reserved. <?php echo Configure::read('COMPANY.ADDRESS'); ?> </p>
    </body>
</html>