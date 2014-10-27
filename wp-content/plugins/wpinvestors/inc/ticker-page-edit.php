<div class="wrap">

<div id="icon-options-general" class="icon32"></div>
<h2>SHARE PRICE TICKER</h2>

<div id="poststuff">

<div id="post-body" class="metabox-holder columns-2">

<!-- main content -->
<div id="post-body-content">

    <div class="meta-box-sortables ui-sortable">

        <div class="postbox">

            <div class="inside">
                <?PHP
                if (count($share_price_array) > 0) {
                    ?>
                    <form name="wptreehouse_username_form" method="post"
                          action="<?php echo admin_url('admin.php?page=wpinvestors-top&ticker_code=' . $share_price_id . ''); ?>">
                        <input type="hidden" name="wpinvestors_ticker_edit_form_submitted" value="Y"/>

                        <table class="form-table">
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_name">Name: </label></td>
                                <td><input name="wpinvestor_ticker_name" id="wpinvestor_ticker_name" type="text"
                                           value="<?PHP echo $share_price_array["name"];?>" class="regular-text"/></td>
                            </tr>
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_code">Ticker Code: </label></td>
                                <td><input name="wpinvestor_ticker_code" id="wpinvestor_ticker_code" type="text"
                                           value="<?PHP echo $share_price_array["ticker_code"];?>" class="regular-text"/></td>
                            </tr>
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_display">Display Options: </label></td>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>Fieldset Example</span></legend>
                                        <label for="users_can_register">
                                            <input name="wpinvestor_ticker_shortcode" type="checkbox" id="wpinvestor_ticker_shortcode"
                                                   value="1"  <?PHP echo $share_price_array["display_shortcode"] == 1 ? "checked" : "";?> />
                                            Shortcodes [wp-shareprice id='<?PHP echo $counter; ?>']
                                        </label>
                                    </fieldset>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>Fieldset Example</span></legend>
                                        <label for="users_can_register">
                                            <input name="wpinvestor_ticker_html" type="checkbox" id="wpinvestor_ticker_html"
                                                   value="1" <?PHP echo $share_price_array["display_html"] == 1 ? "checked" : "";?>/>
                                            HTML Tags
                                        </label>
                                    </fieldset>
                                </td>
                            </tr>
                        </table>

                        <table class="form-table">
                            <tr>
                                <td class="row-title"><label for="wpinvestor_pricefeed">Price Feed: </label></td>
                                <td><input name="wpinvestor_pricefeed" id="wpinvestor_pricefeed" type="text"
                                           value="" class="regular-text"/></td>
                                <td class="row-title"><input class="button-primary" type="submit" name="wpinvestors_price_feed"
                                                             value="<?php _e('Read'); ?>"/></td>

                            </tr>
                        </table>
                        <table class="form-table ticker-drop-options">
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_date">Date </label></td>
                                <td>
                                    <select name="wpinvestor_ticker_date" id="wpinvestor_ticker_date">
                                        <option  value="none"></option>
                                        <?PHP
                                        if (isset($pricefeed_output["wpinvestor_ticker_date"]) && $pricefeed_output["wpinvestor_ticker_date"] != "") {
                                            ?>
                                            <option value="<?PHP echo $pricefeed_output["wpinvestor_ticker_date"];?>"><?PHP echo $pricefeed_output["wpinvestor_ticker_date"];?></option>
                                            <?PHP
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><?PHP echo $share_price_array["SP_DATE_$counter"]; ?></td>
                                <td>[wp-shortcode field='SP_DATE' id='<?PHP echo $counter; ?>']</td>
                            </tr>
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_time">Time </label></td>
                                <td>
                                    <select name="wpinvestor_ticker_time" id="wpinvestor_ticker_time">
                                        <option  value="none"></option>
                                        <?PHP
                                        if (isset($pricefeed_output["wpinvestor_ticker_time"]) && $pricefeed_output["wpinvestor_ticker_time"] != "") {
                                            ?>
                                            <option value="<?PHP echo $pricefeed_output["wpinvestor_ticker_time"];?>"><?PHP echo $pricefeed_output["wpinvestor_ticker_time"];?></option>
                                        <?PHP
                                        }
                                        ?>                                    </select>
                                </td>
                                <td><?PHP echo $share_price_array["SP_TIME_$counter"]; ?></td>
                                <td>[wp-shortcode field='SP_TIME' id='<?PHP echo $counter; ?>']</td>

                            </tr>
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_last">Last </label></td>
                                <td>
                                    <select name="wpinvestor_ticker_last" id="wpinvestor_ticker_last">
                                        <option  value="none"></option>
                                        <?PHP
                                        if (isset($pricefeed_output["wpinvestor_ticker_last"]) && $pricefeed_output["wpinvestor_ticker_last"] != "") {
                                            ?>
                                            <option value="<?PHP echo $pricefeed_output["wpinvestor_ticker_last"];?>"><?PHP echo $pricefeed_output["wpinvestor_ticker_last"];?></option>
                                        <?PHP
                                        }
                                        ?>                                    </select>
                                </td>
                                <td><?PHP echo $share_price_array["SP_LAST_$counter"]; ?></td>
                                <td>[wp-shortcode field='SP_LAST' id='<?PHP echo $counter; ?>']</td>

                            </tr>
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_ask">Ask </label></td>
                                <td>
                                    <select name="wpinvestor_ticker_ask" id="wpinvestor_ticker_ask">
                                        <option  value="none"></option>
                                        <?PHP
                                        if (isset($pricefeed_output["wpinvestor_ticker_ask"]) && $pricefeed_output["wpinvestor_ticker_ask"] != "") {
                                            ?>
                                            <option value="<?PHP echo $pricefeed_output["wpinvestor_ticker_ask"];?>"><?PHP echo $pricefeed_output["wpinvestor_ticker_ask"];?></option>
                                        <?PHP
                                        }
                                        ?>                                    </select>
                                </td>
                                <td><?PHP echo $share_price_array["SP_ASK_$counter"]; ?></td>
                                <td>[wp-shortcode field='SP_ASK' id='<?PHP echo $counter; ?>']</td>

                            </tr>
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_bid">Bid </label></td>
                                <td>
                                    <select name="wpinvestor_ticker_bid" id="wpinvestor_ticker_bid">
                                        <option  value="none"></option>
                                        <?PHP
                                        if (isset($pricefeed_output["wpinvestor_ticker_bid"]) && $pricefeed_output["wpinvestor_ticker_bid"] != "") {
                                            ?>
                                            <option value="<?PHP echo $pricefeed_output["wpinvestor_ticker_bid"];?>"><?PHP echo $pricefeed_output["wpinvestor_ticker_bid"];?></option>
                                        <?PHP
                                        }
                                        ?>                                    </select>
                                </td>
                                <td><?PHP echo $share_price_array["SP_BID_$counter"]; ?></td>
                                <td>[wp-shortcode field='SP_BID' id='<?PHP echo $counter; ?>']</td>

                            </tr>
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_high">High </label></td>
                                <td>
                                    <select name="wpinvestor_ticker_high" id="wpinvestor_ticker_high">
                                        <option  value="none"></option>
                                        <?PHP
                                        if (isset($pricefeed_output["wpinvestor_ticker_high"]) && $pricefeed_output["wpinvestor_ticker_high"] != "") {
                                            ?>
                                            <option value="<?PHP echo $pricefeed_output["wpinvestor_ticker_high"];?>"><?PHP echo $pricefeed_output["wpinvestor_ticker_high"];?></option>
                                        <?PHP
                                        }
                                        ?>                                    </select>
                                </td>
                                <td><?PHP echo $share_price_array["SP_HIGH_$counter"]; ?></td>
                                <td>[wp-shortcode field='SP_HIGH' id='<?PHP echo $counter; ?>']</td>

                            </tr>
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_low">Low </label></td>
                                <td>
                                    <select name="wpinvestor_ticker_low" id="wpinvestor_ticker_low">
                                        <option  value="none"></option>
                                        <?PHP
                                        if (isset($pricefeed_output["wpinvestor_ticker_low"]) && $pricefeed_output["wpinvestor_ticker_low"] != "") {
                                            ?>
                                            <option value="<?PHP echo $pricefeed_output["wpinvestor_ticker_low"];?>"><?PHP echo $pricefeed_output["wpinvestor_ticker_low"];?></option>
                                        <?PHP
                                        }
                                        ?>                                    </select>
                                </td>
                                <td><?PHP echo $share_price_array["SP_LOW_$counter"]; ?></td>
                                <td>[wp-shortcode field='SP_LOW' id='<?PHP echo $counter; ?>']</td>

                            </tr>
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_change">Change </label></td>
                                <td>
                                    <select name="wpinvestor_ticker_change" id="wpinvestor_ticker_change">
                                        <option  value="none"></option>
                                        <?PHP
                                        if (isset($pricefeed_output["wpinvestor_ticker_change"]) && $pricefeed_output["wpinvestor_ticker_change"] != "") {
                                            ?>
                                            <option value="<?PHP echo $pricefeed_output["wpinvestor_ticker_change"];?>"><?PHP echo $pricefeed_output["wpinvestor_ticker_change"];?></option>
                                        <?PHP
                                        }
                                        ?>                                    </select>
                                </td>
                                <td><?PHP echo $share_price_array["SP_CHANGE_$counter"]; ?></td>
                                <td>[wp-shortcode field='SP_CHANGE' id='<?PHP echo $counter; ?>']</td>

                            </tr>
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_percentchange">%Change </label></td>
                                <td>
                                    <select name="wpinvestor_ticker_percentchange" id="wpinvestor_ticker_percentchange">
                                        <option  value="none"></option>
                                        <?PHP
                                        if (isset($pricefeed_output["wpinvestor_ticker_percentchange"]) && $pricefeed_output["wpinvestor_ticker_percentchange"] != "") {
                                            ?>
                                            <option value="<?PHP echo $pricefeed_output["wpinvestor_ticker_percentchange"];?>"><?PHP echo $pricefeed_output["wpinvestor_ticker_percentchange"];?></option>
                                        <?PHP
                                        }
                                        ?>                                    </select>
                                </td>
                                <td><?PHP echo $share_price_array["SP_PERCENTCHANGE_$counter"]; ?></td>
                                <td>[wp-shortcode field='SP_PERCENTCHANGE' id='<?PHP echo $counter; ?>']</td>

                            </tr>
                            <tr>
                                <td class="row-title"><label for="wpinvestor_ticker_volume">Volume </label></td>
                                <td>
                                    <select name="wpinvestor_ticker_volume" id="wpinvestor_ticker_volume">
                                        <option  value="none"></option>
                                        <?PHP
                                        if (isset($pricefeed_output["wpinvestor_ticker_volume"]) && $pricefeed_output["wpinvestor_ticker_volume"] != "") {
                                            ?>
                                            <option value="<?PHP echo $pricefeed_output["wpinvestor_ticker_volume"];?>"><?PHP echo $pricefeed_output["wpinvestor_ticker_volume"];?></option>
                                        <?PHP
                                        }
                                        ?>                                    </select>
                                </td>
                                <td><?PHP echo $share_price_array["SP_VOLUME_$counter"]; ?></td>
                                <td>[wp-shortcode field='SP_VOLUME' id='<?PHP echo $counter; ?>']</td>

                            </tr>
                        </table>
<!--                        <input class="button-secondary" type="submit" value="--><?php //_e('Cancel'); ?><!--"/>-->
                        <a class="button-secondary" href="<?PHP echo admin_url("admin.php?page=wpinvestors-top"); ?>" title="<?php _e( 'Cancel' ); ?>"><?php _e( 'Cancel' ); ?></a>
                        <input class="button-primary" type="submit" name="wpinvestor_ticker_save"
                               value="<?php _e('Save'); ?>"/>
                    </form>
                <?PHP
                } else {
                    ?>
                    <p>This isn't a valid share price</p>
                <?PHP
                }
                ?>
            </div>
            <!-- .inside -->

        </div>
        <!-- .postbox -->

    </div>
    <!-- .meta-box-sortables .ui-sortable -->

</div>
<!-- post-body-content -->

<!-- sidebar -->
<div id="postbox-container-1" class="postbox-container">

    <div class="meta-box-sortables">

        <div class="postbox">
            <?PHP
            if (count($share_price_array) > 0) {
                ?>
                <h3><span>Preview</span></h3>

                <div class="inside">
                    <div class="ticker-box">
                        <div class="ticker-box-top">
                            <?PHP echo $share_price_array["SP_LAST_$counter"]; ?> <span class="green-text"><?PHP echo $share_price_array["SP_CHANGE_$counter"]; ?> (<?PHP echo $share_price_array["SP_PERCENTCHANGE_$counter"]; ?>%)</span>
                        </div>
                        <table class="form-table">
                            <tr>
                                <td>Ask</td>
                                <td><?PHP echo $share_price_array["SP_ASK_$counter"]; ?></td>
                            </tr>
                            <tr>
                                <td>Bid</td>
                                <td><?PHP echo $share_price_array["SP_BID_$counter"]; ?></td>
                            </tr>
                            <tr>
                                <td>High</td>
                                <td><?PHP echo $share_price_array["SP_HIGH_$counter"]; ?></td>
                            </tr>
                            <tr>
                                <td>Low</td>
                                <td><?PHP echo $share_price_array["SP_LOW_$counter"]; ?></td>
                            </tr>
                            <tr>
                                <td>Volume</td>
                                <td><?PHP echo $share_price_array["SP_VOLUME_$counter"]; ?></td>
                            </tr>
                        </table>
                        <div class="ticker-box-bottom">
                            As at <?PHP echo $share_price_array["SP_TIME_$counter"]; ?> - <?PHP echo $share_price_array["SP_DATE_$counter"]; ?>
                        </div>
                    </div>
                </div>
            <?PHP
            }
            ?>
        </div>
        <!-- .inside -->

    </div>
    <!-- .postbox -->

</div>
<!-- .meta-box-sortables -->

</div>
<!-- #postbox-container-1 .postbox-container -->

</div>
<!-- #post-body .metabox-holder .columns-2 -->

<br class="clear">
</div> <!-- #poststuff -->

</div> <!-- .wrap -->