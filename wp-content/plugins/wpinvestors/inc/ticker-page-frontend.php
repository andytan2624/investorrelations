<div class="postbox">
    <h3><span><?PHP echo $share_price_array["name"]." (".$share_price_array["ticker_code"].")"; ?></span></h3>
    <div class="inside">
        <div class="ticker-box">
            <div class="ticker-box-top">
                <?PHP echo $share_price_array["SP_LAST_$id"]; ?> <span
                    class="green-text"><?PHP echo $share_price_array["SP_CHANGE_$id"]; ?>
                    (<?PHP echo $share_price_array["SP_PERCENTCHANGE_$id"]; ?>%)</span>
            </div>
            <table class="form-table">
                <tr>
                    <td>Ask</td>
                    <td><?PHP echo $share_price_array["SP_ASK_$id"]; ?></td>
                </tr>
                <tr>
                    <td>Bid</td>
                    <td><?PHP echo $share_price_array["SP_BID_$id"]; ?></td>
                </tr>
                <tr>
                    <td>High</td>
                    <td><?PHP echo $share_price_array["SP_HIGH_$id"]; ?></td>
                </tr>
                <tr>
                    <td>Low</td>
                    <td><?PHP echo $share_price_array["SP_LOW_$id"]; ?></td>
                </tr>
                <tr>
                    <td>Volume</td>
                    <td><?PHP echo $share_price_array["SP_VOLUME_$id"]; ?></td>
                </tr>
            </table>
            <div class="ticker-box-bottom">
                As at <?PHP echo $share_price_array["SP_TIME_$id"]; ?>
                - <?PHP echo $share_price_array["SP_DATE_$id"]; ?>
            </div>
        </div>
    </div>
</div>