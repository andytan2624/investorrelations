<?php
$wpinvestors_plugin_url = WP_PLUGIN_URL . '/wpinvestors';
$options = array();
$display_json = false;
date_default_timezone_set('Australia/Canberra');
function wp_investors_menu() {
    add_menu_page(
        '',
        'Investors',
        'manage_options',
        'wpinvestors-top',
        'wp_investors_ticker_page'
    );
    add_submenu_page(
        'wpinvestors-top',
        'Share Price Ticker',
        'Share Price Ticker',
        'manage_options',
        'wpinvestors-top',
        'wp_investors_ticker_page'
    );
}
add_action('admin_menu', 'wp_investors_menu');
//Add styling page
function wp_investors_chart_menu() {
    add_submenu_page(
        'wpinvestors-top',
        'Share Price Chart',
        'Share Price Chart',
        'manage_options',
        'wpinvestors-chart',
        'wp_investors_chart_page'
    );
}
add_action('admin_menu', 'wp_investors_chart_menu');

//Add styling page
function wp_investors_history_menu() {
    add_submenu_page(
        'wpinvestors-top',
        'Share Price History',
        'Share Price History',
        'manage_options',
        'wpinvestors-history',
        'wp_investors_history_page'
    );
}
add_action('admin_menu', 'wp_investors_history_menu');

//Add styling page
function wp_investors_annoucements_menu() {
    add_submenu_page(
        'wpinvestors-top',
        'Annoucements',
        'Annoucements',
        'manage_options',
        'wpinvestors-annoucements',
        'wp_investors_annoucements_page'
    );
}
add_action('admin_menu', 'wp_investors_annoucements_menu');

//Create Settings page

