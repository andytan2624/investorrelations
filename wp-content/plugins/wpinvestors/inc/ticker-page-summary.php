<div class="wrap">

    <div id="icon-options-general" class="icon32"></div>
    <h2>SHARE PRICE TICKER</h2>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-3">

            <!-- main content -->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable">

                    <div class="postbox">

                        <div class="inside">
                            <table class="form-table investor-table">
                                <tr>
                                    <th class="row-title">Name</th>
                                    <th class="row-title">Ticker Code</th>
                                    <th class="row-title">Shortcode</th>
                                    <th class="row-title">Edited</th>
                                    <th class="row-title">Action</th>

                                </tr>
                                <?PHP
                                foreach ($share_ticker_array as $tickerID) {
                                    // Get the option object
                                    $ticker = get_option($tickerID);
                                    if ($ticker) {
                                        // Get the id
                                        $counter = str_replace("SHARE_PRICE_TICKER_","",$tickerID);
                                        $ticker_array = json_decode($ticker,true);
                                        $editlink = admin_url('admin.php?page=wpinvestors-top&ticker_code=' . $tickerID);
                                        $deletelink = admin_url('admin.php?page=wpinvestors-top&ticker_code=' . $tickerID.'&delete=1&noheader=true');

                                        ?>
                                        <tr>
                                            <td><a href="<?PHP echo $editlink;?>"><?PHP echo $ticker_array["name"];?></a></td>
                                            <td><?PHP echo $ticker_array["ticker_code"];?></td>
                                            <td><?PHP echo "[wp-shareprice id='$counter']";?></td>
                                            <td><?PHP echo date("d/m/Y h:iA",strtotime($ticker_array["updated_date"]));?></td>
                                            <td><a href="<?PHP echo $editlink;?>">edit</a> | <a href="<?PHP echo $deletelink;?>">delete</a></td>
                                        </tr>
                                        <?PHP
                                    }
                                }
                                ?>
                            </table>
                        </div>
                        <!-- .inside -->

                        <!--                        <a href="/ir/wp-admin/admin.php?page=wpinvestors-top&edit=1">Check the edit page</a>-->
                        <form action="<?php echo admin_url('admin.php?page=wpinvestors-top&noheader=true'); ?>" method="post" name="wpinvestors_ticker_form">
                            <input type="hidden" name="wpinvestors_ticker_form_submitted" value="Y"/>
                            <input class="button-primary  investor-button" type="submit" name="Create New Ticker" value="<?php _e( 'Create New Ticker' ); ?>" />
                        </form>
                    </div>
                    <!-- .postbox -->
                    <br class="clear">
                </div>
                <!-- .meta-box-sortables .ui-sortable -->

            </div>
            <!-- post-body-content -->


            <br class="clear">
        </div>
        <!-- #poststuff -->

    </div>
    <!-- .wrap -->