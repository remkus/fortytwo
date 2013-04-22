<?php /**
 * The additional data inserted into the menu edit box for menu objects of type menu-extension -> widget
 *
 * @category   Forsite Extension Pack
 * @package    Module
 * @subpackage Menu Extensions : View
 * @author     ForsiteThemes
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://forsitethemes.com
 */
?>
<p>This menu item will render any widgets added to the 
widget area named</p>
<em><a href="widgets.php" target="_blank"><?php echo $item->title ?></a></em>
<?php if (count($widget_descriptions) > 0) { ?>
<div class="link-to-original">
    Current widgets:
    <ul>
        <?php foreach ($widget_descriptions as $widget) {
            echo "<li>{$widget['name']}</li>";
    } ?>
    </ul>
</div>
<?php } ?>