//***************************************************************************************************
// Share Ticker Information
//***************************************************************************************************
function wp_investors_ticker_page() {

    global $wpinvestors_plugin_url;
    global $options;
    global $display_json;

    $hidden_field = "";

    // If the Create new button has been pressed
    if (isset($_POST['wpinvestors_ticker_form_submitted'])) {
        $hidden_field = esc_html($_POST['wpinvestors_ticker_form_submitted']);
        if ($hidden_field == "Y") {
            // Get option that tracks of all the sharetickers
            $share_ticker_counter = get_option("share_ticket_counter");
            if (!$share_ticker_counter) {
                // Create a new tracker for share tickers
                $share_ticker_counter = 1;
            } else {
                $share_ticker_counter++;
            }
            update_option("share_ticket_counter",$share_ticker_counter);
            $share_ticker_array = get_option("share_ticket_array");
            if (!$share_ticker_counter || !is_array($share_ticker_array)) {
                // Create a new tracker for share tickers
                $share_ticker_array = array();
            }
            // Add the name to the share ticker array
            $newname = "SHARE_PRICE_TICKER_$share_ticker_counter";
            $share_ticker_array[] = $newname;

            update_option("share_ticket_array",$share_ticker_array);

            // Now create the actual ticker
            $share_ticker = array();
            $share_ticker["id"] = $newname;
            $share_ticker["name"] = "";
            $share_ticker["ticker_code"] = "";
            $share_ticker["display_shortcode"] = "";
            $share_ticker["display_html"] = "";
            $share_ticker["SP_DATE_$share_ticker_counter"] = "";
            $share_ticker["SP_TIME_$share_ticker_counter"] = "";
            $share_ticker["SP_LAST_$share_ticker_counter"] = "";
            $share_ticker["SP_ASK_$share_ticker_counter"] = "";
            $share_ticker["SP_BID_$share_ticker_counter"] = "";
            $share_ticker["SP_HIGH_$share_ticker_counter"] = "";
            $share_ticker["SP_LOW_$share_ticker_counter"] = "";
            $share_ticker["SP_CHANGE_$share_ticker_counter"] = "";
            $share_ticker["SP_PERCENTCHANGE_$share_ticker_counter"] = "";
            $share_ticker["SP_VOLUME_$share_ticker_counter"] = "";
            $share_ticker["updated_date"] = date("d/m/Y H:i:s");

            add_option($newname,json_encode($share_ticker));

            wp_redirect( admin_url('admin.php?page=wpinvestors-top&ticker_code='.$newname),301 );
            exit;
        }
    }

    if (isset($_GET['ticker_code'])) {
        // Get the share price ticker
        $share_price_id = trim($_GET['ticker_code']);
        $share_price_object = get_option($share_price_id);
        $share_price_array = array();
        $pricefeed_output = array();
        $counter = 0;
        if ($share_price_object) {

            // If the delete option is here, we must delete it
            if (isset($_GET["delete"]) && $_GET["delete"] == 1) {
                // We must remove it from the list of arrays
                $share_ticker_array = get_option("share_ticket_array");
                if (is_array($share_ticker_array)) {
                    // Remove the share ticker from the array
                    $share_ticker_array = array_diff($share_ticker_array, array($share_price_id));
                    update_option("share_ticket_array",$share_ticker_array);
                }
                delete_option($share_price_id);
                wp_redirect( admin_url('admin.php?page=wpinvestors-top'),301 );
                exit;

            }
            $counter = intval(str_replace("SHARE_PRICE_TICKER_","",$share_price_id));
            $share_price_array = json_decode($share_price_object,true);

            //If the save button has been pressed for an individual object, with post parameters

            if (isset($_POST['wpinvestor_ticker_save']) && $_POST['wpinvestor_ticker_save'] != "") {

                $share_price_array["name"] = sanitize_text_field($_POST["wpinvestor_ticker_name"]);
                $share_price_array["ticker_code"] = sanitize_text_field($_POST["wpinvestor_ticker_code"]);
                $ticker_shortcode = isset($_POST["wpinvestor_ticker_shortcode"]) ? "1" : "";
                $share_price_array["display_shortcode"] = $ticker_shortcode;
                $ticker_html = isset($_POST["wpinvestor_ticker_html"]) ? "1" : "";
                $share_price_array["display_html"] = $ticker_html;
                if (isset($_POST["wpinvestor_ticker_date"]) && $_POST["wpinvestor_ticker_date"] != "none") {
                    $share_price_array["SP_DATE_$counter"] = sanitize_text_field($_POST["wpinvestor_ticker_date"]);

                }
                if (isset($_POST["wpinvestor_ticker_time"]) && $_POST["wpinvestor_ticker_time"] != "none") {
                    $share_price_array["SP_TIME_$counter"] = sanitize_text_field($_POST["wpinvestor_ticker_time"]);

                }
                if (isset($_POST["wpinvestor_ticker_last"]) && $_POST["wpinvestor_ticker_last"] != "none") {
                    $share_price_array["SP_LAST_$counter"] = sanitize_text_field($_POST["wpinvestor_ticker_last"]);

                }
                if (isset($_POST["wpinvestor_ticker_ask"]) && $_POST["wpinvestor_ticker_ask"] != "none") {
                    $share_price_array["SP_ASK_$counter"] = sanitize_text_field($_POST["wpinvestor_ticker_ask"]);

                }
                if (isset($_POST["wpinvestor_ticker_bid"]) && $_POST["wpinvestor_ticker_bid"] != "none") {
                    $share_price_array["SP_BID_$counter"] = sanitize_text_field($_POST["wpinvestor_ticker_bid"]);

                }
                if (isset($_POST["wpinvestor_ticker_high"]) && $_POST["wpinvestor_ticker_high"] != "none") {
                    $share_price_array["SP_HIGH_$counter"] = sanitize_text_field($_POST["wpinvestor_ticker_high"]);

                }
                if (isset($_POST["wpinvestor_ticker_low"]) && $_POST["wpinvestor_ticker_low"] != "none") {
                    $share_price_array["SP_LOW_$counter"] = sanitize_text_field($_POST["wpinvestor_ticker_low"]);

                }
                if (isset($_POST["wpinvestor_ticker_change"]) && $_POST["wpinvestor_ticker_change"] != "none") {
                    $share_price_array["SP_CHANGE_$counter"] = sanitize_text_field($_POST["wpinvestor_ticker_change"]);

                }
                if (isset($_POST["wpinvestor_ticker_percentchange"]) && $_POST["wpinvestor_ticker_percentchange"] != "none") {
                    $share_price_array["SP_PERCENTCHANGE_$counter"] = sanitize_text_field($_POST["wpinvestor_ticker_percentchange"]);

                }
                if (isset($_POST["wpinvestor_ticker_volume"]) && $_POST["wpinvestor_ticker_volume"] != "none") {
                    $share_price_array["SP_VOLUME_$counter"] = sanitize_text_field($_POST["wpinvestor_ticker_volume"]);

                }
                $share_price_array["updated_date"] = date("d/m/Y H:i:s");
                // Updare the individual
                update_option($share_price_id,json_encode($share_price_array));

//                wp_redirect( admin_url('admin.php?page=wpinvestors-top&ticker_code='.$share_price_id),301 );
//                exit;
            }
            // If the price feed button has been pressed, then let's parse the file
            if (isset($_POST['wpinvestors_price_feed']) && $_POST['wpinvestors_price_feed'] != "" && $_POST["wpinvestor_pricefeed"] != "") {
                $pricefeed_output = xmlParser(trim($_POST["wpinvestor_pricefeed"]),$counter);
            }

        }


        require('inc/ticker-page-edit.php');
    } else {
        // Get a list of all the existing tickers
        $share_ticker_counter = get_option("share_ticket_counter");

        $share_ticker_array = get_option("share_ticket_array");
        if (!$share_ticker_counter || !is_array($share_ticker_array)) {
            // Create a new tracker for share tickers
            $share_ticker_array = array();
        }
        require('inc/ticker-page-summary.php');
    }

} //End Settings_Page



