<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package chiro-schelle-15
 * Template Name: Programma
 */


function getProgramByGroup($groupId) {

    global $wpdb;
    $table_name = $wpdb->prefix . "programma";
    $sql = "SELECT datum, programma FROM " . $table_name ." WHERE (afdeling = %d OR afdeling = 17) AND datum >= NOW() - INTERVAL 1 DAY ORDER BY datum;";
    $query = $wpdb->prepare($sql, $groupId);
    $result = $wpdb->get_results($query);

    return $result;
}

$activities = [];
if(!$_GET['id']) {
    $activities = getProgramByGroup(17);
} else {
    $activities = getProgramByGroup($_GET['id']);
}


get_header(); ?>

	<section class="highlighted container padding">

        <div class="row">

            <div class="col-md-6">

                <div id="kiesafdeling" class="noprint">
                    <a href="?id=1">Ribbel &#9794;</a> ||
                    <a href="?id=3">Speelclub &#9794;</a> ||
                    <a href="?id=5">Rakkers</a> ||
                    <a href="?id=7">Toppers</a> ||
                    <a href="?id=9">Kerels</a> ||
                    <a href="?id=11">Aspi &#9794;</a> ||
                    <br/>
                    <a href="?id=2">Ribbel &#9792;</a> ||
                    <a href="?id=4">Speelclub &#9792;</a> ||
                    <a href="?id=6">Kwiks</a> ||
                    <a href="?id=8">Tippers</a> ||
                    <a href="?id=10">Tiptiens</a> ||
                    <a href="?id=12">Aspi &#9792;</a> ||
                    <!--<a href="?id=17">Activiteiten</a>-->
                </div>

            </div>

        </div>

	</section>

    <section class="container">

        <?php
            $id = $_GET['id'];
            $afdeling = "";
            
            switch ($id) {
                case 1:
                    $afdeling = "Ribbel Jongens";
                    break;
                case 2:
                    $afdeling = "Ribbel Meisjes";
                    break;
                case 3:
                    $afdeling = "Speelclub Jongens";
                    break;
                case 4:
                    $afdeling = "Speelclub Meisjes";
                    break;
                case 5:
                    $afdeling = "Rakkers";
                    break;
                case 6:
                    $afdeling = "Kwiks";
                    break;
                case 7:
                    $afdeling = "Toppers";
                    break;
                case 8:
                    $afdeling = "Tippers";
                    break;
                case 9:
                    $afdeling = "Kerels";
                    break;
                case 10:
                    $afdeling = "Tiptiens";
                    break;
                case 11:
                    $afdeling = "Aspi Jongens";
                    break;
                case 12:
                    $afdeling = "Aspi Meisjes";
                    break;
                default:
                    break;
            }
            echo '<section class="padding">';
            echo '<section class="padding">';
            echo '<h3>' . $afdeling . '</h3>';
            echo '</section>';
            echo '</section>';
            
            foreach($activities as $activity) {
                echo '<div class="activity">';
                    echo '<div class="date">' . date_i18n('l d F', strtotime($activity->datum)) . '</div>';
                    echo '<div class="program">' . nl2br($activity->programma) . '</div>';
                echo '</div>';
            }
        ?>

    </section>

<?php get_footer(); ?>