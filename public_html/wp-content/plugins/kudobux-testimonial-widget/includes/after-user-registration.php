<?php
ini_set('display_errors', 1);
/*
 * After create a user account
 * insert the kudobuzz javascript in the front head
 */

require_once PLUGIN_DIR . 'kudobuzzwp.php';
$kwp = new Kudobuzzwp();

$uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : NULL;

if (isset($uid) && $uid != NULL) {
    update_option('kudobuzz_uid', $uid);
} else {
    die('<h3>Error!</h3><div>Missing UID</div>');
}
?>

<style>
    ul {
        padding-left: 35px;
    }
    ul li {
        font-size: 13px !important
    }
</style>
<div class="main-wrapper">
    <div class="main-app-wrapper">
        <div id="title-div">
            KUDOBUZZ
        </div>
        <div class="main-app-content" style="min-height: 440px; margin-bottom: 10px;">

            <div style="margin: 0px auto 10px auto; width: 820px; overflow: hidden;">

                <div  style="padding: 0px 20px; margin: 30px auto">
                    <h3>
                        <p class="main-title" style="margin-top: 45px; font-size: 30px; color: #585858">Registration Completed Successfully</p>
                        <p>We have sent you an email. Please follow the simple steps below to get started.</p>
                        <ul class="ul-with-bullet">
                            <li>We have created a testimonial page for you (<a href="<?php echo get_site_url() ?>?page_id=<?php echo get_page_by_title('Testimonials')->ID ?>" target="_blank">View</a>). A Kudobuzz widget has been embedded on your website (<a href="<?php echo get_site_url(); ?>" target="_blank">View</a>). You can customize the look & feel later.</li>
                            <li>Don't worry if your testimonial page is blank, testimonials will start showing when you publish them from your dashboard.</li>
                            <li>From your dashboard, connect your Social Account to start collecting testimonials using [ Add Social Account ] button.</li>
                            <li>Add your existing testimonials using [ Add Custom Reviews ] button.</li>
                            <li>Reviews from your website will be listed under [ Website Reviews ] menu</li>
                            <li>Choose and customize your preferred testimonial widget the [ Customize Widget ] menu.</li>
                        </ul>
                        <p>If you need any help reach us at [ hello@kudobuzz.com ]</p>
                        <a style="margin-top: 30px" href="http://app.kudobuzz.com/authenticate?email=<?php echo get_option('kudobuzz_email')?>&id=<?php echo get_option('kudobuzz_user_id')?>" target="_blank" class="btn btn-info btn-lg">Start Publishing Your Testimonials Now</a>
                        <!--<a style="margin-top: 30px" href="http://app.kudobuzz.com/authenticate?email=<?php //echo get_option("kudobuzz_email")?>&id=<?php //echo get_option("kudobuzz_user_id")?>" target="_blank" class="btn btn-info btn-lg">Start Publishing Your Testimonials Now</a>-->
                    </h3>
                </div>
            </div>
        </div>
        <div id="copyright-div">
            &copy; 2014 Kudobuzz
        </div>
    </div>
</div>
