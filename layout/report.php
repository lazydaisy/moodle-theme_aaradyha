<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * This is a one-line short description of the file
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    theme
 * @subpackage base_rtl
 * @copyright  2012 Mary Evans
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));

$hasmasthead = (!empty($PAGE->theme->settings->masthead));
$hasfootnote = (!empty($PAGE->theme->settings->footnote));

$custommenu = $OUTPUT->custom_menu($PAGE->theme->settings->custommenuitems);
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if ($showsidepre) {
   if (right_to_left()) {
        $bodyclasses[] = 'side-post-only';
    } else {
        $bodyclasses[] = 'side-pre-only';
    }
} else {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses))
?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">

    <div id="menublock">
    <?php if ($hascustommenu) { ?>
        <div id="custommenu"><?php echo $custommenu; ?></div>
    <?php } ?>
    </div>

<?php if ($hasheading || $hasnavbar) {
    ?>
    <div id="page-header">

    <?php if ($hasheading) {
        ?>

    <?php
    if ($hasmasthead ) {
        echo $PAGE->theme->settings->masthead;
    }else{ ?>
        <h1 class="headermain"><?php echo $PAGE->heading ?></h1>
    <?php }?>

        <div class="headermenu"><?php
        if ($haslogininfo) {
            echo $OUTPUT->login_info();
        }
        if (!empty($PAGE->layout_options['langmenu'])) {
            echo $OUTPUT->lang_menu();
        }
        echo $PAGE->headingmenu
        ?></div>

        <?php
} ?>

    <?php if ($hasnavbar) {
        ?>
        <div class="navbar clearfix">
        <div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
        <div class="navbutton"> <?php echo $PAGE->button; ?></div>
        </div>
        <?php
} ?>
    </div>
    <?php
} ?>
<!-- END OF HEADER -->

    <div id="page-content">
        <div id="region-main-box">
            <div id="region-pre-box">
                <div id="region-main">
                    <div class="region-content">
                        <?php echo $OUTPUT->main_content() ?>
                    </div>
                </div>

                    <?php
                if ($hassidepre and !right_to_left()) { ?>
                    <div id="region-pre" class="block-region">
                        <div class="region-content">
                            <?php echo $OUTPUT->blocks_for_region('side-pre');?>
                        </div>
                    </div>
                    <?php
                } ?>

                <?php if ($hassidepre and right_to_left() ) { ?>
                <div id="region-post" class="block-region">
                    <div class="region-content">
                        <?php echo $OUTPUT->blocks_for_region('side-pre'); ?>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>

<!-- START OF FOOTER -->
    <?php if ($hasfooter) { ?>
    <div id="page-footer" class="clearfix">
        <?php if ($hasfootnote) { ?>
                <div id="footnote"><?php echo $PAGE->theme->settings->footnote;?></div>
        <?php } ?>
        <p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')) ?></p>
        <?php
        echo $OUTPUT->login_info();
        echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>
    <?php
} ?>
</div>
<div id="scroll"></div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
