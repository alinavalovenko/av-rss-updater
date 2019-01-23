<div class="av-rss-feed-wrapper">
    <form method="post" action="" id="av-rss-feed-submit-form">
		<?php settings_fields( AV_RSS_SLUG . '_option_group' ); ?>
		<?php do_settings_sections( AV_RSS_SLUG ); ?>
        <button class="btn btn-primary" type="submit">Save Settings</button>
    </form>
</div>