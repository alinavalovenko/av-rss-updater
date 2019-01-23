jQuery(window).ready(function ($) {
    var settingsForm = $('#av-rss-feed-submit-form');
    settingsForm.submit(event, function () {
        event.preventDefault();
        var period = settingsForm.find('input[name="av-rss-feed-updater_option[av_rss_feed_update_period]"]').val();
        var includeThumbnail = settingsForm.find('input[name="av-rss-feed-updater_option[av_rss_feed_include_thumbnail]"]').val();
        var includeMedia = settingsForm.find('input[name="av-rss-feed-updater_option[av_rss_feed_include_images]"]').val();
        var data = {
            action: 'av_rss_save_options',
            period: period,
            thumb: includeThumbnail,
            media: includeMedia,
        };

        $.post(ajaxurl, data, function (response) {
            alert(response);
        });
    });
});