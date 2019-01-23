jQuery(window).ready(function ($) {
    var settingsForm = $('#av-rss-feed-submit-form');
    var updateFeedBtn = $('#av-rss-update-feed');
    settingsForm.submit(event, function () {
        event.preventDefault();
        var period = settingsForm.find('input[name="av-rss-feed-updater_option[av_rss_feed_update_period]"]').val();
        var includeThumbnail =  $('#av-rss-feed-include-thumbnail');
        var includeMedia =  $('#av-rss-feed-include-images');
        var itStatus, imStatus='';
        if(includeThumbnail[0].checked === true){
            itStatus = 'checked';
        }
        if(includeMedia[0].checked === true){
            imStatus = 'checked';
        }

        var data = {
            action: 'av_rss_save_options',
            period: period,
            thumb: itStatus,
            media: imStatus,
        };

        $.post(ajaxurl, data, function (response) {
            alert(response);
        });
    });

    updateFeedBtn.click(function () {
        var data = {
            action: 'av_rss_update_feed',
        };
        $.post(ajaxurl, data, function (response) {
            alert(response);
        });
    });
});