//Create Chart page
function wp_investors_chart_page() {

    echo "<h1>Chart Page</h1>";

    echo "<a href='/ir/wp-admin/admin.php?page=wpinvestors-history&test=jul'>Test Link</a>";


    if (isset($_POST['wptreehouse_form_submitted'])) {
        $hidden_field = esc_html($_POST['wptreehouse_form_submitted']);
        if ($hidden_field == "Y") {
            $wptreehouse_username = esc_html($_POST['wptreehouse_username']);
            $wptreehouse_profile = wptreehouse_badges_get_profile($wptreehouse_username);

            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);

            if ((($_FILES["file"]["type"] == "image/gif")
                    || ($_FILES["file"]["type"] == "image/jpeg")
                    || ($_FILES["file"]["type"] == "image/jpg")
                    || ($_FILES["file"]["type"] == "image/pjpeg")
                    || ($_FILES["file"]["type"] == "image/x-png")
                    || ($_FILES["file"]["type"] == "image/png"))
                && ($_FILES["file"]["size"] < 10000000)
                && in_array($extension, $allowedExts)) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {
                    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
                    echo "Type: " . $_FILES["file"]["type"] . "<br>";
                    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
                    if (file_exists("upload/" . $_FILES["file"]["name"])) {
                        echo $_FILES["file"]["name"] . " already exists. ";
                    } else {

                        // Upload file
                        if(!move_uploaded_file($_FILES["file"]["tmp_name"],
                            plugins_url('wpinvestors/uploads')."/" . $_FILES["file"]["name"])){
                            echo 'Error uploading file - check destination is writeable.';
                        }
                        echo "Stored in: " . plugins_url('wpinvestors/uploads')."/" . $_FILES["file"]["name"];
                        echo "<br/>".$_FILES["file"]["tmp_name"];
                    }
                }
            } else {
                echo "Invalid file ".$_FILES["file"]["type"]." ===  ".$_FILES["file"]["size"]." ==== ".$extension;
            }
            echo "THIS IS THE END OF THE FILE";
        }
    }


    require('inc/chart-page-summary.php');


} //End Chart
//Create History page
function wp_investors_history_page() {

    echo "<h1>History Page</h1>";
    if (isset($_GET['test'])) {
//        echo "Andy and Mary";
    } else {
//        echo "Mary put on weight";
    }
} //End History _Page
//Create Style page
function wp_investors_annoucements_page() {

    echo "<h1>Annoucement Page</h1>";
} //End Style_Page

