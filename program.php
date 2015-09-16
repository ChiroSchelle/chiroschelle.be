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
    $sql = "SELECT datum, programma FROM " . $table_name ." WHERE afdeling = %d AND datum > NOW() ORDER BY datum;";
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
                    <a href="?id=17">Activiteiten</a>
                </div>

            </div>

            <!-- <div class="col-md-6">
                <div id="kalender" class="noprint">
                    <?php /*if ($_GET['toon']== 'datum'){*/include_once( TEMPLATEPATH . '/template-parts/calendar.php');/*}*/ ?>
                </div>
            </div> -->

        </div>

	</section>

    <section class="container">

        <?php
            foreach($activities as $activity) {
                echo '<div class="activity">';
                    echo '<div class="date">' . date_i18n(get_option( 'date_format' ), strtotime($activity->datum)) . '</div>';
                    echo '<div class="program">' . nl2br($activity->programma) . '</div>';
                echo '</div>';
            }
        ?>

    </section>

<?php get_footer(); ?>