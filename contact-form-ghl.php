<?php
/**
 * Plugin Name: Contact Form + GoHighLevel
 * Plugin URI: https://upwork.com/freelancers/adelsherif8
 * Description: Fully customizable contact form with GoHighLevel CRM integration. Use shortcode [contact_form_ghl].
 * Version:     1.7.2
 * Author:      Adel Emad
 * Author URI:  https://upwork.com/freelancers/adelsherif8
 * License:     GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'CFG_SLUG',   'contact-form-ghl' );
define( 'CFG_OPTION', 'cfg_settings' );

// ═══════════════════════════════════════════════════════════════
//  AUTO-UPDATE FROM GITHUB
// ═══════════════════════════════════════════════════════════════
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
$cfg_update_checker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
    'https://github.com/adelsherif8/contact-form-ghl/',
    __FILE__,
    'contact-form-ghl'
);
$cfg_update_checker->getVcsApi()->enableReleaseAssets();

// ═══════════════════════════════════════════════════════════════
//  DEFAULTS
// ═══════════════════════════════════════════════════════════════
function cfg_defaults() {
    return [
        // ── GHL ─────────────────────────────────────────────────────────
        'ghl_api_key'            => '',
        'ghl_location_id'        => '',

        // ── Security / Spam ──────────────────────────────────────────────
        'spam_honeypot'          => '1',
        'spam_recaptcha_site'    => '',
        'spam_recaptcha_secret'  => '',

        // ── Shared Design ────────────────────────────────────────────────
        'primary_color'          => '#2563eb',
        'bg_color'               => '#ffffff',
        'text_color'             => '#111827',
        'muted_color'            => '#6b7280',
        'border_color'           => '#e5e7eb',
        'font_family'            => 'system',
        'custom_font_url'        => '',
        'custom_font_name'       => '',
        'font_weight_normal'     => '400',
        'font_weight_bold'       => '600',
        'card_radius'            => '6',
        'input_radius'           => '4',
        'card_border'            => '1',
        'card_shadow'            => '1',
        'btn_hover_bg_color'     => '',
        'btn_hover_text_color'   => '',

        // ── Contact Form ─────────────────────────────────────────────────
        'show_hero'              => '1',
        'hero_eyebrow'           => 'Book an Appointment',
        'hero_heading'           => 'Request an Appointment',
        'hero_subheading'        => 'Fill out the form below and our team will reach out to confirm your appointment by text.',
        'hero_bg_color'          => '#f4f4f5',
        'req_first_name'         => '1',
        'req_last_name'          => '1',
        'req_email'              => '1',
        'req_phone'              => '1',
        'req_treatment'          => '1',
        'show_treatment'         => '1',
        'show_terms'             => '1',
        'show_back_link'         => '1',
        'phone_number'           => '(661) 259-4474',
        'btn_text'               => 'Text Me to Confirm',
        'terms_text'             => 'By submitting this form you agree to be contacted via text or phone regarding your appointment request. Standard message rates may apply.',
        'success_redirect_url'   => '',
        'success_msg'            => "Thank you! We'll be in touch shortly to confirm your appointment.",
        'back_link_text'         => '← Other ways to book',
        'back_link_url'          => '/booking-method',
        'treatment_options'      => "General Dentistry\nWhitening\nRoot Canal\nTeeth Alignment / Straightening\nEmergency Service\nCrowns / Caps\nDental Implant\nTeeth Cleaning\nTeeth Extraction",

        // ── Booking Method Page ──────────────────────────────────────────
        'bm_show_hero'           => '1',
        'bm_hero_eyebrow'        => 'Book an Appointment',
        'bm_hero_heading'        => 'We Are Here to Help',
        'bm_hero_subheading'     => "Choose the most convenient way to reach us and we'll get you scheduled as quickly as possible.",
        'bm_hero_bg_color'       => '#f4f4f5',
        // Card 1 – Call
        'bm_card1_eyebrow'       => 'Call Us',
        'bm_card1_heading'       => 'Speak With Our Team',
        'bm_card1_body'          => 'Call us directly and one of our friendly team members will help you find the perfect appointment time.',
        'bm_card1_btn_text'      => '(661) 259-4474',
        'bm_card1_btn_url'       => 'tel:+16612594474',
        'bm_card1_icon'          => 'phone',
        // Card 2 – Text
        'bm_card2_eyebrow'       => 'Text Us',
        'bm_card2_heading'       => 'Book Via Text',
        'bm_card2_body'          => "Prefer to text? Fill out a quick form and we'll reach out to confirm your appointment by text.",
        'bm_card2_btn_text'      => 'Text to Book',
        'bm_card2_btn_url'       => '/contact-form',
        'bm_card2_icon'          => 'message',
        // Card 3 – optional
        'bm_show_card3'          => '0',
        'bm_card3_eyebrow'       => '',
        'bm_card3_heading'       => '',
        'bm_card3_body'          => '',
        'bm_card3_btn_text'      => '',
        'bm_card3_btn_url'       => '',
        'bm_card3_icon'          => 'mail',
        // Card 4 – optional
        'bm_show_card4'          => '0',
        'bm_card4_eyebrow'       => '',
        'bm_card4_heading'       => '',
        'bm_card4_body'          => '',
        'bm_card4_btn_text'      => '',
        'bm_card4_btn_url'       => '',
        'bm_card4_icon'          => 'map',
        // CTA strip
        'bm_show_cta'            => '1',
        'bm_cta_bg_color'        => '#2563eb',
        'bm_cta_heading'         => 'Questions Before You Book?',
        'bm_cta_body'            => 'Our team is happy to answer any questions about treatments, insurance, or what to expect during your visit.',
        'bm_cta_btn1_text'       => 'View FAQs',
        'bm_cta_btn1_url'        => '/faq',
        'bm_cta_btn2_text'       => '(661) 259-4474',
        'bm_cta_btn2_url'        => 'tel:+16612594474',

        // ── Thank You Page ───────────────────────────────────────────────
        'ty_eyebrow'             => 'Appointment Request',
        'ty_heading_line1'       => 'Thank you for',
        'ty_heading_line2'       => 'your request.',
        'ty_body'                => 'We will contact you in the next 24 hours to answer any questions or confirm your appointment. We appreciate your time.',
        'ty_social_show'         => '1',
        'ty_social_platform'     => 'instagram',
        'ty_social_label'        => 'Check out our Instagram',
        'ty_social_handle'       => '@yourpractice',
        'ty_social_url'          => '',
        'ty_image_url'           => '',
        'ty_image_alt'           => 'Our practice',
        'ty_show_image'          => '1',
        'ty_bg_color'            => '#ffffff',

        // ── Aligner / Quiz Form ──────────────────────────────────────────
        'alg_accent_color'       => '#C9A84C',
        'alg_success_url'        => '',

        // ── Implant Cost Estimator ────────────────────────────────────────
        'imp_accent_color'     => '#1e3a5f',
        'imp_success_url'      => '',
        'imp_currency'         => '$',
        'imp_single_min'       => '3000',
        'imp_single_max'       => '6000',
        'imp_multi_min'        => '5000',
        'imp_multi_max'        => '20000',
        'imp_arch_min'         => '24000',
        'imp_arch_max'         => '30000',
        'imp_graft_min'        => '650',
        'imp_graft_max'        => '1100',
        'imp_show_full_arch'   => '1',
        'imp_show_financing'   => '1',
        'imp_financing_text'   => 'Flexible financing available — ask us about monthly payment plans.',
        'imp_disclaimer'       => 'Prices shown are estimates only. Final cost depends on your specific needs, bone density, and treatment plan. A consultation is required for an accurate quote.',
        'imp_intro_title'      => 'Get Your Free Implant Cost Estimate',
        'imp_intro_heading'    => 'Dental Implant Cost Estimator',
        'imp_intro_subtitle'   => "Answer 4 quick questions and we'll give you a personalised cost range for your dental implant treatment.",
        'imp_intro_bullets'    => "Takes under 2 minutes\nNo obligation — 100% free\nInstant, personalised estimate",
        'imp_intro_btn'        => 'Get My Estimate',
        'imp_router_title'     => 'What are you looking to replace?',
        'imp_router_sub'       => 'Select the option that best describes your situation.',
        'imp_router_opt1'      => 'One missing tooth',       'imp_router_opt1_sub' => 'Replace a single tooth with an implant',
        'imp_router_opt2'      => 'Several missing teeth',   'imp_router_opt2_sub' => 'Replace 2 to 5 individual teeth',
        'imp_router_opt3'      => 'A denture or most/all teeth in an arch', 'imp_router_opt3_sub' => 'Full-arch or All-on-4 / All-on-6',
        'imp_a1_title'         => 'Where is the tooth located?',
        'imp_a1_opt1'          => 'Front',         'imp_a1_opt1_sub' => 'Visible when smiling',
        'imp_a1_opt2'          => 'Back',           'imp_a1_opt2_sub' => 'Chewing tooth (molar or premolar)',
        'imp_a1_opt3'          => 'Not sure',       'imp_a1_opt3_sub' => '',
        'imp_a2_title'         => 'How long has the tooth been missing?',
        'imp_a2_opt1'          => 'Less than 6 months',
        'imp_a2_opt2'          => '6–12 months',
        'imp_a2_opt3'          => '1–3 years',
        'imp_a2_opt4'          => '3+ years',
        'imp_a2_opt5'          => 'Not sure',
        'imp_a3_title'         => 'Has a dentist mentioned bone loss or the need for bone grafting?',
        'imp_a3_opt1'          => 'Yes',
        'imp_a3_opt2'          => 'No',
        'imp_a3_opt3'          => 'Not sure',
        'imp_a4_title'         => 'What best describes your situation?',
        'imp_a4_opt1'          => 'Tooth already missing',
        'imp_a4_opt2'          => 'Tooth needs to be removed',
        'imp_a4_opt3'          => 'Replacing a bridge or crown',
        'imp_a4_opt4'          => 'Not sure',
        'imp_m1_title'         => 'How many teeth are you looking to replace?',
        'imp_m1_opt1'          => '2 teeth',
        'imp_m1_opt2'          => '3 teeth',
        'imp_m1_opt3'          => '4 teeth',
        'imp_m1_opt4'          => '5+ teeth',
        'imp_m2_title'         => 'Where are the teeth located?',
        'imp_m2_opt1'          => 'Front',          'imp_m2_opt1_sub' => 'Visible when smiling',
        'imp_m2_opt2'          => 'Back',            'imp_m2_opt2_sub' => 'Chewing teeth',
        'imp_m2_opt3'          => 'Both front and back', 'imp_m2_opt3_sub' => '',
        'imp_m2_opt4'          => 'Not sure',        'imp_m2_opt4_sub' => '',
        'imp_m3_title'         => 'How long have the teeth been missing?',
        'imp_m3_opt1'          => 'Less than 6 months',
        'imp_m3_opt2'          => '6–12 months',
        'imp_m3_opt3'          => '1–3 years',
        'imp_m3_opt4'          => '3+ years',
        'imp_m3_opt5'          => 'Not sure',
        'imp_m4_title'         => 'Has a dentist mentioned bone loss or the need for bone grafting?',
        'imp_m4_opt1'          => 'Yes',
        'imp_m4_opt2'          => 'No',
        'imp_m4_opt3'          => 'Not sure',
        'imp_m5_title'         => 'What best describes your situation?',
        'imp_m5_opt1'          => 'Teeth already missing',
        'imp_m5_opt2'          => 'Some teeth need to be removed',
        'imp_m5_opt3'          => 'Replacing bridges or crowns',
        'imp_m5_opt4'          => 'Not sure',
        'imp_b1_title'         => 'Which arch are you looking to replace?',
        'imp_b1_opt1'          => 'Upper',  'imp_b1_opt1_sub' => 'Top teeth',
        'imp_b1_opt2'          => 'Lower',  'imp_b1_opt2_sub' => 'Bottom teeth',
        'imp_b1_opt3'          => 'Both',   'imp_b1_opt3_sub' => 'Full mouth restoration',
        'imp_b2_title'         => 'What best describes your current situation?',
        'imp_b2_opt1'          => 'Wearing a denture',
        'imp_b2_opt2'          => 'Multiple failing teeth',
        'imp_b2_opt3'          => 'Teeth beyond repair',
        'imp_b2_opt4'          => 'Not sure',
        'imp_b3_title'         => 'How long have you had missing or failing teeth?',
        'imp_b3_opt1'          => 'Less than 1 year',
        'imp_b3_opt2'          => '1–5 years',
        'imp_b3_opt3'          => '5+ years',
        'imp_ins_title'        => 'Do you have dental insurance?',
        'imp_ins_opt1'         => 'Yes (I have coverage)',
        'imp_ins_opt2'         => 'No',
        'imp_result_single_suffix'   => 'for a single dental implant',
        'imp_result_multiple_suffix' => 'Based on number of teeth at the per-implant rate',
        'imp_result_fullarch_suffix' => 'per arch',
        'imp_result_title'     => 'Your Estimated Investment',
        'imp_result_subtitle'  => "Based on your answers, here's a personalised cost range:",
        'imp_contact_title'    => 'Book Your Free Consultation',
        'imp_contact_subtitle' => "Enter your details and we'll reach out to confirm your free implant consultation.",
        'imp_contact_btn'      => 'Book My Free Consultation',
        'imp_hide_header'       => '0',
        'imp_show_price'        => '1',
        'imp_show_insurance'    => '1',
        'imp_no_price_title'    => 'Your Estimate Is Ready',
        'imp_no_price_subtitle' => 'Book a free consultation and our team will walk you through your personalised treatment options and costs.',
        'imp_no_price_btn'      => 'Book My Free Consultation',
    ];
}

function cfg_get( $key = null ) {
    $opts = get_option( CFG_OPTION, [] );
    $opts = wp_parse_args( $opts, cfg_defaults() );
    if ( $key !== null ) return $opts[ $key ] ?? null;
    return $opts;
}

// ═══════════════════════════════════════════════════════════════
//  REGISTER & SANITIZE
// ═══════════════════════════════════════════════════════════════
add_action( 'admin_init', function () {
    register_setting( CFG_SLUG, CFG_OPTION, [ 'sanitize_callback' => 'cfg_sanitize' ] );
} );

function cfg_sanitize( $input ) {
    $defaults = cfg_defaults();
    $clean    = [];

    $url_fields = [
        'custom_font_url','success_redirect_url',
        'bm_card1_btn_url','bm_card2_btn_url','bm_card3_btn_url','bm_card4_btn_url','bm_cta_btn1_url','bm_cta_btn2_url',
        'ty_social_url','ty_image_url','alg_success_url','imp_success_url',
    ];
    $color_fields = [
        'hero_bg_color','primary_color','bg_color','text_color','muted_color','border_color',
        'btn_hover_bg_color','btn_hover_text_color',
        'bm_hero_bg_color','bm_cta_bg_color','ty_bg_color','alg_accent_color','imp_accent_color',
        // imp extra color fields (none currently, placeholder for future)
    ];
    $textarea_fields = [
        'hero_subheading','terms_text','success_msg','treatment_options',
        'bm_hero_subheading','bm_card1_body','bm_card2_body','bm_card3_body','bm_card4_body','bm_cta_body','ty_body',
        'imp_intro_subtitle','imp_intro_bullets','imp_financing_text','imp_disclaimer','imp_result_subtitle','imp_contact_subtitle','imp_no_price_subtitle',
    ];
    $bool_fields = [
        'show_hero','req_first_name','req_last_name','req_email','req_phone',
        'req_treatment','show_treatment','show_terms','show_back_link',
        'card_border','card_shadow',
        'spam_honeypot',
        'bm_show_hero','bm_show_cta','bm_show_card3','bm_show_card4',
        'ty_social_show','ty_show_image',
        'imp_show_full_arch','imp_show_financing','imp_hide_header','imp_show_price','imp_show_insurance',
    ];

    // ── General loop ──
    foreach ( $defaults as $key => $default ) {
        if ( in_array( $key, $bool_fields ) ) {
            $clean[ $key ] = ! empty( $input[ $key ] ) ? '1' : '0';
        } elseif ( in_array( $key, $color_fields ) ) {
            $clean[ $key ] = sanitize_hex_color( $input[ $key ] ?? '' ) ?: $default;
        } elseif ( in_array( $key, $textarea_fields ) ) {
            $clean[ $key ] = sanitize_textarea_field( $input[ $key ] ?? '' );
        } elseif ( in_array( $key, $url_fields ) ) {
            $clean[ $key ] = esc_url_raw( $input[ $key ] ?? '' );
        } else {
            $clean[ $key ] = sanitize_text_field( $input[ $key ] ?? $default );
        }
    }
    return $clean;
}

// ═══════════════════════════════════════════════════════════════
//  ADMIN MENU
// ═══════════════════════════════════════════════════════════════
add_action( 'admin_menu', function () {
    add_options_page(
        'Contact Form GHL', 'Contact Form GHL',
        'manage_options', CFG_SLUG, 'cfg_settings_page'
    );
} );

// ═══════════════════════════════════════════════════════════════
//  SETTINGS PAGE
// ═══════════════════════════════════════════════════════════════
function cfg_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    $s     = cfg_get();
    $saved = isset( $_GET['settings-updated'] );
    ?>
    <div class="wrap">
    <h1 style="display:flex;align-items:center;gap:10px;">
        <span style="background:#2271b1;color:#fff;padding:4px 10px;border-radius:6px;font-size:13px;">GHL</span>
        Contact Form Settings
    </h1>
    <?php if ( $saved ): ?>
    <div class="notice notice-success is-dismissible"><p><strong>Settings saved.</strong></p></div>
    <?php endif; ?>

    <style>
    .cfg-wrap{max-width:960px}
    .cfg-tabs{display:flex;flex-wrap:wrap;gap:0;margin-bottom:0;border-bottom:2px solid #2271b1;}
    .cfg-tab{padding:9px 16px;cursor:pointer;border:1px solid #c3c4c7;border-bottom:none;background:#f6f7f7;font-weight:500;font-size:12.5px;margin-right:2px;border-radius:4px 4px 0 0;}
    .cfg-tab.active{background:#fff;border-bottom:2px solid #fff;margin-bottom:-2px;color:#2271b1;}
    .cfg-panel{display:none;background:#fff;border:1px solid #c3c4c7;border-top:none;padding:24px 28px;}
    .cfg-panel.active{display:block;}
    .cfg-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px 24px;}
    .cfg-full{grid-column:span 2;}
    .cfg-field{display:flex;flex-direction:column;gap:5px;}
    .cfg-field label{font-weight:600;font-size:13px;color:#1d2327;}
    .cfg-field input[type=text],.cfg-field input[type=url],.cfg-field input[type=password],.cfg-field select,.cfg-field textarea{width:100%;padding:7px 10px;border:1px solid #8c8f94;border-radius:4px;font-size:13px;}
    .cfg-field textarea{min-height:80px;font-family:monospace;resize:vertical;}
    .cfg-desc{color:#646970;font-size:11.5px;line-height:1.5;}
    .cfg-toggle-row{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f6f7f7;}
    .cfg-toggle-row:last-child{border-bottom:none;}
    .cfg-toggle-row label{flex:1;font-size:13px;cursor:pointer;}
    .cfg-toggle-row input[type=checkbox]{width:16px;height:16px;cursor:pointer;}
    .cfg-section-title{font-size:14px;font-weight:700;margin:22px 0 10px;padding-bottom:6px;border-bottom:2px solid #f0f0f1;color:#1d2327;}
    .cfg-section-title:first-child{margin-top:0;}
    .cfg-color-row{display:flex;align-items:center;gap:8px;}
    .cfg-color-row input[type=color]{width:48px;height:36px;padding:2px;border:1px solid #8c8f94;border-radius:4px;cursor:pointer;flex-shrink:0;}
    .cfg-color-row input[type=text]{flex:1;}
    .cfg-badge{display:inline-block;background:#e7f3ff;color:#2271b1;padding:2px 8px;border-radius:12px;font-size:11px;font-weight:600;margin-left:6px;vertical-align:middle;}
    .cfg-card-section{background:#f9f9f9;border:1px solid #e5e5e5;border-radius:6px;padding:16px 20px;margin-bottom:16px;}
    .cfg-card-section h4{margin:0 0 12px;font-size:13px;font-weight:700;color:#1d2327;}
    </style>

    <div class="cfg-wrap">
    <form method="post" action="options.php">
    <?php settings_fields( CFG_SLUG ); ?>

    <div class="cfg-tabs">
        <div class="cfg-tab active"  onclick="cfgTab(this,'ghl')">⚡ GHL + Security</div>
        <div class="cfg-tab"         onclick="cfgTab(this,'design')">🎨 Design</div>
        <div class="cfg-tab"         onclick="cfgTab(this,'form')">📋 Contact Form</div>
        <div class="cfg-tab"         onclick="cfgTab(this,'bm')">📞 Booking Method</div>
        <div class="cfg-tab"         onclick="cfgTab(this,'ty')">✅ Thank You Page</div>
        <div class="cfg-tab"         onclick="cfgTab(this,'alg')">🦷 Aligner Form</div>
        <div class="cfg-tab"         onclick="cfgTab(this,'imp')">🦷 Implant Estimator</div>
        <div class="cfg-tab"         onclick="cfgTab(this,'guide')">📖 Setup Guide</div>
    </div>

    <!-- ═══ GHL + SECURITY TAB ═══ -->
    <div id="cfg-ghl" class="cfg-panel active">
        <div class="cfg-section-title">GoHighLevel API</div>
        <p class="cfg-desc">API credentials are stored server-side only and are never sent to the browser.</p>
        <div class="cfg-grid" style="margin-top:14px;">
            <div class="cfg-field">
                <label>API Key / Bearer Token</label>
                <input type="password" name="<?= CFG_OPTION ?>[ghl_api_key]" value="<?= esc_attr( $s['ghl_api_key'] ) ?>" placeholder="eyJhbGci..." autocomplete="off"/>
                <span class="cfg-desc">Settings → API → Private Integrations in GHL. Use a location-level token.</span>
            </div>
            <div class="cfg-field">
                <label>Location ID</label>
                <input type="text" name="<?= CFG_OPTION ?>[ghl_location_id]" value="<?= esc_attr( $s['ghl_location_id'] ) ?>" placeholder="AbCdEfGhIj123"/>
                <span class="cfg-desc">GHL → Settings → Business Profile → Location ID.</span>
            </div>
        </div>
        <?php if ( ! empty( $s['ghl_api_key'] ) && ! empty( $s['ghl_location_id'] ) ): ?>
        <p><span style="color:#15803d;font-weight:600;">✔ GHL credentials are configured.</span></p>
        <?php else: ?>
        <p><span style="color:#b91c1c;font-weight:600;">⚠ GHL credentials not yet set — form submissions will return an error.</span></p>
        <?php endif; ?>

        <div class="cfg-section-title">Spam Protection</div>
        <div class="cfg-toggle-row">
            <input type="checkbox" id="spam_honeypot" name="<?= CFG_OPTION ?>[spam_honeypot]" value="1" <?= checked( $s['spam_honeypot'], '1', false ) ?>/>
            <label for="spam_honeypot"><strong>Honeypot field</strong> — hidden field that bots fill in, real users never see it (recommended, zero friction)</label>
        </div>
        <div class="cfg-grid" style="margin-top:12px;">
            <div class="cfg-field">
                <label>reCAPTCHA v3 Site Key <span class="cfg-badge">optional</span></label>
                <input type="text" name="<?= CFG_OPTION ?>[spam_recaptcha_site]" value="<?= esc_attr( $s['spam_recaptcha_site'] ) ?>" placeholder="6Lc..."/>
                <span class="cfg-desc">Leave blank to disable reCAPTCHA. Get keys at google.com/recaptcha.</span>
            </div>
            <div class="cfg-field">
                <label>reCAPTCHA v3 Secret Key</label>
                <input type="password" name="<?= CFG_OPTION ?>[spam_recaptcha_secret]" value="<?= esc_attr( $s['spam_recaptcha_secret'] ) ?>" placeholder="6Lc..." autocomplete="off"/>
                <span class="cfg-desc">Server-side secret — never visible in the browser.</span>
            </div>
        </div>

        <div class="cfg-section-title">Shortcodes</div>
        <table style="border-collapse:collapse;width:100%;">
            <tr style="background:#f9f9f9;"><td style="padding:8px 12px;font-family:monospace;font-size:13px;border:1px solid #e5e5e5;">[contact_form_ghl]</td><td style="padding:8px 12px;font-size:13px;border:1px solid #e5e5e5;">Full contact form page — hero + form card + back link</td></tr>
            <tr><td style="padding:8px 12px;font-family:monospace;font-size:13px;border:1px solid #e5e5e5;">[contact_form_embed]</td><td style="padding:8px 12px;font-size:13px;border:1px solid #e5e5e5;">Form card only — embed on any page without the hero</td></tr>
            <tr style="background:#f9f9f9;"><td style="padding:8px 12px;font-family:monospace;font-size:13px;border:1px solid #e5e5e5;">[booking_method_ghl]</td><td style="padding:8px 12px;font-size:13px;border:1px solid #e5e5e5;">Booking method choice page (Call vs Text)</td></tr>
            <tr><td style="padding:8px 12px;font-family:monospace;font-size:13px;border:1px solid #e5e5e5;">[thank_you_ghl]</td><td style="padding:8px 12px;font-size:13px;border:1px solid #e5e5e5;">Post-submission thank you / confirmation page</td></tr>
            <tr style="background:#f9f9f9;"><td style="padding:8px 12px;font-family:monospace;font-size:13px;border:1px solid #e5e5e5;">[aligner_form_ghl]</td><td style="padding:8px 12px;font-size:13px;border:1px solid #e5e5e5;">Multi-step animated clear aligner estimate quiz</td></tr>
            <tr><td style="padding:8px 12px;font-family:monospace;font-size:13px;border:1px solid #e5e5e5;">[implant_estimator_ghl]</td><td style="padding:8px 12px;font-size:13px;border:1px solid #e5e5e5;">Multi-step dental implant cost estimator with dynamic price calculation</td></tr>
        </table>
    </div>

    <!-- ═══ DESIGN TAB ═══ -->
    <div id="cfg-design" class="cfg-panel">
        <p class="cfg-desc">These design settings apply to all three shortcode pages.</p>
        <div class="cfg-section-title">Colors</div>
        <div class="cfg-grid">
        <?php foreach ( [
            'primary_color' => 'Primary / Accent Color',
            'bg_color'      => 'Card / Page Background',
            'text_color'    => 'Body Text',
            'muted_color'   => 'Muted / Label Text',
            'border_color'  => 'Borders',
        ] as $key => $lbl ): ?>
            <div class="cfg-field">
                <label><?= $lbl ?></label>
                <div class="cfg-color-row">
                    <input type="color" id="c_<?= $key ?>" value="<?= esc_attr( $s[ $key ] ) ?>" oninput="syncColor('<?= $key ?>',this.value)"/>
                    <input type="text"  id="<?= $key ?>" name="<?= CFG_OPTION ?>[<?= $key ?>]" value="<?= esc_attr( $s[ $key ] ) ?>" maxlength="7" oninput="syncPicker('c_<?= $key ?>',this.value)"/>
                </div>
            </div>
        <?php endforeach; ?>
        </div>

        <div class="cfg-section-title">Button Hover Effect</div>
        <div class="cfg-grid">
            <div class="cfg-field">
                <label>Hover Background Color <span class="cfg-badge">optional</span></label>
                <div class="cfg-color-row">
                    <input type="color" id="c_btn_hover_bg_color" value="<?= esc_attr( $s['btn_hover_bg_color'] ?: $s['primary_color'] ) ?>" oninput="syncColor('btn_hover_bg_color',this.value)"/>
                    <input type="text" id="btn_hover_bg_color" name="<?= CFG_OPTION ?>[btn_hover_bg_color]" value="<?= esc_attr( $s['btn_hover_bg_color'] ) ?>" maxlength="7" placeholder="Default: darken primary" oninput="syncPicker('c_btn_hover_bg_color',this.value)"/>
                </div>
                <span class="cfg-desc">Leave blank to use the default brightness effect on hover.</span>
            </div>
            <div class="cfg-field">
                <label>Hover Text Color <span class="cfg-badge">optional</span></label>
                <div class="cfg-color-row">
                    <input type="color" id="c_btn_hover_text_color" value="<?= esc_attr( $s['btn_hover_text_color'] ?: '#ffffff' ) ?>" oninput="syncColor('btn_hover_text_color',this.value)"/>
                    <input type="text" id="btn_hover_text_color" name="<?= CFG_OPTION ?>[btn_hover_text_color]" value="<?= esc_attr( $s['btn_hover_text_color'] ) ?>" maxlength="7" placeholder="Default: #ffffff" oninput="syncPicker('c_btn_hover_text_color',this.value)"/>
                </div>
                <span class="cfg-desc">Leave blank to keep white text on hover.</span>
            </div>
        </div>

        <div class="cfg-section-title">Typography</div>
        <div class="cfg-grid">
            <div class="cfg-field">
                <label>Font Family</label>
                <select name="<?= CFG_OPTION ?>[font_family]" id="cfg_font_sel" onchange="document.getElementById('cfg_custom_font_row').style.display=this.value==='custom'?'grid':'none'">
                    <?php foreach ( [
                        'system' => 'System Default', 'inter' => 'Inter', 'roboto' => 'Roboto',
                        'open-sans' => 'Open Sans', 'lato' => 'Lato', 'poppins' => 'Poppins',
                        'montserrat' => 'Montserrat', 'custom' => 'Custom Google Font',
                    ] as $v => $l ): ?>
                    <option value="<?= $v ?>" <?= selected( $s['font_family'], $v, false ) ?>><?= $l ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="cfg-field">
                <label>Normal Font Weight</label>
                <select name="<?= CFG_OPTION ?>[font_weight_normal]">
                    <?php foreach ( [ '300' => 'Light (300)', '400' => 'Regular (400)', '500' => 'Medium (500)' ] as $w => $wl ): ?>
                    <option value="<?= $w ?>" <?= selected( $s['font_weight_normal'], $w, false ) ?>><?= $wl ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="cfg_custom_font_row" class="cfg-grid cfg-full" style="display:<?= $s['font_family'] === 'custom' ? 'grid' : 'none' ?>;margin:0;">
                <div class="cfg-field">
                    <label>Google Fonts Embed URL</label>
                    <input type="url" name="<?= CFG_OPTION ?>[custom_font_url]" value="<?= esc_url( $s['custom_font_url'] ) ?>" placeholder="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap"/>
                </div>
                <div class="cfg-field">
                    <label>CSS Font Name</label>
                    <input type="text" name="<?= CFG_OPTION ?>[custom_font_name]" value="<?= esc_attr( $s['custom_font_name'] ) ?>" placeholder="Nunito"/>
                    <span class="cfg-desc">Exact name as written in font-family.</span>
                </div>
            </div>
            <div class="cfg-field">
                <label>Bold / Label Font Weight</label>
                <select name="<?= CFG_OPTION ?>[font_weight_bold]">
                    <?php foreach ( [ '500' => 'Medium (500)', '600' => 'Semi-Bold (600)', '700' => 'Bold (700)' ] as $w => $wl ): ?>
                    <option value="<?= $w ?>" <?= selected( $s['font_weight_bold'], $w, false ) ?>><?= $wl ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="cfg-section-title">Card & Input Style</div>
        <div class="cfg-grid">
            <div class="cfg-field">
                <label>Card Border Radius (px)</label>
                <input type="text" name="<?= CFG_OPTION ?>[card_radius]" value="<?= esc_attr( $s['card_radius'] ) ?>" maxlength="4"/>
            </div>
            <div class="cfg-field">
                <label>Input / Button Border Radius (px)</label>
                <input type="text" name="<?= CFG_OPTION ?>[input_radius]" value="<?= esc_attr( $s['input_radius'] ) ?>" maxlength="4"/>
            </div>
            <div class="cfg-toggle-row">
                <input type="checkbox" id="card_border" name="<?= CFG_OPTION ?>[card_border]" value="1" <?= checked( $s['card_border'], '1', false ) ?>/>
                <label for="card_border">Show border on cards</label>
            </div>
            <div class="cfg-toggle-row">
                <input type="checkbox" id="card_shadow" name="<?= CFG_OPTION ?>[card_shadow]" value="1" <?= checked( $s['card_shadow'], '1', false ) ?>/>
                <label for="card_shadow">Show drop shadow on cards</label>
            </div>
        </div>
    </div>

    <!-- ═══ CONTACT FORM TAB ═══ -->
    <div id="cfg-form" class="cfg-panel">
        <div class="cfg-section-title">Hero Section</div>
        <div class="cfg-toggle-row">
            <input type="checkbox" id="show_hero" name="<?= CFG_OPTION ?>[show_hero]" value="1" <?= checked( $s['show_hero'], '1', false ) ?>/>
            <label for="show_hero">Show hero banner above the form</label>
        </div>
        <div class="cfg-grid" style="margin-top:12px;">
            <div class="cfg-field">
                <label>Eyebrow Label</label>
                <input type="text" name="<?= CFG_OPTION ?>[hero_eyebrow]" value="<?= esc_attr( $s['hero_eyebrow'] ) ?>"/>
            </div>
            <div class="cfg-field">
                <label>H1 Heading</label>
                <input type="text" name="<?= CFG_OPTION ?>[hero_heading]" value="<?= esc_attr( $s['hero_heading'] ) ?>"/>
            </div>
            <div class="cfg-field cfg-full">
                <label>Subheading Paragraph</label>
                <textarea name="<?= CFG_OPTION ?>[hero_subheading]"><?= esc_textarea( $s['hero_subheading'] ) ?></textarea>
            </div>
            <div class="cfg-field">
                <label>Hero Background Color</label>
                <div class="cfg-color-row">
                    <input type="color" id="c_hero_bg_color" value="<?= esc_attr( $s['hero_bg_color'] ) ?>" oninput="syncColor('hero_bg_color',this.value)"/>
                    <input type="text" id="hero_bg_color" name="<?= CFG_OPTION ?>[hero_bg_color]" value="<?= esc_attr( $s['hero_bg_color'] ) ?>" maxlength="7" oninput="syncPicker('c_hero_bg_color',this.value)"/>
                </div>
            </div>
        </div>

        <div class="cfg-section-title">Field Settings</div>
        <?php foreach ( [
            'req_first_name' => 'First Name required',
            'req_last_name'  => 'Last Name required',
            'req_email'      => 'Email required',
            'req_phone'      => 'Phone required',
            'req_treatment'  => 'Treatment Type required',
        ] as $key => $lbl ): ?>
        <div class="cfg-toggle-row">
            <input type="checkbox" id="<?= $key ?>" name="<?= CFG_OPTION ?>[<?= $key ?>]" value="1" <?= checked( $s[ $key ], '1', false ) ?>/>
            <label for="<?= $key ?>"><?= $lbl ?></label>
        </div>
        <?php endforeach; ?>
        <div class="cfg-toggle-row">
            <input type="checkbox" id="show_treatment" name="<?= CFG_OPTION ?>[show_treatment]" value="1" <?= checked( $s['show_treatment'], '1', false ) ?>/>
            <label for="show_treatment">Show Treatment Type dropdown</label>
        </div>
        <div class="cfg-toggle-row">
            <input type="checkbox" id="show_terms" name="<?= CFG_OPTION ?>[show_terms]" value="1" <?= checked( $s['show_terms'], '1', false ) ?>/>
            <label for="show_terms">Show Terms / Consent checkbox</label>
        </div>
        <div class="cfg-toggle-row">
            <input type="checkbox" id="show_back_link" name="<?= CFG_OPTION ?>[show_back_link]" value="1" <?= checked( $s['show_back_link'], '1', false ) ?>/>
            <label for="show_back_link">Show back link below the form</label>
        </div>

        <div class="cfg-section-title">Treatment Options</div>
        <div class="cfg-field">
            <label>Options <span class="cfg-badge">one per line</span></label>
            <textarea name="<?= CFG_OPTION ?>[treatment_options]" style="min-height:160px;"><?= esc_textarea( $s['treatment_options'] ) ?></textarea>
        </div>

        <div class="cfg-section-title">Text & Labels</div>
        <div class="cfg-grid">
            <div class="cfg-field">
                <label>Contact Phone <span class="cfg-badge">shown in error messages</span></label>
                <input type="text" name="<?= CFG_OPTION ?>[phone_number]" value="<?= esc_attr( $s['phone_number'] ) ?>"/>
                <span class="cfg-desc">"Something went wrong. Please call us at …"</span>
            </div>
            <div class="cfg-field">
                <label>Submit Button Text</label>
                <input type="text" name="<?= CFG_OPTION ?>[btn_text]" value="<?= esc_attr( $s['btn_text'] ) ?>"/>
            </div>
            <div class="cfg-field cfg-full">
                <label>Terms / Consent Text</label>
                <textarea name="<?= CFG_OPTION ?>[terms_text]"><?= esc_textarea( $s['terms_text'] ) ?></textarea>
            </div>
            <div class="cfg-field cfg-full">
                <label>Success Redirect URL <span class="cfg-badge">after submit</span></label>
                <input type="text" name="<?= CFG_OPTION ?>[success_redirect_url]" value="<?= esc_attr( $s['success_redirect_url'] ) ?>" placeholder="/thank-you"/>
                <span class="cfg-desc">User is redirected here after successful submission. Leave blank to show the fallback message below.</span>
            </div>
            <div class="cfg-field cfg-full">
                <label>Fallback Success Message <span class="cfg-badge">only if no redirect URL</span></label>
                <textarea name="<?= CFG_OPTION ?>[success_msg]"><?= esc_textarea( $s['success_msg'] ) ?></textarea>
            </div>
            <div class="cfg-field">
                <label>Back Link Text</label>
                <input type="text" name="<?= CFG_OPTION ?>[back_link_text]" value="<?= esc_attr( $s['back_link_text'] ) ?>"/>
            </div>
            <div class="cfg-field">
                <label>Back Link URL</label>
                <input type="text" name="<?= CFG_OPTION ?>[back_link_url]" value="<?= esc_attr( $s['back_link_url'] ) ?>"/>
            </div>
        </div>
    </div>

    <!-- ═══ BOOKING METHOD TAB ═══ -->
    <div id="cfg-bm" class="cfg-panel">
        <div class="cfg-section-title">Hero Section</div>
        <div class="cfg-toggle-row">
            <input type="checkbox" id="bm_show_hero" name="<?= CFG_OPTION ?>[bm_show_hero]" value="1" <?= checked( $s['bm_show_hero'], '1', false ) ?>/>
            <label for="bm_show_hero">Show hero banner on the booking method page</label>
        </div>
        <div class="cfg-grid" style="margin-top:12px;">
            <div class="cfg-field">
                <label>Eyebrow Label</label>
                <input type="text" name="<?= CFG_OPTION ?>[bm_hero_eyebrow]" value="<?= esc_attr( $s['bm_hero_eyebrow'] ) ?>"/>
            </div>
            <div class="cfg-field">
                <label>H1 Heading</label>
                <input type="text" name="<?= CFG_OPTION ?>[bm_hero_heading]" value="<?= esc_attr( $s['bm_hero_heading'] ) ?>"/>
            </div>
            <div class="cfg-field cfg-full">
                <label>Subheading</label>
                <textarea name="<?= CFG_OPTION ?>[bm_hero_subheading]"><?= esc_textarea( $s['bm_hero_subheading'] ) ?></textarea>
            </div>
            <div class="cfg-field">
                <label>Hero Background Color</label>
                <div class="cfg-color-row">
                    <input type="color" id="c_bm_hero_bg_color" value="<?= esc_attr( $s['bm_hero_bg_color'] ) ?>" oninput="syncColor('bm_hero_bg_color',this.value)"/>
                    <input type="text" id="bm_hero_bg_color" name="<?= CFG_OPTION ?>[bm_hero_bg_color]" value="<?= esc_attr( $s['bm_hero_bg_color'] ) ?>" maxlength="7" oninput="syncPicker('c_bm_hero_bg_color',this.value)"/>
                </div>
            </div>
        </div>

        <div class="cfg-section-title">Card 1 — Call</div>
        <div class="cfg-card-section">
            <div class="cfg-grid">
                <div class="cfg-field">
                    <label>Icon</label>
                    <select name="<?= CFG_OPTION ?>[bm_card1_icon]">
                        <option value="phone"   <?= selected( $s['bm_card1_icon'], 'phone',   false ) ?>>Phone</option>
                        <option value="message" <?= selected( $s['bm_card1_icon'], 'message', false ) ?>>Message / Chat</option>
                        <option value="mail"    <?= selected( $s['bm_card1_icon'], 'mail',    false ) ?>>Email</option>
                        <option value="map"     <?= selected( $s['bm_card1_icon'], 'map',     false ) ?>>Map Pin</option>
                        <option value="clock"   <?= selected( $s['bm_card1_icon'], 'clock',   false ) ?>>Clock</option>
                    </select>
                </div>
                <div class="cfg-field">
                    <label>Eyebrow</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card1_eyebrow]" value="<?= esc_attr( $s['bm_card1_eyebrow'] ) ?>"/>
                </div>
                <div class="cfg-field">
                    <label>Heading</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card1_heading]" value="<?= esc_attr( $s['bm_card1_heading'] ) ?>"/>
                </div>
                <div class="cfg-field cfg-full">
                    <label>Body Text</label>
                    <textarea name="<?= CFG_OPTION ?>[bm_card1_body]"><?= esc_textarea( $s['bm_card1_body'] ) ?></textarea>
                </div>
                <div class="cfg-field">
                    <label>Button Text</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card1_btn_text]" value="<?= esc_attr( $s['bm_card1_btn_text'] ) ?>"/>
                </div>
                <div class="cfg-field">
                    <label>Button URL / Link</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card1_btn_url]" value="<?= esc_attr( $s['bm_card1_btn_url'] ) ?>" placeholder="tel:+16612594474"/>
                    <span class="cfg-desc">Use <code>tel:+1XXXXXXXXXX</code> for a click-to-call link.</span>
                </div>
            </div>
        </div>

        <div class="cfg-section-title">Card 2 — Text / Online</div>
        <div class="cfg-card-section">
            <div class="cfg-grid">
                <div class="cfg-field">
                    <label>Icon</label>
                    <select name="<?= CFG_OPTION ?>[bm_card2_icon]">
                        <option value="message" <?= selected( $s['bm_card2_icon'], 'message', false ) ?>>Message / Chat</option>
                        <option value="phone"   <?= selected( $s['bm_card2_icon'], 'phone',   false ) ?>>Phone</option>
                        <option value="mail"    <?= selected( $s['bm_card2_icon'], 'mail',    false ) ?>>Email</option>
                        <option value="map"     <?= selected( $s['bm_card2_icon'], 'map',     false ) ?>>Map Pin</option>
                        <option value="clock"   <?= selected( $s['bm_card2_icon'], 'clock',   false ) ?>>Clock</option>
                    </select>
                </div>
                <div class="cfg-field">
                    <label>Eyebrow</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card2_eyebrow]" value="<?= esc_attr( $s['bm_card2_eyebrow'] ) ?>"/>
                </div>
                <div class="cfg-field">
                    <label>Heading</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card2_heading]" value="<?= esc_attr( $s['bm_card2_heading'] ) ?>"/>
                </div>
                <div class="cfg-field cfg-full">
                    <label>Body Text</label>
                    <textarea name="<?= CFG_OPTION ?>[bm_card2_body]"><?= esc_textarea( $s['bm_card2_body'] ) ?></textarea>
                </div>
                <div class="cfg-field">
                    <label>Button Text</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card2_btn_text]" value="<?= esc_attr( $s['bm_card2_btn_text'] ) ?>"/>
                </div>
                <div class="cfg-field">
                    <label>Button URL / Link</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card2_btn_url]" value="<?= esc_attr( $s['bm_card2_btn_url'] ) ?>" placeholder="/contact-form"/>
                </div>
            </div>
        </div>

        <div class="cfg-section-title">Card 3 — Optional Extra Card</div>
        <div class="cfg-card-section">
            <div class="cfg-toggle-row" style="margin-bottom:12px;">
                <input type="checkbox" id="bm_show_card3" name="<?= CFG_OPTION ?>[bm_show_card3]" value="1" <?= checked( $s['bm_show_card3'], '1', false ) ?>/>
                <label for="bm_show_card3"><strong>Enable Card 3</strong> — shows next to the two main cards</label>
            </div>
            <div class="cfg-grid">
                <div class="cfg-field">
                    <label>Icon</label>
                    <select name="<?= CFG_OPTION ?>[bm_card3_icon]">
                        <?php foreach ( [ 'mail'=>'Email', 'phone'=>'Phone', 'message'=>'Message / Chat', 'map'=>'Map Pin', 'clock'=>'Clock' ] as $v => $l ): ?>
                        <option value="<?= $v ?>" <?= selected( $s['bm_card3_icon'], $v, false ) ?>><?= $l ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="cfg-field">
                    <label>Eyebrow</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card3_eyebrow]" value="<?= esc_attr( $s['bm_card3_eyebrow'] ) ?>"/>
                </div>
                <div class="cfg-field">
                    <label>Heading</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card3_heading]" value="<?= esc_attr( $s['bm_card3_heading'] ) ?>"/>
                </div>
                <div class="cfg-field cfg-full">
                    <label>Body Text</label>
                    <textarea name="<?= CFG_OPTION ?>[bm_card3_body]"><?= esc_textarea( $s['bm_card3_body'] ) ?></textarea>
                </div>
                <div class="cfg-field">
                    <label>Button Text</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card3_btn_text]" value="<?= esc_attr( $s['bm_card3_btn_text'] ) ?>"/>
                </div>
                <div class="cfg-field">
                    <label>Button URL</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card3_btn_url]" value="<?= esc_attr( $s['bm_card3_btn_url'] ) ?>"/>
                </div>
            </div>
        </div>

        <div class="cfg-section-title">Card 4 — Optional Extra Card</div>
        <div class="cfg-card-section">
            <div class="cfg-toggle-row" style="margin-bottom:12px;">
                <input type="checkbox" id="bm_show_card4" name="<?= CFG_OPTION ?>[bm_show_card4]" value="1" <?= checked( $s['bm_show_card4'], '1', false ) ?>/>
                <label for="bm_show_card4"><strong>Enable Card 4</strong> — shows next to the other cards</label>
            </div>
            <div class="cfg-grid">
                <div class="cfg-field">
                    <label>Icon</label>
                    <select name="<?= CFG_OPTION ?>[bm_card4_icon]">
                        <?php foreach ( [ 'map'=>'Map Pin', 'mail'=>'Email', 'phone'=>'Phone', 'message'=>'Message / Chat', 'clock'=>'Clock' ] as $v => $l ): ?>
                        <option value="<?= $v ?>" <?= selected( $s['bm_card4_icon'], $v, false ) ?>><?= $l ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="cfg-field">
                    <label>Eyebrow</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card4_eyebrow]" value="<?= esc_attr( $s['bm_card4_eyebrow'] ) ?>"/>
                </div>
                <div class="cfg-field">
                    <label>Heading</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card4_heading]" value="<?= esc_attr( $s['bm_card4_heading'] ) ?>"/>
                </div>
                <div class="cfg-field cfg-full">
                    <label>Body Text</label>
                    <textarea name="<?= CFG_OPTION ?>[bm_card4_body]"><?= esc_textarea( $s['bm_card4_body'] ) ?></textarea>
                </div>
                <div class="cfg-field">
                    <label>Button Text</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card4_btn_text]" value="<?= esc_attr( $s['bm_card4_btn_text'] ) ?>"/>
                </div>
                <div class="cfg-field">
                    <label>Button URL</label>
                    <input type="text" name="<?= CFG_OPTION ?>[bm_card4_btn_url]" value="<?= esc_attr( $s['bm_card4_btn_url'] ) ?>"/>
                </div>
            </div>
        </div>

        <div class="cfg-section-title">Bottom CTA Strip</div>
        <div class="cfg-toggle-row">
            <input type="checkbox" id="bm_show_cta" name="<?= CFG_OPTION ?>[bm_show_cta]" value="1" <?= checked( $s['bm_show_cta'], '1', false ) ?>/>
            <label for="bm_show_cta">Show CTA section below the cards</label>
        </div>
        <div class="cfg-grid" style="margin-top:12px;">
            <div class="cfg-field">
                <label>CTA Background Color</label>
                <div class="cfg-color-row">
                    <input type="color" id="c_bm_cta_bg_color" value="<?= esc_attr( $s['bm_cta_bg_color'] ) ?>" oninput="syncColor('bm_cta_bg_color',this.value)"/>
                    <input type="text" id="bm_cta_bg_color" name="<?= CFG_OPTION ?>[bm_cta_bg_color]" value="<?= esc_attr( $s['bm_cta_bg_color'] ) ?>" maxlength="7" oninput="syncPicker('c_bm_cta_bg_color',this.value)"/>
                </div>
            </div>
            <div class="cfg-field">
                <label>CTA Heading</label>
                <input type="text" name="<?= CFG_OPTION ?>[bm_cta_heading]" value="<?= esc_attr( $s['bm_cta_heading'] ) ?>"/>
            </div>
            <div class="cfg-field cfg-full">
                <label>CTA Body Paragraph</label>
                <textarea name="<?= CFG_OPTION ?>[bm_cta_body]"><?= esc_textarea( $s['bm_cta_body'] ) ?></textarea>
            </div>
            <div class="cfg-field">
                <label>Button 1 Text</label>
                <input type="text" name="<?= CFG_OPTION ?>[bm_cta_btn1_text]" value="<?= esc_attr( $s['bm_cta_btn1_text'] ) ?>"/>
            </div>
            <div class="cfg-field">
                <label>Button 1 URL</label>
                <input type="text" name="<?= CFG_OPTION ?>[bm_cta_btn1_url]" value="<?= esc_attr( $s['bm_cta_btn1_url'] ) ?>"/>
            </div>
            <div class="cfg-field">
                <label>Button 2 Text (ghost / phone)</label>
                <input type="text" name="<?= CFG_OPTION ?>[bm_cta_btn2_text]" value="<?= esc_attr( $s['bm_cta_btn2_text'] ) ?>"/>
            </div>
            <div class="cfg-field">
                <label>Button 2 URL</label>
                <input type="text" name="<?= CFG_OPTION ?>[bm_cta_btn2_url]" value="<?= esc_attr( $s['bm_cta_btn2_url'] ) ?>"/>
            </div>
        </div>
    </div>

    <!-- ═══ THANK YOU TAB ═══ -->
    <div id="cfg-ty" class="cfg-panel">
        <div class="cfg-section-title">Page Background</div>
        <div class="cfg-field" style="max-width:260px;">
            <label>Background Color</label>
            <div class="cfg-color-row">
                <input type="color" id="c_ty_bg_color" value="<?= esc_attr( $s['ty_bg_color'] ) ?>" oninput="syncColor('ty_bg_color',this.value)"/>
                <input type="text" id="ty_bg_color" name="<?= CFG_OPTION ?>[ty_bg_color]" value="<?= esc_attr( $s['ty_bg_color'] ) ?>" maxlength="7" oninput="syncPicker('c_ty_bg_color',this.value)"/>
            </div>
        </div>

        <div class="cfg-section-title">Left Column — Text</div>
        <div class="cfg-grid">
            <div class="cfg-field">
                <label>Eyebrow Label</label>
                <input type="text" name="<?= CFG_OPTION ?>[ty_eyebrow]" value="<?= esc_attr( $s['ty_eyebrow'] ) ?>"/>
            </div>
            <div class="cfg-field">
                <label>Heading — Line 1</label>
                <input type="text" name="<?= CFG_OPTION ?>[ty_heading_line1]" value="<?= esc_attr( $s['ty_heading_line1'] ) ?>"/>
            </div>
            <div class="cfg-field">
                <label>Heading — Line 2</label>
                <input type="text" name="<?= CFG_OPTION ?>[ty_heading_line2]" value="<?= esc_attr( $s['ty_heading_line2'] ) ?>"/>
            </div>
            <div class="cfg-field cfg-full">
                <label>Body Paragraph</label>
                <textarea name="<?= CFG_OPTION ?>[ty_body]"><?= esc_textarea( $s['ty_body'] ) ?></textarea>
            </div>
        </div>

        <div class="cfg-section-title">Social Link</div>
        <div class="cfg-toggle-row">
            <input type="checkbox" id="ty_social_show" name="<?= CFG_OPTION ?>[ty_social_show]" value="1" <?= checked( $s['ty_social_show'], '1', false ) ?>/>
            <label for="ty_social_show">Show social media link</label>
        </div>
        <div class="cfg-grid" style="margin-top:12px;">
            <div class="cfg-field">
                <label>Platform / Icon</label>
                <select name="<?= CFG_OPTION ?>[ty_social_platform]">
                    <?php foreach ( [
                        'instagram' => 'Instagram', 'facebook' => 'Facebook',
                        'tiktok' => 'TikTok', 'youtube' => 'YouTube', 'x' => 'X (Twitter)',
                    ] as $v => $l ): ?>
                    <option value="<?= $v ?>" <?= selected( $s['ty_social_platform'], $v, false ) ?>><?= $l ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="cfg-field">
                <label>Display Label</label>
                <input type="text" name="<?= CFG_OPTION ?>[ty_social_label]" value="<?= esc_attr( $s['ty_social_label'] ) ?>" placeholder="Check out our Instagram"/>
            </div>
            <div class="cfg-field">
                <label>Handle / Username</label>
                <input type="text" name="<?= CFG_OPTION ?>[ty_social_handle]" value="<?= esc_attr( $s['ty_social_handle'] ) ?>" placeholder="@yourpractice"/>
            </div>
            <div class="cfg-field">
                <label>Profile URL</label>
                <input type="url" name="<?= CFG_OPTION ?>[ty_social_url]" value="<?= esc_url( $s['ty_social_url'] ) ?>" placeholder="https://instagram.com/yourpractice"/>
            </div>
        </div>

        <div class="cfg-section-title">Right Column — Image</div>
        <div class="cfg-toggle-row">
            <input type="checkbox" id="ty_show_image" name="<?= CFG_OPTION ?>[ty_show_image]" value="1" <?= checked( $s['ty_show_image'], '1', false ) ?>/>
            <label for="ty_show_image">Show image on the right side</label>
        </div>
        <div class="cfg-grid" style="margin-top:12px;">
            <div class="cfg-field cfg-full">
                <label>Image URL</label>
                <input type="text" name="<?= CFG_OPTION ?>[ty_image_url]" value="<?= esc_url( $s['ty_image_url'] ) ?>" placeholder="https://yoursite.com/wp-content/uploads/smile.jpg"/>
                <span class="cfg-desc">Paste a direct image URL or upload to Media Library and copy the URL.</span>
            </div>
            <div class="cfg-field">
                <label>Image Alt Text</label>
                <input type="text" name="<?= CFG_OPTION ?>[ty_image_alt]" value="<?= esc_attr( $s['ty_image_alt'] ) ?>"/>
            </div>
        </div>
    </div>

    <!-- ═══ ALIGNER FORM TAB ═══ -->
    <div id="cfg-alg" class="cfg-panel">
        <p class="cfg-desc">Configure the multi-step clear aligner estimate quiz. Use shortcode <code>[aligner_form_ghl]</code> on any page. Uses the GHL API key from the ⚡ tab.</p>

        <div class="cfg-section-title">Global Settings</div>
        <div class="cfg-grid">
            <div class="cfg-field">
                <label>Accent / Highlight Color</label>
                <div style="display:flex;gap:8px;align-items:center;">
                    <input type="color" id="alg_accent_picker" value="<?= esc_attr( $s['alg_accent_color'] ) ?>" oninput="syncColor('alg_accent_text',this.value)"/>
                    <input type="text" id="alg_accent_text" name="<?= CFG_OPTION ?>[alg_accent_color]" value="<?= esc_attr( $s['alg_accent_color'] ) ?>" oninput="syncPicker('alg_accent_picker',this.value)" style="width:110px;"/>
                </div>
                <span class="cfg-desc">Heading & button color (default gold #C9A84C)</span>
            </div>
            <div class="cfg-field">
                <label>Success Redirect URL</label>
                <input type="text" name="<?= CFG_OPTION ?>[alg_success_url]" value="<?= esc_attr( $s['alg_success_url'] ?? '' ) ?>" placeholder="/thank-you"/>
                <span class="cfg-desc">Where to go after form submit. Leave blank to show inline thank-you.</span>
            </div>
        </div>

        <div class="cfg-section-title" style="margin-top:24px;">Form Steps</div>
        <p class="cfg-desc">Click a step to expand and edit. Use ↑↓ to reorder. Steps auto-advance on selection for yes/no and image types.</p>

        <div id="alg-builder" style="margin-top:12px;"></div>

        <div style="display:flex;gap:10px;margin-top:16px;align-items:center;flex-wrap:wrap;">
            <select id="alg-add-type" style="padding:7px 12px;border:1px solid #8c8f94;border-radius:4px;font-size:13px;">
                <option value="yesno">Yes / No Question</option>
                <option value="image">Image Choice Question</option>
                <option value="intro">Intro Screen</option>
                <option value="content">Content / Offer Screen</option>
                <option value="contact">Contact Form</option>
            </select>
            <button type="button" id="alg-add-step-btn" class="button">+ Add Step</button>
            <button type="button" onclick="algResetSteps()" class="button" style="margin-left:auto;color:#b32d2e;">↺ Reset to Defaults</button>
        </div>

        <textarea name="cfg_aligner_steps" id="cfg_aligner_steps_json" style="display:none;"></textarea>

        <template id="alg-step-tpl">
            <div class="alg-admin-step" style="border:1px solid #c3c4c7;border-radius:6px;margin-bottom:10px;background:#fff;">
                <div class="alg-step-hdr" style="display:flex;align-items:center;gap:8px;padding:10px 14px;cursor:pointer;user-select:none;background:#f9f9f9;border-radius:6px 6px 0 0;">
                    <span class="alg-step-num" style="background:#2271b1;color:#fff;border-radius:50%;width:22px;height:22px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;"></span>
                    <span class="alg-step-type-badge" style="background:#e8f4fd;color:#2271b1;font-size:10px;padding:2px 7px;border-radius:3px;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;flex-shrink:0;"></span>
                    <span class="alg-step-preview" style="color:#3c434a;font-size:12px;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"></span>
                    <div style="display:flex;gap:3px;flex-shrink:0;">
                        <button type="button" class="alg-move-up button button-small" title="Move up" style="padding:2px 7px;">↑</button>
                        <button type="button" class="alg-move-down button button-small" title="Move down" style="padding:2px 7px;">↓</button>
                        <button type="button" class="alg-delete button button-small" title="Delete" style="padding:2px 7px;color:#b32d2e;">✕</button>
                    </div>
                    <span class="alg-toggle-icon" style="font-size:9px;color:#888;margin-left:4px;">▼</span>
                </div>
                <div class="alg-step-body" style="display:none;padding:16px 18px;border-top:1px solid #e5e5e5;">
                    <div style="margin-bottom:14px;">
                        <label style="font-weight:600;font-size:13px;display:block;margin-bottom:5px;">Step Type</label>
                        <select class="alg-f-type" style="padding:6px 10px;border:1px solid #8c8f94;border-radius:4px;min-width:200px;">
                            <option value="intro">Intro Screen</option>
                            <option value="yesno">Yes / No Question</option>
                            <option value="image">Image Choice Question</option>
                            <option value="content">Content / Offer Screen</option>
                            <option value="contact">Contact Form</option>
                        </select>
                    </div>
                    <div class="alg-fields-intro">
                        <div class="cfg-grid">
                            <div class="cfg-field"><label>Title</label><input type="text" class="alg-f-title" style="width:100%;"/></div>
                            <div class="cfg-field"><label>Button Text</label><input type="text" class="alg-f-btn-text" style="width:100%;"/></div>
                            <div class="cfg-field cfg-full"><label>Subtitle / Description</label><textarea class="alg-f-subtitle" rows="2" style="width:100%;"></textarea></div>
                            <div class="cfg-field cfg-full"><label>Bullet Points <span style="font-weight:400;color:#666;">(one per line)</span></label><textarea class="alg-f-bullets" rows="3" style="width:100%;"></textarea></div>
                        </div>
                    </div>
                    <div class="alg-fields-yesno">
                        <div class="cfg-grid">
                            <div class="cfg-field cfg-full"><label>Question</label><input type="text" class="alg-f-question" style="width:100%;"/></div>
                            <div class="cfg-field"><label>Hint / Subtext</label><input type="text" class="alg-f-hint" style="width:100%;"/></div>
                            <div class="cfg-field"><label>Field Key <span style="font-weight:400;color:#666;">(sent to GHL)</span></label><input type="text" class="alg-f-key" placeholder="e.g. prev_orthodontic" style="width:100%;"/></div>
                        </div>
                    </div>
                    <div class="alg-fields-image">
                        <div class="cfg-grid">
                            <div class="cfg-field cfg-full"><label>Question</label><input type="text" class="alg-f-question" style="width:100%;"/></div>
                            <div class="cfg-field"><label>Hint / Subtext</label><input type="text" class="alg-f-hint" style="width:100%;"/></div>
                            <div class="cfg-field"><label>Field Key</label><input type="text" class="alg-f-key" placeholder="e.g. teeth_alignment" style="width:100%;"/></div>
                        </div>
                        <div style="margin-top:14px;">
                            <label style="font-weight:600;font-size:13px;display:block;margin-bottom:4px;">Choices</label>
                            <div style="display:grid;grid-template-columns:2fr 52px 3fr 28px;gap:4px;margin-bottom:6px;padding:0 2px;">
                                <span style="font-size:11px;color:#666;">Label</span>
                                <span style="font-size:11px;color:#666;">Emoji</span>
                                <span style="font-size:11px;color:#666;">Image URL (optional)</span>
                                <span></span>
                            </div>
                            <div class="alg-choices-container" style="display:flex;flex-direction:column;gap:6px;"></div>
                            <button type="button" class="alg-add-choice button button-small" style="margin-top:8px;">+ Add Choice</button>
                        </div>
                    </div>
                    <div class="alg-fields-content">
                        <div class="cfg-grid">
                            <div class="cfg-field"><label>Title</label><input type="text" class="alg-f-title" style="width:100%;"/></div>
                            <div class="cfg-field"><label>Button Text</label><input type="text" class="alg-f-btn-text" style="width:100%;"/></div>
                            <div class="cfg-field cfg-full"><label>Subtitle</label><input type="text" class="alg-f-subtitle" style="width:100%;"/></div>
                            <div class="cfg-field cfg-full"><label>Bullet Points <span style="font-weight:400;color:#666;">(one per line)</span></label><textarea class="alg-f-bullets" rows="3" style="width:100%;"></textarea></div>
                        </div>
                    </div>
                    <div class="alg-fields-contact">
                        <div class="cfg-grid">
                            <div class="cfg-field"><label>Title</label><input type="text" class="alg-f-title" style="width:100%;"/></div>
                            <div class="cfg-field"><label>Button Text</label><input type="text" class="alg-f-btn-text" style="width:100%;"/></div>
                            <div class="cfg-field cfg-full"><label>Subtitle</label><textarea class="alg-f-subtitle" rows="2" style="width:100%;"></textarea></div>
                        </div>
                        <p class="cfg-desc" style="margin-top:8px;">Contact form always collects: First Name, Last Name, Phone, Email. All quiz answers are sent to GHL as custom fields and tags.</p>
                    </div>
                </div>
            </div>
        </template>

        <script>
        (function(){
            var savedData = <?= wp_json_encode( cfg_aligner_get() ) ?>;
            var dflts     = <?= wp_json_encode( cfg_aligner_defaults() ) ?>;
            var builder   = document.getElementById('alg-builder');
            var tpl       = document.getElementById('alg-step-tpl');
            var LABELS    = {intro:'Intro Screen',yesno:'Yes/No Question',image:'Image Choices',content:'Content Screen',contact:'Contact Form'};

            function init(data) {
                builder.innerHTML = '';
                data.forEach(function(step){ builder.appendChild(mkCard(step)); });
                renumber();
            }

            function mkCard(step) {
                var frag = tpl.content.cloneNode(true);
                var card = frag.querySelector('.alg-admin-step');
                var type = step.type || 'yesno';

                var ts = card.querySelector('.alg-f-type');
                ts.value = type;
                applyType(card, type);
                ts.addEventListener('change', function(){ applyType(card, this.value); refreshPreview(card); });

                function sf(sel, val) {
                    if (val === undefined || val === null) return;
                    var el = card.querySelector(sel);
                    if (el) el.value = val;
                }
                sf('.alg-f-title',    step.title    || step.question || '');
                sf('.alg-f-subtitle', step.type === 'yesno' || step.type === 'image' ? (step.hint || '') : (step.subtitle || ''));
                sf('.alg-f-bullets',  step.bullets  || '');
                sf('.alg-f-btn-text', step.btn_text || '');
                sf('.alg-f-question', step.question || '');
                sf('.alg-f-hint',     step.hint     || '');
                sf('.alg-f-key',      step.field_key|| '');

                if (type === 'image' && step.choices) {
                    var cc = card.querySelector('.alg-choices-container');
                    step.choices.forEach(function(c){ cc.appendChild(mkChoice(c.label||'',c.emoji||'',c.img||'')); });
                }

                refreshPreview(card);
                card.querySelectorAll('input,textarea').forEach(function(el){ el.addEventListener('input', function(){ refreshPreview(card); }); });

                card.querySelector('.alg-step-hdr').addEventListener('click', function(e){
                    if (e.target.closest('button') || e.target.tagName === 'SELECT') return;
                    var body = card.querySelector('.alg-step-body');
                    var icon = card.querySelector('.alg-toggle-icon');
                    var open = body.style.display !== 'none';
                    body.style.display = open ? 'none' : 'block';
                    icon.textContent = open ? '▼' : '▲';
                    card.querySelector('.alg-step-hdr').style.borderRadius = open ? '6px 6px 0 0' : '6px';
                });
                card.querySelector('.alg-delete').addEventListener('click', function(){
                    if (confirm('Delete this step?')) { card.remove(); renumber(); }
                });
                card.querySelector('.alg-move-up').addEventListener('click', function(e){
                    e.stopPropagation();
                    var prev = card.previousElementSibling;
                    if (prev) { builder.insertBefore(card, prev); renumber(); }
                });
                card.querySelector('.alg-move-down').addEventListener('click', function(e){
                    e.stopPropagation();
                    var next = card.nextElementSibling;
                    if (next) { builder.insertBefore(next, card); renumber(); }
                });
                var addChoiceBtn = card.querySelector('.alg-add-choice');
                if (addChoiceBtn) {
                    addChoiceBtn.addEventListener('click', function(){
                        card.querySelector('.alg-choices-container').appendChild(mkChoice('New Option','🦷',''));
                    });
                }
                return card;
            }

            function applyType(card, type) {
                ['intro','yesno','image','content','contact'].forEach(function(t){
                    var el = card.querySelector('.alg-fields-' + t);
                    if (el) el.style.display = t === type ? 'block' : 'none';
                });
                var badge = card.querySelector('.alg-step-type-badge');
                if (badge) badge.textContent = LABELS[type] || type;
            }

            function refreshPreview(card) {
                var type = card.querySelector('.alg-f-type').value;
                var txt = '';
                if (type === 'yesno' || type === 'image') {
                    var el = card.querySelector('.alg-f-question'); txt = el ? el.value : '';
                } else {
                    var el = card.querySelector('.alg-f-title'); txt = el ? el.value : '';
                }
                var prev = card.querySelector('.alg-step-preview');
                if (prev) prev.textContent = txt ? '— ' + txt : '';
            }

            function renumber() {
                Array.from(builder.querySelectorAll('.alg-admin-step')).forEach(function(c,i){
                    var n = c.querySelector('.alg-step-num'); if (n) n.textContent = i + 1;
                });
            }

            function mkChoice(label, emoji, img) {
                var div = document.createElement('div');
                div.style.cssText = 'display:grid;grid-template-columns:2fr 52px 3fr 28px;gap:4px;align-items:center;';
                var hq = function(s){ return String(s||'').replace(/&/g,'&amp;').replace(/"/g,'&quot;'); };
                div.innerHTML =
                    '<input type="text" placeholder="Label" value="'+hq(label)+'" style="padding:5px 8px;border:1px solid #8c8f94;border-radius:3px;font-size:13px;width:100%;"/>' +
                    '<input type="text" placeholder="😬" value="'+hq(emoji)+'" style="padding:5px 4px;border:1px solid #8c8f94;border-radius:3px;font-size:1.15rem;text-align:center;width:100%;"/>' +
                    '<input type="text" placeholder="https://... (optional)" value="'+hq(img)+'" style="padding:5px 8px;border:1px solid #8c8f94;border-radius:3px;font-size:13px;width:100%;"/>' +
                    '<button type="button" title="Remove choice" onclick="this.closest(\'div\').remove()" style="background:none;border:none;cursor:pointer;color:#b32d2e;font-size:1rem;padding:0;line-height:1;">✕</button>';
                return div;
            }

            document.getElementById('alg-add-step-btn').addEventListener('click', function(){
                var type = document.getElementById('alg-add-type').value;
                var now  = Date.now();
                var map  = {
                    intro:   {type:'intro',   title:'New Intro',        subtitle:'', bullets:'', btn_text:'Get Started'},
                    yesno:   {type:'yesno',   question:'New question?', hint:'', field_key:'q_'+now},
                    image:   {type:'image',   question:'New question?', hint:'', field_key:'q_'+now, choices:[{label:'Option A',emoji:'🦷',img:''},{label:'Option B',emoji:'🦷',img:''}]},
                    content: {type:'content', title:'New Offer',        subtitle:'', bullets:'', btn_text:'Continue'},
                    contact: {type:'contact', title:'Get Your Estimate',subtitle:'', btn_text:'Submit'},
                };
                var card = mkCard(map[type] || map.yesno);
                card.querySelector('.alg-step-body').style.display = 'block';
                card.querySelector('.alg-toggle-icon').textContent = '▲';
                builder.appendChild(card);
                renumber();
                card.scrollIntoView({behavior:'smooth',block:'nearest'});
            });

            window.algResetSteps = function(){
                if (confirm('Reset all steps to defaults? Save after resetting.')) { init(dflts); }
            };

            document.querySelector('form[action="options.php"]').addEventListener('submit', function(){
                var steps = [];
                builder.querySelectorAll('.alg-admin-step').forEach(function(card){
                    var type = card.querySelector('.alg-f-type').value;
                    var step = {type:type};
                    function gf(sel){ var el = card.querySelector(sel); return el ? el.value : ''; }
                    if (type === 'intro' || type === 'content') {
                        step.title    = gf('.alg-f-title');
                        step.subtitle = gf('.alg-f-subtitle');
                        step.bullets  = gf('.alg-f-bullets');
                        step.btn_text = gf('.alg-f-btn-text');
                    } else if (type === 'yesno') {
                        step.question  = gf('.alg-f-question');
                        step.hint      = gf('.alg-f-hint');
                        step.field_key = gf('.alg-f-key');
                    } else if (type === 'image') {
                        step.question  = gf('.alg-f-question');
                        step.hint      = gf('.alg-f-hint');
                        step.field_key = gf('.alg-f-key');
                        step.choices   = [];
                        card.querySelectorAll('.alg-choices-container > div').forEach(function(row){
                            var ins = row.querySelectorAll('input');
                            step.choices.push({label:ins[0]?ins[0].value:'', emoji:ins[1]?ins[1].value:'', img:ins[2]?ins[2].value:''});
                        });
                    } else if (type === 'contact') {
                        step.title    = gf('.alg-f-title');
                        step.subtitle = gf('.alg-f-subtitle');
                        step.btn_text = gf('.alg-f-btn-text');
                    }
                    steps.push(step);
                });
                document.getElementById('cfg_aligner_steps_json').value = JSON.stringify(steps);
            });

            init(savedData);
        })();
        </script>
    </div>

    <!-- ═══ IMPLANT ESTIMATOR TAB ═══ -->
    <div id="cfg-imp" class="cfg-panel">
    <style>
    /* ── IMP REDESIGN ─────────────────────────────────── */
    .imp-sw-row{display:flex;align-items:center;justify-content:space-between;padding:13px 16px;border-radius:8px;background:#fff;border:1px solid #e5e7eb;margin-bottom:8px;transition:box-shadow .15s;}
    .imp-sw-row:hover{box-shadow:0 1px 4px rgba(0,0,0,.08);}
    .imp-sw-info{flex:1;min-width:0;padding-right:16px;}
    .imp-sw-info strong{font-size:13px;color:#1d2327;display:block;margin-bottom:2px;}
    .imp-sw-info span{font-size:12px;color:#6b7280;line-height:1.4;}
    .imp-sw{position:relative;display:inline-block;width:42px;height:24px;flex-shrink:0;}
    .imp-sw input{opacity:0;width:0;height:0;position:absolute;}
    .imp-sw-slider{position:absolute;inset:0;background:#c7ccd1;border-radius:24px;cursor:pointer;transition:background .2s;}
    .imp-sw-slider:before{content:'';position:absolute;width:18px;height:18px;left:3px;top:3px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.2);}
    .imp-sw input:checked + .imp-sw-slider{background:#2271b1;}
    .imp-sw input:checked + .imp-sw-slider:before{transform:translateX(18px);}
    .imp-sw input:focus + .imp-sw-slider{outline:2px solid #2271b1;outline-offset:2px;}
    .imp-section-hdr{display:flex;align-items:center;gap:10px;padding:14px 0 10px;border-bottom:2px solid #f0f0f1;margin-bottom:16px;}
    .imp-section-hdr .imp-section-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
    .imp-section-hdr h3{margin:0;font-size:14px;font-weight:700;color:#1d2327;}
    .imp-section-hdr p{margin:2px 0 0;font-size:12px;color:#6b7280;}
    .imp-pricing-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;}
    .imp-price-card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:14px 16px;position:relative;}
    .imp-price-card.disabled-card{opacity:.4;pointer-events:none;}
    .imp-price-card-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#6b7280;margin-bottom:10px;display:flex;align-items:center;gap:6px;}
    .imp-price-card-label span.dot{width:8px;height:8px;border-radius:50%;display:inline-block;}
    .imp-price-range-row{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
    .imp-price-range-row .cfg-field label{font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.04em;}
    .imp-path-accordion{border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;margin-bottom:10px;}
    .imp-path-header{display:flex;align-items:center;gap:12px;padding:13px 16px;cursor:pointer;user-select:none;background:#fafafa;transition:background .15s;}
    .imp-path-header:hover{background:#f3f4f6;}
    .imp-path-header .imp-path-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;}
    .imp-path-header .imp-path-title{flex:1;font-size:13px;font-weight:700;color:#1d2327;}
    .imp-path-header .imp-path-count{font-size:11px;color:#9ca3af;background:#f0f0f1;padding:2px 8px;border-radius:12px;}
    .imp-path-header .imp-path-chevron{font-size:12px;color:#9ca3af;transition:transform .2s;margin-left:4px;}
    .imp-path-header.open .imp-path-chevron{transform:rotate(180deg);}
    .imp-path-body{display:none;padding:16px;background:#fff;border-top:1px solid #e5e7eb;}
    .imp-path-body.open{display:block;}
    .imp-path-body .cfg-grid{gap:12px 20px;}
    .imp-q-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;}
    .imp-result-suffix-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;}
    .imp-q-block{background:#fafafa;border:1px solid #e5e7eb;border-radius:8px;padding:12px 14px;margin-bottom:10px;}
    .imp-q-title-input{width:100%;padding:7px 10px;border:1px solid #8c8f94;border-radius:4px;font-size:13px;margin-bottom:10px;box-sizing:border-box;}
    .imp-opts-grid{display:flex;flex-direction:column;gap:6px;}
    .imp-opt-row{display:flex;align-items:center;gap:8px;}
    .imp-opt-num{flex-shrink:0;width:22px;height:22px;border-radius:50%;background:#e5e7eb;font-size:11px;font-weight:700;color:#6b7280;display:flex;align-items:center;justify-content:center;}
    .imp-opt-row input[type=text]{flex:1;padding:6px 9px;border:1px solid #d1d5db;border-radius:4px;font-size:12.5px;min-width:0;}
    .imp-opt-row input[type=text]:focus{border-color:#2271b1;outline:none;box-shadow:0 0 0 1px #2271b1;}
    .imp-opt-sub{color:#6b7280!important;font-style:italic;}
    </style>

        <!-- ════════════════════════════════════════════════════ -->
        <!--  1 · DISPLAY & TOGGLES                               -->
        <!-- ════════════════════════════════════════════════════ -->
        <div class="imp-section-hdr" style="margin-top:0;">
            <div class="imp-section-icon" style="background:#eff6ff;">⚙️</div>
            <div>
                <h3>Display Settings</h3>
                <p>Control what appears in the estimator and basic redirect behaviour</p>
            </div>
        </div>

        <div class="cfg-grid" style="margin-bottom:16px;">
            <div class="cfg-field">
                <label>Accent Color</label>
                <div class="cfg-color-row">
                    <input type="color" id="c_imp_accent_color" value="<?= esc_attr( $s['imp_accent_color'] ) ?>" oninput="syncColor('imp_accent_color',this.value)"/>
                    <input type="text" id="imp_accent_color" name="<?= CFG_OPTION ?>[imp_accent_color]" value="<?= esc_attr( $s['imp_accent_color'] ) ?>" maxlength="7" oninput="syncPicker('c_imp_accent_color',this.value)"/>
                </div>
            </div>
            <div class="cfg-field">
                <label>Success Redirect URL <span class="cfg-badge">optional</span></label>
                <input type="url" name="<?= CFG_OPTION ?>[imp_success_url]" value="<?= esc_url( $s['imp_success_url'] ) ?>" placeholder="/thank-you"/>
                <span class="cfg-desc">Leave blank to show results inline.</span>
            </div>
        </div>

        <div class="imp-sw-row">
            <div class="imp-sw-info">
                <strong>Hide Site Header</strong>
                <span>Hides <code>&lt;header&gt;</code> and common nav elements on pages with this estimator</span>
            </div>
            <label class="imp-sw">
                <input type="checkbox" id="imp_hide_header" name="<?= CFG_OPTION ?>[imp_hide_header]" value="1" <?= checked( $s['imp_hide_header'], '1', false ) ?>/>
                <span class="imp-sw-slider"></span>
            </label>
        </div>

        <div class="imp-sw-row">
            <div class="imp-sw-info">
                <strong>Show "Full Arch" Path</strong>
                <span>Adds the full arch route to the router question and enables arch pricing below</span>
            </div>
            <label class="imp-sw">
                <input type="checkbox" id="imp_show_full_arch" name="<?= CFG_OPTION ?>[imp_show_full_arch]" value="1" <?= checked( $s['imp_show_full_arch'], '1', false ) ?> onchange="document.getElementById('imp-arch-price-card').classList.toggle('disabled-card',!this.checked)"/>
                <span class="imp-sw-slider"></span>
            </label>
        </div>

        <div class="imp-sw-row">
            <div class="imp-sw-info">
                <strong>Show Financing Note</strong>
                <span>Displays a financing availability message on the results screen</span>
            </div>
            <label class="imp-sw">
                <input type="checkbox" id="imp_show_financing" name="<?= CFG_OPTION ?>[imp_show_financing]" value="1" <?= checked( $s['imp_show_financing'], '1', false ) ?>/>
                <span class="imp-sw-slider"></span>
            </label>
        </div>

        <div class="imp-sw-row">
            <div class="imp-sw-info">
                <strong>Show Insurance Question</strong>
                <span>When off, single &amp; multiple tooth flows skip insurance and go straight to the summary</span>
            </div>
            <label class="imp-sw">
                <input type="checkbox" id="imp_show_insurance" name="<?= CFG_OPTION ?>[imp_show_insurance]" value="1" <?= checked( $s['imp_show_insurance'], '1', false ) ?>/>
                <span class="imp-sw-slider"></span>
            </label>
        </div>

        <div class="imp-sw-row">
            <div class="imp-sw-info">
                <strong>Show Price Range on Results</strong>
                <span>When off, a custom call-to-action is shown instead of the estimated price</span>
            </div>
            <label class="imp-sw">
                <input type="checkbox" id="imp_show_price" name="<?= CFG_OPTION ?>[imp_show_price]" value="1" <?= checked( $s['imp_show_price'], '1', false ) ?> onchange="document.getElementById('imp-price-rows').style.display=this.checked?'block':'none';document.getElementById('imp-noprice-rows').style.display=this.checked?'none':'block'"/>
                <span class="imp-sw-slider"></span>
            </label>
        </div>

        <!-- ════════════════════════════════════════════════════ -->
        <!--  2 · PRICING                                         -->
        <!-- ════════════════════════════════════════════════════ -->
        <div class="imp-section-hdr" style="margin-top:28px;">
            <div class="imp-section-icon" style="background:#f0fdf4;">💰</div>
            <div>
                <h3>Pricing Ranges</h3>
                <p>Bone graft cost is added on top when the patient selects "Yes" or "Not sure"</p>
            </div>
        </div>

        <div class="cfg-grid" style="margin-bottom:14px;">
            <div class="cfg-field">
                <label>Currency Symbol</label>
                <input type="text" name="<?= CFG_OPTION ?>[imp_currency]" value="<?= esc_attr( $s['imp_currency'] ) ?>" maxlength="5" placeholder="$" style="max-width:110px;"/>
                <span class="cfg-desc">E.g. <code>$</code>, <code>CAD $</code>, <code>£</code></span>
            </div>
        </div>

        <div class="imp-pricing-grid">
            <div class="imp-price-card">
                <div class="imp-price-card-label"><span class="dot" style="background:#3b82f6;"></span> Single Tooth</div>
                <div class="imp-price-range-row">
                    <div class="cfg-field"><label>Min</label><input type="text" name="<?= CFG_OPTION ?>[imp_single_min]" value="<?= esc_attr( $s['imp_single_min'] ) ?>" maxlength="8" placeholder="3000"/></div>
                    <div class="cfg-field"><label>Max</label><input type="text" name="<?= CFG_OPTION ?>[imp_single_max]" value="<?= esc_attr( $s['imp_single_max'] ) ?>" maxlength="8" placeholder="6000"/></div>
                </div>
            </div>
            <div class="imp-price-card">
                <div class="imp-price-card-label"><span class="dot" style="background:#8b5cf6;"></span> Multiple Teeth</div>
                <div class="imp-price-range-row">
                    <div class="cfg-field"><label>Min</label><input type="text" name="<?= CFG_OPTION ?>[imp_multi_min]" value="<?= esc_attr( $s['imp_multi_min'] ) ?>" maxlength="8" placeholder="5000"/></div>
                    <div class="cfg-field"><label>Max</label><input type="text" name="<?= CFG_OPTION ?>[imp_multi_max]" value="<?= esc_attr( $s['imp_multi_max'] ) ?>" maxlength="8" placeholder="20000"/></div>
                </div>
            </div>
            <div class="imp-price-card <?= $s['imp_show_full_arch'] !== '1' ? 'disabled-card' : '' ?>" id="imp-arch-price-card">
                <div class="imp-price-card-label"><span class="dot" style="background:#10b981;"></span> Full Arch <span class="cfg-badge" style="font-size:10px;">toggle above</span></div>
                <div class="imp-price-range-row">
                    <div class="cfg-field"><label>Min</label><input type="text" name="<?= CFG_OPTION ?>[imp_arch_min]" value="<?= esc_attr( $s['imp_arch_min'] ) ?>" maxlength="8" placeholder="24000"/></div>
                    <div class="cfg-field"><label>Max</label><input type="text" name="<?= CFG_OPTION ?>[imp_arch_max]" value="<?= esc_attr( $s['imp_arch_max'] ) ?>" maxlength="8" placeholder="30000"/></div>
                </div>
            </div>
            <div class="imp-price-card">
                <div class="imp-price-card-label"><span class="dot" style="background:#f59e0b;"></span> Bone Graft Add-On</div>
                <div class="imp-price-range-row">
                    <div class="cfg-field"><label>Min</label><input type="text" name="<?= CFG_OPTION ?>[imp_graft_min]" value="<?= esc_attr( $s['imp_graft_min'] ) ?>" maxlength="8" placeholder="650"/></div>
                    <div class="cfg-field"><label>Max</label><input type="text" name="<?= CFG_OPTION ?>[imp_graft_max]" value="<?= esc_attr( $s['imp_graft_max'] ) ?>" maxlength="8" placeholder="1100"/></div>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════ -->
        <!--  3 · QUESTION TITLES (collapsible path groups)       -->
        <!-- ════════════════════════════════════════════════════ -->
        <div class="imp-section-hdr" style="margin-top:28px;">
            <div class="imp-section-icon" style="background:#fdf4ff;">📝</div>
            <div>
                <h3>Question Titles</h3>
                <p>Customise the heading shown on each question panel — answer options are fixed</p>
            </div>
        </div>

        <!-- Router -->
        <div class="imp-path-accordion">
            <div class="imp-path-header" onclick="impTogglePath(this)">
                <span class="imp-path-dot" style="background:#6b7280;"></span>
                <span class="imp-path-title">Router Question</span>
                <span class="imp-path-count">1 question · 3 options</span>
                <span class="imp-path-chevron">▼</span>
            </div>
            <div class="imp-path-body">
                <div class="cfg-grid" style="margin-bottom:14px;">
                    <div class="cfg-field cfg-full">
                        <div class="imp-q-label">Question Title</div>
                        <input type="text" name="<?= CFG_OPTION ?>[imp_router_title]" value="<?= esc_attr( $s['imp_router_title'] ) ?>"/>
                    </div>
                    <div class="cfg-field cfg-full">
                        <div class="imp-q-label">Sub-label</div>
                        <input type="text" name="<?= CFG_OPTION ?>[imp_router_sub]" value="<?= esc_attr( $s['imp_router_sub'] ) ?>"/>
                    </div>
                </div>
                <div style="border-top:1px solid #e5e7eb;padding-top:12px;">
                    <div class="imp-q-label" style="margin-bottom:10px;color:#6b7280;">Answer Options</div>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_router_opt1]" value="<?= esc_attr( $s['imp_router_opt1'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_router_opt1_sub]" value="<?= esc_attr( $s['imp_router_opt1_sub'] ) ?>" placeholder="Sub-label (optional)" class="imp-opt-sub"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_router_opt2]" value="<?= esc_attr( $s['imp_router_opt2'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_router_opt2_sub]" value="<?= esc_attr( $s['imp_router_opt2_sub'] ) ?>" placeholder="Sub-label (optional)" class="imp-opt-sub"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_router_opt3]" value="<?= esc_attr( $s['imp_router_opt3'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_router_opt3_sub]" value="<?= esc_attr( $s['imp_router_opt3_sub'] ) ?>" placeholder="Sub-label (optional)" class="imp-opt-sub"/></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Single Tooth Path -->
        <div class="imp-path-accordion">
            <div class="imp-path-header" onclick="impTogglePath(this)">
                <span class="imp-path-dot" style="background:#3b82f6;"></span>
                <span class="imp-path-title">Single Tooth Path</span>
                <span class="imp-path-count">4 questions &nbsp;·&nbsp; A1 – A4</span>
                <span class="imp-path-chevron">▼</span>
            </div>
            <div class="imp-path-body">

                <div class="imp-q-block">
                    <div class="imp-q-label" style="color:#3b82f6;">A1 — Tooth Location</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_a1_title]" value="<?= esc_attr( $s['imp_a1_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_a1_opt1]" value="<?= esc_attr( $s['imp_a1_opt1'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_a1_opt1_sub]" value="<?= esc_attr( $s['imp_a1_opt1_sub'] ) ?>" placeholder="Sub-label" class="imp-opt-sub"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_a1_opt2]" value="<?= esc_attr( $s['imp_a1_opt2'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_a1_opt2_sub]" value="<?= esc_attr( $s['imp_a1_opt2_sub'] ) ?>" placeholder="Sub-label" class="imp-opt-sub"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_a1_opt3]" value="<?= esc_attr( $s['imp_a1_opt3'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_a1_opt3_sub]" value="<?= esc_attr( $s['imp_a1_opt3_sub'] ) ?>" placeholder="Sub-label" class="imp-opt-sub"/></div>
                    </div>
                </div>

                <div class="imp-q-block">
                    <div class="imp-q-label" style="color:#3b82f6;">A2 — How Long Missing</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_a2_title]" value="<?= esc_attr( $s['imp_a2_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_a2_opt1]" value="<?= esc_attr( $s['imp_a2_opt1'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_a2_opt2]" value="<?= esc_attr( $s['imp_a2_opt2'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_a2_opt3]" value="<?= esc_attr( $s['imp_a2_opt3'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">4</span><input type="text" name="<?= CFG_OPTION ?>[imp_a2_opt4]" value="<?= esc_attr( $s['imp_a2_opt4'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">5</span><input type="text" name="<?= CFG_OPTION ?>[imp_a2_opt5]" value="<?= esc_attr( $s['imp_a2_opt5'] ) ?>" placeholder="Label"/></div>
                    </div>
                </div>

                <div class="imp-q-block">
                    <div class="imp-q-label" style="color:#3b82f6;">A3 — Bone Graft</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_a3_title]" value="<?= esc_attr( $s['imp_a3_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_a3_opt1]" value="<?= esc_attr( $s['imp_a3_opt1'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_a3_opt2]" value="<?= esc_attr( $s['imp_a3_opt2'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_a3_opt3]" value="<?= esc_attr( $s['imp_a3_opt3'] ) ?>" placeholder="Label"/></div>
                    </div>
                </div>

                <div class="imp-q-block" style="margin-bottom:0;">
                    <div class="imp-q-label" style="color:#3b82f6;">A4 — Situation</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_a4_title]" value="<?= esc_attr( $s['imp_a4_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_a4_opt1]" value="<?= esc_attr( $s['imp_a4_opt1'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_a4_opt2]" value="<?= esc_attr( $s['imp_a4_opt2'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_a4_opt3]" value="<?= esc_attr( $s['imp_a4_opt3'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">4</span><input type="text" name="<?= CFG_OPTION ?>[imp_a4_opt4]" value="<?= esc_attr( $s['imp_a4_opt4'] ) ?>" placeholder="Label"/></div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Multiple Teeth Path -->
        <div class="imp-path-accordion">
            <div class="imp-path-header" onclick="impTogglePath(this)">
                <span class="imp-path-dot" style="background:#8b5cf6;"></span>
                <span class="imp-path-title">Multiple Teeth Path</span>
                <span class="imp-path-count">5 questions &nbsp;·&nbsp; M1 – M5</span>
                <span class="imp-path-chevron">▼</span>
            </div>
            <div class="imp-path-body">

                <div class="imp-q-block">
                    <div class="imp-q-label" style="color:#8b5cf6;">M1 — How Many Teeth</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_m1_title]" value="<?= esc_attr( $s['imp_m1_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_m1_opt1]" value="<?= esc_attr( $s['imp_m1_opt1'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_m1_opt2]" value="<?= esc_attr( $s['imp_m1_opt2'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_m1_opt3]" value="<?= esc_attr( $s['imp_m1_opt3'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">4</span><input type="text" name="<?= CFG_OPTION ?>[imp_m1_opt4]" value="<?= esc_attr( $s['imp_m1_opt4'] ) ?>" placeholder="Label"/></div>
                    </div>
                </div>

                <div class="imp-q-block">
                    <div class="imp-q-label" style="color:#8b5cf6;">M2 — Teeth Location</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_m2_title]" value="<?= esc_attr( $s['imp_m2_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_m2_opt1]" value="<?= esc_attr( $s['imp_m2_opt1'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_m2_opt1_sub]" value="<?= esc_attr( $s['imp_m2_opt1_sub'] ) ?>" placeholder="Sub-label" class="imp-opt-sub"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_m2_opt2]" value="<?= esc_attr( $s['imp_m2_opt2'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_m2_opt2_sub]" value="<?= esc_attr( $s['imp_m2_opt2_sub'] ) ?>" placeholder="Sub-label" class="imp-opt-sub"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_m2_opt3]" value="<?= esc_attr( $s['imp_m2_opt3'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_m2_opt3_sub]" value="<?= esc_attr( $s['imp_m2_opt3_sub'] ) ?>" placeholder="Sub-label" class="imp-opt-sub"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">4</span><input type="text" name="<?= CFG_OPTION ?>[imp_m2_opt4]" value="<?= esc_attr( $s['imp_m2_opt4'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_m2_opt4_sub]" value="<?= esc_attr( $s['imp_m2_opt4_sub'] ) ?>" placeholder="Sub-label" class="imp-opt-sub"/></div>
                    </div>
                </div>

                <div class="imp-q-block">
                    <div class="imp-q-label" style="color:#8b5cf6;">M3 — How Long Missing</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_m3_title]" value="<?= esc_attr( $s['imp_m3_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_m3_opt1]" value="<?= esc_attr( $s['imp_m3_opt1'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_m3_opt2]" value="<?= esc_attr( $s['imp_m3_opt2'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_m3_opt3]" value="<?= esc_attr( $s['imp_m3_opt3'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">4</span><input type="text" name="<?= CFG_OPTION ?>[imp_m3_opt4]" value="<?= esc_attr( $s['imp_m3_opt4'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">5</span><input type="text" name="<?= CFG_OPTION ?>[imp_m3_opt5]" value="<?= esc_attr( $s['imp_m3_opt5'] ) ?>" placeholder="Label"/></div>
                    </div>
                </div>

                <div class="imp-q-block">
                    <div class="imp-q-label" style="color:#8b5cf6;">M4 — Bone Graft</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_m4_title]" value="<?= esc_attr( $s['imp_m4_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_m4_opt1]" value="<?= esc_attr( $s['imp_m4_opt1'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_m4_opt2]" value="<?= esc_attr( $s['imp_m4_opt2'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_m4_opt3]" value="<?= esc_attr( $s['imp_m4_opt3'] ) ?>" placeholder="Label"/></div>
                    </div>
                </div>

                <div class="imp-q-block" style="margin-bottom:0;">
                    <div class="imp-q-label" style="color:#8b5cf6;">M5 — Situation</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_m5_title]" value="<?= esc_attr( $s['imp_m5_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_m5_opt1]" value="<?= esc_attr( $s['imp_m5_opt1'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_m5_opt2]" value="<?= esc_attr( $s['imp_m5_opt2'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_m5_opt3]" value="<?= esc_attr( $s['imp_m5_opt3'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">4</span><input type="text" name="<?= CFG_OPTION ?>[imp_m5_opt4]" value="<?= esc_attr( $s['imp_m5_opt4'] ) ?>" placeholder="Label"/></div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Full Arch Path -->
        <div class="imp-path-accordion">
            <div class="imp-path-header" onclick="impTogglePath(this)">
                <span class="imp-path-dot" style="background:#10b981;"></span>
                <span class="imp-path-title">Full Arch Path</span>
                <span class="imp-path-count">3 questions &nbsp;·&nbsp; B1 – B3</span>
                <span class="imp-path-chevron">▼</span>
            </div>
            <div class="imp-path-body">

                <div class="imp-q-block">
                    <div class="imp-q-label" style="color:#10b981;">B1 — Which Arch</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_b1_title]" value="<?= esc_attr( $s['imp_b1_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_b1_opt1]" value="<?= esc_attr( $s['imp_b1_opt1'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_b1_opt1_sub]" value="<?= esc_attr( $s['imp_b1_opt1_sub'] ) ?>" placeholder="Sub-label" class="imp-opt-sub"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_b1_opt2]" value="<?= esc_attr( $s['imp_b1_opt2'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_b1_opt2_sub]" value="<?= esc_attr( $s['imp_b1_opt2_sub'] ) ?>" placeholder="Sub-label" class="imp-opt-sub"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_b1_opt3]" value="<?= esc_attr( $s['imp_b1_opt3'] ) ?>" placeholder="Label"/><input type="text" name="<?= CFG_OPTION ?>[imp_b1_opt3_sub]" value="<?= esc_attr( $s['imp_b1_opt3_sub'] ) ?>" placeholder="Sub-label" class="imp-opt-sub"/></div>
                    </div>
                </div>

                <div class="imp-q-block">
                    <div class="imp-q-label" style="color:#10b981;">B2 — Current Situation</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_b2_title]" value="<?= esc_attr( $s['imp_b2_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_b2_opt1]" value="<?= esc_attr( $s['imp_b2_opt1'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_b2_opt2]" value="<?= esc_attr( $s['imp_b2_opt2'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_b2_opt3]" value="<?= esc_attr( $s['imp_b2_opt3'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">4</span><input type="text" name="<?= CFG_OPTION ?>[imp_b2_opt4]" value="<?= esc_attr( $s['imp_b2_opt4'] ) ?>" placeholder="Label"/></div>
                    </div>
                </div>

                <div class="imp-q-block" style="margin-bottom:0;">
                    <div class="imp-q-label" style="color:#10b981;">B3 — Duration</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_b3_title]" value="<?= esc_attr( $s['imp_b3_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_b3_opt1]" value="<?= esc_attr( $s['imp_b3_opt1'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_b3_opt2]" value="<?= esc_attr( $s['imp_b3_opt2'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">3</span><input type="text" name="<?= CFG_OPTION ?>[imp_b3_opt3]" value="<?= esc_attr( $s['imp_b3_opt3'] ) ?>" placeholder="Label"/></div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Insurance Question -->
        <div class="imp-path-accordion">
            <div class="imp-path-header" onclick="impTogglePath(this)">
                <span class="imp-path-dot" style="background:#f59e0b;"></span>
                <span class="imp-path-title">Insurance Question</span>
                <span class="imp-path-count">optional &nbsp;·&nbsp; toggle above</span>
                <span class="imp-path-chevron">▼</span>
            </div>
            <div class="imp-path-body">

                <div class="imp-q-block" style="margin-bottom:0;">
                    <div class="imp-q-label" style="color:#f59e0b;">Question Title</div>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_ins_title]" value="<?= esc_attr( $s['imp_ins_title'] ) ?>" class="imp-q-title-input"/>
                    <div class="imp-opts-grid">
                        <div class="imp-opt-row"><span class="imp-opt-num">1</span><input type="text" name="<?= CFG_OPTION ?>[imp_ins_opt1]" value="<?= esc_attr( $s['imp_ins_opt1'] ) ?>" placeholder="Label"/></div>
                        <div class="imp-opt-row"><span class="imp-opt-num">2</span><input type="text" name="<?= CFG_OPTION ?>[imp_ins_opt2]" value="<?= esc_attr( $s['imp_ins_opt2'] ) ?>" placeholder="Label"/></div>
                    </div>
                </div>

            </div>
        </div>

        <!-- ════════════════════════════════════════════════════ -->
        <!--  4 · INTRO SCREEN                                    -->
        <!-- ════════════════════════════════════════════════════ -->
        <div class="imp-section-hdr" style="margin-top:28px;">
            <div class="imp-section-icon" style="background:#fff7ed;">🏠</div>
            <div>
                <h3>Intro Screen</h3>
                <p>The first thing patients see before they start the estimator</p>
            </div>
        </div>

        <div class="cfg-card-section">
            <div class="cfg-grid">
                <div class="cfg-field cfg-full">
                    <label>Badge / Tag Text <span style="font-weight:400;color:#9ca3af;">— small pill above the heading</span></label>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_intro_title]" value="<?= esc_attr( $s['imp_intro_title'] ) ?>"/>
                </div>
                <div class="cfg-field cfg-full">
                    <label>Main Heading</label>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_intro_heading]" value="<?= esc_attr( $s['imp_intro_heading'] ) ?>"/>
                </div>
                <div class="cfg-field cfg-full">
                    <label>Subtitle Paragraph</label>
                    <textarea name="<?= CFG_OPTION ?>[imp_intro_subtitle]"><?= esc_textarea( $s['imp_intro_subtitle'] ) ?></textarea>
                </div>
                <div class="cfg-field cfg-full">
                    <label>Bullet Points <span style="font-weight:400;color:#9ca3af;">— one per line</span></label>
                    <textarea name="<?= CFG_OPTION ?>[imp_intro_bullets]"><?= esc_textarea( $s['imp_intro_bullets'] ) ?></textarea>
                </div>
                <div class="cfg-field">
                    <label>Button Text</label>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_intro_btn]" value="<?= esc_attr( $s['imp_intro_btn'] ) ?>"/>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════ -->
        <!--  5 · RESULTS SCREEN                                  -->
        <!-- ════════════════════════════════════════════════════ -->
        <div class="imp-section-hdr" style="margin-top:28px;">
            <div class="imp-section-icon" style="background:#f0fdf4;">📊</div>
            <div>
                <h3>Results Screen</h3>
                <p>What the patient sees after completing the quiz</p>
            </div>
        </div>

        <!-- Price shown -->
        <div id="imp-price-rows" style="display:<?= $s['imp_show_price'] === '1' ? 'block' : 'none' ?>;">
            <div class="cfg-card-section">
                <h4 style="display:flex;align-items:center;gap:8px;"><span style="background:#dcfce7;color:#166534;padding:2px 8px;border-radius:12px;font-size:11px;font-weight:700;">PRICE SHOWN</span> Results Screen</h4>
                <div class="cfg-grid">
                    <div class="cfg-field"><label>Title <span style="font-weight:400;color:#9ca3af;">— small label above price</span></label><input type="text" name="<?= CFG_OPTION ?>[imp_result_title]" value="<?= esc_attr( $s['imp_result_title'] ) ?>"/></div>
                    <div class="cfg-field cfg-full"><label>Subtitle <span style="font-weight:400;color:#9ca3af;">— shown below title, above price</span></label><textarea name="<?= CFG_OPTION ?>[imp_result_subtitle]"><?= esc_textarea( $s['imp_result_subtitle'] ) ?></textarea></div>
                    <div class="cfg-field cfg-full"><label>Financing Note <span class="cfg-badge">shown only when financing toggle is on</span></label><input type="text" name="<?= CFG_OPTION ?>[imp_financing_text]" value="<?= esc_attr( $s['imp_financing_text'] ) ?>"/></div>
                </div>
            </div>
            <div class="cfg-card-section">
                <h4>Price Suffix by Path</h4>
                <div class="imp-result-suffix-grid">
                    <div class="cfg-field"><div class="imp-q-label" style="color:#3b82f6;">Single Tooth</div><input type="text" name="<?= CFG_OPTION ?>[imp_result_single_suffix]" value="<?= esc_attr( $s['imp_result_single_suffix'] ) ?>"/></div>
                    <div class="cfg-field"><div class="imp-q-label" style="color:#8b5cf6;">Multiple Teeth</div><input type="text" name="<?= CFG_OPTION ?>[imp_result_multiple_suffix]" value="<?= esc_attr( $s['imp_result_multiple_suffix'] ) ?>"/></div>
                    <div class="cfg-field"><div class="imp-q-label" style="color:#10b981;">Full Arch</div><input type="text" name="<?= CFG_OPTION ?>[imp_result_fullarch_suffix]" value="<?= esc_attr( $s['imp_result_fullarch_suffix'] ) ?>"/></div>
                </div>
            </div>
        </div>

        <!-- Price hidden -->
        <div id="imp-noprice-rows" style="display:<?= $s['imp_show_price'] === '1' ? 'none' : 'block' ?>;">
            <div class="cfg-card-section" style="border-left:3px solid #2271b1;">
                <h4 style="display:flex;align-items:center;gap:8px;"><span style="background:#dbeafe;color:#1e40af;padding:2px 8px;border-radius:12px;font-size:11px;font-weight:700;">PRICE HIDDEN</span> Results Screen</h4>
                <p class="cfg-desc" style="margin:0 0 12px;">Shown instead of the price — encourage the patient to book.</p>
                <div class="cfg-grid">
                    <div class="cfg-field cfg-full"><label>Heading</label><input type="text" name="<?= CFG_OPTION ?>[imp_no_price_title]" value="<?= esc_attr( $s['imp_no_price_title'] ) ?>"/></div>
                    <div class="cfg-field cfg-full"><label>Body Text</label><textarea name="<?= CFG_OPTION ?>[imp_no_price_subtitle]" rows="3"><?= esc_textarea( $s['imp_no_price_subtitle'] ) ?></textarea></div>
                    <div class="cfg-field"><label>Button Text</label><input type="text" name="<?= CFG_OPTION ?>[imp_no_price_btn]" value="<?= esc_attr( $s['imp_no_price_btn'] ) ?>"/></div>
                </div>
                <p class="cfg-desc" style="margin-top:8px;">Button links to the Success Redirect URL set above.</p>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════ -->
        <!--  6 · CONTACT FORM STEP                               -->
        <!-- ════════════════════════════════════════════════════ -->
        <div class="imp-section-hdr" style="margin-top:28px;">
            <div class="imp-section-icon" style="background:#fef3c7;">📬</div>
            <div>
                <h3>Contact Form Step</h3>
                <p>The lead capture screen shown after the patient sees their estimate</p>
            </div>
        </div>

        <div class="cfg-card-section">
            <div class="cfg-grid">
                <div class="cfg-field"><label>Title</label><input type="text" name="<?= CFG_OPTION ?>[imp_contact_title]" value="<?= esc_attr( $s['imp_contact_title'] ) ?>"/></div>
                <div class="cfg-field cfg-full"><label>Subtitle</label><textarea name="<?= CFG_OPTION ?>[imp_contact_subtitle]"><?= esc_textarea( $s['imp_contact_subtitle'] ) ?></textarea></div>
                <div class="cfg-field"><label>Submit Button Text</label><input type="text" name="<?= CFG_OPTION ?>[imp_contact_btn]" value="<?= esc_attr( $s['imp_contact_btn'] ) ?>"/></div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════ -->
        <!--  7 · DISCLAIMER                                      -->
        <!-- ════════════════════════════════════════════════════ -->
        <div class="imp-section-hdr" style="margin-top:28px;">
            <div class="imp-section-icon" style="background:#fef2f2;">⚠️</div>
            <div>
                <h3>Disclaimer</h3>
                <p>Shown in small text below the estimate on the results screen</p>
            </div>
        </div>

        <div class="cfg-card-section">
            <div class="cfg-field cfg-full">
                <textarea name="<?= CFG_OPTION ?>[imp_disclaimer]"><?= esc_textarea( $s['imp_disclaimer'] ) ?></textarea>
                <span class="cfg-desc">Protects against patients holding you to the estimate price.</span>
            </div>
        </div>

        <script>
        function impTogglePath(hdr) {
            hdr.classList.toggle('open');
            var body = hdr.nextElementSibling;
            body.classList.toggle('open');
        }
        </script>

    </div>

    <!-- ═══ SETUP GUIDE TAB ═══ -->
    <div id="cfg-guide" class="cfg-panel">

        <style>
        .cfg-guide-step{display:flex;gap:16px;align-items:flex-start;padding:18px 0;border-bottom:1px solid #f0f0f1;}
        .cfg-guide-step:last-child{border-bottom:none;}
        .cfg-guide-num{flex-shrink:0;width:32px;height:32px;border-radius:50%;background:#2271b1;color:#fff;font-weight:700;font-size:14px;display:flex;align-items:center;justify-content:center;}
        .cfg-guide-body h3{margin:0 0 6px;font-size:14px;font-weight:700;color:#1d2327;}
        .cfg-guide-body p{margin:0 0 8px;font-size:13px;color:#3c434a;line-height:1.6;}
        .cfg-guide-body ul{margin:6px 0 0 18px;padding:0;font-size:13px;color:#3c434a;line-height:1.7;}
        .cfg-guide-code{display:inline-block;background:#f0f0f0;border:1px solid #ddd;border-radius:3px;padding:1px 6px;font-family:monospace;font-size:12px;color:#1d2327;}
        .cfg-guide-section{font-size:15px;font-weight:700;margin:28px 0 4px;padding-bottom:8px;border-bottom:2px solid #2271b1;color:#1d2327;}
        .cfg-guide-section:first-of-type{margin-top:0;}
        .cfg-guide-tip{background:#fff8e1;border-left:4px solid #f0b429;padding:10px 14px;font-size:13px;color:#3c434a;border-radius:0 4px 4px 0;margin-top:8px;}
        </style>

        <p class="cfg-desc" style="margin-bottom:20px;">Follow these steps to connect the plugin to GoHighLevel and make sure every form submission lands in your CRM correctly.</p>

        <!-- ══ SECTION 1 — GHL API ══ -->
        <div class="cfg-guide-section">Step 1 — Connect to GoHighLevel</div>

        <div class="cfg-guide-step">
            <div class="cfg-guide-num">1</div>
            <div class="cfg-guide-body">
                <h3>Create a Private Integration API Key</h3>
                <p>In GHL go to <strong>Settings → Integrations → Private Integrations</strong> and click <strong>+ Add Integration</strong>. Give it any name (e.g. <em>WordPress Contact Form</em>), select <strong>Location level</strong>, and grant at minimum:</p>
                <ul>
                    <li>Contacts — Read &amp; Write</li>
                    <li>Conversations — Read &amp; Write (optional, for notes)</li>
                </ul>
                <p>Copy the generated <strong>Bearer Token</strong> and paste it into the <em>API Key / Bearer Token</em> field on the <strong>⚡ GHL + Security</strong> tab.</p>
            </div>
        </div>

        <div class="cfg-guide-step">
            <div class="cfg-guide-num">2</div>
            <div class="cfg-guide-body">
                <h3>Find Your Location ID</h3>
                <p>In GHL go to <strong>Settings → Business Profile</strong>. Scroll down to find the <strong>Location ID</strong> string (e.g. <code class="cfg-guide-code">AbCdEfGhIj123456</code>). Paste it into the <em>Location ID</em> field on the <strong>⚡ GHL + Security</strong> tab.</p>
            </div>
        </div>

        <!-- ══ SECTION 2 — Custom Fields ══ -->
        <div class="cfg-guide-section">Step 2 — Create Custom Fields in GHL</div>

        <p class="cfg-desc" style="margin-bottom:16px;">Go to <strong>Settings → Custom Fields → Contacts</strong> and create all the fields below. Every field type is <strong>Text</strong> unless noted. The <em>Key</em> column is what matters — it must match exactly.</p>

        <style>
        .cfg-cft{width:100%;border-collapse:collapse;font-size:12.5px;margin-bottom:20px;}
        .cfg-cft th{background:#f0f6fc;padding:8px 12px;text-align:left;border:1px solid #dde3e9;font-weight:700;color:#1d2327;}
        .cfg-cft td{padding:7px 12px;border:1px solid #e5e5e5;color:#3c434a;vertical-align:top;}
        .cfg-cft tr:nth-child(even) td{background:#fafafa;}
        .cfg-cft .req{color:#b32d2e;font-weight:700;}
        .cfg-cft .opt{color:#646970;}
        </style>

        <p style="font-size:13px;font-weight:700;color:#1d2327;margin:12px 0 6px;">All Forms — Required</p>
        <table class="cfg-cft">
            <tr><th>Key</th><th>Label (suggestion)</th><th>Sent by</th></tr>
            <tr><td><code class="cfg-guide-code">utm_campaign</code></td><td>UTM Campaign</td><td>All 3 forms</td></tr>
            <tr><td><code class="cfg-guide-code">utm_medium</code></td><td>UTM Medium</td><td>All 3 forms</td></tr>
            <tr><td><code class="cfg-guide-code">utm_content</code></td><td>UTM Content</td><td>All 3 forms</td></tr>
            <tr><td><code class="cfg-guide-code">utm_keyword</code></td><td>UTM Keyword</td><td>All 3 forms</td></tr>
            <tr><td><code class="cfg-guide-code">gclid</code></td><td>Google Click ID</td><td>All 3 forms</td></tr>
        </table>

        <p style="font-size:13px;font-weight:700;color:#1d2327;margin:12px 0 6px;">Contact Form</p>
        <table class="cfg-cft">
            <tr><th>Key</th><th>Label (suggestion)</th><th>Notes</th></tr>
            <tr><td><code class="cfg-guide-code">treatment_type</code></td><td>Treatment Type</td><td>Treatment selected from dropdown</td></tr>
        </table>

        <p style="font-size:13px;font-weight:700;color:#1d2327;margin:12px 0 6px;">Implant Estimator</p>
        <table class="cfg-cft">
            <tr><th>Key</th><th>Label (suggestion)</th><th>Example value</th></tr>
            <tr><td><code class="cfg-guide-code">situation</code></td><td>Implant Situation</td><td><em>q1_0</em> (internal key)</td></tr>
            <tr><td><code class="cfg-guide-code">situation_label</code></td><td>Implant Situation (label)</td><td><em>I'm missing a tooth</em></td></tr>
            <tr><td><code class="cfg-guide-code">teeth</code></td><td>Teeth Count Tier</td><td><em>single</em>, <em>multi</em>, or <em>arch</em></td></tr>
            <tr><td><code class="cfg-guide-code">teeth_label</code></td><td>Teeth Count (label)</td><td><em>Just one tooth</em></td></tr>
            <tr><td><code class="cfg-guide-code">bone_graft</code></td><td>Bone Graft</td><td><em>yes</em>, <em>notsure</em>, or <em>no</em></td></tr>
            <tr><td><code class="cfg-guide-code">bone_graft_label</code></td><td>Bone Graft (label)</td><td><em>Not sure</em></td></tr>
            <tr><td><code class="cfg-guide-code">insurance</code></td><td>Has Insurance</td><td><em>yes</em> or <em>no</em> (if Q4 is enabled)</td></tr>
            <tr><td><code class="cfg-guide-code">insurance_label</code></td><td>Insurance (label)</td><td><em>Yes, I have coverage</em></td></tr>
            <tr><td><code class="cfg-guide-code">range</code></td><td>Estimated Price Range</td><td><em>$3,000 – $6,000</em></td></tr>
        </table>

        <p style="font-size:13px;font-weight:700;color:#1d2327;margin:12px 0 6px;">Aligner Quiz</p>
        <table class="cfg-cft">
            <tr><th>Key</th><th>Notes</th></tr>
            <tr><td colspan="2" style="color:#646970;font-style:italic;">Keys are generated automatically from your quiz step IDs. Each answer is sent as its own custom field using the step key you configure in the Aligner Form tab.</td></tr>
        </table>

        <div class="cfg-guide-tip" style="margin-top:4px;">
            <strong>Tip:</strong> Only non-empty fields are sent. If a patient skips the insurance question (or it is turned off), the <code class="cfg-guide-code">insurance</code> field simply won't appear on the contact.
        </div>

        <!-- ══ SECTION 3 — Tags & Workflows ══ -->
        <div class="cfg-guide-section">Step 3 — Tags &amp; Workflow Triggers</div>

        <div class="cfg-guide-step">
            <div class="cfg-guide-num">3</div>
            <div class="cfg-guide-body">
                <h3>Understand the Tags Each Form Sends</h3>
                <p>Every submission automatically applies tags to the GHL contact. Use these tags as workflow triggers:</p>
                <ul>
                    <li><strong>Contact Form:</strong> <code class="cfg-guide-code">website-contact-form</code></li>
                    <li><strong>Implant Estimator:</strong> <code class="cfg-guide-code">implant-estimator</code>, <code class="cfg-guide-code">website-lead</code></li>
                    <li><strong>Aligner Quiz:</strong> <code class="cfg-guide-code">aligner-quiz</code>, <code class="cfg-guide-code">website-lead</code></li>
                </ul>
                <p>The implant and aligner forms also add answer-specific tags like <code class="cfg-guide-code">teeth-single</code>, <code class="cfg-guide-code">bone_graft-yes</code> etc. — useful for segmenting automations.</p>
            </div>
        </div>

        <div class="cfg-guide-step">
            <div class="cfg-guide-num">4</div>
            <div class="cfg-guide-body">
                <h3>Create Workflows Triggered by Tags</h3>
                <p>In GHL go to <strong>Automation → Workflows → + New Workflow</strong>. Set the trigger to <strong>Contact Tag</strong> and enter the tag to listen for. Recommended workflows to create:</p>
                <ul>
                    <li><strong>Tag: <code class="cfg-guide-code">website-contact-form</code></strong> → Send confirmation SMS/email, assign to pipeline stage <em>New Lead</em></li>
                    <li><strong>Tag: <code class="cfg-guide-code">implant-estimator</code></strong> → Send personalised implant follow-up with price range, book consultation</li>
                    <li><strong>Tag: <code class="cfg-guide-code">aligner-quiz</code></strong> → Send aligner offer email sequence</li>
                    <li><strong>Tag: <code class="cfg-guide-code">website-lead</code></strong> → General lead nurture sequence (fires for both implant and aligner)</li>
                </ul>
                <div class="cfg-guide-tip">
                    <strong>Tip:</strong> Use <em>Contact Tag Added</em> as the trigger type (not <em>Contact Created</em>) so the workflow fires even if the contact already exists in GHL.
                </div>
            </div>
        </div>

        <div class="cfg-guide-step">
            <div class="cfg-guide-num">5</div>
            <div class="cfg-guide-body">
                <h3>Add Contacts to a Pipeline</h3>
                <p>Inside each workflow, add a <strong>Add to Pipeline</strong> action to move the contact into your sales pipeline at the appropriate stage. Suggested setup:</p>
                <ul>
                    <li>Pipeline: <em>New Leads</em> (or your main dental pipeline)</li>
                    <li>Stage: <em>New Lead</em> → moves to <em>Consultation Booked</em> when they book</li>
                </ul>
            </div>
        </div>

        <!-- ══ SECTION 4 — Test ══ -->
        <div class="cfg-guide-section">Step 4 — Test &amp; Verify</div>

        <div class="cfg-guide-step">
            <div class="cfg-guide-num">6</div>
            <div class="cfg-guide-body">
                <h3>Submit a Test Lead</h3>
                <p>Open a form page on your site and append UTM parameters to the URL to test tracking, e.g.:</p>
                <p><code class="cfg-guide-code">/contact-form?utm_campaign=test&amp;utm_medium=cpc&amp;gclid=abc123</code></p>
                <p>Submit the form and then check in GHL <strong>Contacts</strong> that:</p>
                <ul>
                    <li>Contact was created with correct name/email/phone</li>
                    <li>Tags were applied (<code class="cfg-guide-code">website-contact-form</code> etc.)</li>
                    <li>Custom fields show the UTM values</li>
                    <li>Workflow was triggered (check the contact's workflow history)</li>
                </ul>
            </div>
        </div>

    </div>

    <?php submit_button( 'Save All Settings', 'primary large' ); ?>
    </form>
    </div>

    <script>
    /* ── Tab navigation ── */
    function cfgTab(el, id) {
        document.querySelectorAll('.cfg-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.cfg-panel').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('cfg-' + id).classList.add('active');
    }
    function syncColor(textId, val) {
        var el = document.getElementById(textId); if (el) el.value = val;
    }
    function syncPicker(pickerId, val) {
        if (/^#[0-9a-f]{6}$/i.test(val)) { var el = document.getElementById(pickerId); if (el) el.value = val; }
    }

    </script>
    <?php
}

// ═══════════════════════════════════════════════════════════════
//  SHARED HELPERS
// ═══════════════════════════════════════════════════════════════
function cfg_font_setup( $s ) {
    $stacks = [
        'system'     => "-apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif",
        'inter'      => "'Inter', sans-serif",
        'roboto'     => "'Roboto', sans-serif",
        'open-sans'  => "'Open Sans', sans-serif",
        'lato'       => "'Lato', sans-serif",
        'poppins'    => "'Poppins', sans-serif",
        'montserrat' => "'Montserrat', sans-serif",
    ];
    $urls = [
        'inter'      => 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap',
        'roboto'     => 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap',
        'open-sans'  => 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&display=swap',
        'lato'       => 'https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap',
        'poppins'    => 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap',
        'montserrat' => 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap',
    ];
    if ( $s['font_family'] === 'custom' ) {
        return [
            'stack' => ! empty( $s['custom_font_name'] ) ? "'{$s['custom_font_name']}', sans-serif" : 'sans-serif',
            'url'   => ! empty( $s['custom_font_url'] ) ? esc_url( $s['custom_font_url'] ) : '',
        ];
    }
    return [
        'stack' => $stacks[ $s['font_family'] ] ?? $stacks['system'],
        'url'   => $urls[ $s['font_family'] ] ?? '',
    ];
}

// SVG icon helper
function cfg_icon( $name, $size = 24 ) {
    $icons = [
        'phone'   => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'message' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
        'mail'    => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
        'map'     => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
        'clock'   => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'arrow'   => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
        'instagram' => '<rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>',
        'facebook'  => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
        'tiktok'    => '<path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/>',
        'youtube'   => '<path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><polygon points="10 15 15 12 10 9 10 15"/>',
        'x'         => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
    ];
    $path = $icons[ $name ] ?? $icons['message'];
    return '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>';
}

function cfg_recaptcha_script( $site_key ) {
    if ( empty( $site_key ) ) return '';
    return '<script src="https://www.google.com/recaptcha/api.js?render=' . esc_attr( $site_key ) . '"></script>';
}

// ═══════════════════════════════════════════════════════════════
//  SHORTCODE: [contact_form_ghl]
// ═══════════════════════════════════════════════════════════════
add_shortcode( 'contact_form_ghl', 'cfg_shortcode' );

function cfg_shortcode( $atts = [], $embed = false ) {
    $s    = cfg_get();
    if ( $embed ) $s['show_hero'] = '0';
    $font = cfg_font_setup( $s );

    $cr  = absint( $s['card_radius'] )  . 'px';
    $ir  = absint( $s['input_radius'] ) . 'px';
    $pri = esc_attr( $s['primary_color'] );
    $bg  = esc_attr( $s['bg_color'] );
    $tc  = esc_attr( $s['text_color'] );
    $mc  = esc_attr( $s['muted_color'] );
    $bc  = esc_attr( $s['border_color'] );
    $bw  = esc_attr( $s['font_weight_bold'] );
    $nw  = esc_attr( $s['font_weight_normal'] );

    $card_style  = "background:{$bg};border-radius:{$cr};padding:2rem 2.5rem;box-sizing:border-box;";
    if ( $s['card_border'] === '1' ) $card_style .= "border:1px solid {$bc};";
    if ( $s['card_shadow'] === '1' ) $card_style .= "box-shadow:0 4px 24px rgba(0,0,0,0.08);";

    $input_style = "width:100%;padding:0.75rem 1rem;border:1px solid {$bc};border-radius:{$ir};font-size:0.875rem;background:{$bg};color:{$tc};box-sizing:border-box;font-family:inherit;";
    $label_style = "display:block;margin-bottom:0.5rem;font-weight:{$bw};color:{$tc};font-size:0.875rem;";

    $treatments = array_filter( array_map( 'trim', explode( "\n", $s['treatment_options'] ) ) );
    $nonce      = wp_create_nonce( 'cfg_submit' );

    ob_start();
    if ( $font['url'] ) echo '<link rel="stylesheet" href="' . esc_url( $font['url'] ) . '"/>';
    echo cfg_recaptcha_script( $s['spam_recaptcha_site'] );
    ?>
    <style>
    #cfg-wrap *{box-sizing:border-box;}
    #cfg-wrap input:focus,#cfg-wrap select:focus{outline:none;box-shadow:0 0 0 3px <?= $pri ?>33;border-color:<?= $pri ?> !important;}
    #cfg-wrap button[type=submit]:hover{<?= $s['btn_hover_bg_color'] ? 'background:' . esc_attr( $s['btn_hover_bg_color'] ) . '!important;' . ( $s['btn_hover_text_color'] ? 'color:' . esc_attr( $s['btn_hover_text_color'] ) . '!important;' : '' ) : 'filter:brightness(1.1);' ?>}
    #cfg-wrap button[type=submit]:disabled{opacity:0.65;cursor:not-allowed;}
    @media(max-width:600px){.cfg-row2{grid-template-columns:1fr !important;}#cfg-wrap .cfg-card{padding:1.25rem !important;}}
    </style>

    <div id="cfg-wrap" style="font-family:<?= esc_attr( $font['stack'] ) ?>;color:<?= $tc ?>;font-weight:<?= $nw ?>;line-height:1.6;">

    <?php if ( $s['show_hero'] === '1' ): ?>
    <section style="background:<?= esc_attr( $s['hero_bg_color'] ) ?>;padding:6rem 1.5rem 3.5rem;text-align:center;">
        <div style="max-width:800px;margin:0 auto;">
            <?php if ( $s['hero_eyebrow'] ): ?><p style="margin:0 0 1rem;font-weight:<?= $bw ?>;color:<?= $mc ?>;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.1em;"><?= esc_html( $s['hero_eyebrow'] ) ?></p><?php endif; ?>
            <?php if ( $s['hero_heading'] ): ?><h1 style="margin:0 0 1.25rem;font-size:clamp(1.75rem,5vw,3rem);font-weight:<?= $bw ?>;line-height:1.15;color:<?= $tc ?>;"><?= esc_html( $s['hero_heading'] ) ?></h1><?php endif; ?>
            <?php if ( $s['hero_subheading'] ): ?><p style="max-width:42rem;margin:0 auto;font-size:1.1rem;color:<?= $mc ?>;"><?= esc_html( $s['hero_subheading'] ) ?></p><?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <section style="padding:<?= $s['show_hero'] === '1' ? '3.5rem' : '6rem' ?> 1.5rem 3.5rem;">
        <div style="max-width:660px;margin:0 auto;">
            <div class="cfg-card" style="<?= $card_style ?>">
                <form id="cfg-form" novalidate>
                    <input type="hidden" id="cfg_nonce" value="<?= esc_attr( $nonce ) ?>"/>
                    <?php if ( $s['spam_honeypot'] === '1' ): ?>
                    <div style="display:none!important;visibility:hidden!important;position:absolute!important;left:-9999px!important;" aria-hidden="true">
                        <input type="text" name="cfg_hp_website" tabindex="-1" autocomplete="off" value=""/>
                    </div>
                    <?php endif; ?>
                    <?php if ( ! empty( $s['spam_recaptcha_site'] ) ): ?>
                    <input type="hidden" id="cfg_recaptcha_token" name="cfg_recaptcha_token" value=""/>
                    <?php endif; ?>

                    <div class="cfg-row2" style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
                        <div>
                            <label for="cfg_firstName" style="<?= $label_style ?>">First Name <?php if ( $s['req_first_name'] === '1' ): ?><span style="color:<?= $pri ?>">*</span><?php endif; ?></label>
                            <input id="cfg_firstName" name="firstName" type="text" <?= $s['req_first_name'] === '1' ? 'required' : '' ?> placeholder="Jane" style="<?= $input_style ?>"/>
                        </div>
                        <div>
                            <label for="cfg_lastName" style="<?= $label_style ?>">Last Name <?php if ( $s['req_last_name'] === '1' ): ?><span style="color:<?= $pri ?>">*</span><?php endif; ?></label>
                            <input id="cfg_lastName" name="lastName" type="text" <?= $s['req_last_name'] === '1' ? 'required' : '' ?> placeholder="Smith" style="<?= $input_style ?>"/>
                        </div>
                    </div>
                    <div class="cfg-row2" style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
                        <div>
                            <label for="cfg_email" style="<?= $label_style ?>">Email <?php if ( $s['req_email'] === '1' ): ?><span style="color:<?= $pri ?>">*</span><?php endif; ?></label>
                            <input id="cfg_email" name="email" type="email" <?= $s['req_email'] === '1' ? 'required' : '' ?> placeholder="jane@example.com" style="<?= $input_style ?>"/>
                        </div>
                        <div>
                            <label for="cfg_phone" style="<?= $label_style ?>">Phone <?php if ( $s['req_phone'] === '1' ): ?><span style="color:<?= $pri ?>">*</span><?php endif; ?></label>
                            <input id="cfg_phone" name="phone" type="tel" <?= $s['req_phone'] === '1' ? 'required' : '' ?> placeholder="(555) 123-4567" style="<?= $input_style ?>"/>
                        </div>
                    </div>

                    <?php if ( $s['show_treatment'] === '1' ): ?>
                    <div style="margin-bottom:1.25rem;">
                        <label for="cfg_treatment" style="<?= $label_style ?>">Treatment Type <?php if ( $s['req_treatment'] === '1' ): ?><span style="color:<?= $pri ?>">*</span><?php endif; ?></label>
                        <select id="cfg_treatment" name="treatment" <?= $s['req_treatment'] === '1' ? 'required' : '' ?> style="<?= $input_style ?>appearance:none;">
                            <option value="" disabled selected>Select a treatment…</option>
                            <?php foreach ( $treatments as $opt ): ?><option value="<?= esc_attr( $opt ) ?>"><?= esc_html( $opt ) ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <div id="cfg-error"   style="display:none;padding:0.75rem 1rem;background:#fef2f2;border:1px solid #fecaca;border-radius:<?= $ir ?>;color:#b91c1c;font-size:0.875rem;margin-bottom:1rem;"></div>
                    <div id="cfg-success" style="display:none;padding:0.75rem 1rem;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:<?= $ir ?>;color:#15803d;font-size:0.875rem;margin-bottom:1rem;"><?= esc_html( $s['success_msg'] ) ?></div>

                    <div style="display:flex;flex-direction:column;gap:0.875rem;">
                        <button type="submit" id="cfg-submit-btn" style="width:100%;padding:0.875rem 1.5rem;background:<?= $pri ?>;color:#fff;border:none;border-radius:<?= $ir ?>;font-size:0.9rem;font-weight:<?= $bw ?>;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;font-family:inherit;transition:filter 0.15s;">
                            <?= cfg_icon( 'message', 16 ) ?>
                            <span id="cfg-submit-label"><?= esc_html( $s['btn_text'] ) ?></span>
                        </button>
                        <?php if ( $s['show_terms'] === '1' ): ?>
                        <label style="display:flex;align-items:flex-start;gap:0.75rem;cursor:pointer;">
                            <input id="cfg_terms" name="terms" type="checkbox" required style="margin-top:3px;width:1rem;height:1rem;flex-shrink:0;accent-color:<?= $pri ?>;"/>
                            <span style="color:<?= $mc ?>;font-size:0.75rem;line-height:1.6;"><?= esc_html( $s['terms_text'] ) ?></span>
                        </label>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <?php if ( $s['show_back_link'] === '1' && $s['back_link_url'] ): ?>
            <div style="margin-top:1.75rem;text-align:center;">
                <a href="<?= esc_url( $s['back_link_url'] ) ?>" style="color:<?= $mc ?>;font-size:0.875rem;text-decoration:none;" onmouseover="this.style.color='<?= $pri ?>'" onmouseout="this.style.color='<?= $mc ?>'"><?= esc_html( $s['back_link_text'] ) ?></a>
            </div>
            <?php endif; ?>
        </div>
    </section>
    </div>

    <script>
    (function(){
        var AJAX      = <?= wp_json_encode( admin_url( 'admin-ajax.php' ) ) ?>;
        var NONCE     = document.getElementById('cfg_nonce').value;
        var PHONE     = <?= wp_json_encode( $s['phone_number'] ) ?>;
        var BTN_TXT   = <?= wp_json_encode( $s['btn_text'] ) ?>;
        var REDIRECT  = <?= wp_json_encode( $s['success_redirect_url'] ) ?>;
        var HAS_TERMS = <?= $s['show_terms'] === '1' ? 'true' : 'false' ?>;
        var RC_KEY    = <?= wp_json_encode( $s['spam_recaptcha_site'] ) ?>;

        var form   = document.getElementById('cfg-form');
        var btn    = document.getElementById('cfg-submit-btn');
        var lbl    = document.getElementById('cfg-submit-label');
        var errBox = document.getElementById('cfg-error');
        var okBox  = document.getElementById('cfg-success');

        function showErr(msg){ errBox.textContent=msg; errBox.style.display='block'; okBox.style.display='none'; }
        function hideErr(){ errBox.style.display='none'; }

        var _up = new URLSearchParams(window.location.search);
        function doSubmit(token) {
            if (RC_KEY) {
                var tf = document.getElementById('cfg_recaptcha_token');
                if (tf) tf.value = token || '';
            }
            var hp = form.querySelector('[name="cfg_hp_website"]');
            var payload = {
                action:       'cfg_submit',
                cfg_nonce:    NONCE,
                cfg_hp:       hp ? hp.value : '',
                cfg_rc:       (RC_KEY && document.getElementById('cfg_recaptcha_token')) ? document.getElementById('cfg_recaptcha_token').value : '',
                firstName:    (form.querySelector('[name="firstName"]') || {}).value || '',
                lastName:     (form.querySelector('[name="lastName"]')  || {}).value || '',
                email:        (form.querySelector('[name="email"]')     || {}).value || '',
                phone:        (form.querySelector('[name="phone"]')     || {}).value || '',
                treatment:    (form.querySelector('[name="treatment"]') || {value:''}).value || '',
                utm_campaign: _up.get('utm_campaign') || '',
                utm_medium:   _up.get('utm_medium')   || '',
                utm_content:  _up.get('utm_content')  || '',
                utm_keyword:  _up.get('utm_keyword')  || '',
                gclid:        _up.get('gclid')        || ''
            };
            btn.disabled = true; lbl.textContent = 'Sending\u2026';
            fetch(AJAX, {
                method:  'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body:    Object.keys(payload).map(k=>encodeURIComponent(k)+'='+encodeURIComponent(payload[k])).join('&')
            })
            .then(function(r){ return r.json(); })
            .then(function(d){
                btn.disabled=false; lbl.textContent=BTN_TXT;
                if (d.success) {
                    if (REDIRECT) { window.location.href = REDIRECT; }
                    else { form.reset(); okBox.style.display='block'; }
                } else { showErr(d.data||'Submission failed. Please try again.'); }
            })
            .catch(function(){ btn.disabled=false; lbl.textContent=BTN_TXT; showErr('Something went wrong. Please call us at '+PHONE+'.'); });
        }

        form.addEventListener('submit', function(e){
            e.preventDefault(); hideErr();
            if (HAS_TERMS) {
                var terms = form.querySelector('[name="terms"]');
                if (!terms||!terms.checked){ showErr('Please agree to the terms before submitting.'); return; }
            }
            if (RC_KEY && typeof grecaptcha !== 'undefined') {
                grecaptcha.ready(function(){ grecaptcha.execute(RC_KEY,{action:'submit'}).then(doSubmit); });
            } else { doSubmit(''); }
        });
    })();
    </script>
    <?php
    return ob_get_clean();
}

// ═══════════════════════════════════════════════════════════════
//  SHORTCODE: [contact_form_embed] — form card only, no hero/wrapper
// ═══════════════════════════════════════════════════════════════
add_shortcode( 'contact_form_embed', 'cfg_embed_shortcode' );

function cfg_embed_shortcode() {
    return cfg_shortcode( [], true );
}

function cfg_embed_shortcode_OLD_UNUSED() {
    $s    = cfg_get();
    $font = cfg_font_setup( $s );

    $cr  = absint( $s['card_radius'] )  . 'px';
    $ir  = absint( $s['input_radius'] ) . 'px';
    $pri = esc_attr( $s['primary_color'] );
    $bg  = esc_attr( $s['bg_color'] );
    $tc  = esc_attr( $s['text_color'] );
    $mc  = esc_attr( $s['muted_color'] );
    $bc  = esc_attr( $s['border_color'] );
    $bw  = esc_attr( $s['font_weight_bold'] );
    $nw  = esc_attr( $s['font_weight_normal'] );

    $card_style  = "background:{$bg};border-radius:{$cr};padding:2rem 2.5rem;box-sizing:border-box;";
    if ( $s['card_border'] === '1' ) $card_style .= "border:1px solid {$bc};";
    if ( $s['card_shadow'] === '1' ) $card_style .= "box-shadow:0 4px 24px rgba(0,0,0,0.08);";

    $input_style = "width:100%;padding:0.75rem 1rem;border:1px solid {$bc};border-radius:{$ir};font-size:0.875rem;background:{$bg};color:{$tc};box-sizing:border-box;font-family:inherit;";
    $label_style = "display:block;margin-bottom:0.5rem;font-weight:{$bw};color:{$tc};font-size:0.875rem;";

    $treatments = array_filter( array_map( 'trim', explode( "\n", $s['treatment_options'] ) ) );
    $nonce      = wp_create_nonce( 'cfg_submit' );

    ob_start();
    if ( $font['url'] ) echo '<link rel="stylesheet" href="' . esc_url( $font['url'] ) . '"/>';
    echo cfg_recaptcha_script( $s['spam_recaptcha_site'] );
    ?>
    <style>
    #cfge-wrap *{box-sizing:border-box;}
    #cfge-wrap input:focus,#cfge-wrap select:focus{outline:none;box-shadow:0 0 0 3px <?= $pri ?>33;border-color:<?= $pri ?> !important;}
    #cfge-wrap button[type=submit]:hover{<?= $s['btn_hover_bg_color'] ? 'background:' . esc_attr( $s['btn_hover_bg_color'] ) . '!important;' . ( $s['btn_hover_text_color'] ? 'color:' . esc_attr( $s['btn_hover_text_color'] ) . '!important;' : '' ) : 'filter:brightness(1.1);' ?>}
    #cfge-wrap button[type=submit]:disabled{opacity:0.65;cursor:not-allowed;}
    @media(max-width:600px){.cfge-row2{grid-template-columns:1fr !important;}#cfge-wrap .cfge-card{padding:1.25rem !important;}}
    </style>

    <div id="cfge-wrap" style="font-family:<?= esc_attr( $font['stack'] ) ?>;color:<?= $tc ?>;font-weight:<?= $nw ?>;line-height:1.6;">
        <div class="cfge-card" style="<?= $card_style ?>">
            <form id="cfge-form" novalidate>
                <input type="hidden" id="cfge_nonce" value="<?= esc_attr( $nonce ) ?>"/>
                <?php if ( $s['spam_honeypot'] === '1' ): ?>
                <div style="display:none!important;visibility:hidden!important;position:absolute!important;left:-9999px!important;" aria-hidden="true">
                    <input type="text" name="cfg_hp_website" tabindex="-1" autocomplete="off" value=""/>
                </div>
                <?php endif; ?>
                <?php if ( ! empty( $s['spam_recaptcha_site'] ) ): ?>
                <input type="hidden" id="cfge_recaptcha_token" name="cfge_recaptcha_token" value=""/>
                <?php endif; ?>

                <div class="cfge-row2" style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
                    <div>
                        <label for="cfge_firstName" style="<?= $label_style ?>">First Name <?php if ( $s['req_first_name'] === '1' ): ?><span style="color:<?= $pri ?>">*</span><?php endif; ?></label>
                        <input id="cfge_firstName" name="firstName" type="text" <?= $s['req_first_name'] === '1' ? 'required' : '' ?> placeholder="Jane" style="<?= $input_style ?>"/>
                    </div>
                    <div>
                        <label for="cfge_lastName" style="<?= $label_style ?>">Last Name <?php if ( $s['req_last_name'] === '1' ): ?><span style="color:<?= $pri ?>">*</span><?php endif; ?></label>
                        <input id="cfge_lastName" name="lastName" type="text" <?= $s['req_last_name'] === '1' ? 'required' : '' ?> placeholder="Smith" style="<?= $input_style ?>"/>
                    </div>
                </div>
                <div class="cfge-row2" style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
                    <div>
                        <label for="cfge_email" style="<?= $label_style ?>">Email <?php if ( $s['req_email'] === '1' ): ?><span style="color:<?= $pri ?>">*</span><?php endif; ?></label>
                        <input id="cfge_email" name="email" type="email" <?= $s['req_email'] === '1' ? 'required' : '' ?> placeholder="jane@example.com" style="<?= $input_style ?>"/>
                    </div>
                    <div>
                        <label for="cfge_phone" style="<?= $label_style ?>">Phone <?php if ( $s['req_phone'] === '1' ): ?><span style="color:<?= $pri ?>">*</span><?php endif; ?></label>
                        <input id="cfge_phone" name="phone" type="tel" <?= $s['req_phone'] === '1' ? 'required' : '' ?> placeholder="(555) 123-4567" style="<?= $input_style ?>"/>
                    </div>
                </div>

                <?php if ( $s['show_treatment'] === '1' ): ?>
                <div style="margin-bottom:1.25rem;">
                    <label for="cfge_treatment" style="<?= $label_style ?>">Treatment Type <?php if ( $s['req_treatment'] === '1' ): ?><span style="color:<?= $pri ?>">*</span><?php endif; ?></label>
                    <select id="cfge_treatment" name="treatment" <?= $s['req_treatment'] === '1' ? 'required' : '' ?> style="<?= $input_style ?>appearance:none;">
                        <option value="" disabled selected>Select a treatment…</option>
                        <?php foreach ( $treatments as $opt ): ?><option value="<?= esc_attr( $opt ) ?>"><?= esc_html( $opt ) ?></option><?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>

                <div id="cfge-error"   style="display:none;padding:0.75rem 1rem;background:#fef2f2;border:1px solid #fecaca;border-radius:<?= $ir ?>;color:#b91c1c;font-size:0.875rem;margin-bottom:1rem;"></div>
                <div id="cfge-success" style="display:none;padding:0.75rem 1rem;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:<?= $ir ?>;color:#15803d;font-size:0.875rem;margin-bottom:1rem;"><?= esc_html( $s['success_msg'] ) ?></div>

                <div style="display:flex;flex-direction:column;gap:0.875rem;">
                    <button type="submit" id="cfge-submit-btn" style="width:100%;padding:0.875rem 1.5rem;background:<?= $pri ?>;color:#fff;border:none;border-radius:<?= $ir ?>;font-size:0.9rem;font-weight:<?= $bw ?>;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;font-family:inherit;transition:filter 0.15s;">
                        <?= cfg_icon( 'message', 16 ) ?>
                        <span id="cfge-submit-label"><?= esc_html( $s['btn_text'] ) ?></span>
                    </button>
                    <?php if ( $s['show_terms'] === '1' ): ?>
                    <label style="display:flex;align-items:flex-start;gap:0.75rem;cursor:pointer;">
                        <input id="cfge_terms" name="terms" type="checkbox" required style="margin-top:3px;width:1rem;height:1rem;flex-shrink:0;accent-color:<?= $pri ?>;"/>
                        <span style="color:<?= $mc ?>;font-size:0.75rem;line-height:1.6;"><?= esc_html( $s['terms_text'] ) ?></span>
                    </label>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <script>
    (function(){
        var AJAX      = <?= wp_json_encode( admin_url( 'admin-ajax.php' ) ) ?>;
        var NONCE     = document.getElementById('cfge_nonce').value;
        var PHONE     = <?= wp_json_encode( $s['phone_number'] ) ?>;
        var BTN_TXT   = <?= wp_json_encode( $s['btn_text'] ) ?>;
        var REDIRECT  = <?= wp_json_encode( $s['success_redirect_url'] ) ?>;
        var HAS_TERMS = <?= $s['show_terms'] === '1' ? 'true' : 'false' ?>;
        var RC_KEY    = <?= wp_json_encode( $s['spam_recaptcha_site'] ) ?>;

        var form   = document.getElementById('cfge-form');
        var btn    = document.getElementById('cfge-submit-btn');
        var lbl    = document.getElementById('cfge-submit-label');
        var errBox = document.getElementById('cfge-error');
        var okBox  = document.getElementById('cfge-success');

        function showErr(msg){ errBox.textContent=msg; errBox.style.display='block'; okBox.style.display='none'; }
        function hideErr(){ errBox.style.display='none'; }

        var _up = new URLSearchParams(window.location.search);
        function doSubmit(token) {
            if (RC_KEY) { var tf = document.getElementById('cfge_recaptcha_token'); if (tf) tf.value = token||''; }
            var hp = form.querySelector('[name="cfg_hp_website"]');
            var payload = {
                action:       'cfg_submit',
                cfg_nonce:    NONCE,
                cfg_hp:       hp ? hp.value : '',
                cfg_rc:       (RC_KEY && document.getElementById('cfge_recaptcha_token')) ? document.getElementById('cfge_recaptcha_token').value : '',
                firstName:    (form.querySelector('[name="firstName"]') || {}).value || '',
                lastName:     (form.querySelector('[name="lastName"]')  || {}).value || '',
                email:        (form.querySelector('[name="email"]')     || {}).value || '',
                phone:        (form.querySelector('[name="phone"]')     || {}).value || '',
                treatment:    (form.querySelector('[name="treatment"]') || {value:''}).value || '',
                utm_campaign: _up.get('utm_campaign') || '',
                utm_medium:   _up.get('utm_medium')   || '',
                utm_content:  _up.get('utm_content')  || '',
                utm_keyword:  _up.get('utm_keyword')  || '',
                gclid:        _up.get('gclid')        || ''
            };
            btn.disabled = true; lbl.textContent = 'Sending\u2026';
            fetch(AJAX, {
                method:  'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body:    Object.keys(payload).map(k=>encodeURIComponent(k)+'='+encodeURIComponent(payload[k])).join('&')
            })
            .then(function(r){ return r.json(); })
            .then(function(d){
                btn.disabled=false; lbl.textContent=BTN_TXT;
                if (d.success) {
                    if (REDIRECT) { window.location.href = REDIRECT; }
                    else { form.reset(); okBox.style.display='block'; }
                } else { showErr(d.data||'Submission failed. Please try again.'); }
            })
            .catch(function(){ btn.disabled=false; lbl.textContent=BTN_TXT; showErr('Something went wrong. Please call us at '+PHONE+'.'); });
        }

        form.addEventListener('submit', function(e){
            e.preventDefault(); hideErr();
            if (HAS_TERMS) {
                var terms = form.querySelector('[name="terms"]');
                if (!terms||!terms.checked){ showErr('Please agree to the terms before submitting.'); return; }
            }
            if (RC_KEY && typeof grecaptcha !== 'undefined') {
                grecaptcha.ready(function(){ grecaptcha.execute(RC_KEY,{action:'submit'}).then(doSubmit); });
            } else { doSubmit(''); }
        });
    })();
    </script>
    <?php
    return ob_get_clean();
}

// ═══════════════════════════════════════════════════════════════
//  SHORTCODE: [booking_method_ghl]
// ═══════════════════════════════════════════════════════════════
add_shortcode( 'booking_method_ghl', 'cfg_booking_method_shortcode' );

function cfg_booking_method_shortcode() {
    $s    = cfg_get();
    $font = cfg_font_setup( $s );

    $cr  = absint( $s['card_radius'] )  . 'px';
    $ir  = absint( $s['input_radius'] ) . 'px';
    $pri = esc_attr( $s['primary_color'] );
    $bg  = esc_attr( $s['bg_color'] );
    $tc  = esc_attr( $s['text_color'] );
    $mc  = esc_attr( $s['muted_color'] );
    $bc  = esc_attr( $s['border_color'] );
    $bw  = esc_attr( $s['font_weight_bold'] );
    $nw  = esc_attr( $s['font_weight_normal'] );

    $card_base = "background:{$bg};border-radius:{$cr};padding:2.5rem;display:flex;flex-direction:column;align-items:center;text-align:center;";
    if ( $s['card_border'] === '1' ) $card_base .= "border:1px solid {$bc};";
    if ( $s['card_shadow'] === '1' ) $card_base .= "box-shadow:0 4px 24px rgba(0,0,0,0.08);";

    ob_start();
    if ( $font['url'] ) echo '<link rel="stylesheet" href="' . esc_url( $font['url'] ) . '"/>';
    ?>
    <style>
    #cfg-bm-wrap *{box-sizing:border-box;}
    .cfg-bm-card{transition:box-shadow 0.2s;}
    .cfg-bm-card:hover{box-shadow:0 8px 32px rgba(0,0,0,0.13)!important;}
    @media(max-width:640px){.cfg-bm-grid{grid-template-columns:1fr!important;}}
    @media(min-width:641px) and (max-width:900px){.cfg-bm-grid{grid-template-columns:1fr 1fr!important;}}
    </style>

    <div id="cfg-bm-wrap" style="font-family:<?= esc_attr( $font['stack'] ) ?>;color:<?= $tc ?>;font-weight:<?= $nw ?>;line-height:1.6;">

    <?php if ( $s['bm_show_hero'] === '1' ): ?>
    <section style="background:<?= esc_attr( $s['bm_hero_bg_color'] ) ?>;padding:6rem 1.5rem 3.5rem;text-align:center;">
        <div style="max-width:800px;margin:0 auto;">
            <?php if ( $s['bm_hero_eyebrow'] ): ?><p style="margin:0 0 1rem;font-weight:<?= $bw ?>;color:<?= $mc ?>;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.1em;"><?= esc_html( $s['bm_hero_eyebrow'] ) ?></p><?php endif; ?>
            <?php if ( $s['bm_hero_heading'] ): ?><h1 style="margin:0 0 1.25rem;font-size:clamp(1.75rem,5vw,3rem);font-weight:<?= $bw ?>;line-height:1.15;color:<?= $tc ?>;"><?= esc_html( $s['bm_hero_heading'] ) ?></h1><?php endif; ?>
            <?php if ( $s['bm_hero_subheading'] ): ?><p style="max-width:42rem;margin:0 auto;font-size:1.1rem;color:<?= $mc ?>;"><?= esc_html( $s['bm_hero_subheading'] ) ?></p><?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    $bm_card_count = 2 + ( $s['bm_show_card3'] === '1' ? 1 : 0 ) + ( $s['bm_show_card4'] === '1' ? 1 : 0 );
    $bm_cols = $bm_card_count === 4 ? '1fr 1fr 1fr 1fr' : ( $bm_card_count === 3 ? '1fr 1fr 1fr' : '1fr 1fr' );
    $bm_max  = $bm_card_count === 4 ? '1200px' : ( $bm_card_count === 3 ? '960px' : '800px' );
    ?>
    <section style="padding:<?= $s['bm_show_hero'] === '1' ? '3.5rem' : '6rem' ?> 1.5rem 3.5rem;">
        <div style="max-width:<?= $bm_max ?>;margin:0 auto;">
            <div class="cfg-bm-grid" style="display:grid;grid-template-columns:<?= $bm_cols ?>;gap:2rem;">

                <!-- Card 1 -->
                <div class="cfg-bm-card" style="<?= $card_base ?>">
                    <div style="display:flex;justify-content:center;align-items:center;background:<?= $pri ?>1a;border-radius:50%;width:64px;height:64px;margin-bottom:1.5rem;color:<?= $pri ?>;">
                        <?= cfg_icon( esc_attr( $s['bm_card1_icon'] ), 28 ) ?>
                    </div>
                    <?php if ( $s['bm_card1_eyebrow'] ): ?>
                    <p style="margin:0 0 0.5rem;font-weight:<?= $bw ?>;color:<?= $mc ?>;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;"><?= esc_html( $s['bm_card1_eyebrow'] ) ?></p>
                    <?php endif; ?>
                    <h2 style="margin:0 0 0.75rem;font-size:1.375rem;font-weight:<?= $bw ?>;color:<?= $tc ?>;"><?= esc_html( $s['bm_card1_heading'] ) ?></h2>
                    <p style="margin:0 0 2rem;font-size:0.9rem;color:<?= $mc ?>;flex:1;"><?= esc_html( $s['bm_card1_body'] ) ?></p>
                    <a href="<?= esc_attr( $s['bm_card1_btn_url'] ) ?>" style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;width:100%;padding:0.875rem 1rem;background:<?= $pri ?>;color:#fff;border-radius:<?= $ir ?>;font-size:0.875rem;font-weight:<?= $bw ?>;text-decoration:none;transition:filter 0.15s;" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter=''">
                        <?= cfg_icon( esc_attr( $s['bm_card1_icon'] ), 16 ) ?>
                        <?= esc_html( $s['bm_card1_btn_text'] ) ?>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="cfg-bm-card" style="<?= $card_base ?>">
                    <div style="display:flex;justify-content:center;align-items:center;background:<?= $pri ?>1a;border-radius:50%;width:64px;height:64px;margin-bottom:1.5rem;color:<?= $pri ?>;">
                        <?= cfg_icon( esc_attr( $s['bm_card2_icon'] ), 28 ) ?>
                    </div>
                    <?php if ( $s['bm_card2_eyebrow'] ): ?>
                    <p style="margin:0 0 0.5rem;font-weight:<?= $bw ?>;color:<?= $mc ?>;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;"><?= esc_html( $s['bm_card2_eyebrow'] ) ?></p>
                    <?php endif; ?>
                    <h2 style="margin:0 0 0.75rem;font-size:1.375rem;font-weight:<?= $bw ?>;color:<?= $tc ?>;"><?= esc_html( $s['bm_card2_heading'] ) ?></h2>
                    <p style="margin:0 0 2rem;font-size:0.9rem;color:<?= $mc ?>;flex:1;"><?= esc_html( $s['bm_card2_body'] ) ?></p>
                    <a href="<?= esc_url( $s['bm_card2_btn_url'] ) ?>" style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;width:100%;padding:0.875rem 1rem;background:<?= $pri ?>;color:#fff;border-radius:<?= $ir ?>;font-size:0.875rem;font-weight:<?= $bw ?>;text-decoration:none;transition:filter 0.15s;" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter=''">
                        <?= cfg_icon( esc_attr( $s['bm_card2_icon'] ), 16 ) ?>
                        <?= esc_html( $s['bm_card2_btn_text'] ) ?>
                    </a>
                </div>

                <?php if ( $s['bm_show_card3'] === '1' ): ?>
                <!-- Card 3 -->
                <div class="cfg-bm-card" style="<?= $card_base ?>">
                    <div style="display:flex;justify-content:center;align-items:center;background:<?= $pri ?>1a;border-radius:50%;width:64px;height:64px;margin-bottom:1.5rem;color:<?= $pri ?>;">
                        <?= cfg_icon( esc_attr( $s['bm_card3_icon'] ), 28 ) ?>
                    </div>
                    <?php if ( $s['bm_card3_eyebrow'] ): ?>
                    <p style="margin:0 0 0.5rem;font-weight:<?= $bw ?>;color:<?= $mc ?>;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;"><?= esc_html( $s['bm_card3_eyebrow'] ) ?></p>
                    <?php endif; ?>
                    <h2 style="margin:0 0 0.75rem;font-size:1.375rem;font-weight:<?= $bw ?>;color:<?= $tc ?>;"><?= esc_html( $s['bm_card3_heading'] ) ?></h2>
                    <p style="margin:0 0 2rem;font-size:0.9rem;color:<?= $mc ?>;flex:1;"><?= esc_html( $s['bm_card3_body'] ) ?></p>
                    <?php if ( $s['bm_card3_btn_url'] ): ?>
                    <a href="<?= esc_url( $s['bm_card3_btn_url'] ) ?>" style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;width:100%;padding:0.875rem 1rem;background:<?= $pri ?>;color:#fff;border-radius:<?= $ir ?>;font-size:0.875rem;font-weight:<?= $bw ?>;text-decoration:none;transition:filter 0.15s;" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter=''">
                        <?= cfg_icon( esc_attr( $s['bm_card3_icon'] ), 16 ) ?>
                        <?= esc_html( $s['bm_card3_btn_text'] ) ?>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if ( $s['bm_show_card4'] === '1' ): ?>
                <!-- Card 4 -->
                <div class="cfg-bm-card" style="<?= $card_base ?>">
                    <div style="display:flex;justify-content:center;align-items:center;background:<?= $pri ?>1a;border-radius:50%;width:64px;height:64px;margin-bottom:1.5rem;color:<?= $pri ?>;">
                        <?= cfg_icon( esc_attr( $s['bm_card4_icon'] ), 28 ) ?>
                    </div>
                    <?php if ( $s['bm_card4_eyebrow'] ): ?>
                    <p style="margin:0 0 0.5rem;font-weight:<?= $bw ?>;color:<?= $mc ?>;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;"><?= esc_html( $s['bm_card4_eyebrow'] ) ?></p>
                    <?php endif; ?>
                    <h2 style="margin:0 0 0.75rem;font-size:1.375rem;font-weight:<?= $bw ?>;color:<?= $tc ?>;"><?= esc_html( $s['bm_card4_heading'] ) ?></h2>
                    <p style="margin:0 0 2rem;font-size:0.9rem;color:<?= $mc ?>;flex:1;"><?= esc_html( $s['bm_card4_body'] ) ?></p>
                    <?php if ( $s['bm_card4_btn_url'] ): ?>
                    <a href="<?= esc_url( $s['bm_card4_btn_url'] ) ?>" style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;width:100%;padding:0.875rem 1rem;background:<?= $pri ?>;color:#fff;border-radius:<?= $ir ?>;font-size:0.875rem;font-weight:<?= $bw ?>;text-decoration:none;transition:filter 0.15s;" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter=''">
                        <?= cfg_icon( esc_attr( $s['bm_card4_icon'] ), 16 ) ?>
                        <?= esc_html( $s['bm_card4_btn_text'] ) ?>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <?php if ( $s['bm_show_cta'] === '1' ): ?>
    <section style="background:<?= esc_attr( $s['bm_cta_bg_color'] ) ?>;padding:4rem 1.5rem;text-align:center;">
        <div style="max-width:600px;margin:0 auto;">
            <h2 style="margin:0 0 1rem;font-size:clamp(1.5rem,4vw,2.25rem);font-weight:<?= $bw ?>;color:#fff;"><?= esc_html( $s['bm_cta_heading'] ) ?></h2>
            <p style="margin:0 0 2.5rem;font-size:1.05rem;color:rgba(255,255,255,0.8);"><?= esc_html( $s['bm_cta_body'] ) ?></p>
            <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
                <?php if ( $s['bm_cta_btn1_text'] && $s['bm_cta_btn1_url'] ): ?>
                <a href="<?= esc_url( $s['bm_cta_btn1_url'] ) ?>" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 2rem;background:#fff;color:<?= esc_attr( $s['bm_cta_bg_color'] ) ?>;border-radius:<?= $ir ?>;font-size:0.875rem;font-weight:<?= $bw ?>;text-decoration:none;transition:opacity 0.15s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    <?= esc_html( $s['bm_cta_btn1_text'] ) ?> <?= cfg_icon( 'arrow', 16 ) ?>
                </a>
                <?php endif; ?>
                <?php if ( $s['bm_cta_btn2_text'] && $s['bm_cta_btn2_url'] ): ?>
                <a href="<?= esc_attr( $s['bm_cta_btn2_url'] ) ?>" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 2rem;color:rgba(255,255,255,0.75);border-radius:<?= $ir ?>;font-size:0.875rem;font-weight:<?= $bw ?>;text-decoration:none;border:1px solid rgba(255,255,255,0.3);transition:color 0.15s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.75)'">
                    <?= cfg_icon( 'phone', 16 ) ?>
                    <?= esc_html( $s['bm_cta_btn2_text'] ) ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    </div>
    <?php
    return ob_get_clean();
}

// ═══════════════════════════════════════════════════════════════
//  SHORTCODE: [thank_you_ghl]
// ═══════════════════════════════════════════════════════════════
add_shortcode( 'thank_you_ghl', 'cfg_thank_you_shortcode' );

function cfg_thank_you_shortcode() {
    $s    = cfg_get();
    $font = cfg_font_setup( $s );

    $pri = esc_attr( $s['primary_color'] );
    $tc  = esc_attr( $s['text_color'] );
    $mc  = esc_attr( $s['muted_color'] );
    $bw  = esc_attr( $s['font_weight_bold'] );
    $nw  = esc_attr( $s['font_weight_normal'] );
    $bg  = esc_attr( $s['ty_bg_color'] );

    // Social icon
    $social_icons = [
        'instagram' => 'instagram', 'facebook' => 'facebook',
        'tiktok' => 'tiktok', 'youtube' => 'youtube', 'x' => 'x',
    ];
    $soc_icon = $social_icons[ $s['ty_social_platform'] ] ?? 'instagram';

    ob_start();
    if ( $font['url'] ) echo '<link rel="stylesheet" href="' . esc_url( $font['url'] ) . '"/>';
    ?>
    <style>
    #cfg-ty-wrap *{box-sizing:border-box;}
    @media(max-width:768px){.cfg-ty-grid{grid-template-columns:1fr!important;} .cfg-ty-img{display:none!important;}}
    </style>

    <div id="cfg-ty-wrap" style="background:<?= $bg ?>;font-family:<?= esc_attr( $font['stack'] ) ?>;color:<?= $tc ?>;font-weight:<?= $nw ?>;line-height:1.6;">
        <div class="cfg-ty-grid" style="display:grid;grid-template-columns:1fr 1fr;align-items:center;gap:4rem;max-width:1100px;margin:0 auto;padding:6rem 2rem;">

            <!-- Left: Text -->
            <div>
                <?php if ( $s['ty_eyebrow'] ): ?>
                <p style="margin:0 0 1rem;font-weight:<?= $bw ?>;color:<?= $pri ?>;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.1em;"><?= esc_html( $s['ty_eyebrow'] ) ?></p>
                <?php endif; ?>

                <h1 style="margin:0 0 1.5rem;font-size:clamp(2rem,5vw,3.25rem);font-weight:<?= $bw ?>;line-height:1.15;color:<?= $tc ?>;">
                    <?= esc_html( $s['ty_heading_line1'] ) ?><?php if ( $s['ty_heading_line2'] ): ?><br/><?= esc_html( $s['ty_heading_line2'] ) ?><?php endif; ?>
                </h1>

                <?php if ( $s['ty_body'] ): ?>
                <p style="margin:0 0 2.5rem;font-size:1.1rem;color:<?= $mc ?>;max-width:32rem;"><?= esc_html( $s['ty_body'] ) ?></p>
                <?php endif; ?>

                <?php if ( $s['ty_social_show'] === '1' && $s['ty_social_url'] ): ?>
                <a href="<?= esc_url( $s['ty_social_url'] ) ?>" target="_blank" rel="noopener noreferrer" style="display:inline-flex;align-items:center;gap:0.875rem;text-decoration:none;">
                    <span style="display:flex;justify-content:center;align-items:center;background:<?= $pri ?>1a;border-radius:50%;width:48px;height:48px;flex-shrink:0;color:<?= $pri ?>;transition:background 0.2s;" onmouseover="this.style.background='<?= $pri ?>33'" onmouseout="this.style.background='<?= $pri ?>1a'">
                        <?= cfg_icon( $soc_icon, 22 ) ?>
                    </span>
                    <span>
                        <span style="display:block;font-weight:<?= $bw ?>;color:<?= $tc ?>;font-size:0.9rem;"><?= esc_html( $s['ty_social_label'] ) ?></span>
                        <?php if ( $s['ty_social_handle'] ): ?>
                        <span style="font-size:0.8rem;color:<?= $mc ?>;"><?= esc_html( $s['ty_social_handle'] ) ?></span>
                        <?php endif; ?>
                    </span>
                </a>
                <?php endif; ?>
            </div>

            <!-- Right: Image -->
            <?php if ( ! empty( $s['ty_image_url'] ) ): ?>
            <div class="cfg-ty-img" style="border-radius:24px;overflow:hidden;position:relative;box-shadow:0 8px 40px rgba(0,0,0,0.12);">
                <div style="padding-bottom:75%;position:relative;height:0;overflow:hidden;">
                    <img src="<?= esc_url( $s['ty_image_url'] ) ?>" alt="<?= esc_attr( $s['ty_image_alt'] ) ?>" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;display:block;"/>
                </div>
            </div>
            <?php else: ?>
            <div class="cfg-ty-img" style="border-radius:24px;padding-bottom:75%;position:relative;background:#f4f4f5;">
                <span style="position:absolute;top:0;left:0;right:0;bottom:0;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:0.875rem;padding:1rem;text-align:center;">Set an image URL in Settings → Thank You Page</span>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <?php
    return ob_get_clean();
}

// ═══════════════════════════════════════════════════════════════
//  AJAX HANDLER
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_ajax_cfg_submit',        'cfg_ajax_submit' );
add_action( 'wp_ajax_nopriv_cfg_submit', 'cfg_ajax_submit' );

function cfg_ajax_submit() {
    if ( ! isset( $_POST['cfg_nonce'] ) || ! wp_verify_nonce( $_POST['cfg_nonce'], 'cfg_submit' ) ) {
        wp_send_json_error( 'Security check failed. Please refresh and try again.' );
    }

    $s = cfg_get();

    // ── Honeypot ─────────────────────────────────────────────
    if ( $s['spam_honeypot'] === '1' ) {
        $hp = sanitize_text_field( $_POST['cfg_hp'] ?? '' );
        if ( ! empty( $hp ) ) {
            wp_send_json_error( 'Submission blocked.' );
        }
    }

    // ── reCAPTCHA v3 ─────────────────────────────────────────
    if ( ! empty( $s['spam_recaptcha_secret'] ) ) {
        $rc_token = sanitize_text_field( $_POST['cfg_rc'] ?? '' );
        if ( empty( $rc_token ) ) {
            wp_send_json_error( 'reCAPTCHA verification missing. Please try again.' );
        }
        $rc_resp = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', [
            'body'    => [ 'secret' => $s['spam_recaptcha_secret'], 'response' => $rc_token ],
            'timeout' => 10,
        ] );
        if ( ! is_wp_error( $rc_resp ) ) {
            $rc_data = json_decode( wp_remote_retrieve_body( $rc_resp ), true );
            if ( empty( $rc_data['success'] ) || ( isset( $rc_data['score'] ) && $rc_data['score'] < 0.5 ) ) {
                wp_send_json_error( 'reCAPTCHA score too low. Please try again.' );
            }
        }
    }

    // ── Sanitise inputs ──────────────────────────────────────
    $first     = sanitize_text_field( $_POST['firstName'] ?? '' );
    $last      = sanitize_text_field( $_POST['lastName']  ?? '' );
    $email     = sanitize_email(      $_POST['email']     ?? '' );
    $phone     = sanitize_text_field( $_POST['phone']     ?? '' );
    $treatment = sanitize_text_field( $_POST['treatment'] ?? '' );

    // ── Validate ─────────────────────────────────────────────
    if ( $s['req_first_name'] === '1' && empty( $first ) )       wp_send_json_error( 'First name is required.' );
    if ( $s['req_last_name']  === '1' && empty( $last ) )        wp_send_json_error( 'Last name is required.' );
    if ( $s['req_email']      === '1' && ! is_email( $email ) )  wp_send_json_error( 'A valid email address is required.' );
    if ( $s['req_phone']      === '1' && empty( $phone ) )       wp_send_json_error( 'Phone number is required.' );
    if ( $s['req_treatment']  === '1' && $s['show_treatment'] === '1' && empty( $treatment ) )
        wp_send_json_error( 'Please select a treatment type.' );

    if ( empty( $s['ghl_api_key'] ) || empty( $s['ghl_location_id'] ) ) {
        wp_send_json_error( 'The form is not fully configured yet. Please contact us directly.' );
    }

    // ── Build GHL payload ────────────────────────────────────
    $custom_fields = [];
    if ( ! empty( $treatment ) ) {
        $custom_fields[] = [ 'key' => 'treatment_type', 'field_value' => $treatment ];
    }
    foreach ( [ 'utm_campaign', 'utm_medium', 'utm_content', 'utm_keyword', 'gclid' ] as $utm_key ) {
        $val = sanitize_text_field( $_POST[ $utm_key ] ?? '' );
        if ( $val !== '' ) $custom_fields[] = [ 'key' => $utm_key, 'field_value' => $val ];
    }

    $payload = [
        'firstName'  => $first,
        'lastName'   => $last,
        'email'      => $email,
        'phone'      => $phone,
        'locationId' => $s['ghl_location_id'],
        'source'     => 'Website Contact Form',
        'tags'       => [ 'website-contact-form' ],
    ];
    if ( $custom_fields ) $payload['customFields'] = $custom_fields;

    // ── POST to GHL ──────────────────────────────────────────
    $response = wp_remote_post( 'https://services.leadconnectorhq.com/contacts/upsert', [
        'headers' => [
            'Authorization' => 'Bearer ' . $s['ghl_api_key'],
            'Content-Type'  => 'application/json',
            'Version'       => '2021-07-28',
        ],
        'body'    => wp_json_encode( $payload ),
        'timeout' => 15,
    ] );

    if ( is_wp_error( $response ) ) {
        error_log( '[CFG] GHL request failed: ' . $response->get_error_message() );
        wp_send_json_error( 'Could not reach the CRM. Please try again in a moment.' );
    }

    $code = wp_remote_retrieve_response_code( $response );
    $body = json_decode( wp_remote_retrieve_body( $response ), true );

    if ( $code === 200 || $code === 201 ) {
        wp_send_json_success( 'Contact created.' );
    } else {
        $msg = $body['message'] ?? ( 'Unexpected error (HTTP ' . $code . ').' );
        error_log( '[CFG] GHL error ' . $code . ': ' . wp_json_encode( $body ) );
        wp_send_json_error( $msg );
    }
}

// ═══════════════════════════════════════════════════════════════
//  ALIGNER QUIZ — DEFAULTS & OPTION
// ═══════════════════════════════════════════════════════════════
define( 'CFG_ALG_OPTION', 'cfg_aligner_steps' );

function cfg_aligner_defaults() {
    return [
        [
            'type'     => 'intro',
            'title'    => 'Your Treatment Estimate & Discount',
            'subtitle' => "Just a few questions and we'll provide you with an instant estimate for your clear aligner treatment, and you'll also receive:",
            'bullets'  => "An estimate of treatment cost and duration, plus a \$1000 discount\nAlternative affordable options to improve your smile\nA 3D scan assessment to visualize your future results",
            'btn_text' => 'Start Questions',
        ],
        [
            'type'      => 'yesno',
            'question'  => 'Have you had orthodontic treatment before?',
            'hint'      => '',
            'field_key' => 'prev_orthodontic',
        ],
        [
            'type'      => 'yesno',
            'question'  => 'Do you currently have any dental crowns, bridges, implants, or veneers?',
            'hint'      => '(Existing dental work might affect the treatment plan.)',
            'field_key' => 'dental_work',
        ],
        [
            'type'      => 'image',
            'question'  => 'How would you describe your teeth alignment?',
            'hint'      => '(This will help in assessing the complexity of the alignment issue.)',
            'field_key' => 'teeth_alignment',
            'choices'   => [
                [ 'label' => 'Very crowded',       'emoji' => '😬', 'img' => '' ],
                [ 'label' => 'Moderately crowded', 'emoji' => '😐', 'img' => '' ],
                [ 'label' => 'Slightly crowded',   'emoji' => '🙂', 'img' => '' ],
                [ 'label' => 'Gaps between teeth', 'emoji' => '😁', 'img' => '' ],
                [ 'label' => 'Generally straight', 'emoji' => '😊', 'img' => '' ],
            ],
        ],
        [
            'type'      => 'image',
            'question'  => 'Do you experience any of the following issues?',
            'hint'      => '(Specific bite issues might require specialized treatment approaches.)',
            'field_key' => 'bite_issues',
            'choices'   => [
                [ 'label' => 'Overbite',         'emoji' => '🔼', 'img' => '' ],
                [ 'label' => 'Underbite',        'emoji' => '🔽', 'img' => '' ],
                [ 'label' => 'Crossbite',        'emoji' => '↔️',  'img' => '' ],
                [ 'label' => 'Open bite',        'emoji' => '⭕',  'img' => '' ],
                [ 'label' => 'None of the above','emoji' => '✅',  'img' => '' ],
            ],
        ],
        [
            'type'      => 'yesno',
            'question'  => 'Do you have dental insurance that covers orthodontic treatments?',
            'hint'      => '',
            'field_key' => 'has_insurance',
        ],
        [
            'type'      => 'yesno',
            'question'  => 'Are you covered with CDCP?',
            'hint'      => '',
            'field_key' => 'cdcp_covered',
        ],
        [
            'type'     => 'content',
            'title'    => 'Limited Time Offer',
            'subtitle' => 'Get an average of $3000 in savings',
            'bullets'  => "Extra \$1000 Off with this online estimate\nFree consultation (valued at \$500)\nFree Retainers (worth up to \$1500)",
            'btn_text' => 'Continue to Get My Estimate',
        ],
        [
            'type'     => 'contact',
            'title'    => 'Get Your Estimate & $1000 Discount',
            'subtitle' => 'We will text you your estimate & discount offer. We can also call if you prefer.',
            'btn_text' => 'Text Me My Estimate',
        ],
    ];
}

function cfg_aligner_get() {
    $saved = get_option( CFG_ALG_OPTION );
    if ( ! empty( $saved ) && is_array( $saved ) ) return $saved;
    return cfg_aligner_defaults();
}

add_action( 'admin_init', function () {
    register_setting( CFG_SLUG, CFG_ALG_OPTION, [ 'sanitize_callback' => 'cfg_aligner_sanitize' ] );
} );

function cfg_aligner_sanitize( $input ) {
    if ( is_string( $input ) && ! empty( $input ) ) {
        $decoded = json_decode( wp_unslash( $input ), true );
        if ( is_array( $decoded ) ) return $decoded;
    }
    return cfg_aligner_defaults();
}

// ═══════════════════════════════════════════════════════════════
//  ALIGNER QUIZ — SHORTCODE [aligner_form_ghl]
// ═══════════════════════════════════════════════════════════════
add_shortcode( 'aligner_form_ghl', 'cfg_aligner_shortcode' );

function cfg_aligner_shortcode() {
    $s      = cfg_get();
    $steps  = cfg_aligner_get();
    $font   = cfg_font_setup( $s );
    $accent = sanitize_hex_color( $s['alg_accent_color'] ?? '#C9A84C' ) ?: '#C9A84C';
    $bg     = sanitize_hex_color( $s['bg_color'] ) ?: '#ffffff';
    $tc     = sanitize_hex_color( $s['text_color'] ) ?: '#111827';
    $uid    = 'alg' . wp_rand( 1000, 9999 );
    $nonce  = wp_create_nonce( 'cfg_aligner_submit' );
    $ajax   = admin_url( 'admin-ajax.php' );
    $surl   = esc_js( $s['alg_success_url'] ?? '' );
    $total  = count( $steps );
    $honeypot = $s['spam_honeypot'] === '1';

    // Find submit button text from contact step
    $submit_txt = 'Submit';
    foreach ( $steps as $st ) {
        if ( $st['type'] === 'contact' ) { $submit_txt = esc_js( $st['btn_text'] ?? 'Submit' ); break; }
    }

    if ( ! empty( $font['url'] ) ) {
        echo '<link rel="stylesheet" href="' . esc_url( $font['url'] ) . '">';
    }

    ob_start(); ?>
<style>
#<?= $uid ?>-wrap{font-family:<?= esc_attr($font['stack']) ?>;color:<?= $tc ?>;box-sizing:border-box;}
#<?= $uid ?>-wrap *,#<?= $uid ?>-wrap *::before,#<?= $uid ?>-wrap *::after{box-sizing:border-box;}
#<?= $uid ?>-outer{overflow:hidden;position:relative;transition:height 0.38s ease;}
#<?= $uid ?>-slider{display:flex;transition:transform 0.42s cubic-bezier(0.4,0,0.2,1);will-change:transform;}
.<?= $uid ?>-step{flex:0 0 100%;min-width:100%;padding:2.5rem 2.25rem;}
@media(max-width:560px){.<?= $uid ?>-step{padding:1.75rem 1.25rem;}}
#<?= $uid ?>-prog-wrap{height:5px;background:#f3f4f6;border-radius:99px;overflow:hidden;}
#<?= $uid ?>-prog-bar{height:100%;background:<?= $accent ?>;border-radius:99px;transition:width 0.4s ease;width:0%;}
.<?= $uid ?>-card{cursor:pointer;border:2px solid #e5e7eb;border-radius:14px;padding:1.5rem 1rem;text-align:center;display:flex;flex-direction:column;align-items:center;justify-content:center;transition:border-color 0.2s,background 0.2s,transform 0.18s,box-shadow 0.18s;background:#fff;user-select:none;}
.<?= $uid ?>-card:hover{border-color:<?= $accent ?>88;transform:translateY(-3px);box-shadow:0 6px 24px rgba(0,0,0,0.09);}
.<?= $uid ?>-card.alg-sel{border-color:<?= $accent ?>;background:<?= $accent ?>18;transform:scale(1.04);}
.<?= $uid ?>-yn{display:grid;grid-template-columns:1fr 1fr;gap:1.125rem;}
@media(max-width:380px){.<?= $uid ?>-yn{grid-template-columns:1fr;}}
.<?= $uid ?>-img3{display:grid;grid-template-columns:repeat(3,1fr);gap:0.875rem;}
.<?= $uid ?>-img2{display:grid;grid-template-columns:1fr 1fr;gap:0.875rem;}
@media(max-width:500px){.<?= $uid ?>-img3{grid-template-columns:1fr 1fr;}}
@media(max-width:340px){.<?= $uid ?>-img3,.<?= $uid ?>-img2{grid-template-columns:1fr;}}
.<?= $uid ?>-btn{display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;background:<?= $accent ?>;color:#fff;border:none;border-radius:10px;font-weight:600;cursor:pointer;font-family:inherit;transition:filter 0.18s,transform 0.12s;letter-spacing:0.01em;}
.<?= $uid ?>-btn:hover{<?= $s['btn_hover_bg_color'] ? 'background:' . esc_attr( $s['btn_hover_bg_color'] ) . '!important;' . ( $s['btn_hover_text_color'] ? 'color:' . esc_attr( $s['btn_hover_text_color'] ) . '!important;' : '' ) : 'filter:brightness(1.1);' ?>}
.<?= $uid ?>-btn:active{transform:scale(0.97);}
.<?= $uid ?>-ghost{background:none;border:2px solid #e5e7eb;border-radius:8px;color:#6b7280;font-weight:500;cursor:pointer;font-family:inherit;transition:border-color 0.18s,color 0.18s;}
.<?= $uid ?>-ghost:hover{border-color:<?= $accent ?>;color:<?= $accent ?>;}
.<?= $uid ?>-input{width:100%;padding:0.75rem 1rem;border:1.5px solid #e5e7eb;border-radius:10px;font-size:0.95rem;outline:none;font-family:inherit;transition:border-color 0.2s,box-shadow 0.2s;}
.<?= $uid ?>-input:focus{border-color:<?= $accent ?>;box-shadow:0 0 0 3px <?= $accent ?>22;}
.<?= $uid ?>-fgrid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
@media(max-width:480px){.<?= $uid ?>-fgrid{grid-template-columns:1fr;}}
</style>
<div id="<?= $uid ?>-wrap" style="background:<?= $bg ?>;padding:4rem 1.5rem;">
    <div style="max-width:700px;margin:0 auto;">
        <div style="margin-bottom:1.75rem;">
            <div id="<?= $uid ?>-prog-wrap"><div id="<?= $uid ?>-prog-bar"></div></div>
            <div id="<?= $uid ?>-counter" style="text-align:right;font-size:0.78rem;color:#9ca3af;margin-top:5px;min-height:1.1em;"></div>
        </div>
        <div style="background:#fff;border-radius:22px;box-shadow:0 4px 48px rgba(0,0,0,0.11);overflow:hidden;">
            <div id="<?= $uid ?>-outer">
                <div id="<?= $uid ?>-slider">
                <?php foreach ( $steps as $i => $step ):
                    $type = $step['type'] ?? 'yesno';
                    $fk   = esc_attr( $step['field_key'] ?? '' );
                    echo '<div class="' . $uid . '-step" data-index="' . $i . '" data-type="' . esc_attr( $type ) . '" data-key="' . $fk . '">';

                    // ── INTRO ──────────────────────────────────────
                    if ( $type === 'intro' ) {
                        $bullets = array_filter( array_map( 'trim', explode( "\n", $step['bullets'] ?? '' ) ) );
                        echo '<div style="text-align:center;max-width:540px;margin:0 auto;padding:0.75rem 0;">';
                        echo '<h1 style="font-size:clamp(1.45rem,4vw,2.15rem);font-weight:700;color:' . $accent . ';margin:0 0 1rem;line-height:1.25;">' . esc_html( $step['title'] ?? '' ) . '</h1>';
                        if ( ! empty( $step['subtitle'] ) ) {
                            echo '<p style="font-size:1rem;color:#6b7280;margin:0 0 1.5rem;line-height:1.65;">' . esc_html( $step['subtitle'] ) . '</p>';
                        }
                        if ( $bullets ) {
                            echo '<ul style="text-align:left;list-style:none;padding:0;margin:0 0 2rem;display:inline-block;">';
                            foreach ( $bullets as $b ) {
                                echo '<li style="padding:0.45rem 0 0.45rem 2rem;position:relative;color:#374151;font-size:0.95rem;">';
                                echo '<span style="position:absolute;left:0;top:0.45rem;color:' . $accent . ';font-size:1.1rem;line-height:1;font-weight:700;">✓</span>';
                                echo esc_html( $b ) . '</li>';
                            }
                            echo '</ul>';
                        }
                        echo '<button class="' . $uid . '-btn" style="font-size:1.05rem;padding:1rem 2.75rem;" onclick="' . $uid . 'go(' . ( $i + 1 ) . ')">' . esc_html( $step['btn_text'] ?? 'Start' ) . ' &rarr;</button>';
                        echo '</div>';
                    }

                    // ── YES / NO ───────────────────────────────────
                    elseif ( $type === 'yesno' ) {
                        $has_hint = ! empty( $step['hint'] );
                        echo '<h2 style="font-size:clamp(1.15rem,3vw,1.7rem);font-weight:700;color:' . $accent . ';margin:0 0 ' . ( $has_hint ? '0.5rem' : '1.75rem' ) . ';text-align:center;line-height:1.3;">' . esc_html( $step['question'] ?? '' ) . '</h2>';
                        if ( $has_hint ) {
                            echo '<p style="text-align:center;color:#9ca3af;font-size:0.875rem;margin:0 0 1.75rem;">' . esc_html( $step['hint'] ) . '</p>';
                        }
                        echo '<div class="' . $uid . '-yn" style="margin-bottom:1.75rem;">';
                        // Yes card
                        echo '<div class="' . $uid . '-card" data-value="Yes" onclick="' . $uid . 'yn(this)">';
                        echo '<div style="color:#22c55e;margin-bottom:0.75rem;"><svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></div>';
                        echo '<div style="font-weight:600;font-size:1.05rem;color:#1a1a2e;">Yes</div></div>';
                        // No card
                        echo '<div class="' . $uid . '-card" data-value="No" onclick="' . $uid . 'yn(this)">';
                        echo '<div style="color:#ef4444;margin-bottom:0.75rem;"><svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg></div>';
                        echo '<div style="font-weight:600;font-size:1.05rem;color:#1a1a2e;">No</div></div>';
                        echo '</div>';
                        echo cfg_alg_nav( $uid, $i, $accent );
                    }

                    // ── IMAGE CHOICES ──────────────────────────────
                    elseif ( $type === 'image' ) {
                        $has_hint = ! empty( $step['hint'] );
                        echo '<h2 style="font-size:clamp(1.15rem,3vw,1.7rem);font-weight:700;color:' . $accent . ';margin:0 0 ' . ( $has_hint ? '0.5rem' : '1.75rem' ) . ';text-align:center;line-height:1.3;">' . esc_html( $step['question'] ?? '' ) . '</h2>';
                        if ( $has_hint ) {
                            echo '<p style="text-align:center;color:#9ca3af;font-size:0.875rem;margin:0 0 1.75rem;">' . esc_html( $step['hint'] ) . '</p>';
                        }
                        $choices  = $step['choices'] ?? [];
                        $g_class  = count( $choices ) >= 4 ? $uid . '-img3' : $uid . '-img2';
                        echo '<div class="' . $g_class . '" style="margin-bottom:1.75rem;">';
                        foreach ( $choices as $c ) {
                            echo '<div class="' . $uid . '-card" data-value="' . esc_attr( $c['label'] ) . '" onclick="' . $uid . 'img(this)" style="min-height:128px;padding:1.25rem 0.75rem;">';
                            if ( ! empty( $c['img'] ) ) {
                                echo '<img src="' . esc_url( $c['img'] ) . '" alt="' . esc_attr( $c['label'] ) . '" style="width:70px;height:70px;object-fit:contain;margin-bottom:0.75rem;display:block;"/>';
                            } else {
                                echo '<div style="font-size:2.75rem;margin-bottom:0.75rem;line-height:1;">' . esc_html( $c['emoji'] ?? '🦷' ) . '</div>';
                            }
                            echo '<div style="font-size:0.85rem;font-weight:500;color:#374151;line-height:1.3;">' . esc_html( $c['label'] ) . '</div>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo cfg_alg_nav( $uid, $i, $accent );
                    }

                    // ── CONTENT / OFFER ────────────────────────────
                    elseif ( $type === 'content' ) {
                        $bullets = array_filter( array_map( 'trim', explode( "\n", $step['bullets'] ?? '' ) ) );
                        echo '<div style="text-align:center;padding:0.75rem 0;">';
                        echo '<h2 style="font-size:clamp(1.35rem,3.5vw,2rem);font-weight:700;color:' . $accent . ';margin:0 0 0.5rem;">' . esc_html( $step['title'] ?? '' ) . '</h2>';
                        if ( ! empty( $step['subtitle'] ) ) {
                            echo '<p style="color:#6b7280;margin:0 0 1.5rem;font-size:0.95rem;">' . esc_html( $step['subtitle'] ) . '</p>';
                        }
                        if ( $bullets ) {
                            echo '<ul style="text-align:left;list-style:none;padding:0;margin:0 auto 2rem;max-width:420px;">';
                            foreach ( $bullets as $b ) {
                                echo '<li style="padding:0.65rem 0 0.65rem 2rem;position:relative;color:#374151;border-bottom:1px solid #f3f4f6;font-size:0.95rem;">';
                                echo '<span style="position:absolute;left:0;top:0.65rem;color:' . $accent . ';font-size:1.1rem;line-height:1;">★</span>';
                                echo esc_html( $b ) . '</li>';
                            }
                            echo '</ul>';
                        }
                        echo '<div style="display:flex;flex-direction:column;gap:0.5rem;align-items:center;">';
                        echo '<button class="' . $uid . '-btn" style="font-size:1rem;padding:0.9rem 2.25rem;" onclick="' . $uid . 'go(' . ( $i + 1 ) . ')">' . esc_html( $step['btn_text'] ?? 'Continue' ) . ' &rarr;</button>';
                        if ( $i > 0 ) {
                            echo '<button class="' . $uid . '-ghost" style="font-size:0.875rem;padding:0.5rem 1.25rem;" onclick="' . $uid . 'go(' . ( $i - 1 ) . ')">← Back</button>';
                        }
                        echo '</div></div>';
                    }

                    // ── CONTACT FORM ───────────────────────────────
                    elseif ( $type === 'contact' ) {
                        echo '<h2 style="font-size:clamp(1.15rem,3vw,1.7rem);font-weight:700;color:' . $accent . ';margin:0 0 0.5rem;text-align:center;line-height:1.3;">' . esc_html( $step['title'] ?? 'Get Your Estimate' ) . '</h2>';
                        if ( ! empty( $step['subtitle'] ) ) {
                            echo '<p style="text-align:center;color:#6b7280;margin:0 0 1.75rem;font-size:0.925rem;line-height:1.65;">' . esc_html( $step['subtitle'] ) . '</p>';
                        }
                        echo '<form id="' . $uid . '-form" novalidate>';
                        echo '<input type="hidden" name="action" value="cfg_aligner_submit"/>';
                        echo '<input type="hidden" name="alg_nonce" value="' . $nonce . '"/>';
                        echo '<input type="hidden" name="alg_answers" id="' . $uid . '-ans" value=""/>';
                        if ( $honeypot ) {
                            echo '<input type="text" name="alg_hp" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;opacity:0;height:0;overflow:hidden;"/>';
                        }
                        echo '<div class="' . $uid . '-fgrid" style="margin-bottom:1rem;">';
                        echo '<div><label style="display:block;margin-bottom:0.4rem;font-size:0.83rem;font-weight:600;color:#374151;">First Name <span style="color:' . $accent . '">*</span></label><input type="text" name="firstName" required placeholder="Jane" class="' . $uid . '-input"/></div>';
                        echo '<div><label style="display:block;margin-bottom:0.4rem;font-size:0.83rem;font-weight:600;color:#374151;">Last Name <span style="color:' . $accent . '">*</span></label><input type="text" name="lastName" required placeholder="Smith" class="' . $uid . '-input"/></div>';
                        echo '</div>';
                        echo '<div class="' . $uid . '-fgrid" style="margin-bottom:1.5rem;">';
                        echo '<div><label style="display:block;margin-bottom:0.4rem;font-size:0.83rem;font-weight:600;color:#374151;">Phone <span style="color:' . $accent . '">*</span></label><input type="tel" name="phone" required placeholder="(555) 123-4567" class="' . $uid . '-input"/></div>';
                        echo '<div><label style="display:block;margin-bottom:0.4rem;font-size:0.83rem;font-weight:600;color:#374151;">Email <span style="color:' . $accent . '">*</span></label><input type="email" name="email" required placeholder="jane@example.com" class="' . $uid . '-input"/></div>';
                        echo '</div>';
                        echo '<div id="' . $uid . '-err" style="display:none;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:0.75rem 1rem;color:#dc2626;font-size:0.875rem;margin-bottom:1rem;"></div>';
                        echo '<button type="submit" id="' . $uid . '-sbtn" class="' . $uid . '-btn" style="width:100%;font-size:1rem;padding:1rem;"><span id="' . $uid . '-slbl">' . esc_html( $step['btn_text'] ?? 'Submit' ) . '</span></button>';
                        if ( $i > 0 ) {
                            echo '<button type="button" onclick="' . $uid . 'go(' . ( $i - 1 ) . ')" style="display:block;width:100%;background:none;border:none;color:#9ca3af;cursor:pointer;padding:0.75rem;margin-top:0.5rem;font-size:0.875rem;font-family:inherit;">← Go back</button>';
                        }
                        echo '</form>';
                    }

                    echo '</div>'; // close .step
                endforeach; ?>
                </div><!-- /slider -->
            </div><!-- /outer -->
        </div><!-- /card shell -->
    </div>
</div>
<script>
(function(){
    var uid     = '<?= $uid ?>';
    var cur     = 0;
    var total   = <?= (int)$total ?>;
    var answers = {};
    var acc     = '<?= esc_js($accent) ?>';
    var ajaxUrl = '<?= esc_js($ajax) ?>';
    var surl    = '<?= $surl ?>';
    var sTxt    = '<?= $submit_txt ?>';

    var wrap   = document.getElementById(uid+'-wrap');
    var outer  = document.getElementById(uid+'-outer');
    var slider = document.getElementById(uid+'-slider');
    var steps  = Array.from(document.querySelectorAll('.'+uid+'-step'));

    function setH(){ outer.style.height = steps[cur].offsetHeight+'px'; }
    slider.addEventListener('transitionend', function(e){ if(e.target===slider) setH(); });
    window.addEventListener('resize', function(){
        slider.style.transition='none';
        slider.style.transform='translateX(-'+(cur*100)+'%)';
        setTimeout(function(){ slider.style.transition=''; setH(); }, 10);
    });

    function goTo(n){
        if(n<0||n>=total) return;
        cur=n;
        slider.style.transform='translateX(-'+(cur*100)+'%)';
        updateProg();
        wrap.scrollIntoView({behavior:'smooth',block:'start'});
    }

    function updateProg(){
        var bar=document.getElementById(uid+'-prog-bar');
        var ctr=document.getElementById(uid+'-counter');
        if(cur===0){ if(bar) bar.style.width='0%'; if(ctr) ctr.textContent=''; return; }
        var pct=Math.round((cur/(total-1))*100);
        if(bar) bar.style.width=pct+'%';
        if(ctr) ctr.textContent='Step '+cur+' of '+(total-1);
    }

    window[uid+'go']  = goTo;

    window[uid+'yn'] = function(card){
        var step=card.closest('.'+uid+'-step');
        var key=step.dataset.key;
        step.querySelectorAll('.'+uid+'-card').forEach(function(c){ c.classList.remove('alg-sel'); });
        card.classList.add('alg-sel');
        if(key) answers[key]=card.dataset.value;
        setTimeout(function(){ goTo(cur+1); }, 360);
    };

    window[uid+'img'] = function(card){
        var step=card.closest('.'+uid+'-step');
        var key=step.dataset.key;
        step.querySelectorAll('.'+uid+'-card').forEach(function(c){ c.classList.remove('alg-sel'); });
        card.classList.add('alg-sel');
        if(key) answers[key]=card.dataset.value;
        setTimeout(function(){ goTo(cur+1); }, 400);
    };

    var form=document.getElementById(uid+'-form');
    if(form){
        form.addEventListener('submit',function(e){
            e.preventDefault();
            var fn=(form.querySelector('[name="firstName"]')||{}).value||'';
            var ln=(form.querySelector('[name="lastName"]') ||{}).value||'';
            var ph=(form.querySelector('[name="phone"]')    ||{}).value||'';
            var em=(form.querySelector('[name="email"]')    ||{}).value||'';
            var errBox=document.getElementById(uid+'-err');
            var sbtn=document.getElementById(uid+'-sbtn');
            var slbl=document.getElementById(uid+'-slbl');
            function showErr(m){ errBox.textContent=m; errBox.style.display='block'; }
            errBox.style.display='none';
            if(!fn.trim()){ showErr('First name is required.'); return; }
            if(!ln.trim()){ showErr('Last name is required.'); return; }
            if(!ph.trim()){ showErr('Phone number is required.'); return; }
            if(!em.trim()){ showErr('Please enter your email address.'); return; }
            var ansEl=document.getElementById(uid+'-ans');
            if(ansEl) ansEl.value=JSON.stringify(answers);
            sbtn.disabled=true; slbl.textContent='Sending\u2026';
            var _up=new URLSearchParams(window.location.search);
            var _fd=new FormData(form);
            ['utm_campaign','utm_medium','utm_content','utm_keyword','gclid'].forEach(function(k){ _fd.append(k,_up.get(k)||''); });
            fetch(ajaxUrl,{method:'POST',body:_fd})
            .then(function(r){ return r.json(); })
            .then(function(res){
                if(res.success){
                    if(surl){ window.location.href=surl; }
                    else{
                        form.innerHTML='<div style="text-align:center;padding:2.5rem 0;">'+
                            '<div style="font-size:3.5rem;margin-bottom:1rem;">&#x2705;</div>'+
                            '<h3 style="color:'+acc+';margin:0 0 0.75rem;font-size:1.5rem;">Thank you!</h3>'+
                            '<p style="color:#6b7280;margin:0;font-size:0.95rem;">We\'ll be in touch shortly with your estimate.</p>'+
                            '</div>';
                    }
                } else {
                    showErr(res.data||'Something went wrong. Please try again.');
                    sbtn.disabled=false; slbl.textContent=sTxt;
                }
            })
            .catch(function(){
                showErr('Connection error. Please call us directly.');
                sbtn.disabled=false; slbl.textContent=sTxt;
            });
        });
    }

    setH();
    updateProg();
})();
</script>
    <?php
    return ob_get_clean();
}

// Helper: nav buttons for yesno/image steps
function cfg_alg_nav( $uid, $i, $accent ) {
    $html = '<div style="display:flex;justify-content:' . ( $i > 0 ? 'space-between' : 'flex-end' ) . ';align-items:center;margin-top:0.5rem;">';
    if ( $i > 0 ) {
        $html .= '<button class="' . $uid . '-ghost" style="padding:0.625rem 1.35rem;font-size:0.875rem;" onclick="' . $uid . 'go(' . ( $i - 1 ) . ')">← Back</button>';
    }
    $html .= '<button class="' . $uid . '-btn" style="padding:0.625rem 1.5rem;font-size:0.875rem;" onclick="' . $uid . 'go(' . ( $i + 1 ) . ')">Next →</button>';
    $html .= '</div>';
    return $html;
}

// ═══════════════════════════════════════════════════════════════
//  ALIGNER QUIZ — AJAX SUBMIT
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_ajax_cfg_aligner_submit',        'cfg_aligner_ajax_submit' );
add_action( 'wp_ajax_nopriv_cfg_aligner_submit', 'cfg_aligner_ajax_submit' );

function cfg_aligner_ajax_submit() {
    if ( ! isset( $_POST['alg_nonce'] ) || ! wp_verify_nonce( $_POST['alg_nonce'], 'cfg_aligner_submit' ) ) {
        wp_send_json_error( 'Security check failed. Please refresh and try again.' );
    }

    $s = cfg_get();

    // Honeypot
    if ( $s['spam_honeypot'] === '1' && ! empty( $_POST['alg_hp'] ) ) {
        wp_send_json_error( 'Submission blocked.' );
    }

    // Sanitise
    $first = sanitize_text_field( $_POST['firstName'] ?? '' );
    $last  = sanitize_text_field( $_POST['lastName']  ?? '' );
    $phone = sanitize_text_field( $_POST['phone']     ?? '' );
    $email = sanitize_email(      $_POST['email']     ?? '' );

    if ( empty( $first ) ) wp_send_json_error( 'First name is required.' );
    if ( empty( $last ) )  wp_send_json_error( 'Last name is required.' );
    if ( empty( $phone ) ) wp_send_json_error( 'Phone number is required.' );
    if ( ! is_email( $email ) ) wp_send_json_error( 'A valid email address is required.' );

    if ( empty( $s['ghl_api_key'] ) || empty( $s['ghl_location_id'] ) ) {
        wp_send_json_error( 'Form is not fully configured. Please contact us directly.' );
    }

    // Quiz answers
    $ans_raw = sanitize_text_field( $_POST['alg_answers'] ?? '' );
    $answers = json_decode( wp_unslash( $ans_raw ), true ) ?: [];

    // Tags: one per answer + base tags
    $tags = [ 'aligner-quiz', 'website-lead' ];
    foreach ( $answers as $key => $val ) {
        $tags[] = sanitize_title( $key . '-' . $val );
    }

    // Custom fields
    $custom = [];
    foreach ( $answers as $key => $val ) {
        $custom[] = [ 'key' => sanitize_key( $key ), 'field_value' => sanitize_text_field( $val ) ];
    }
    foreach ( [ 'utm_campaign', 'utm_medium', 'utm_content', 'utm_keyword', 'gclid' ] as $utm_key ) {
        $val = sanitize_text_field( $_POST[ $utm_key ] ?? '' );
        if ( $val !== '' ) $custom[] = [ 'key' => $utm_key, 'field_value' => $val ];
    }

    $payload = [
        'firstName'  => $first,
        'lastName'   => $last,
        'email'      => $email,
        'phone'      => $phone,
        'locationId' => $s['ghl_location_id'],
        'source'     => 'Aligner Quiz Form',
        'tags'       => $tags,
    ];
    if ( $custom ) $payload['customFields'] = $custom;

    $response = wp_remote_post( 'https://services.leadconnectorhq.com/contacts/upsert', [
        'headers' => [
            'Authorization' => 'Bearer ' . $s['ghl_api_key'],
            'Content-Type'  => 'application/json',
            'Version'       => '2021-07-28',
        ],
        'body'    => wp_json_encode( $payload ),
        'timeout' => 15,
    ] );

    if ( is_wp_error( $response ) ) {
        wp_send_json_error( 'Could not reach the CRM. Please try again.' );
    }

    $code = wp_remote_retrieve_response_code( $response );
    $body = json_decode( wp_remote_retrieve_body( $response ), true );

    if ( $code === 200 || $code === 201 ) {
        wp_send_json_success( 'Contact created.' );
    } else {
        $msg = $body['message'] ?? ( 'Unexpected error (HTTP ' . $code . ').' );
        error_log( '[CFG Aligner] GHL error ' . $code . ': ' . wp_json_encode( $body ) );
        wp_send_json_error( $msg );
    }
}

// ═══════════════════════════════════════════════════════════════
//  IMPLANT ESTIMATOR — SHORTCODE [implant_estimator_ghl]
// ═══════════════════════════════════════════════════════════════
function cfg_imp_hex_to_hsl( $hex ) {
    $hex = ltrim( $hex, '#' );
    if ( strlen( $hex ) === 3 ) { $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2]; }
    $r = hexdec( substr($hex,0,2) ) / 255;
    $g = hexdec( substr($hex,2,2) ) / 255;
    $b = hexdec( substr($hex,4,2) ) / 255;
    $max = max($r,$g,$b); $min = min($r,$g,$b);
    $l   = ($max+$min)/2; $d = $max-$min;
    if ( $d == 0 ) { $h = 0; $s = 0; }
    else {
        $s = $d / (1 - abs(2*$l-1));
        switch ($max) {
            case $r: $h = 60 * fmod(($g-$b)/$d,6); break;
            case $g: $h = 60 * (($b-$r)/$d+2);     break;
            default: $h = 60 * (($r-$g)/$d+4);     break;
        }
        if ($h<0) $h += 360;
    }
    return round($h).' '.round($s*100).'% '.round($l*100).'%';
}

function cfg_imp_sidebar( $uid ) {
    return
      '<div id="'.esc_attr($uid).'-sidebar" style="display:flex;flex-direction:column;gap:1rem;flex-shrink:0;">'
     .'<div style="padding:1rem;border:1px solid hsl(var(--border));border-radius:.75rem;background:hsl(var(--card));">'
     .'<div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.75rem;">'
     .'<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));flex-shrink:0;"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>'
     .'<p style="font-family:Inter,sans-serif;font-size:.7rem;font-weight:500;color:hsl(var(--muted-foreground));text-transform:uppercase;letter-spacing:.05em;">Your Estimate Profile</p>'
     .'</div>'
     .'<div id="'.esc_attr($uid).'-sidebar-tags" class="imp-st-'.esc_attr($uid).'" style="display:flex;flex-wrap:wrap;gap:.375rem;">'
     .'<p style="color:hsl(var(--muted-foreground)/.6);font-size:.8rem;font-family:Inter,sans-serif;">Select your answers to build your estimate</p>'
     .'</div></div>'
     .'<div style="padding:1rem;border:1px solid hsl(var(--border));border-radius:.75rem;background:hsl(var(--card));position:relative;overflow:hidden;">'
     .'<div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.75rem;">'
     .'<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));flex-shrink:0;"><polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/></svg>'
     .'<p style="font-family:Inter,sans-serif;font-size:.7rem;font-weight:500;color:hsl(var(--muted-foreground));text-transform:uppercase;letter-spacing:.05em;">Likely Treatment Range</p>'
     .'</div>'
     .'<div id="'.esc_attr($uid).'-range-blur" class="imp-range-blurred" style="user-select:none;-webkit-user-select:none;">'
     .'<p id="'.esc_attr($uid).'-sidebar-range" class="imp-sr-'.esc_attr($uid).'" style="font-family:\'Cormorant Garamond\',serif;font-weight:700;font-size:1.5rem;line-height:1;color:hsl(var(--muted-foreground)/.3);">$5,000 – $7,500</p>'
     .'</div>'
     .'<div style="margin-top:.75rem;">'
     .'<div style="background:hsl(var(--secondary));border-radius:9999px;height:.25rem;overflow:hidden;">'
     .'<div id="'.esc_attr($uid).'-range-bar" class="imp-rb-'.esc_attr($uid).'" style="background:hsl(var(--primary)/.6);border-radius:9999px;height:100%;width:5%;transition:width .6s ease;"></div>'
     .'</div>'
     .'<p style="margin-top:.5rem;font-family:Inter,sans-serif;font-size:.72rem;color:hsl(var(--muted-foreground));">Range becomes more precise as you answer</p>'
     .'</div></div></div>';
}

add_shortcode( 'implant_estimator_ghl', 'cfg_implant_shortcode' );

function cfg_implant_shortcode() {
    $s           = cfg_get();
    $accent      = sanitize_hex_color( $s['imp_accent_color'] ?? '#1e3a5f' ) ?: '#1e3a5f';
    $uid         = 'imp' . wp_rand( 1000, 9999 );
    $nonce       = wp_create_nonce( 'cfg_implant_submit' );
    $ajax_url    = esc_url( admin_url( 'admin-ajax.php' ) );
    $surl        = esc_js( $s['imp_success_url'] ?? '' );
    $honeypot    = $s['spam_honeypot'] === '1';
    $show_arch   = $s['imp_show_full_arch'] === '1';
    $show_fin    = $s['imp_show_financing'] === '1';
    $currency    = $s['imp_currency'] ?? '$';
    $primary_hsl      = cfg_imp_hex_to_hsl( $accent );
    $pfg_hsl          = '0 0% 100%';
    $hide_header      = $s['imp_hide_header']    === '1';
    $show_price       = $s['imp_show_price']    !== '0';
    $show_insurance   = $s['imp_show_insurance'] !== '0';
    $no_price_title   = $s['imp_no_price_title']    ?? 'Your Estimate Is Ready';
    $no_price_sub     = $s['imp_no_price_subtitle'] ?? 'Book a free consultation and our team will walk you through your personalised treatment options and costs.';
    $no_price_btn     = $s['imp_no_price_btn']      ?? 'Book My Free Consultation';
    $prices_json = wp_json_encode([
        'single_min' => (int)($s['imp_single_min'] ?? 3000),
        'single_max' => (int)($s['imp_single_max'] ?? 6000),
        'multi_min'  => (int)($s['imp_multi_min']  ?? 5000),
        'multi_max'  => (int)($s['imp_multi_max']  ?? 20000),
        'arch_min'   => (int)($s['imp_arch_min']   ?? 24000),
        'arch_max'   => (int)($s['imp_arch_max']   ?? 30000),
        'graft_min'  => (int)($s['imp_graft_min']  ?? 650),
        'graft_max'  => (int)($s['imp_graft_max']  ?? 1100),
    ]);

    // Option button helper — fixed internal $val for logic, $label for display
    $opt = function( $key, $val, $label, $next, $sub = '' ) use ( $uid ) {
        $sub_html = $sub
            ? '<span style="display:block;margin-top:.125rem;font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.7);font-size:.75rem;">' . esc_html($sub) . '</span>'
            : '';
        return '<button class="option-btn" style="background:hsl(var(--card));padding:1.1rem 1.5rem;border:2px solid hsl(var(--border));border-radius:.75rem;width:100%;text-align:left;cursor:pointer;"'
             . ' onclick="' . esc_attr($uid) . 'Sel(this,\'' . esc_js($key) . '\',\'' . esc_js($val) . '\',\'' . esc_js($label) . '\',\'' . esc_js($next) . '\')">'
             . '<span style="font-family:Inter,sans-serif;font-weight:600;color:hsl(var(--foreground));font-size:.875rem;">' . esc_html($label) . '</span>'
             . $sub_html . '</button>';
    };

    $back_btn = '<button onclick="' . esc_attr($uid) . 'Back()" style="display:inline-flex;align-items:center;gap:.375rem;margin-bottom:1.5rem;font-family:Inter,sans-serif;font-size:.875rem;color:hsl(var(--muted-foreground));background:none;border:none;cursor:pointer;padding:0;">'
              . '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg> Go back</button>';

    $sidebar = cfg_imp_sidebar( $uid );

    $qpanel = function( $id, $q, $sub, $opts_html ) use ( $uid, $back_btn, $sidebar ) {
        return '<div class="die-panel" id="' . esc_attr($uid) . '-panel-' . esc_attr($id) . '">'
             . '<main style="display:flex;flex-direction:column;flex:1;">'
             . '<div style="flex:1;margin:0 auto;padding:2rem 1.5rem;width:100%;max-width:64rem;box-sizing:border-box;">'
             . $back_btn
             . '<div class="imp-q-row" style="display:flex;flex-direction:column;gap:1.5rem;">'
             . '<div style="flex:1;min-width:0;">'
             . '<div class="die-question-card" style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;padding:2rem 2rem 2.5rem;box-shadow:0 1px 3px rgba(0,0,0,.06);position:relative;">'
             . '<h2 style="font-family:\'Cormorant Garamond\',serif;font-weight:600;color:hsl(var(--foreground));font-size:clamp(1.5rem,3vw,2rem);line-height:1.3;margin:0 0 .625rem;">' . esc_html($q) . '</h2>'
             . '<p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.875rem;margin:0 0 2rem;">' . esc_html($sub) . '</p>'
             . '<div style="display:flex;flex-direction:column;gap:.75rem;">' . $opts_html . '</div>'
             . '</div></div>'
             . $sidebar
             . '</div></div></main></div>';
    };

    ob_start();
?><style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap');
<?php if($hide_header): ?>
header,#header,.header,#site-header,.site-header,#masthead,.masthead,
.navbar,.nav-bar,.navigation,nav.main-nav,#main-nav,.main-navigation,
#page-header,.page-header,.header-wrapper,.site-header-wrapper,
.header-container,.top-header{display:none!important;}
<?php endif; ?>
#<?= $uid ?>-app{--background:40 20% 97%;--foreground:200 10% 20%;--card:0 0% 100%;--card-foreground:200 10% 20%;--primary:<?= esc_attr($primary_hsl) ?>;--primary-foreground:<?= esc_attr($pfg_hsl) ?>;--secondary:40 18% 93%;--muted:40 12% 94%;--muted-foreground:200 8% 46%;--accent:100 10% 90%;--accent-foreground:100 14% 38%;--border:40 14% 88%;font-family:Inter,sans-serif;background-color:hsl(var(--background));color:hsl(var(--foreground));line-height:1.5;-webkit-font-smoothing:antialiased;margin:0 auto;}
#<?= $uid ?>-app *,#<?= $uid ?>-app *::before,#<?= $uid ?>-app *::after{box-sizing:border-box;border-width:0;border-style:solid;border-color:hsl(var(--border));}
#<?= $uid ?>-app h1,#<?= $uid ?>-app h2,#<?= $uid ?>-app h3,#<?= $uid ?>-app h4{font-size:inherit;font-weight:inherit;margin:0;}
#<?= $uid ?>-app p{margin:0;}
#<?= $uid ?>-app ul{list-style:none;margin:0;padding:0;}
#<?= $uid ?>-app button{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0;background:transparent;-webkit-appearance:button;cursor:pointer;border:none;}
#<?= $uid ?>-app input{font-family:inherit;font-size:100%;font-weight:inherit;color:inherit;margin:0;padding:0;}
#<?= $uid ?>-app svg{display:block;vertical-align:middle;}
#<?= $uid ?>-app a{color:inherit;text-decoration:inherit;}
/* Panel system */
#<?= $uid ?>-app .die-panel{display:none;flex-direction:column;min-height:100vh;}
#<?= $uid ?>-app .die-panel.die-panel-active{display:flex;animation:<?= $uid ?>_panelIn 0.35s ease forwards;}
@keyframes <?= $uid ?>_panelIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
/* Option buttons */
#<?= $uid ?>-app .option-btn{transition:border-color .2s,background .2s,box-shadow .2s;}
#<?= $uid ?>-app .option-btn.selected{border-color:hsl(var(--primary))!important;background-color:hsl(var(--accent)/.6)!important;}
#<?= $uid ?>-app .option-btn:hover:not(.selected){border-color:hsl(var(--primary)/.5);background:hsl(var(--accent)/.6);box-shadow:0 2px 8px rgba(0,0,0,.06);}
/* CTA button */
#<?= $uid ?>-app .imp-cta-btn{display:inline-flex;align-items:center;gap:.625rem;padding:1.1rem 2.75rem;background:hsl(var(--primary));color:hsl(var(--primary-foreground));border-radius:.5rem;font-family:Inter,sans-serif;font-size:1rem;font-weight:500;letter-spacing:.02em;border:none;cursor:pointer;transition:background .2s,box-shadow .2s,transform .15s;box-shadow:0 2px 8px hsl(var(--primary)/.25);}
#<?= $uid ?>-app .imp-cta-btn:hover{background:hsl(var(--primary)/.85);box-shadow:0 6px 20px hsl(var(--primary)/.35);transform:translateY(-1px);}
#<?= $uid ?>-app .imp-cta-btn:active{transform:translateY(0);box-shadow:0 2px 8px hsl(var(--primary)/.25);}
/* Spinner */
@keyframes <?= $uid ?>_spin{to{transform:rotate(360deg)}}
#<?= $uid ?>-app .die-spinner{animation:<?= $uid ?>_spin 1s linear infinite;transform-origin:center;}
/* Pulse */
@keyframes <?= $uid ?>_pulse{0%,100%{opacity:1}50%{opacity:.3}}
#<?= $uid ?>-app .die-pulse-dot{display:inline-block;width:.5rem;height:.5rem;border-radius:9999px;background:hsl(var(--primary));animation:<?= $uid ?>_pulse 2s cubic-bezier(.4,0,.6,1) infinite;}
/* Sidebar blur */
#<?= $uid ?>-app .imp-range-blurred{filter:blur(8px);transition:filter .6s ease;user-select:none;-webkit-user-select:none;}
/* Inputs */
#<?= $uid ?>-app .imp-input{width:100%;padding:.875rem 1rem;border:1px solid hsl(var(--border));border-radius:.75rem;font-size:.875rem;outline:none;transition:border-color .2s,box-shadow .2s;background:hsl(var(--card));color:hsl(var(--foreground));}
#<?= $uid ?>-app .imp-input:focus{border-color:hsl(var(--primary));box-shadow:0 0 0 3px hsl(var(--primary)/.12);}
/* Reveal button */
#<?= $uid ?>-reveal-btn:not(:disabled){cursor:pointer;opacity:1!important;}
#<?= $uid ?>-reveal-btn:not(:disabled):hover{<?= $s['btn_hover_bg_color'] ? 'background:' . esc_attr( $s['btn_hover_bg_color'] ) . '!important;' . ( $s['btn_hover_text_color'] ? 'color:' . esc_attr( $s['btn_hover_text_color'] ) . '!important;' : '' ) : 'background:hsl(var(--primary)/.85)!important;box-shadow:0 6px 20px hsl(var(--primary)/.3)!important;' ?>}
/* Intro layout */
#<?= $uid ?>-intro-cols{display:flex;flex-direction:column;gap:2.5rem;width:100%;}
#<?= $uid ?>-intro-left{flex:1;min-width:0;display:flex;flex-direction:column;justify-content:center;}
#<?= $uid ?>-intro-card{width:100%;flex-shrink:0;}
/* Question row */
#<?= $uid ?>-app .imp-q-row{display:flex;flex-direction:column;gap:1.5rem;}
/* Sidebar */
#<?= $uid ?>-sidebar{display:flex;flex-direction:column;gap:1rem;width:100%;flex-shrink:0;}
/* Responsive */
@media(min-width:640px){
  #<?= $uid ?>-app .sm-flex-row{flex-direction:row!important;}
}
@media(min-width:1024px){
  #<?= $uid ?>-intro-cols{flex-direction:row;align-items:center;}
  #<?= $uid ?>-intro-card{width:22rem;}
  #<?= $uid ?>-app .imp-q-row{flex-direction:row!important;}
  #<?= $uid ?>-sidebar{width:18rem!important;}
}
</style>

<div id="<?= $uid ?>-app">

<!-- STEP PROGRESS BAR -->
<div style="position:sticky;top:0;z-index:50;background:hsl(var(--background)/.96);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);border-bottom:1px solid hsl(var(--border));padding:.625rem 1rem;">
  <div style="max-width:64rem;margin:0 auto;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.3rem;">
      <span id="<?= $uid ?>-step-label" style="font-family:Inter,sans-serif;font-weight:500;color:hsl(var(--muted-foreground));font-size:.75rem;letter-spacing:.025em;">Get Started</span>
      <span style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.5);font-size:.75rem;">Free &middot; No Obligation</span>
    </div>
    <div style="background:hsl(var(--secondary));border-radius:9999px;width:100%;overflow:hidden;height:.3rem;">
      <div id="<?= $uid ?>-step-progress" style="background:hsl(var(--primary));border-radius:9999px;height:100%;width:5%;transition:width 0.55s cubic-bezier(0.4,0,0.2,1);"></div>
    </div>
  </div>
</div>

<div id="<?= $uid ?>-panels">

<!-- INTRO -->
<div class="die-panel" id="<?= $uid ?>-panel-intro">
  <main style="display:flex;flex-direction:column;flex:1;min-height:calc(100vh - 53px);">
    <div style="flex:1;margin:0 auto;padding:2.5rem 1.5rem;width:100%;max-width:64rem;display:flex;align-items:center;box-sizing:border-box;">
      <div id="<?= $uid ?>-intro-cols">
        <div id="<?= $uid ?>-intro-left">
          <div style="display:inline-flex;align-items:center;gap:.5rem;background:hsl(var(--accent)/.6);padding:.375rem 1rem;border:1px solid hsl(var(--border));border-radius:9999px;font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.75rem;align-self:flex-start;margin-bottom:1.5rem;">
            <span class="die-pulse-dot"></span>
            <?= esc_html( $s['imp_intro_title'] ) ?>
          </div>
          <h1 style="font-family:'Cormorant Garamond',serif;font-weight:600;color:hsl(var(--foreground));font-size:clamp(2rem,4vw,3rem);line-height:1.15;margin:0 0 1rem;">
            <?= nl2br( esc_html( $s['imp_intro_heading'] ) ) ?>
          </h1>
          <p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:1rem;line-height:1.65;margin:0 0 2rem;max-width:26rem;">
            <?= esc_html( $s['imp_intro_subtitle'] ) ?>
          </p>
          <div>
            <button onclick="<?= $uid ?>Nav('router')" class="imp-cta-btn">
              <?= esc_html( $s['imp_intro_btn'] ) ?>
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
            <p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.75rem;margin-top:.75rem;opacity:.5;">Personalized based on your answers &nbsp;&middot;&nbsp; Free &nbsp;&middot;&nbsp; No obligation</p>
          </div>
        </div>
        <div id="<?= $uid ?>-intro-card">
          <div style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;box-shadow:0 1px 6px rgba(0,0,0,.06);overflow:hidden;">
            <div style="padding:1rem 1.25rem;background:hsl(var(--accent)/.35);border-bottom:1px solid hsl(var(--border));">
              <p style="font-family:Inter,sans-serif;font-weight:600;color:hsl(var(--foreground));font-size:.875rem;">Your Estimate Preview</p>
              <p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.75rem;margin-top:.125rem;">Factors we'll consider</p>
            </div>
            <div style="padding:1.25rem;display:flex;flex-direction:column;gap:1rem;">
              <?php
              $preview_items = [
                ['Your current situation',        'Missing, needs extraction, or replacing a denture'],
                ['Number of teeth needing care',  'Single implant, multiple, or full arch solution'],
                ['Bone health at the site',        'Whether a graft may be required'],
              ];
              foreach ( $preview_items as $pi ) : ?>
              <div style="display:flex;align-items:flex-start;gap:.75rem;">
                <div style="width:1.375rem;height:1.375rem;border-radius:9999px;flex-shrink:0;margin-top:.125rem;display:flex;align-items:center;justify-content:center;background:hsl(var(--primary)/.12);border:1px solid hsl(var(--border));">
                  <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="stroke:hsl(var(--primary));"><polyline points="20 6 9 13 4 10"/></svg>
                </div>
                <div>
                  <p style="font-family:Inter,sans-serif;font-weight:500;color:hsl(var(--foreground));font-size:.875rem;"><?= esc_html($pi[0]) ?></p>
                  <p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.75rem;margin-top:.2rem;"><?= esc_html($pi[1]) ?></p>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <div style="padding:.75rem 1.25rem;background:hsl(var(--accent)/.25);border-top:1px solid hsl(var(--border));display:flex;align-items:center;gap:.5rem;">
              <span class="die-pulse-dot"></span>
              <p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.75rem;">Estimate accuracy improves with each step</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<?php
// ── insurance next helper ──
$ins_next = $show_insurance ? 'ins' : 'summary';
?>

<!-- ROUTER -->
<?php
$router_opts = $opt( 'router', 'single',   $s['imp_router_opt1'], 'a1', $s['imp_router_opt1_sub'] )
             . $opt( 'router', 'multiple',  $s['imp_router_opt2'], 'm1', $s['imp_router_opt2_sub'] );
if ( $show_arch ) {
    $router_opts .= $opt( 'router', 'fullarch', $s['imp_router_opt3'], 'b1', $s['imp_router_opt3_sub'] );
}
echo $qpanel( 'router', $s['imp_router_title'], $s['imp_router_sub'], $router_opts );
?>

<!-- SINGLE-TOOTH FLOW -->
<?php echo $qpanel( 'a1', $s['imp_a1_title'], 'Location affects restoration complexity and the materials used.',
    $opt('toothLocation','front',    $s['imp_a1_opt1'], 'a2', $s['imp_a1_opt1_sub'])
  . $opt('toothLocation','back',     $s['imp_a1_opt2'], 'a2', $s['imp_a1_opt2_sub'])
  . $opt('toothLocation','not-sure', $s['imp_a1_opt3'], 'a2', $s['imp_a1_opt3_sub'])
); ?>

<?php echo $qpanel( 'a2', $s['imp_a2_title'], 'This helps us assess potential bone changes at the site.',
    $opt('timeMissing','under-6mo', $s['imp_a2_opt1'], 'a3')
  . $opt('timeMissing','6-12mo',   $s['imp_a2_opt2'], 'a3')
  . $opt('timeMissing','1-3yr',    $s['imp_a2_opt3'], 'a3')
  . $opt('timeMissing','3yr+',     $s['imp_a2_opt4'], 'a3')
  . $opt('timeMissing','not-sure', $s['imp_a2_opt5'], 'a3')
); ?>

<?php echo $qpanel( 'a3', $s['imp_a3_title'], 'This can affect your treatment plan and overall timeline.',
    $opt('boneGraft','yes',      $s['imp_a3_opt1'], 'a4')
  . $opt('boneGraft','no',       $s['imp_a3_opt2'], 'a4')
  . $opt('boneGraft','not-sure', $s['imp_a3_opt3'], 'a4')
); ?>

<?php echo $qpanel( 'a4', $s['imp_a4_title'], 'This helps us tailor your estimate to your current needs.',
    $opt('situationSingle','already-missing', $s['imp_a4_opt1'], $ins_next)
  . $opt('situationSingle','needs-removal',   $s['imp_a4_opt2'], $ins_next)
  . $opt('situationSingle','bridge-crown',    $s['imp_a4_opt3'], $ins_next)
  . $opt('situationSingle','not-sure',        $s['imp_a4_opt4'], $ins_next)
); ?>

<!-- MULTIPLE-TEETH FLOW -->
<?php echo $qpanel( 'm1', $s['imp_m1_title'], "We'll use this to calculate your personalized range.",
    $opt('teethCount','2',     $s['imp_m1_opt1'], 'm2')
  . $opt('teethCount','3',     $s['imp_m1_opt2'], 'm2')
  . $opt('teethCount','4',     $s['imp_m1_opt3'], 'm2')
  . $opt('teethCount','5plus', $s['imp_m1_opt4'], 'm2')
); ?>

<?php echo $qpanel( 'm2', $s['imp_m2_title'], 'Location affects restoration complexity and materials.',
    $opt('teethLocation','front',    $s['imp_m2_opt1'], 'm3', $s['imp_m2_opt1_sub'])
  . $opt('teethLocation','back',     $s['imp_m2_opt2'], 'm3', $s['imp_m2_opt2_sub'])
  . $opt('teethLocation','both',     $s['imp_m2_opt3'], 'm3', $s['imp_m2_opt3_sub'])
  . $opt('teethLocation','not-sure', $s['imp_m2_opt4'], 'm3', $s['imp_m2_opt4_sub'])
); ?>

<?php echo $qpanel( 'm3', $s['imp_m3_title'], 'This helps us assess potential bone changes at the sites.',
    $opt('timeMissingMult','under-6mo', $s['imp_m3_opt1'], 'm4')
  . $opt('timeMissingMult','6-12mo',   $s['imp_m3_opt2'], 'm4')
  . $opt('timeMissingMult','1-3yr',    $s['imp_m3_opt3'], 'm4')
  . $opt('timeMissingMult','3yr+',     $s['imp_m3_opt4'], 'm4')
  . $opt('timeMissingMult','not-sure', $s['imp_m3_opt5'], 'm4')
); ?>

<?php echo $qpanel( 'm4', $s['imp_m4_title'], 'This can affect your treatment plan and overall timeline.',
    $opt('boneGraftMult','yes',      $s['imp_m4_opt1'], 'm5')
  . $opt('boneGraftMult','no',       $s['imp_m4_opt2'], 'm5')
  . $opt('boneGraftMult','not-sure', $s['imp_m4_opt3'], 'm5')
); ?>

<?php echo $qpanel( 'm5', $s['imp_m5_title'], 'This helps us tailor your estimate to your current needs.',
    $opt('situationMult','already-missing', $s['imp_m5_opt1'], $ins_next)
  . $opt('situationMult','needs-removal',   $s['imp_m5_opt2'], $ins_next)
  . $opt('situationMult','bridge-crown',    $s['imp_m5_opt3'], $ins_next)
  . $opt('situationMult','not-sure',        $s['imp_m5_opt4'], $ins_next)
); ?>

<!-- FULL-ARCH FLOW -->
<?php echo $qpanel( 'b1', $s['imp_b1_title'], 'Upper, lower, or both — this shapes your treatment overview.',
    $opt('archSelection','upper', $s['imp_b1_opt1'], 'b2', $s['imp_b1_opt1_sub'])
  . $opt('archSelection','lower', $s['imp_b1_opt2'], 'b2', $s['imp_b1_opt2_sub'])
  . $opt('archSelection','both',  $s['imp_b1_opt3'], 'b2', $s['imp_b1_opt3_sub'])
); ?>

<?php echo $qpanel( 'b2', $s['imp_b2_title'], 'This helps us understand your starting point.',
    $opt('situationArch','wearing-denture', $s['imp_b2_opt1'], 'b3')
  . $opt('situationArch','failing-teeth',   $s['imp_b2_opt2'], 'b3')
  . $opt('situationArch','beyond-repair',   $s['imp_b2_opt3'], 'b3')
  . $opt('situationArch','not-sure',        $s['imp_b2_opt4'], 'b3')
); ?>

<?php echo $qpanel( 'b3', $s['imp_b3_title'], 'Duration helps determine bone volume and treatment complexity.',
    $opt('archDuration','under-1yr', $s['imp_b3_opt1'], 'summary')
  . $opt('archDuration','1-5yr',     $s['imp_b3_opt2'], 'summary')
  . $opt('archDuration','5yr+',      $s['imp_b3_opt3'], 'summary')
); ?>

<!-- INSURANCE -->
<?php if ( $show_insurance ) :
echo $qpanel( 'ins', $s['imp_ins_title'], 'Insurance can reduce your out-of-pocket cost.',
    $opt('insurance','yes', $s['imp_ins_opt1'], 'summary')
  . $opt('insurance','no',  $s['imp_ins_opt2'], 'summary')
);
endif; ?>

<!-- SUMMARY -->
<div class="die-panel" id="<?= $uid ?>-panel-summary">
  <main style="display:flex;flex-direction:column;flex:1;">
    <div style="flex:1;margin:0 auto;padding:1.5rem 1rem;width:100%;max-width:64rem;box-sizing:border-box;">
      <?= $back_btn ?>
      <div class="imp-q-row" style="display:flex;flex-direction:column;gap:1.5rem;">
        <div style="flex:1;min-width:0;">
          <div style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;padding:1.25rem 1.5rem 1.5rem;box-shadow:0 1px 3px rgba(0,0,0,.06);">
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.5rem;">
              <div style="width:2.75rem;height:2.75rem;border-radius:9999px;background:hsl(var(--primary)/.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              </div>
              <h2 style="font-family:'Cormorant Garamond',serif;font-weight:600;color:hsl(var(--foreground));font-size:1.5rem;line-height:1.3;">Your estimate is almost ready</h2>
            </div>
            <p style="font-family:Inter,sans-serif;font-weight:500;color:hsl(var(--foreground));font-size:.875rem;margin:0 0 .75rem;">What we factored in</p>
            <div id="<?= $uid ?>-summary-list" style="display:flex;flex-direction:column;gap:.625rem;margin-bottom:1.25rem;"></div>
            <p id="<?= $uid ?>-summary-desc" style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.875rem;padding:1rem;background:hsl(var(--accent)/.4);border-radius:.75rem;margin-bottom:1.5rem;"></p>
            <button onclick="<?= $uid ?>Nav('lead')" style="display:inline-flex;justify-content:center;align-items:center;gap:.5rem;background:hsl(var(--primary));color:hsl(var(--primary-foreground));padding:1rem 2rem;border-radius:.5rem;width:100%;font-family:Inter,sans-serif;font-weight:500;font-size:1rem;letter-spacing:.025em;cursor:pointer;transition:box-shadow .2s;border:none;">
              Continue to My Estimate
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
            <div style="margin-top:1rem;text-align:center;">
              <button onclick="<?= $uid ?>Back()" style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.875rem;background:none;border:none;cursor:pointer;text-decoration:underline;text-underline-offset:2px;">Go back</button>
            </div>
          </div>
        </div>
        <?= $sidebar ?>
      </div>
    </div>
  </main>
</div>

<!-- LEAD CAPTURE -->
<div class="die-panel" id="<?= $uid ?>-panel-lead">
  <main style="display:flex;flex-direction:column;flex:1;">
    <div style="flex:1;margin:0 auto;padding:1.5rem 1rem;width:100%;max-width:64rem;box-sizing:border-box;">
      <?= $back_btn ?>
      <div class="imp-q-row" style="display:flex;flex-direction:column;gap:1.5rem;">
        <div style="flex:1;min-width:0;">
          <div style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;padding:1.25rem 1.5rem 1.5rem;box-shadow:0 1px 3px rgba(0,0,0,.06);">
            <div style="margin-bottom:1.5rem;">
              <h2 style="font-family:'Cormorant Garamond',serif;font-weight:600;color:hsl(var(--foreground));font-size:1.5rem;line-height:1.3;margin:0 0 .5rem;"><?= esc_html( $s['imp_contact_title'] ) ?></h2>
              <p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.875rem;"><?= esc_html( $s['imp_contact_subtitle'] ) ?></p>
            </div>
            <?php if ( $honeypot ): ?>
            <div style="position:absolute;left:-9999px;top:-9999px;overflow:hidden;" aria-hidden="true">
              <input type="text" name="imp_hp" id="<?= $uid ?>-hp" tabindex="-1" autocomplete="off"/>
            </div>
            <?php endif; ?>
            <form id="<?= $uid ?>-lead-form" style="display:flex;flex-direction:column;gap:1rem;">
              <div style="display:flex;gap:1rem;" class="sm-flex-row">
                <div style="flex:1;">
                  <label for="<?= $uid ?>-firstName" style="display:block;margin-bottom:.375rem;font-family:Inter,sans-serif;font-weight:500;color:hsl(var(--foreground));font-size:.875rem;">First Name <span style="color:hsl(var(--primary));">*</span></label>
                  <input type="text" id="<?= $uid ?>-firstName" class="imp-input" placeholder="First name" autocomplete="given-name" required>
                </div>
                <div style="flex:1;">
                  <label for="<?= $uid ?>-lastName" style="display:block;margin-bottom:.375rem;font-family:Inter,sans-serif;font-weight:500;color:hsl(var(--foreground));font-size:.875rem;">Last Name <span style="color:hsl(var(--primary));">*</span></label>
                  <input type="text" id="<?= $uid ?>-lastName" class="imp-input" placeholder="Last name" autocomplete="family-name" required>
                </div>
              </div>
              <div>
                <label for="<?= $uid ?>-email" style="display:block;margin-bottom:.375rem;font-family:Inter,sans-serif;font-weight:500;color:hsl(var(--foreground));font-size:.875rem;">Email Address <span style="color:hsl(var(--primary));">*</span></label>
                <input type="email" id="<?= $uid ?>-email" class="imp-input" placeholder="your@email.com" autocomplete="email" required>
              </div>
              <div>
                <label for="<?= $uid ?>-phone" style="display:block;margin-bottom:.375rem;font-family:Inter,sans-serif;font-weight:500;color:hsl(var(--foreground));font-size:.875rem;">Phone Number <span style="color:hsl(var(--primary));">*</span></label>
                <input type="tel" id="<?= $uid ?>-phone" class="imp-input" placeholder="(000) 000-0000" autocomplete="tel" required>
              </div>
              <button type="submit" id="<?= $uid ?>-reveal-btn" disabled
                style="display:inline-flex;justify-content:center;align-items:center;gap:.5rem;background:hsl(var(--primary));color:hsl(var(--primary-foreground));padding:1rem 2rem;border-radius:.5rem;width:100%;font-family:Inter,sans-serif;font-weight:500;font-size:1rem;letter-spacing:.025em;border:none;cursor:not-allowed;opacity:.6;margin-top:4px;transition:box-shadow .2s;">
                <?= esc_html( $s['imp_contact_btn'] ) ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
              </button>
            </form>
            <p style="margin-top:1rem;font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.5);font-size:.75rem;text-align:center;">Your information is kept private and never sold.</p>
          </div>
        </div>
        <?= $sidebar ?>
      </div>
    </div>
  </main>
</div>

<?php
// ── Helper: result check-item ──
$rci = function( $label ) {
    return '<div style="display:flex;align-items:center;gap:.5rem;">'
         . '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));flex-shrink:0;"><polyline points="20 6 9 13 4 10"/></svg>'
         . '<span style="font-family:Inter,sans-serif;color:hsl(var(--foreground));font-size:.875rem;">' . esc_html($label) . '</span>'
         . '</div>';
};
$single_items  = ['Implant surgery','Abutment','Final crown','Surgical planning'];
$arch_items    = ['All-on-4/6 implant system','Temporary arch','Final prosthesis','Surgical guides'];
$np_href = ! empty( $s['imp_success_url'] ) ? esc_url( $s['imp_success_url'] ) : '#';
$cta_btn = ! empty( $s['imp_success_url'] )
    ? '<div style="display:flex;justify-content:center;"><a href="' . esc_url($s['imp_success_url']) . '" class="imp-cta-btn" style="text-decoration:none;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg> Book My Free Consultation</a></div>'
    : '';
$fin_block = ( $show_fin && ! empty( $s['imp_financing_text'] ) )
    ? '<div style="display:flex;align-items:flex-start;gap:.75rem;background:hsl(var(--accent)/.4);padding:1rem 1.25rem;border:1px solid hsl(var(--border));border-radius:.75rem;margin-bottom:1rem;">'
      . '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));flex-shrink:0;margin-top:1px;"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>'
      . '<p style="font-family:Inter,sans-serif;color:hsl(var(--foreground)/.8);font-size:.875rem;">' . esc_html($s['imp_financing_text']) . '</p>'
      . '</div>'
    : '';
$disc_block = ! empty( $s['imp_disclaimer'] )
    ? '<div style="margin-bottom:1.5rem;text-align:center;"><p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.7);font-size:.75rem;line-height:1.65;">' . esc_html($s['imp_disclaimer']) . '</p></div>'
    : '';
$no_price_card = '<div style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;padding:2.5rem 2rem;box-shadow:0 1px 3px rgba(0,0,0,.06);text-align:center;margin-bottom:1.5rem;">'
    . '<div style="width:3.5rem;height:3.5rem;border-radius:9999px;background:hsl(var(--primary)/.1);display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>'
    . '<h2 style="font-family:\'Cormorant Garamond\',serif;font-weight:600;color:hsl(var(--foreground));font-size:clamp(1.5rem,4vw,2rem);line-height:1.25;margin:0 0 1rem;">' . esc_html($no_price_title) . '</h2>'
    . '<p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.9375rem;line-height:1.65;margin:0 auto 2rem;max-width:26rem;">' . esc_html($no_price_sub) . '</p>'
    . '<a href="' . $np_href . '" class="imp-cta-btn" style="text-decoration:none;margin:0 auto;">' . esc_html($no_price_btn)
    . '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></a></div>';
?>

<!-- RESULT: SINGLE -->
<div class="die-panel" id="<?= $uid ?>-panel-result-single">
  <main style="display:flex;flex-direction:column;flex:1;">
    <div style="flex:1;margin:0 auto;padding:1.5rem 1rem 2rem;width:100%;max-width:48rem;box-sizing:border-box;">
      <div style="display:flex;justify-content:center;margin-bottom:1.5rem;">
        <div style="display:inline-flex;align-items:center;gap:.375rem;background:hsl(var(--accent)/.6);padding:.375rem 1rem;border:1px solid hsl(var(--border));border-radius:9999px;font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.75rem;">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          Your Estimate Is Ready
        </div>
      </div>
      <?php if ( $show_price ): ?>
      <div style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;padding:2rem 2rem 2.5rem;box-shadow:0 1px 3px rgba(0,0,0,.06);text-align:center;margin-bottom:1.5rem;">
        <p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;margin-bottom:.5rem;"><?= esc_html( $s['imp_result_title'] ) ?></p>
        <p id="<?= $uid ?>-result-single-range" style="font-family:'Cormorant Garamond',serif;font-weight:700;color:hsl(var(--foreground));font-size:clamp(2rem,8vw,3.25rem);line-height:1;margin-bottom:.25rem;">Calculating&hellip;</p>
        <p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.6);font-size:.875rem;margin-bottom:2rem;"><?= esc_html( $s['imp_result_single_suffix'] ) ?></p>
        <div style="display:flex;flex-direction:column;gap:.625rem;max-width:18rem;margin:0 auto 1.5rem;text-align:left;">
          <p style="font-family:Inter,sans-serif;font-weight:500;color:hsl(var(--foreground));font-size:.875rem;">Included:</p>
          <?php foreach($single_items as $item): echo $rci($item); endforeach; ?>
        </div>
        <div id="<?= $uid ?>-graft-note-single" style="display:none;background:hsl(var(--accent)/.5);padding:1rem;border:1px solid hsl(var(--border));border-radius:.75rem;text-align:left;margin-bottom:1rem;">
          <p style="font-family:Inter,sans-serif;color:hsl(var(--foreground)/.8);font-size:.875rem;"><strong style="font-weight:600;">Bone grafting,</strong> if required, adds an estimated <?= esc_html($currency) ?><?= esc_html( number_format( (int)($s['imp_graft_min'] ?? 650) ) ) ?> &ndash; <?= esc_html($currency) ?><?= esc_html( number_format( (int)($s['imp_graft_max'] ?? 1100) ) ) ?>. Confirmed after a clinical exam.</p>
        </div>
      </div>
      <?= $fin_block ?>
      <?= $disc_block ?>
      <?= $cta_btn ?>
      <?php else: ?>
      <?= $no_price_card ?>
      <?php if ( ! empty( $s['imp_disclaimer'] ) ): ?><div style="text-align:center;"><p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.7);font-size:.75rem;line-height:1.65;"><?= esc_html( $s['imp_disclaimer'] ) ?></p></div><?php endif; ?>
      <?php endif; ?>
    </div>
  </main>
</div>

<!-- RESULT: MULTIPLE -->
<div class="die-panel" id="<?= $uid ?>-panel-result-multiple">
  <main style="display:flex;flex-direction:column;flex:1;">
    <div style="flex:1;margin:0 auto;padding:1.5rem 1rem 2rem;width:100%;max-width:48rem;box-sizing:border-box;">
      <div style="display:flex;justify-content:center;margin-bottom:1.5rem;">
        <div style="display:inline-flex;align-items:center;gap:.375rem;background:hsl(var(--accent)/.6);padding:.375rem 1rem;border:1px solid hsl(var(--border));border-radius:9999px;font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.75rem;">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          Your Estimate Is Ready
        </div>
      </div>
      <?php if ( $show_price ): ?>
      <div style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;padding:2rem 2rem 2.5rem;box-shadow:0 1px 3px rgba(0,0,0,.06);text-align:center;margin-bottom:1.5rem;">
        <p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;margin-bottom:.5rem;"><?= esc_html( $s['imp_result_title'] ) ?></p>
        <p id="<?= $uid ?>-result-multiple-range" style="font-family:'Cormorant Garamond',serif;font-weight:700;color:hsl(var(--foreground));font-size:clamp(2rem,8vw,3.25rem);line-height:1;margin-bottom:.25rem;">Calculating&hellip;</p>
        <p id="<?= $uid ?>-result-multiple-count" style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.6);font-size:.875rem;margin-bottom:2rem;"><?= esc_html( $s['imp_result_multiple_suffix'] ) ?></p>
        <div style="display:flex;flex-direction:column;gap:.625rem;max-width:18rem;margin:0 auto 1.5rem;text-align:left;">
          <p style="font-family:Inter,sans-serif;font-weight:500;color:hsl(var(--foreground));font-size:.875rem;">Included (per implant):</p>
          <?php foreach($single_items as $item): echo $rci($item); endforeach; ?>
        </div>
        <div id="<?= $uid ?>-graft-note-multiple" style="display:none;background:hsl(var(--accent)/.5);padding:1rem;border:1px solid hsl(var(--border));border-radius:.75rem;text-align:left;margin-bottom:1rem;">
          <p style="font-family:Inter,sans-serif;color:hsl(var(--foreground)/.8);font-size:.875rem;"><strong style="font-weight:600;">Bone grafting,</strong> if required, adds an estimated <?= esc_html($currency) ?><?= esc_html( number_format( (int)($s['imp_graft_min'] ?? 650) ) ) ?> &ndash; <?= esc_html($currency) ?><?= esc_html( number_format( (int)($s['imp_graft_max'] ?? 1100) ) ) ?> per site. Confirmed after a clinical exam.</p>
        </div>
      </div>
      <?= $fin_block ?>
      <?= $disc_block ?>
      <?= $cta_btn ?>
      <?php else: ?>
      <?= $no_price_card ?>
      <?php if ( ! empty( $s['imp_disclaimer'] ) ): ?><div style="text-align:center;"><p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.7);font-size:.75rem;line-height:1.65;"><?= esc_html( $s['imp_disclaimer'] ) ?></p></div><?php endif; ?>
      <?php endif; ?>
    </div>
  </main>
</div>

<!-- RESULT: FULL ARCH -->
<div class="die-panel" id="<?= $uid ?>-panel-result-fullarch">
  <main style="display:flex;flex-direction:column;flex:1;">
    <div style="flex:1;margin:0 auto;padding:1.5rem 1rem 2rem;width:100%;max-width:48rem;box-sizing:border-box;">
      <div style="display:flex;justify-content:center;margin-bottom:1.5rem;">
        <div style="display:inline-flex;align-items:center;gap:.375rem;background:hsl(var(--accent)/.6);padding:.375rem 1rem;border:1px solid hsl(var(--border));border-radius:9999px;font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.75rem;">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          Your Overview Is Ready
        </div>
      </div>
      <?php if ( $show_price ): ?>
      <div style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;padding:2rem 2rem 2.5rem;box-shadow:0 1px 3px rgba(0,0,0,.06);text-align:center;margin-bottom:1.5rem;">
        <p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;margin-bottom:.5rem;"><?= esc_html( $s['imp_result_title'] ) ?></p>
        <p id="<?= $uid ?>-result-fullarch-range" style="font-family:'Cormorant Garamond',serif;font-weight:700;color:hsl(var(--foreground));font-size:clamp(2rem,8vw,3.25rem);line-height:1;margin-bottom:.25rem;">Calculating&hellip;</p>
        <p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.6);font-size:.875rem;margin-bottom:2rem;"><?= esc_html( $s['imp_result_fullarch_suffix'] ) ?></p>
        <div style="display:flex;flex-direction:column;gap:.625rem;max-width:18rem;margin:0 auto 1.5rem;text-align:left;">
          <p style="font-family:Inter,sans-serif;font-weight:500;color:hsl(var(--foreground));font-size:.875rem;">Included:</p>
          <?php foreach($arch_items as $item): echo $rci($item); endforeach; ?>
        </div>
      </div>
      <?= $fin_block ?>
      <?= $disc_block ?>
      <?= $cta_btn ?>
      <?php else: ?>
      <?= $no_price_card ?>
      <?php if ( ! empty( $s['imp_disclaimer'] ) ): ?><div style="text-align:center;"><p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.7);font-size:.75rem;line-height:1.65;"><?= esc_html( $s['imp_disclaimer'] ) ?></p></div><?php endif; ?>
      <?php endif; ?>
    </div>
  </main>
</div>

</div><!-- /panels -->
</div><!-- /app -->

<script>
(function(){
  'use strict';
  var uid    = '<?= esc_js($uid) ?>';
  var config = {
    ajaxUrl:  '<?= esc_js( admin_url('admin-ajax.php') ) ?>',
    nonce:    '<?= esc_js($nonce) ?>',
    currency: '<?= esc_js($currency) ?>',
    prices:   <?= $prices_json ?>,
    honeypot: <?= $honeypot ? 'true' : 'false' ?>,
    showIns:  <?= $show_insurance ? 'true' : 'false' ?>
  };

  /* ── STATE ── */
  var s = {
    flow: null,
    // single
    toothLocation: null, toothLocationL: null,
    timeMissing: null, timeMissingL: null,
    boneGraft: null, boneGraftL: null,
    situationSingle: null, situationSingleL: null,
    // multiple
    teethCount: null, teethCountN: 2, teethCountL: null,
    teethLocation: null, teethLocationL: null,
    timeMissingMult: null, timeMissingMultL: null,
    boneGraftMult: null, boneGraftMultL: null,
    situationMult: null, situationMultL: null,
    // full-arch
    archSelection: null, archSelectionL: null,
    situationArch: null, situationArchL: null,
    archDuration: null, archDurationL: null,
    // insurance
    insurance: null, insuranceL: null
  };

  var currentPanel = 'intro';
  var navHistory   = [];

  /* ── STEP MAP ── */
  // single=9 steps total (router+a1-a4+ins+summary+lead+result)
  // multiple=10, fullarch=7 (no insurance for fullarch)
  var stepMap = {
    intro:  { label: 'Get Started',       pct: 5   },
    router: { label: 'Step 1',            pct: 11  },
    a1:     { label: 'Step 2 of 9',       pct: 22  },
    a2:     { label: 'Step 3 of 9',       pct: 33  },
    a3:     { label: 'Step 4 of 9',       pct: 44  },
    a4:     { label: 'Step 5 of 9',       pct: 55  },
    ins:    { label: 'Step 6 of 9',       pct: 65  },
    m1:     { label: 'Step 2 of 10',      pct: 20  },
    m2:     { label: 'Step 3 of 10',      pct: 30  },
    m3:     { label: 'Step 4 of 10',      pct: 40  },
    m4:     { label: 'Step 5 of 10',      pct: 50  },
    m5:     { label: 'Step 6 of 10',      pct: 60  },
    b1:     { label: 'Step 2 of 7',       pct: 28  },
    b2:     { label: 'Step 3 of 7',       pct: 42  },
    b3:     { label: 'Step 4 of 7',       pct: 57  }
  };

  function getStepInfo(id) {
    if (stepMap[id]) return stepMap[id];
    var total = s.flow === 'multiple' ? 10 : (s.flow === 'fullarch' ? 7 : 9);
    if (id === 'summary') return { label: 'Step ' + (total - 2) + ' of ' + total, pct: 76 };
    if (id === 'lead')    return { label: 'Step ' + (total - 1) + ' of ' + total, pct: 88 };
    if (id.indexOf('result') === 0) return { label: 'Step ' + total + ' of ' + total, pct: 100 };
    return { label: '', pct: 0 };
  }

  var msgs = {
    router:           ['Starting your estimate\u2026',          'A few short questions'],
    a1:               ['Personalizing your estimate\u2026',     'Adjusting for your case'],
    a2:               ['Updating your estimate\u2026',          'Adjusting for tooth location'],
    a3:               ['Narrowing your range\u2026',            'Adjusting for timeline'],
    a4:               ['Almost there\u2026',                    'One more detail'],
    m1:               ['Starting your estimate\u2026',          'A few short questions'],
    m2:               ['Calculating your range\u2026',          'Based on tooth count'],
    m3:               ['Updating your estimate\u2026',          'Adjusting for location'],
    m4:               ['Narrowing your range\u2026',            'Adjusting for timeline'],
    m5:               ['Almost there\u2026',                    'One more detail'],
    b1:               ['Starting your full-arch estimate\u2026','A few short questions'],
    b2:               ['Updating your estimate\u2026',          'Adjusting for your arch'],
    b3:               ['Almost there\u2026',                    'One more detail'],
    ins:              ['Final detail\u2026',                     'Insurance information'],
    summary:          ['Reviewing your answers\u2026',           'Your estimate is being prepared'],
    lead:             ['Ready to reveal\u2026',                  'Just one more step'],
    'result-single':  ['Preparing your estimate\u2026',          'Finalizing your range'],
    'result-multiple':['Calculating your range\u2026',           'Based on your answers'],
    'result-fullarch':['Preparing your overview\u2026',          'Reviewing full-arch options']
  };

  /* ── HELPERS ── */
  function fmt(n){ return config.currency + n.toLocaleString('en-US'); }

  function getRange() {
    var p = config.prices;
    if (s.flow === 'fullarch') {
      return { label: fmt(p.arch_min) + ' \u2013 ' + fmt(p.arch_max), suffix: ' <?= esc_js( $s['imp_result_fullarch_suffix'] ) ?>' };
    }
    var bMin, bMax;
    if (s.flow === 'multiple') {
      bMin = p.multi_min; bMax = p.multi_max;
      var gv = s.boneGraftMult || '';
      if (gv === 'yes' || gv === 'not-sure') { bMin += p.graft_min; bMax += p.graft_max; }
      return { label: fmt(bMin) + ' \u2013 ' + fmt(bMax), suffix: ' <?= esc_js( $s['imp_result_multiple_suffix'] ) ?>' };
    }
    // single
    bMin = p.single_min; bMax = p.single_max;
    var gvs = s.boneGraft || '';
    if (gvs === 'yes' || gvs === 'not-sure') { bMin += p.graft_min; bMax += p.graft_max; }
    return { label: fmt(bMin) + ' \u2013 ' + fmt(bMax), suffix: ' <?= esc_js( $s['imp_result_single_suffix'] ) ?>' };
  }

  /* ── SHOW PANEL ── */
  function showPanel(id) {
    document.querySelectorAll('#' + uid + '-app .die-panel').forEach(function(p){
      p.classList.remove('die-panel-active');
    });
    var el = document.getElementById(uid + '-panel-' + id);
    if (el) el.classList.add('die-panel-active');
    window.scrollTo(0, 0);
  }

  function updateStepBar(id) {
    var info = getStepInfo(id);
    var lel = document.getElementById(uid + '-step-label');
    var pel = document.getElementById(uid + '-step-progress');
    if (lel) lel.textContent = info.label;
    if (pel) pel.style.width = info.pct + '%';
  }

  /* ── SIDEBAR ── */
  function updateSidebar() {
    var tags = [];
    if (s.flow === 'single') {
      tags.push({l:'Replacing:',   v:'One missing tooth'});
      if (s.toothLocation)   tags.push({l:'Location:',   v:s.toothLocationL});
      if (s.timeMissing)     tags.push({l:'Missing for:',v:s.timeMissingL});
      if (s.boneGraft)       tags.push({l:'Bone graft:', v:s.boneGraftL});
      if (s.situationSingle) tags.push({l:'Situation:',  v:s.situationSingleL});
    } else if (s.flow === 'multiple') {
      tags.push({l:'Replacing:',  v:'Several missing teeth'});
      if (s.teethCount)      tags.push({l:'Teeth:',      v:s.teethCountL});
      if (s.teethLocation)   tags.push({l:'Location:',   v:s.teethLocationL});
      if (s.timeMissingMult) tags.push({l:'Missing for:',v:s.timeMissingMultL});
      if (s.boneGraftMult)   tags.push({l:'Bone graft:', v:s.boneGraftMultL});
      if (s.situationMult)   tags.push({l:'Situation:',  v:s.situationMultL});
    } else if (s.flow === 'fullarch') {
      tags.push({l:'Replacing:',  v:'Full arch / denture'});
      if (s.archSelection)   tags.push({l:'Arch:',       v:s.archSelectionL});
      if (s.situationArch)   tags.push({l:'Situation:',  v:s.situationArchL});
      if (s.archDuration)    tags.push({l:'Duration:',   v:s.archDurationL});
    }
    if (s.insurance) tags.push({l:'Insurance:', v:s.insuranceL});

    var html = tags.length
      ? tags.map(function(t){
          return '<div style="display:inline-flex;align-items:center;gap:.375rem;background:hsl(var(--accent));padding:.375rem .75rem;border:1px solid hsl(var(--border));border-radius:9999px;font-family:Inter,sans-serif;font-size:.75rem;">'
               + '<span style="color:hsl(var(--muted-foreground));">' + t.l + '</span>'
               + '<span style="font-weight:500;color:hsl(var(--foreground));">' + t.v + '</span>'
               + '</div>';
        }).join('')
      : '<p style="color:hsl(var(--muted-foreground)/.6);font-size:.8rem;font-family:Inter,sans-serif;">Select your answers to build your estimate</p>';

    document.querySelectorAll('.imp-st-' + uid).forEach(function(el){ el.innerHTML = html; });

    if (s.flow !== null) {
      var r   = getRange();
      var maxA = s.flow === 'multiple' ? 6 : (s.flow === 'fullarch' ? 4 : 5);
      var pct = Math.max(5, Math.min(90, (tags.length / maxA) * 90));
      document.querySelectorAll('.imp-sr-' + uid).forEach(function(el){ el.textContent = r.label + r.suffix; });
      document.querySelectorAll('.imp-rb-' + uid).forEach(function(el){ el.style.width = pct + '%'; });
    }
  }

  /* ── NAVIGATE ── */
  function navigate(panelId) {
    navHistory.push(currentPanel);
    var m = msgs[panelId] || ['Loading\u2026', ''];
    var curEl  = document.getElementById(uid + '-panel-' + currentPanel);
    var cardEl = curEl ? curEl.querySelector('.die-question-card') : null;

    if (cardEl) {
      cardEl.style.position = 'relative';
      var ov = document.createElement('div');
      ov.id = uid + '-spinner-ov';
      ov.style.cssText = 'position:absolute;inset:0;border-radius:inherit;background:hsl(var(--card));display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:2rem;z-index:5;opacity:0;transition:opacity 0.2s ease;';
      ov.innerHTML = '<div style="margin-bottom:1.25rem;">'
        + '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="die-spinner" style="stroke:hsl(var(--primary));display:block;"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>'
        + '</div>'
        + '<p style="font-family:\'Cormorant Garamond\',serif;font-weight:600;color:hsl(var(--foreground));font-size:1.375rem;margin:0 0 .375rem;">' + m[0] + '</p>'
        + '<p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.875rem;margin:0 0 1.25rem;">' + m[1] + '</p>'
        + '<div style="display:flex;gap:.375rem;align-items:center;justify-content:center;">'
        + '<div style="width:.375rem;height:.375rem;border-radius:9999px;background:hsl(var(--primary)/.4);animation:' + uid + '_pulse 1.2s ease-in-out infinite;"></div>'
        + '<div style="width:.375rem;height:.375rem;border-radius:9999px;background:hsl(var(--primary)/.4);animation:' + uid + '_pulse 1.2s ease-in-out .2s infinite;"></div>'
        + '<div style="width:.375rem;height:.375rem;border-radius:9999px;background:hsl(var(--primary)/.4);animation:' + uid + '_pulse 1.2s ease-in-out .4s infinite;"></div>'
        + '</div>';
      cardEl.appendChild(ov);
      requestAnimationFrame(function(){ ov.style.opacity = '1'; });
    }

    updateSidebar();

    setTimeout(function(){
      var old = document.getElementById(uid + '-spinner-ov');
      if (old) old.parentNode.removeChild(old);
      currentPanel = panelId;
      showPanel(panelId);
      updateStepBar(panelId);
      if (panelId === 'summary') buildSummary();
      if (panelId === 'result-single' || panelId === 'result-multiple' || panelId === 'result-fullarch') renderResult(panelId);
    }, 1700);
  }

  function goBack() {
    if (!navHistory.length) return;
    currentPanel = navHistory.pop();
    showPanel(currentPanel);
    updateStepBar(currentPanel);
    updateSidebar();
  }

  /* ── SELECT OPTION ── */
  function selectOpt(btn, key, val, label, next) {
    s[key] = val;
    s[key + 'L'] = label;
    if (key === 'router') {
      s.flow = val === 'single' ? 'single' : (val === 'multiple' ? 'multiple' : 'fullarch');
    }
    if (key === 'teethCount') {
      s.teethCountN = {'2':2,'3':3,'4':4,'5plus':5}[val] || 2;
    }
    var par = btn.parentNode;
    if (par) {
      var btns = par.querySelectorAll('.option-btn');
      for (var i = 0; i < btns.length; i++) btns[i].classList.remove('selected');
    }
    btn.classList.add('selected');
    navigate(next);
  }

  /* ── SUMMARY ── */
  function buildSummary() {
    var items = [];
    var ck = function(text) {
      return '<div style="display:flex;align-items:center;gap:.625rem;">'
           + '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));flex-shrink:0;"><polyline points="20 6 9 13 4 10"/></svg>'
           + '<span style="font-family:Inter,sans-serif;color:hsl(var(--foreground));font-size:.875rem;">' + text + '</span>'
           + '</div>';
    };
    var desc = '';
    if (s.flow === 'single') {
      items.push(ck('Replacing: <strong>one missing tooth</strong>'));
      if (s.toothLocation)   items.push(ck('Location: <strong>' + s.toothLocationL + '</strong>'));
      if (s.timeMissing)     items.push(ck('Missing for: <strong>' + s.timeMissingL + '</strong>'));
      if (s.boneGraft)       items.push(ck('Bone graft indicated: <strong>' + s.boneGraftL + '</strong>'));
      if (s.situationSingle) items.push(ck('Situation: <strong>' + s.situationSingleL + '</strong>'));
      if (s.insurance)       items.push(ck('Insurance: <strong>' + s.insuranceL + '</strong>'));
      desc = 'We\u2019ve prepared your likely treatment range based on a single missing tooth. Enter your details to unlock the full estimate.';
    } else if (s.flow === 'multiple') {
      items.push(ck('Replacing: <strong>multiple missing teeth</strong>'));
      if (s.teethCount)      items.push(ck('Number of teeth: <strong>' + s.teethCountL + '</strong>'));
      if (s.teethLocation)   items.push(ck('Location: <strong>' + s.teethLocationL + '</strong>'));
      if (s.timeMissingMult) items.push(ck('Missing for: <strong>' + s.timeMissingMultL + '</strong>'));
      if (s.boneGraftMult)   items.push(ck('Bone graft indicated: <strong>' + s.boneGraftMultL + '</strong>'));
      if (s.situationMult)   items.push(ck('Situation: <strong>' + s.situationMultL + '</strong>'));
      if (s.insurance)       items.push(ck('Insurance: <strong>' + s.insuranceL + '</strong>'));
      var n = s.teethCountL ? s.teethCountL.toLowerCase() : 'multiple';
      desc = 'We\u2019ve prepared your likely treatment range based on ' + n + ' missing teeth. Enter your details to unlock the full estimate.';
    } else if (s.flow === 'fullarch') {
      items.push(ck('Replacing: <strong>full arch / denture</strong>'));
      if (s.archSelection) items.push(ck('Arch: <strong>' + s.archSelectionL + '</strong>'));
      if (s.situationArch) items.push(ck('Situation: <strong>' + s.situationArchL + '</strong>'));
      if (s.archDuration)  items.push(ck('Duration: <strong>' + s.archDurationL + '</strong>'));
      desc = 'We\u2019ve prepared your likely treatment range based on full-arch restoration. Enter your details to unlock the full estimate.';
    }
    var listEl = document.getElementById(uid + '-summary-list');
    var descEl = document.getElementById(uid + '-summary-desc');
    if (listEl) listEl.innerHTML = items.join('');
    if (descEl) descEl.textContent = desc;
  }

  /* ── RENDER RESULT ── */
  function animateRange(elId, val) {
    var el = document.getElementById(elId);
    if (!el) return;
    el.style.opacity = '0'; el.style.transform = 'scale(0.92) translateY(10px)';
    setTimeout(function(){
      el.textContent = val;
      el.style.transition = 'opacity 0.7s ease, transform 0.7s cubic-bezier(0.16,1,0.3,1)';
      el.style.opacity = '1'; el.style.transform = 'scale(1) translateY(0)';
    }, 120);
  }

  function renderResult(panelId) {
    var r = getRange();
    if (panelId === 'result-single') {
      animateRange(uid + '-result-single-range', r.label);
      var gns = document.getElementById(uid + '-graft-note-single');
      if (gns) gns.style.display = (s.boneGraft === 'yes' || s.boneGraft === 'not-sure') ? 'block' : 'none';
    } else if (panelId === 'result-multiple') {
      animateRange(uid + '-result-multiple-range', r.label);
      var gnm = document.getElementById(uid + '-graft-note-multiple');
      if (gnm) gnm.style.display = (s.boneGraftMult === 'yes' || s.boneGraftMult === 'not-sure') ? 'block' : 'none';
      var cnt = document.getElementById(uid + '-result-multiple-count');
      if (cnt) cnt.textContent = 'Based on ' + (s.teethCountL || 'multiple teeth') + ' at the per-implant rate';
    } else if (panelId === 'result-fullarch') {
      animateRange(uid + '-result-fullarch-range', r.label);
    }
  }

  /* ── FORM VALIDATION ── */
  function checkValidity() {
    var fn  = document.getElementById(uid + '-firstName');
    var ln  = document.getElementById(uid + '-lastName');
    var em  = document.getElementById(uid + '-email');
    var ph  = document.getElementById(uid + '-phone');
    var btn = document.getElementById(uid + '-reveal-btn');
    if (!fn || !ln || !em || !ph || !btn) return;
    var ok = fn.value.trim().length > 0
          && ln.value.trim().length > 0
          && em.value.trim().indexOf('@') > 0
          && ph.value.trim().length > 0;
    btn.disabled      = !ok;
    btn.style.opacity = ok ? '1' : '0.6';
    btn.style.cursor  = ok ? 'pointer' : 'not-allowed';
  }

  /* ── FORM SUBMIT ── */
  var isSubmitting = false;
  function handleSubmit(e) {
    e.preventDefault();
    if (isSubmitting) return;
    isSubmitting = true;
    var fn = document.getElementById(uid + '-firstName').value.trim();
    var ln = document.getElementById(uid + '-lastName').value.trim();
    var em = document.getElementById(uid + '-email').value.trim();
    var ph = document.getElementById(uid + '-phone').value.trim();
    if (!fn || !ln || !em || !ph) { isSubmitting = false; return; }
    <?php if($honeypot): ?>
    var hp = document.getElementById(uid + '-hp');
    if (hp && hp.value) { isSubmitting = false; return; }
    <?php endif; ?>
    var btn = document.getElementById(uid + '-reveal-btn');
    if (btn) { btn.disabled = true; btn.style.opacity = '0.6'; btn.style.cursor = 'not-allowed'; }

    var r      = getRange();
    var panel  = 'result-' + (s.flow || 'single');
    var fd     = new FormData();
    fd.append('action',          'cfg_implant_submit');
    fd.append('imp_nonce',       config.nonce);
    fd.append('firstName',       fn);
    fd.append('lastName',        ln);
    fd.append('email',           em);
    fd.append('phone',           ph);
    <?php if($honeypot): ?>fd.append('imp_hp', '');<?php endif; ?>
    fd.append('flow',            s.flow             || '');
    fd.append('toothLocation',   s.toothLocation    || '');
    fd.append('timeMissing',     s.timeMissing      || '');
    fd.append('boneGraft',       s.boneGraft        || '');
    fd.append('situationSingle', s.situationSingle  || '');
    fd.append('teethCount',      s.teethCount       || '');
    fd.append('teethLocation',   s.teethLocation    || '');
    fd.append('timeMissingMult', s.timeMissingMult  || '');
    fd.append('boneGraftMult',   s.boneGraftMult    || '');
    fd.append('situationMult',   s.situationMult    || '');
    fd.append('archSelection',   s.archSelection    || '');
    fd.append('archDuration',    s.archDuration     || '');
    fd.append('situationArch',   s.situationArch    || '');
    fd.append('insurance',       s.insurance        || '');
    fd.append('range',           r.label + r.suffix);
    fd.append('rangeType',       panel);
    var _up = new URLSearchParams(window.location.search);
    ['utm_campaign','utm_medium','utm_content','utm_keyword','gclid'].forEach(function(k){ fd.append(k, _up.get(k) || ''); });
    fetch(config.ajaxUrl, { method:'POST', body:fd }).catch(function(){});
    navigate(panel);
  }

  /* ── INIT ── */
  var initialized = false;
  function init() {
    if (initialized) return;
    initialized = true;
    showPanel('intro');
    updateStepBar('intro');
    var form = document.getElementById(uid + '-lead-form');
    if (form) form.addEventListener('submit', handleSubmit);
    ['firstName','lastName','email','phone'].forEach(function(f){
      var el = document.getElementById(uid + '-' + f);
      if (el) el.addEventListener('input', checkValidity);
    });
  }

  window[uid + 'Nav']  = navigate;
  window[uid + 'Back'] = goBack;
  window[uid + 'Sel']  = selectOpt;

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else { init(); }
})();
</script>
<?php
    return ob_get_clean();
}


// ═══════════════════════════════════════════════════════════════
//  IMPLANT ESTIMATOR — AJAX SUBMIT
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_ajax_cfg_implant_submit',        'cfg_implant_ajax_submit' );
add_action( 'wp_ajax_nopriv_cfg_implant_submit', 'cfg_implant_ajax_submit' );

function cfg_implant_ajax_submit() {
    if ( ! isset( $_POST['imp_nonce'] ) || ! wp_verify_nonce( $_POST['imp_nonce'], 'cfg_implant_submit' ) ) {
        wp_send_json_error( 'Security check failed. Please refresh and try again.' );
    }

    $s = cfg_get();

    // Honeypot
    if ( $s['spam_honeypot'] === '1' && ! empty( $_POST['imp_hp'] ) ) {
        wp_send_json_error( 'Submission blocked.' );
    }

    // Sanitise
    $first = sanitize_text_field( $_POST['firstName'] ?? '' );
    $last  = sanitize_text_field( $_POST['lastName']  ?? '' );
    $phone = sanitize_text_field( $_POST['phone']     ?? '' );
    $email = sanitize_email(      $_POST['email']     ?? '' );

    if ( empty( $first ) ) wp_send_json_error( 'First name is required.' );
    if ( empty( $last ) )  wp_send_json_error( 'Last name is required.' );
    if ( empty( $phone ) ) wp_send_json_error( 'Phone number is required.' );
    if ( ! is_email( $email ) ) wp_send_json_error( 'A valid email address is required.' );

    if ( empty( $s['ghl_api_key'] ) || empty( $s['ghl_location_id'] ) ) {
        wp_send_json_error( 'Form is not fully configured. Please contact us directly.' );
    }

    // Quiz answers — individual fields from 3-path flow
    $flow              = sanitize_text_field( $_POST['flow']            ?? '' );
    $tooth_location    = sanitize_text_field( $_POST['toothLocation']   ?? '' );
    $time_missing      = sanitize_text_field( $_POST['timeMissing']     ?? '' );
    $bone_graft        = sanitize_text_field( $_POST['boneGraft']       ?? '' );
    $situation_single  = sanitize_text_field( $_POST['situationSingle'] ?? '' );
    $teeth_count       = sanitize_text_field( $_POST['teethCount']      ?? '' );
    $teeth_location    = sanitize_text_field( $_POST['teethLocation']   ?? '' );
    $time_missing_mult = sanitize_text_field( $_POST['timeMissingMult'] ?? '' );
    $bone_graft_mult   = sanitize_text_field( $_POST['boneGraftMult']   ?? '' );
    $situation_mult    = sanitize_text_field( $_POST['situationMult']   ?? '' );
    $arch_selection    = sanitize_text_field( $_POST['archSelection']   ?? '' );
    $situation_arch    = sanitize_text_field( $_POST['situationArch']   ?? '' );
    $arch_duration     = sanitize_text_field( $_POST['archDuration']    ?? '' );
    $insurance         = sanitize_text_field( $_POST['insurance']       ?? '' );
    $range             = sanitize_text_field( $_POST['range']           ?? '' );
    $range_type        = sanitize_text_field( $_POST['rangeType']       ?? '' );

    // Tags
    $tags = [ 'implant-estimator', 'website-lead' ];
    if ( $flow === 'single' )   $tags[] = 'implant-single';
    elseif ( $flow === 'multiple' ) $tags[] = 'implant-multiple';
    elseif ( $flow === 'fullarch' ) $tags[] = 'implant-fullarch';

    // Custom fields
    $custom = [];
    $custom_map = [
        'implant_flow'           => $flow,
        'implant_tooth_location' => $tooth_location,
        'implant_time_missing'   => $flow === 'multiple' ? $time_missing_mult : $time_missing,
        'implant_bone_graft'     => $flow === 'multiple' ? $bone_graft_mult   : $bone_graft,
        'implant_situation'      => $flow === 'single' ? $situation_single : ( $flow === 'multiple' ? $situation_mult : $situation_arch ),
        'implant_teeth_count'    => $teeth_count,
        'implant_teeth_location' => $teeth_location,
        'implant_arch_selection' => $arch_selection,
        'implant_arch_duration'  => $arch_duration,
        'implant_insurance'      => $insurance,
        'implant_range'          => $range,
        'implant_range_type'     => $range_type,
    ];
    foreach ( $custom_map as $key => $val ) {
        if ( $val !== '' ) $custom[] = [ 'key' => $key, 'field_value' => $val ];
    }
    foreach ( [ 'utm_campaign', 'utm_medium', 'utm_content', 'utm_keyword', 'gclid' ] as $utm_key ) {
        $val = sanitize_text_field( $_POST[ $utm_key ] ?? '' );
        if ( $val !== '' ) $custom[] = [ 'key' => $utm_key, 'field_value' => $val ];
    }

    $payload = [
        'firstName'  => $first,
        'lastName'   => $last,
        'email'      => $email,
        'phone'      => $phone,
        'locationId' => $s['ghl_location_id'],
        'source'     => 'Implant Estimator Form',
        'tags'       => $tags,
    ];
    if ( $custom ) $payload['customFields'] = $custom;

    $response = wp_remote_post( 'https://services.leadconnectorhq.com/contacts/upsert', [
        'headers' => [
            'Authorization' => 'Bearer ' . $s['ghl_api_key'],
            'Content-Type'  => 'application/json',
            'Version'       => '2021-07-28',
        ],
        'body'    => wp_json_encode( $payload ),
        'timeout' => 15,
    ] );

    if ( is_wp_error( $response ) ) {
        wp_send_json_error( 'Could not reach the CRM. Please try again.' );
    }

    $code = wp_remote_retrieve_response_code( $response );
    $body = json_decode( wp_remote_retrieve_body( $response ), true );

    if ( $code === 200 || $code === 201 ) {
        wp_send_json_success( 'Contact created.' );
    } else {
        $msg = $body['message'] ?? ( 'Unexpected error (HTTP ' . $code . ').' );
        error_log( '[CFG Implant] GHL error ' . $code . ': ' . wp_json_encode( $body ) );
        wp_send_json_error( $msg );
    }
}