function doMyShortcode($atts,$content = null) {
    ob_start();
    echo 'Mary Lin is my girlfriend';
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode('say-hello-world', 'doMyShortcode');

function wpinvestors_field_shortcode($atts,$content = null) {
    global $post;
    $id = "";
    $field = "";
    extract(shortcode_atts(array(
        'field' => '',
        'id' => ''
    ),$atts));

    $output = "";
    $display = false;

    if ($field != "" && $id != "") {
        $ticker = get_option("SHARE_PRICE_TICKER_$id");
        if ($ticker) {
            $tickerArray = json_decode($ticker,true);
            if (isset($tickerArray[$field."_".$id])) {
                $output = $tickerArray[$field."_".$id];
            }
            if ($tickerArray["display_html"]) {
                $display = true;
            }
        }
    }
    ob_start();
    if ($display) {

        echo $output;
    }
    $content = ob_get_clean();

    return $content;
}
add_shortcode('wp-shortcode','wpinvestors_field_shortcode');

function wpinvestors_display_ticker($atts,$content = null) {
    global $post;
    $id = "";
    extract(shortcode_atts(array(
        'id' => ''
    ),$atts));

    $share_price_array = array();
    $display = false;
    if ($id != "") {

        $ticker = get_option("SHARE_PRICE_TICKER_$id");
        if ($ticker) {
            $share_price_array = json_decode($ticker,true);
            if ($share_price_array["display_shortcode"]) {
                $display = true;
            }
        }
    }
    ob_start();
    $content = ob_get_clean();
    if ($display) {
        require('inc/ticker-page-frontend.php');
    }
    return $content;
}
add_shortcode('wp-shareprice','wpinvestors_display_ticker');

//************************************************************************************************************
// Other misc functions
//************************************************************************************************************

function xmlParser($xml,$counter) {
    $output = array();
    $xmlCode = simplexml_load_file($xml);
    if ($xmlCode) {
        // Check if we're parsing for xml sample 1
        if ($xmlCode->header && $xmlCode->header->dataDateTime != "") {
            $dateTimeArray = explode("T",$xmlCode->header->dataDateTime);
            $output["wpinvestor_ticker_date"] = trim($dateTimeArray[0]);
            $output["wpinvestor_ticker_time"] = trim($dateTimeArray[1]);
        }
        if ($xmlCode->snap && $xmlCode->snap->equityDomainGroup &&
            $xmlCode->snap->equityDomainGroup->equityDomain && $xmlCode->snap->equityDomainGroup->equityDomain->tradePrice &&
            $xmlCode->snap->equityDomainGroup->equityDomain->tradePrice->last != "") {
            $output["wpinvestor_ticker_last"] = trim($xmlCode->snap->equityDomainGroup->equityDomain->tradePrice->last);
        }

        if ($xmlCode->snap && $xmlCode->snap->equityDomainGroup &&
            $xmlCode->snap->equityDomainGroup->equityDomain && $xmlCode->snap->equityDomainGroup->equityDomain->tradePrice &&
            $xmlCode->snap->equityDomainGroup->equityDomain->tradePrice->bid != "") {
            $output["wpinvestor_ticker_bid"] = trim($xmlCode->snap->equityDomainGroup->equityDomain->tradePrice->bid);
        }
        if ($xmlCode->snap && $xmlCode->snap->equityDomainGroup &&
            $xmlCode->snap->equityDomainGroup->equityDomain && $xmlCode->snap->equityDomainGroup->equityDomain->tradePrice &&
            $xmlCode->snap->equityDomainGroup->equityDomain->tradePrice->high != "") {
            $output["wpinvestor_ticker_high"] = trim($xmlCode->snap->equityDomainGroup->equityDomain->tradePrice->high);
        }
        if ($xmlCode->snap && $xmlCode->snap->equityDomainGroup &&
            $xmlCode->snap->equityDomainGroup->equityDomain && $xmlCode->snap->equityDomainGroup->equityDomain->tradePrice &&
            $xmlCode->snap->equityDomainGroup->equityDomain->tradePrice->low != "") {
            $output["wpinvestor_ticker_low"] = trim($xmlCode->snap->equityDomainGroup->equityDomain->tradePrice->low);
        }
        if ($xmlCode->snap && $xmlCode->snap->equityDomainGroup &&
            $xmlCode->snap->equityDomainGroup->equityDomain && $xmlCode->snap->equityDomainGroup->equityDomain->tradePrice &&
            $xmlCode->snap->equityDomainGroup->equityDomain->tradePrice->change != "") {
            $output["wpinvestor_ticker_change"] = trim($xmlCode->snap->equityDomainGroup->equityDomain->tradePrice->change);
        }
        if ($xmlCode->snap && $xmlCode->snap->equityDomainGroup &&
            $xmlCode->snap->equityDomainGroup->equityDomain && $xmlCode->snap->equityDomainGroup->equityDomain->tradePrice &&
            $xmlCode->snap->equityDomainGroup->equityDomain->tradePrice->percentChange != "") {
            $output["wpinvestor_ticker_percentchange"] = trim($xmlCode->snap->equityDomainGroup->equityDomain->tradePrice->percentChange);
        }
        if ($xmlCode->snap && $xmlCode->snap->equityDomainGroup &&
            $xmlCode->snap->equityDomainGroup->equityDomain && $xmlCode->snap->equityDomainGroup->equityDomain->tradeVolume &&
            $xmlCode->snap->equityDomainGroup->equityDomain->tradeVolume->totalVolume != "") {
            $output["wpinvestor_ticker_volume"] = trim($xmlCode->snap->equityDomainGroup->equityDomain->tradeVolume->totalVolume);
        }

        // Check if we're parsing the xml sample 2
        if ($xmlCode->Date != "") {
            $output["wpinvestor_ticker_date"] = trim($xmlCode->Date);
        }
        if ($xmlCode->Time != "") {
            $output["wpinvestor_ticker_time"] = trim($xmlCode->Time);
        }
        if ($xmlCode->Last != "") {
            $output["wpinvestor_ticker_last"] = trim($xmlCode->Last);
        }
        if ($xmlCode->Ask != "") {
            $output["wpinvestor_ticker_ask"] = trim($xmlCode->Ask);
        }
        if ($xmlCode->Bid != "") {
            $output["wpinvestor_ticker_bid"] = trim($xmlCode->Bid);
        }
        if ($xmlCode->High != "") {
            $output["wpinvestor_ticker_high"] = trim($xmlCode->High);
        }
        if ($xmlCode->Low != "") {
            $output["wpinvestor_ticker_low"] = trim($xmlCode->Low);
        }
        if ($xmlCode->Change != "") {
            $output["wpinvestor_ticker_change"] = trim($xmlCode->Change);
        }
        if ($xmlCode->PercentChange != "") {
            $output["wpinvestor_ticker_percentchange"] = trim($xmlCode->PercentChange);
        }
        if ($xmlCode->Volume != "") {
            $output["wpinvestor_ticker_volume"] = trim($xmlCode->Volume);
        }

    }
    return $output;
}

function xml_child_exists($xml, $childpath)
{
    $result = $xml->xpath($childpath);
    return (bool) (count($result));
}

?>