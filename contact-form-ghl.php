<?php
/**
 * Plugin Name: Contact Form + GoHighLevel
 * Plugin URI: https://upwork.com/freelancers/adelsherif8
 * Description: Fully customizable contact form with GoHighLevel CRM integration. Use shortcode [contact_form_ghl].
 * Version:     2.3.3
 * Author:      Adel Emad
 * Author URI:  https://upwork.com/freelancers/adelsherif8
 * License:     GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'CFG_SLUG',   'contact-form-ghl' );
define( 'CFG_OPTION', 'cfg_settings' );
define( 'CFG_ENTRIES_DB_VER', '1.0' );

// ═══════════════════════════════════════════════════════════════
//  DATABASE — ENTRIES TABLE
// ═══════════════════════════════════════════════════════════════
register_activation_hook( __FILE__, 'cfg_create_entries_table' );

function cfg_create_entries_table() {
    global $wpdb;
    $table           = $wpdb->prefix . 'cfg_entries';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        form_type   VARCHAR(20)  NOT NULL DEFAULT 'contact',
        first_name  VARCHAR(100) NOT NULL DEFAULT '',
        last_name   VARCHAR(100) NOT NULL DEFAULT '',
        email       VARCHAR(200) NOT NULL DEFAULT '',
        phone       VARCHAR(50)  NOT NULL DEFAULT '',
        meta        LONGTEXT,
        ghl_status  VARCHAR(10)  NOT NULL DEFAULT 'ok',
        created_at  DATETIME     NOT NULL,
        PRIMARY KEY (id)
    ) {$charset_collate};";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
    update_option( 'cfg_entries_db_version', CFG_ENTRIES_DB_VER );
}

// Auto-create on plugin update without re-activation
add_action( 'plugins_loaded', function () {
    if ( get_option( 'cfg_entries_db_version' ) !== CFG_ENTRIES_DB_VER ) {
        cfg_create_entries_table();
    }
} );

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
        'imp_intro_btn_url'    => '',
        'imp_router_title'     => 'What are you looking to replace?',
        'imp_router_sub'       => 'Select the option that best describes your situation.',
        'imp_router_opts'  => json_encode([
            ['val'=>'single',   'label'=>'One missing tooth',                    'sub'=>'Replace a single tooth with an implant'],
            ['val'=>'multiple', 'label'=>'Several missing teeth',                'sub'=>'Replace 2 to 5 individual teeth'],
            ['val'=>'fullarch', 'label'=>'A denture or most/all teeth in an arch','sub'=>'Full-arch or All-on-4 / All-on-6'],
        ], JSON_UNESCAPED_UNICODE),

        'imp_single_qs' => json_encode([
            ['id'=>'a1','title'=>'Where is the tooth located?','subtitle'=>'Location affects restoration complexity and the materials used.','type'=>'radio','field'=>'toothLocation',
             'opts'=>[['val'=>'front','label'=>'Front','sub'=>'Visible when smiling'],['val'=>'back','label'=>'Back','sub'=>'Chewing tooth (molar or premolar)'],['val'=>'not-sure','label'=>'Not sure','sub'=>'']]],
            ['id'=>'a2','title'=>'How long has the tooth been missing?','subtitle'=>'This helps us assess potential bone changes at the site.','type'=>'radio','field'=>'timeMissing',
             'opts'=>[['val'=>'under-6mo','label'=>'Less than 6 months','sub'=>''],['val'=>'6-12mo','label'=>'6–12 months','sub'=>''],['val'=>'1-3yr','label'=>'1–3 years','sub'=>''],['val'=>'3yr+','label'=>'3+ years','sub'=>''],['val'=>'not-sure','label'=>'Not sure','sub'=>'']]],
            ['id'=>'a3','title'=>'Has a dentist mentioned bone loss or the need for bone grafting?','subtitle'=>'This can affect your treatment plan and overall timeline.','type'=>'radio','field'=>'boneGraft','pricing_role'=>'bone_graft',
             'opts'=>[['val'=>'yes','label'=>'Yes','sub'=>''],['val'=>'no','label'=>'No','sub'=>''],['val'=>'not-sure','label'=>'Not sure','sub'=>'']]],
            ['id'=>'a4','title'=>'What best describes your situation?','subtitle'=>'This helps us tailor your estimate to your current needs.','type'=>'radio','field'=>'situationSingle',
             'opts'=>[['val'=>'already-missing','label'=>'Tooth already missing','sub'=>''],['val'=>'needs-removal','label'=>'Tooth needs to be removed','sub'=>''],['val'=>'bridge-crown','label'=>'Replacing a bridge or crown','sub'=>''],['val'=>'not-sure','label'=>'Not sure','sub'=>'']]],
        ], JSON_UNESCAPED_UNICODE),

        'imp_multi_qs' => json_encode([
            ['id'=>'m1','title'=>'How many teeth are you looking to replace?','subtitle'=>"We'll use this to calculate your personalized range.",'type'=>'radio','field'=>'teethCount',
             'opts'=>[['val'=>'2','label'=>'2 teeth','sub'=>''],['val'=>'3','label'=>'3 teeth','sub'=>''],['val'=>'4','label'=>'4 teeth','sub'=>''],['val'=>'5','label'=>'5 teeth','sub'=>''],['val'=>'6','label'=>'6 teeth','sub'=>''],['val'=>'7','label'=>'7 teeth','sub'=>'']]],
            ['id'=>'m2','title'=>'Where are the teeth located?','subtitle'=>'Location affects restoration complexity and materials.','type'=>'radio','field'=>'teethLocation',
             'opts'=>[['val'=>'front','label'=>'Front','sub'=>'Visible when smiling'],['val'=>'back','label'=>'Back','sub'=>'Chewing teeth'],['val'=>'both','label'=>'Both front and back','sub'=>''],['val'=>'not-sure','label'=>'Not sure','sub'=>'']]],
            ['id'=>'m3','title'=>'How long have the teeth been missing?','subtitle'=>'This helps us assess potential bone changes at the sites.','type'=>'radio','field'=>'timeMissingMult',
             'opts'=>[['val'=>'under-6mo','label'=>'Less than 6 months','sub'=>''],['val'=>'6-12mo','label'=>'6–12 months','sub'=>''],['val'=>'1-3yr','label'=>'1–3 years','sub'=>''],['val'=>'3yr+','label'=>'3+ years','sub'=>''],['val'=>'not-sure','label'=>'Not sure','sub'=>'']]],
            ['id'=>'m4','title'=>'Has a dentist mentioned bone loss or the need for bone grafting?','subtitle'=>'This can affect your treatment plan and overall timeline.','type'=>'radio','field'=>'boneGraftMult','pricing_role'=>'bone_graft',
             'opts'=>[['val'=>'yes','label'=>'Yes','sub'=>''],['val'=>'no','label'=>'No','sub'=>''],['val'=>'not-sure','label'=>'Not sure','sub'=>'']]],
            ['id'=>'m5','title'=>'What best describes your situation?','subtitle'=>'This helps us tailor your estimate to your current needs.','type'=>'radio','field'=>'situationMult',
             'opts'=>[['val'=>'already-missing','label'=>'Teeth already missing','sub'=>''],['val'=>'needs-removal','label'=>'Some teeth need to be removed','sub'=>''],['val'=>'bridge-crown','label'=>'Replacing bridges or crowns','sub'=>''],['val'=>'not-sure','label'=>'Not sure','sub'=>'']]],
        ], JSON_UNESCAPED_UNICODE),

        'imp_arch_qs' => json_encode([
            ['id'=>'b1','title'=>'Which arch are you looking to replace?','subtitle'=>'Upper, lower, or both — this shapes your treatment overview.','type'=>'radio','field'=>'archSelection',
             'opts'=>[['val'=>'upper','label'=>'Upper','sub'=>'Top teeth'],['val'=>'lower','label'=>'Lower','sub'=>'Bottom teeth'],['val'=>'both','label'=>'Both','sub'=>'Full mouth restoration']]],
            ['id'=>'b2','title'=>'What best describes your current situation?','subtitle'=>'This helps us understand your starting point.','type'=>'radio','field'=>'situationArch',
             'opts'=>[['val'=>'wearing-denture','label'=>'Wearing a denture','sub'=>''],['val'=>'failing-teeth','label'=>'Multiple failing teeth','sub'=>''],['val'=>'beyond-repair','label'=>'Teeth beyond repair','sub'=>''],['val'=>'not-sure','label'=>'Not sure','sub'=>'']]],
            ['id'=>'b3','title'=>'How long have you had missing or failing teeth?','subtitle'=>'Duration helps determine bone volume and treatment complexity.','type'=>'radio','field'=>'archDuration',
             'opts'=>[['val'=>'under-1yr','label'=>'Less than 1 year','sub'=>''],['val'=>'1-5yr','label'=>'1–5 years','sub'=>''],['val'=>'5yr+','label'=>'5+ years','sub'=>'']]],
        ], JSON_UNESCAPED_UNICODE),

        'imp_ins_q' => json_encode(
            ['id'=>'ins','title'=>'Do you have dental insurance?','subtitle'=>'Insurance can reduce your out-of-pocket cost.','type'=>'radio','field'=>'insurance',
             'opts'=>[['val'=>'yes','label'=>'Yes (I have coverage)','sub'=>''],['val'=>'no','label'=>'No','sub'=>'']]],
        JSON_UNESCAPED_UNICODE),
        'imp_result_single_suffix'   => 'for a single dental implant',
        'imp_result_multiple_suffix' => 'Based on number of teeth at the per-implant rate',
        'imp_result_fullarch_suffix' => 'per arch',
        'imp_result_title'     => 'Your Estimated Investment',
        'imp_result_subtitle'  => 'Based on the answers you provided today',
        'imp_result_sections'  => json_encode([
            ['title'=>'What this estimate reflects','items'=>['The type of tooth replacement you may need','Your treatment area','Possible complexity based on your answers','Whether additional support may be needed']],
            ['title'=>'What may affect your final cost','items'=>['Clinical exam findings','3D imaging','Bone grafting needs','Number of implants or restorations needed']],
            ["title"=>"What's included next",'items'=>['Complimentary consultation','Personalized treatment recommendations','A clearer next-step discussion with the team']],
        ], JSON_UNESCAPED_UNICODE),
        'imp_graft_display'    => 'addon',
        'imp_single_includes'  => json_encode([
            ['label'=>'Implant surgery',                      'enabled'=>true],
            ['label'=>'Abutment',                             'enabled'=>true],
            ['label'=>'Final crown / fixed prosthetic',       'enabled'=>true],
            ['label'=>'Surgical guide / treatment planning',  'enabled'=>false],
            ['label'=>'Temporary prosthesis',                 'enabled'=>false],
        ], JSON_UNESCAPED_UNICODE),
        'imp_fullarch_includes' => json_encode([
            ['label'=>'All-on-4/6 implant system',            'enabled'=>true],
            ['label'=>'Temporary fixed teeth',                'enabled'=>true],
            ['label'=>'Final prosthesis',                     'enabled'=>true],
            ['label'=>'Surgical guides',                      'enabled'=>true],
            ['label'=>'Temporary prosthesis (if applicable)', 'enabled'=>false],
        ], JSON_UNESCAPED_UNICODE),
        'imp_cta_book_enabled' => '1',
        'imp_cta_book_label'   => 'Book My Consultation',
        'imp_cta_book_url'     => '',
        'imp_cta_call_enabled' => '0',
        'imp_cta_call_label'   => 'Call the Office',
        'imp_cta_phone'        => '',
        'imp_consult_type'     => 'free',
        'imp_contact_title'    => 'Book Your Free Consultation',
        'imp_contact_subtitle' => "Enter your details and we'll reach out to confirm your free implant consultation.",
        'imp_contact_btn'      => 'Book My Free Consultation',
        'imp_contact_btn_url'  => '',
        'imp_contact_btn2_enabled' => '0',
        'imp_contact_btn2_label'   => 'Call Instead',
        'imp_contact_btn2_url'     => '',
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
//  GHL — AUTO-CREATE CUSTOM FIELDS + FOLDERS
// ═══════════════════════════════════════════════════════════════
function cfg_ghl_ensure_fields( $api_key, $location_id, $s ) {
    $logs = [];

    if ( ! $api_key || ! $location_id ) {
        return [ 'error' => 'missing api_key or location_id' ];
    }

    // Re-try every 6 hours — if the token gets upgraded we'll pick it up automatically
    $transient_key = 'cfg_ghl_fields_v8_' . md5( $location_id );
    if ( get_transient( $transient_key ) ) {
        return [ 'skipped' => 'transient active' ];
    }

    $base    = 'https://services.leadconnectorhq.com';
    $headers = [
        'Authorization' => 'Bearer ' . $api_key,
        'Content-Type'  => 'application/json',
        'Version'       => '2021-07-28',
    ];

    // ── Fetch existing custom field keys ──
    $existing_keys = [];
    $r_list = wp_remote_get( "{$base}/locations/{$location_id}/customFields", [
        'headers' => $headers,
        'timeout' => 10,
    ] );
    if ( is_wp_error( $r_list ) ) {
        $logs[] = 'customFields GET error: ' . $r_list->get_error_message();
        set_transient( $transient_key, '1', 6 * HOUR_IN_SECONDS );
        return $logs;
    }
    $list_code = wp_remote_retrieve_response_code( $r_list );
    if ( $list_code === 401 || $list_code === 403 ) {
        $logs[] = 'customFields GET ' . $list_code . ': token lacks custom-fields scope — create a Private Integration in GHL Settings with contacts.write + custom-fields.readonly + custom-fields.write';
        set_transient( $transient_key, '1', 6 * HOUR_IN_SECONDS );
        return $logs;
    }
    $b_list = json_decode( wp_remote_retrieve_body( $r_list ), true );
    foreach ( $b_list['customFields'] ?? [] as $f ) {
        if ( ! isset( $f['fieldKey'] ) ) continue;
        $fk   = $f['fieldKey'];                              // e.g. "contact.utmcampaign_custom"
        $bare = preg_replace( '/^contact\./', '', $fk );    // e.g. "utmcampaign_custom"
        $existing_keys[ $fk ]              = true;
        $existing_keys[ $bare ]            = true;
        $existing_keys[ strtolower($fk) ]  = true;
        $existing_keys[ strtolower($bare)] = true;
    }
    $logs[] = 'existing fields (' . count( $b_list['customFields'] ?? [] ) . '): ' . implode( ', ', array_column( $b_list['customFields'] ?? [], 'fieldKey' ) );

    // ── Fetch existing folders ──
    $existing_folders = [];
    $r_folders = wp_remote_get( "{$base}/locations/{$location_id}/customFieldsFolders", [
        'headers' => $headers,
        'timeout' => 10,
    ] );
    if ( ! is_wp_error( $r_folders ) ) {
        $fold_code = wp_remote_retrieve_response_code( $r_folders );
        $b_folders = json_decode( wp_remote_retrieve_body( $r_folders ), true );
        $logs[]    = 'folders GET status=' . $fold_code . ' body=' . wp_remote_retrieve_body( $r_folders );
        foreach ( $b_folders['folders'] ?? [] as $fd ) {
            if ( isset( $fd['name'] ) ) $existing_folders[ $fd['name'] ] = $fd['id'];
        }
    }

    // ── Create a folder (or return existing id) ──
    $make_folder = function( $name ) use ( $base, $headers, $location_id, &$existing_folders, &$logs ) {
        if ( isset( $existing_folders[ $name ] ) ) {
            $logs[] = 'folder "' . $name . '" already exists (id=' . $existing_folders[ $name ] . ')';
            return $existing_folders[ $name ];
        }
        $r = wp_remote_post( "{$base}/locations/{$location_id}/customFieldsFolders", [
            'headers' => $headers,
            'body'    => wp_json_encode( [ 'name' => $name ] ),
            'timeout' => 10,
        ] );
        if ( is_wp_error( $r ) ) {
            $logs[] = 'folder create "' . $name . '" WP_ERROR: ' . $r->get_error_message();
            return null;
        }
        $code   = wp_remote_retrieve_response_code( $r );
        $raw    = wp_remote_retrieve_body( $r );
        $b      = json_decode( $raw, true );
        $id     = $b['folder']['id'] ?? $b['id'] ?? null;
        $logs[] = 'folder create "' . $name . '" status=' . $code . ' id=' . $id . ' body=' . $raw;
        if ( $id ) $existing_folders[ $name ] = $id;
        return $id;
    };

    // ── Create a single custom field (skip if already exists) ──
    $make_field = function( $name, $key, $folder_id = null ) use ( $base, $headers, $location_id, $existing_keys, &$logs ) {
        if ( isset( $existing_keys[ $key ] ) || isset( $existing_keys[ strtolower($key) ] ) ) {
            $logs[] = '"' . $key . '" already exists — skipped';
            return;
        }
        $payload = [ 'name' => $name, 'fieldKey' => $key, 'dataType' => 'TEXT', 'position' => 0 ];
        if ( $folder_id ) $payload['parentId'] = $folder_id;
        $r      = wp_remote_post( "{$base}/locations/{$location_id}/customFields", [
            'headers' => $headers,
            'body'    => wp_json_encode( $payload ),
            'timeout' => 10,
        ] );
        $code   = is_wp_error( $r ) ? 'WP_ERROR' : wp_remote_retrieve_response_code( $r );
        $raw    = is_wp_error( $r ) ? $r->get_error_message() : wp_remote_retrieve_body( $r );
        $logs[] = '"' . $key . '" create status=' . $code . ' ' . $raw;
    };

    // ── Build implant field list dynamically from question editor ──
    $single_qs = json_decode( $s['imp_single_qs'], true ) ?: [];
    $multi_qs  = json_decode( $s['imp_multi_qs'],  true ) ?: [];
    $arch_qs   = json_decode( $s['imp_arch_qs'],   true ) ?: [];
    $ins_q     = json_decode( $s['imp_ins_q'],     true ) ?: null;
    $all_qs    = array_merge( $single_qs, $multi_qs, $arch_qs );
    if ( $ins_q ) $all_qs[] = $ins_q;

    $seen       = [];
    $imp_fields = [ 'implant_flow' => 'Flow Type', 'implant_range' => 'Estimated Range' ];
    foreach ( $all_qs as $q ) {
        $key = sanitize_key( $q['field'] ?? '' );
        if ( $key && ! isset( $seen[ $key ] ) ) {
            $seen[ $key ]                    = true;
            $imp_fields[ 'implant_' . $key ] = $q['title'] ?? $key;
        }
    }

    // ── Create folders then fields ──
    $cf_folder  = $make_folder( 'Contact Form' );
    $imp_folder = $make_folder( 'Implant Estimator' );
    $utm_folder = $make_folder( 'UTMs' );

    foreach ( [ 'treatment_type' => 'Treatment Type', 'automation_tester' => 'Automation Tester' ] as $key => $name ) {
        $make_field( $name, $key, $cf_folder );
    }
    foreach ( $imp_fields as $key => $name ) $make_field( $name, $key, $imp_folder );
    // key = GHL fieldKey = display name (both the same per client requirement)
    foreach ( [ 'UTMCampaign_custom', 'UTMMedium_custom', 'UTMContent_custom',
                'UTMKeyword_custom', 'UTMTerm_custom', 'GCLID_custom' ] as $utm_key ) {
        $make_field( $utm_key, $utm_key, $utm_folder );
    }

    // ── Fetch actual stored fieldKeys from GHL so we can map them correctly in payloads ──
    $r_verify = wp_remote_get( "{$base}/locations/{$location_id}/customFields", [
        'headers' => $headers,
        'timeout' => 10,
    ] );
    if ( ! is_wp_error( $r_verify ) ) {
        $b_verify = json_decode( wp_remote_retrieve_body( $r_verify ), true );
        // Match by bare fieldKey (strip contact. prefix, lowercase) — robust regardless of name casing
        $bare_to_post = [
            'utmcampaign_custom' => 'utm_campaign',
            'utmmedium_custom'   => 'utm_medium',
            'utmcontent_custom'  => 'utm_content',
            'utmkeyword_custom'  => 'utm_keyword',
            'utmterm_custom'     => 'utm_term',
            'gclid_custom'       => 'gclid',
        ];
        $key_map = [];
        foreach ( $b_verify['customFields'] ?? [] as $f ) {
            if ( ! isset( $f['fieldKey'] ) ) continue;
            $bare = strtolower( preg_replace( '/^contact\./', '', $f['fieldKey'] ) );
            if ( isset( $bare_to_post[ $bare ] ) ) {
                $key_map[ $bare_to_post[ $bare ] ] = $f['fieldKey'];
            }
        }
        update_option( 'cfg_utm_key_map_' . md5( $location_id ), $key_map );
        $logs[] = 'UTM key map stored: ' . wp_json_encode( $key_map );
    }

    set_transient( $transient_key, '1', 6 * HOUR_IN_SECONDS );
    return $logs;
}

// ═══════════════════════════════════════════════════════════════
//  GHL FIELDS — ADMIN AJAX: CHECK + CREATE
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_ajax_cfg_check_ghl_fields',      'cfg_ajax_check_ghl_fields' );
add_action( 'wp_ajax_cfg_create_ghl_field',      'cfg_ajax_create_ghl_field' );
add_action( 'wp_ajax_cfg_move_ghl_fields',       'cfg_ajax_move_ghl_fields' );
add_action( 'wp_ajax_cfg_save_folder_ids',       'cfg_ajax_save_folder_ids' );
add_action( 'wp_ajax_cfg_detect_folder_ids',     'cfg_ajax_detect_folder_ids' );
add_action( 'wp_ajax_cfg_create_checker_fields', 'cfg_ajax_create_checker_fields' );
add_action( 'wp_ajax_cfg_delete_checker_fields', 'cfg_ajax_delete_checker_fields' );

// Checker field definitions: key → folder name
function cfg_checker_fields() {
    return [
        'cfg_checker_contact_form'    => 'Contact Form',
        'cfg_checker_invisalign_form' => 'Invisalign Form',
        'cfg_checker_implants_form'   => 'Implants Form',
        'cfg_checker_utm_forms'       => 'UTM Forms',
    ];
}

function cfg_ajax_create_checker_fields() {
    check_ajax_referer( 'cfg_fields_nonce', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized.' );

    $s           = get_option( CFG_OPTION, [] ) + cfg_defaults();
    $api_key     = $s['ghl_api_key'] ?? '';
    $location_id = $s['ghl_location_id'] ?? '';
    if ( ! $api_key || ! $location_id ) wp_send_json_error( 'API key or Location ID not configured.' );

    $headers = [
        'Authorization' => 'Bearer ' . $api_key,
        'Content-Type'  => 'application/json',
        'Version'       => '2021-07-28',
    ];
    $base    = 'https://services.leadconnectorhq.com';
    $created = [];
    $errors  = [];

    foreach ( cfg_checker_fields() as $key => $folder ) {
        $label = ucwords( str_replace( [ 'cfg_checker_', '_' ], [ '', ' ' ], $key ) ) . ' Checker';
        $r     = wp_remote_post( "{$base}/locations/{$location_id}/customFields", [
            'headers' => $headers,
            'body'    => wp_json_encode( [ 'name' => $label, 'fieldKey' => $key, 'dataType' => 'TEXT', 'position' => 0 ] ),
            'timeout' => 15,
        ] );
        $code = is_wp_error( $r ) ? 0 : wp_remote_retrieve_response_code( $r );
        if ( $code >= 200 && $code < 300 ) {
            $created[] = $key;
        } else {
            $body = is_wp_error( $r ) ? $r->get_error_message() : ( json_decode( wp_remote_retrieve_body( $r ), true )['message'] ?? 'HTTP ' . $code );
            // 400 usually means field already exists — treat as ok
            if ( $code === 400 ) { $created[] = $key; } else { $errors[] = $key . ': ' . $body; }
        }
    }

    wp_send_json_success( [ 'created' => $created, 'errors' => $errors ] );
}

function cfg_ajax_delete_checker_fields() {
    check_ajax_referer( 'cfg_fields_nonce', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized.' );

    $s           = get_option( CFG_OPTION, [] ) + cfg_defaults();
    $api_key     = $s['ghl_api_key'] ?? '';
    $location_id = $s['ghl_location_id'] ?? '';
    if ( ! $api_key || ! $location_id ) wp_send_json_error( 'API key or Location ID not configured.' );

    $headers = [
        'Authorization' => 'Bearer ' . $api_key,
        'Content-Type'  => 'application/json',
        'Version'       => '2021-07-28',
    ];
    $base = 'https://services.leadconnectorhq.com';

    // Fetch all fields to find checker IDs
    $fr = wp_remote_get( "{$base}/locations/{$location_id}/customFields", [
        'headers' => $headers, 'timeout' => 15,
    ] );
    if ( is_wp_error( $fr ) ) wp_send_json_error( $fr->get_error_message() );

    $checker_keys = array_keys( cfg_checker_fields() );
    $deleted = [];
    $errors  = [];

    foreach ( json_decode( wp_remote_retrieve_body( $fr ), true )['customFields'] ?? [] as $f ) {
        $bare = strtolower( preg_replace( '/^contact\./', '', $f['fieldKey'] ?? '' ) );
        if ( ! in_array( $bare, $checker_keys, true ) ) continue;

        $dr   = wp_remote_request( "{$base}/locations/{$location_id}/customFields/{$f['id']}", [
            'method'  => 'DELETE',
            'headers' => $headers,
            'timeout' => 15,
        ] );
        $code = is_wp_error( $dr ) ? 0 : wp_remote_retrieve_response_code( $dr );
        if ( $code >= 200 && $code < 300 ) {
            $deleted[] = $bare;
        } else {
            $errors[] = $bare . ': HTTP ' . $code;
        }
    }

    wp_send_json_success( [ 'deleted' => $deleted, 'errors' => $errors ] );
}

function cfg_ghl_field_definitions( $s ) {
    // ── Implant fields (dynamic from question editor) ──
    $single_qs = json_decode( $s['imp_single_qs'], true ) ?: [];
    $multi_qs  = json_decode( $s['imp_multi_qs'],  true ) ?: [];
    $arch_qs   = json_decode( $s['imp_arch_qs'],   true ) ?: [];
    $ins_q     = json_decode( $s['imp_ins_q'],     true ) ?: null;
    $all_qs    = array_merge( $single_qs, $multi_qs, $arch_qs );
    if ( $ins_q ) $all_qs[] = $ins_q;

    $imp_fields   = [];
    $imp_fields[] = [ 'name' => 'Flow Type',      'key' => 'implant_flow' ];
    $imp_fields[] = [ 'name' => 'Estimated Range', 'key' => 'implant_range' ];
    $seen = [];
    foreach ( $all_qs as $q ) {
        $k = sanitize_key( $q['field'] ?? '' );
        if ( $k && ! isset( $seen[$k] ) ) {
            $seen[$k]     = true;
            $imp_fields[] = [ 'name' => $q['title'] ?? $k, 'key' => 'implant_' . $k ];
        }
    }

    // ── Invisalign fields (dynamic from aligner quiz steps) ──
    $alg_steps  = cfg_aligner_get();
    $alg_fields = [];
    foreach ( $alg_steps as $step ) {
        if ( empty( $step['field_key'] ) ) continue;
        $alg_fields[] = [
            'name' => $step['question'] ?? $step['field_key'],
            'key'  => sanitize_key( $step['field_key'] ),
        ];
    }

    // Each field has: name, key, folder (GHL folder name to put it in)
    $cf = array_map( fn($f) => $f + ['folder' => 'Contact Form'],    [
        [ 'name' => 'Treatment Type',    'key' => 'treatment_type' ],
        [ 'name' => 'Automation Tester', 'key' => 'automation_tester' ],
    ] );
    $alg = array_map( fn($f) => $f + ['folder' => 'Invisalign Form'],  $alg_fields );
    $imp = array_map( fn($f) => $f + ['folder' => 'Implants Form'],    $imp_fields );
    $utms = array_map( fn($f) => $f + ['folder' => 'UTM Forms'], [
        [ 'name' => 'UTMCampaign_custom', 'key' => 'UTMCampaign_custom' ],
        [ 'name' => 'UTMMedium_custom',   'key' => 'UTMMedium_custom' ],
        [ 'name' => 'UTMContent_custom',  'key' => 'UTMContent_custom' ],
        [ 'name' => 'UTMKeyword_custom',  'key' => 'UTMKeyword_custom' ],
        [ 'name' => 'UTMTerm_custom',     'key' => 'UTMTerm_custom' ],
        [ 'name' => 'GCLID_custom',       'key' => 'GCLID_custom' ],
    ] );

    return [
        'Contact Form'   => $cf,
        'Invisalign Form' => $alg,
        'Implants Form'  => $imp,
        'UTM Forms'      => $utms,
    ];
}

function cfg_ajax_check_ghl_fields() {
    check_ajax_referer( 'cfg_fields_nonce', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized.' );

    $s           = get_option( CFG_OPTION, [] ) + cfg_defaults();
    $api_key     = $s['ghl_api_key'] ?? '';
    $location_id = $s['ghl_location_id'] ?? '';

    if ( ! $api_key || ! $location_id ) wp_send_json_error( 'API key or Location ID not configured.' );

    $r = wp_remote_get( 'https://services.leadconnectorhq.com/locations/' . $location_id . '/customFields', [
        'headers' => [
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type'  => 'application/json',
            'Version'       => '2021-07-28',
        ],
        'timeout' => 15,
    ] );

    if ( is_wp_error( $r ) ) wp_send_json_error( $r->get_error_message() );
    $code = wp_remote_retrieve_response_code( $r );
    if ( $code === 401 || $code === 403 ) wp_send_json_error( 'Token lacks custom-fields scope (HTTP ' . $code . ').' );

    $body   = json_decode( wp_remote_retrieve_body( $r ), true );
    $existing = [];
    foreach ( $body['customFields'] ?? [] as $f ) {
        if ( isset( $f['fieldKey'] ) ) {
            $bare = strtolower( preg_replace( '/^contact\./', '', $f['fieldKey'] ) );
            $existing[ $bare ]             = $f['fieldKey'];
            $existing[ $f['fieldKey'] ]    = $f['fieldKey'];
            $existing[ strtolower($f['fieldKey']) ] = $f['fieldKey'];
        }
    }

    $defs    = cfg_ghl_field_definitions( $s );
    $result  = [];
    foreach ( $defs as $group => $fields ) {
        foreach ( $fields as $f ) {
            $bare   = strtolower( $f['key'] );
            $exists = isset( $existing[ $bare ] ) || isset( $existing[ $f['key'] ] );
            $result[] = [
                'group'  => $group,
                'name'   => $f['name'],
                'key'    => $f['key'],
                'exists' => $exists,
            ];
        }
    }

    wp_send_json_success( $result );
}

function cfg_ajax_create_ghl_field() {
    check_ajax_referer( 'cfg_fields_nonce', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized.' );

    $s           = get_option( CFG_OPTION, [] ) + cfg_defaults();
    $api_key     = $s['ghl_api_key'] ?? '';
    $location_id = $s['ghl_location_id'] ?? '';
    $field_key   = sanitize_text_field( $_POST['field_key'] ?? '' );
    $field_name  = sanitize_text_field( $_POST['field_name'] ?? $field_key );
    $folder_name = sanitize_text_field( $_POST['folder'] ?? '' );

    if ( ! $api_key || ! $location_id || ! $field_key ) wp_send_json_error( 'Missing parameters.' );

    $headers = [
        'Authorization' => 'Bearer ' . $api_key,
        'Content-Type'  => 'application/json',
        'Version'       => '2021-07-28',
    ];
    $base = 'https://services.leadconnectorhq.com';

    // ── Resolve folder parentId if a folder name was provided ──
    $parent_id = null;
    if ( $folder_name ) {
        $fr = wp_remote_get( "{$base}/locations/{$location_id}/customFieldsFolders", [
            'headers' => $headers,
            'timeout' => 15,
        ] );
        if ( ! is_wp_error( $fr ) && wp_remote_retrieve_response_code( $fr ) < 300 ) {
            $fb = json_decode( wp_remote_retrieve_body( $fr ), true );
            foreach ( $fb['folders'] ?? [] as $folder ) {
                if ( strtolower( $folder['name'] ) === strtolower( $folder_name ) ) {
                    $parent_id = $folder['id'];
                    break;
                }
            }
        }
        // Create folder if it doesn't exist yet
        if ( ! $parent_id ) {
            $cr = wp_remote_post( "{$base}/locations/{$location_id}/customFieldsFolders", [
                'headers' => $headers,
                'body'    => wp_json_encode( [ 'name' => $folder_name ] ),
                'timeout' => 15,
            ] );
            if ( ! is_wp_error( $cr ) ) {
                $cb = json_decode( wp_remote_retrieve_body( $cr ), true );
                $parent_id = $cb['folder']['id'] ?? $cb['id'] ?? null;
            }
        }
    }

    // ── Create the custom field ──
    $payload = [
        'name'     => $field_name,
        'fieldKey' => $field_key,
        'dataType' => 'TEXT',
        'position' => 0,
    ];
    if ( $parent_id ) $payload['parentId'] = $parent_id;

    $r    = wp_remote_post( "{$base}/locations/{$location_id}/customFields", [
        'headers' => $headers,
        'body'    => wp_json_encode( $payload ),
        'timeout' => 15,
    ] );

    if ( is_wp_error( $r ) ) wp_send_json_error( $r->get_error_message() );
    $code = wp_remote_retrieve_response_code( $r );
    $body = json_decode( wp_remote_retrieve_body( $r ), true );

    if ( $code >= 200 && $code < 300 ) {
        // Bust the UTM key map cache so it refreshes
        delete_option( 'cfg_utm_key_map_' . md5( $location_id ) );
        wp_send_json_success( 'Field created.' );
    } else {
        wp_send_json_error( $body['message'] ?? 'HTTP ' . $code );
    }
}

// Helper: get stored folder IDs for a location
function cfg_get_folder_ids( $location_id ) {
    return get_option( 'cfg_folder_ids_' . md5( $location_id ), [] );
    // Shape: [ 'Contact Form' => 'xxx', 'Invisalign' => 'yyy', ... ]
}

function cfg_ajax_save_folder_ids() {
    check_ajax_referer( 'cfg_fields_nonce', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized.' );

    $s           = get_option( CFG_OPTION, [] ) + cfg_defaults();
    $location_id = $s['ghl_location_id'] ?? '';
    if ( ! $location_id ) wp_send_json_error( 'Location ID not configured.' );

    $map = [];
    foreach ( [ 'Contact Form', 'Invisalign Form', 'Implants Form', 'UTM Forms' ] as $name ) {
        $id = sanitize_text_field( $_POST[ 'folder_' . str_replace( ' ', '_', strtolower( $name ) ) ] ?? '' );
        if ( $id ) $map[ $name ] = $id;
    }
    update_option( 'cfg_folder_ids_' . md5( $location_id ), $map );
    wp_send_json_success( $map );
}

function cfg_ajax_detect_folder_ids() {
    check_ajax_referer( 'cfg_fields_nonce', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized.' );

    $s           = get_option( CFG_OPTION, [] ) + cfg_defaults();
    $api_key     = $s['ghl_api_key'] ?? '';
    $location_id = $s['ghl_location_id'] ?? '';
    if ( ! $api_key || ! $location_id ) wp_send_json_error( 'API key or Location ID not configured.' );

    $base    = 'https://services.leadconnectorhq.com';
    $headers = [
        'Authorization' => 'Bearer ' . $api_key,
        'Content-Type'  => 'application/json',
        'Version'       => '2021-07-28',
    ];

    $fr   = wp_remote_get( "{$base}/locations/{$location_id}/customFields", [
        'headers' => $headers, 'timeout' => 15,
    ] );
    if ( is_wp_error( $fr ) ) wp_send_json_error( $fr->get_error_message() );
    $body = json_decode( wp_remote_retrieve_body( $fr ), true );

    // ── 1. Try to match by name from a `folders` key in the response ──
    $target_names = [ 'Contact Form', 'Invisalign Form', 'Implants Form', 'UTM Forms' ];
    $by_name      = [];
    foreach ( $body['folders'] ?? [] as $folder ) {
        if ( ! empty( $folder['id'] ) && ! empty( $folder['name'] ) ) {
            $by_name[ strtolower( trim( $folder['name'] ) ) ] = $folder['id'];
        }
    }

    // ── 2. Collect parentIds from existing fields (fallback) ──
    $parent_ids = [];
    foreach ( $body['customFields'] ?? [] as $f ) {
        if ( ! empty( $f['parentId'] ) ) {
            $bare = strtolower( preg_replace( '/^contact\./', '', $f['fieldKey'] ?? '' ) );
            $parent_ids[ $f['parentId'] ][] = $bare;
        }
    }

    // ── 3. Build matched map: folder name → id ──
    $matched = [];
    foreach ( $target_names as $name ) {
        $key = strtolower( $name );
        if ( isset( $by_name[ $key ] ) ) {
            $matched[ $name ] = $by_name[ $key ];
        }
    }

    $stored = cfg_get_folder_ids( $location_id );

    // If we got matches by name, auto-save them
    if ( ! empty( $matched ) ) {
        $merged = array_merge( $stored, $matched );
        update_option( 'cfg_folder_ids_' . md5( $location_id ), $merged );
        $stored = $merged;
    }

    wp_send_json_success( [
        'detected'   => $parent_ids,
        'by_name'    => $matched,   // folder name → id from API folders key
        'stored'     => $stored,
        'raw_folders'=> $body['folders'] ?? [],  // full raw so JS can show it
    ] );
}

function cfg_ajax_move_ghl_fields() {
    check_ajax_referer( 'cfg_fields_nonce', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized.' );

    $s           = get_option( CFG_OPTION, [] ) + cfg_defaults();
    $api_key     = $s['ghl_api_key'] ?? '';
    $location_id = $s['ghl_location_id'] ?? '';
    if ( ! $api_key || ! $location_id ) wp_send_json_error( 'API key or Location ID not configured.' );

    // ── Folder IDs must be stored first ──
    $folder_map = cfg_get_folder_ids( $location_id );
    if ( empty( $folder_map ) ) {
        wp_send_json_error( 'No folder IDs saved yet. Enter and save folder IDs in the Folder IDs section first.' );
    }

    $headers = [
        'Authorization' => 'Bearer ' . $api_key,
        'Content-Type'  => 'application/json',
        'Version'       => '2021-07-28',
    ];
    $base = 'https://services.leadconnectorhq.com';

    // ── Fetch existing GHL fields ──
    $fr = wp_remote_get( "{$base}/locations/{$location_id}/customFields", [
        'headers' => $headers, 'timeout' => 15,
    ] );
    if ( is_wp_error( $fr ) ) wp_send_json_error( $fr->get_error_message() );

    $ghl_fields = [];
    foreach ( json_decode( wp_remote_retrieve_body( $fr ), true )['customFields'] ?? [] as $f ) {
        if ( empty( $f['fieldKey'] ) ) continue;
        $bare = strtolower( preg_replace( '/^contact\./', '', $f['fieldKey'] ) );
        $ghl_fields[ $bare ] = $f;
    }

    $defs    = cfg_ghl_field_definitions( $s );
    $moved   = 0;
    $skipped = 0;
    $errors  = [];

    foreach ( $defs as $group => $fields ) {
        $folder_name = $group;
        $folder_id   = $folder_map[ $folder_name ] ?? null;
        if ( ! $folder_id ) { foreach ( $fields as $f ) $errors[] = $f['key'] . ': no folder ID for "' . $folder_name . '"'; continue; }

        foreach ( $fields as $f ) {
            $bare  = strtolower( $f['key'] );
            if ( ! isset( $ghl_fields[ $bare ] ) ) { $skipped++; continue; }

            $ghl_f = $ghl_fields[ $bare ];
            // Already in the right folder? skip.
            if ( ( $ghl_f['parentId'] ?? null ) === $folder_id ) { $skipped++; continue; }

            $pr    = wp_remote_request( "{$base}/locations/{$location_id}/customFields/{$ghl_f['id']}", [
                'method'  => 'PUT',
                'headers' => $headers,
                'body'    => wp_json_encode( [ 'parentId' => $folder_id ] ),
                'timeout' => 15,
            ] );
            $pcode = is_wp_error( $pr ) ? 0 : wp_remote_retrieve_response_code( $pr );
            if ( $pcode >= 200 && $pcode < 300 ) {
                $moved++;
            } else {
                $pb = is_wp_error( $pr ) ? $pr->get_error_message() : ( json_decode( wp_remote_retrieve_body( $pr ), true )['message'] ?? 'HTTP ' . $pcode );
                $errors[] = $f['key'] . ': ' . $pb;
            }
        }
    }

    wp_send_json_success( [ 'moved' => $moved, 'skipped' => $skipped, 'errors' => $errors ] );
}

// ═══════════════════════════════════════════════════════════════
//  ENTRY LOGGER
// ═══════════════════════════════════════════════════════════════
function cfg_log_entry( $form_type, $first, $last, $email, $phone, $meta = [], $ghl_status = 'ok' ) {
    global $wpdb;
    if ( get_option( 'cfg_entries_db_version' ) !== CFG_ENTRIES_DB_VER ) {
        cfg_create_entries_table();
    }
    $wpdb->insert(
        $wpdb->prefix . 'cfg_entries',
        [
            'form_type'  => $form_type,
            'first_name' => $first,
            'last_name'  => $last,
            'email'      => $email,
            'phone'      => $phone,
            'meta'       => wp_json_encode( $meta ),
            'ghl_status' => $ghl_status,
            'created_at' => current_time( 'mysql' ),
        ],
        [ '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ]
    );

    // ── GHL error alert ──
    if ( $ghl_status === 'error' ) {
        $admin_email = get_option( 'admin_email' );
        $form_labels = [ 'contact' => 'Contact Form', 'aligner' => 'Aligner Quiz', 'implant' => 'Implant Estimator' ];
        $label       = $form_labels[ $form_type ] ?? $form_type;
        wp_mail(
            $admin_email,
            '[Contact Form GHL] GHL submission failed — ' . $label,
            "A form submission failed to reach GoHighLevel.\n\n"
            . "Form: {$label}\n"
            . "Name: {$first} {$last}\n"
            . "Email: {$email}\n"
            . "Phone: {$phone}\n\n"
            . "Check the Entries tab in your WordPress admin for details:\n"
            . admin_url( 'admin.php?page=' . CFG_SLUG . '&cfg_tab=entries' )
        );
    }
}

// ═══════════════════════════════════════════════════════════════
//  DASHBOARD WIDGET
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_dashboard_setup', function () {
    wp_add_dashboard_widget(
        'cfg_dashboard_widget',
        '📋 Contact Form GHL — Submissions',
        'cfg_render_dashboard_widget'
    );
} );

function cfg_render_dashboard_widget() {
    global $wpdb;
    $table  = $wpdb->prefix . 'cfg_entries';
    $today  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE DATE(created_at) = CURDATE()" );
    $week   = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)" );
    $month  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)" );
    $last   = $wpdb->get_var( "SELECT created_at FROM {$table} ORDER BY created_at DESC LIMIT 1" );
    $errors = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE ghl_status = 'error' AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)" );
    $entries_url = admin_url( 'admin.php?page=' . CFG_SLUG . '&cfg_tab=entries' );
    ?>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:14px;">
        <div style="background:#eff6ff;border-radius:8px;padding:12px 14px;text-align:center;">
            <div style="font-size:24px;font-weight:700;color:#1d4ed8;"><?= $today ?></div>
            <div style="font-size:11px;color:#3b82f6;margin-top:2px;font-weight:600;">TODAY</div>
        </div>
        <div style="background:#f0fdf4;border-radius:8px;padding:12px 14px;text-align:center;">
            <div style="font-size:24px;font-weight:700;color:#16a34a;"><?= $week ?></div>
            <div style="font-size:11px;color:#22c55e;margin-top:2px;font-weight:600;">THIS WEEK</div>
        </div>
        <div style="background:#faf5ff;border-radius:8px;padding:12px 14px;text-align:center;">
            <div style="font-size:24px;font-weight:700;color:#7c3aed;"><?= $month ?></div>
            <div style="font-size:11px;color:#a855f7;margin-top:2px;font-weight:600;">30 DAYS</div>
        </div>
    </div>
    <?php if ( $last ): ?>
    <p style="font-size:12px;color:#6b7280;margin:0 0 6px;">
        Last submission: <strong><?= esc_html( date( 'M j, Y g:ia', strtotime( $last ) ) ) ?></strong>
    </p>
    <?php endif; ?>
    <?php if ( $errors > 0 ): ?>
    <p style="font-size:12px;color:#b91c1c;margin:0 0 10px;">
        ⚠ <?= $errors ?> GHL error<?= $errors > 1 ? 's' : '' ?> in the last 7 days
    </p>
    <?php endif; ?>
    <a href="<?= esc_url( $entries_url ) ?>" style="font-size:12px;color:#2271b1;">View all entries →</a>
    <?php
}

// ═══════════════════════════════════════════════════════════════
//  INTL-TEL-INPUT — country code phone picker (all forms)
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_head', function () {
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23/build/css/intlTelInput.min.css"/>';
    echo '<style>
        .iti{display:block!important;width:100%!important;}
        .iti__flag-container{z-index:10;}
        .iti input[type="tel"]{width:100%!important;box-sizing:border-box!important;}
        .iti__selected-dial-code{font-size:.875rem;}
        .iti__dropdown-content{border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,.12);}
    </style>';
} );

add_action( 'wp_footer', function () {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23/build/js/intlTelInput.min.js"></script>
    <script>
    (function(){
        var ITI_UTILS = 'https://cdn.jsdelivr.net/npm/intl-tel-input@23/build/js/utils.js';

        function cfgFmtNational(el, iti) {
            if (!window.intlTelInputUtils || !el.value.trim()) return;
            var iso  = iti.getSelectedCountryData().iso2;
            var fmt  = intlTelInputUtils.formatNumber(
                el.value, iso, intlTelInputUtils.numberFormat.NATIONAL
            );
            if (fmt) el.value = fmt;
        }

        function cfgInitPhone(el) {
            if (el.dataset.itiDone || !window.intlTelInput) return;
            el.dataset.itiDone = '1';

            var iti = window.intlTelInput(el, {
                initialCountry:   'auto',
                geoIpLookup: function(cb) {
                    fetch('https://ipapi.co/json/')
                        .then(function(r){ return r.json(); })
                        .then(function(d){ cb(d.country_code || 'us'); })
                        .catch(function(){ cb('us'); });
                },
                separateDialCode:  true,
                autoPlaceholder:  'polite',
                formatOnDisplay:   true,
                loadUtilsOnInit:   ITI_UTILS,
            });
            el._cfgIti = iti;

            // Format on blur
            el.addEventListener('blur', function(){ cfgFmtNational(el, iti); });

            // Re-format when country changes
            el.closest('.iti') && el.closest('.iti').addEventListener('countrychange', function(){
                cfgFmtNational(el, iti);
            });
        }

        document.addEventListener('DOMContentLoaded', function(){
            document.querySelectorAll('input[type="tel"]').forEach(cfgInitPhone);
        });

        // Dynamically added inputs (quiz steps etc.)
        new MutationObserver(function(muts){
            muts.forEach(function(m){
                m.addedNodes.forEach(function(n){
                    if (n.nodeType !== 1) return;
                    (n.querySelectorAll ? n.querySelectorAll('input[type="tel"]') : []).forEach(cfgInitPhone);
                    if (n.matches && n.matches('input[type="tel"]')) cfgInitPhone(n);
                });
            });
        }).observe(document.body, { childList:true, subtree:true });

        // Before any form submit — replace value with full E.164 international number
        document.addEventListener('submit', function(e){
            var ph = e.target.querySelector('input[type="tel"]');
            if (ph && ph._cfgIti) ph.value = ph._cfgIti.getNumber() || ph.value;
        }, true);
    })();
    </script>
    <?php
} );

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
        'ty_social_url','ty_image_url','alg_success_url','imp_success_url','imp_cta_book_url',
        'imp_intro_btn_url','imp_contact_btn_url','imp_contact_btn2_url',
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
        'imp_cta_book_enabled','imp_cta_call_enabled','imp_contact_btn2_enabled',
    ];
    $json_fields = ['imp_router_opts','imp_single_qs','imp_multi_qs','imp_arch_qs','imp_ins_q','imp_result_sections','imp_single_includes','imp_fullarch_includes'];

    // ── Rebuild JSON from UI array inputs ──
    // single includes
    $si_lbls = array_values( $input['imp_single_includes_lbl'] ?? [] );
    $si_chks = $input['imp_single_includes_chk'] ?? [];
    $si_new  = [];
    foreach ( $si_lbls as $i => $lbl ) {
        $lbl = sanitize_text_field( $lbl );
        if ( $lbl !== '' ) $si_new[] = ['label' => $lbl, 'enabled' => ! empty( $si_chks[ $i ] )];
    }
    if ( ! empty( $si_new ) ) $input['imp_single_includes'] = json_encode( $si_new, JSON_UNESCAPED_UNICODE );

    // fullarch includes
    $ai_lbls = array_values( $input['imp_fullarch_includes_lbl'] ?? [] );
    $ai_chks = $input['imp_fullarch_includes_chk'] ?? [];
    $ai_new  = [];
    foreach ( $ai_lbls as $i => $lbl ) {
        $lbl = sanitize_text_field( $lbl );
        if ( $lbl !== '' ) $ai_new[] = ['label' => $lbl, 'enabled' => ! empty( $ai_chks[ $i ] )];
    }
    if ( ! empty( $ai_new ) ) $input['imp_fullarch_includes'] = json_encode( $ai_new, JSON_UNESCAPED_UNICODE );

    // result sections
    $sec_titles = $input['imp_result_sections_title'] ?? [];
    $sec_items  = $input['imp_result_sections_items'] ?? [];
    $secs_new   = [];
    foreach ( $sec_titles as $si => $title ) {
        $title = sanitize_text_field( $title );
        if ( $title === '' ) continue;
        $items = array_values( array_filter( array_map( 'sanitize_text_field', $sec_items[ $si ] ?? [] ), fn($x) => $x !== '' ) );
        $secs_new[] = ['title' => $title, 'items' => $items];
    }
    if ( ! empty( $secs_new ) ) $input['imp_result_sections'] = json_encode( $secs_new, JSON_UNESCAPED_UNICODE );

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
        } elseif ( in_array( $key, $json_fields ) ) {
            $decoded = json_decode( $input[ $key ] ?? '', true );
            $clean[ $key ] = $decoded !== null ? json_encode( $decoded, JSON_UNESCAPED_UNICODE ) : $default;
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
    add_menu_page(
        'Contact Form GHL', 'Contact Form GHL',
        'manage_options', CFG_SLUG, 'cfg_settings_page',
        'dashicons-feedback', 30
    );
    add_submenu_page( CFG_SLUG, 'Settings — Contact Form GHL', 'Settings', 'manage_options', CFG_SLUG, 'cfg_settings_page' );
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
    <h1 style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
        <span style="flex-shrink:0;display:inline-block;width:48px;height:48px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.18);overflow:hidden;line-height:0;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="48" height="48"><defs><linearGradient id="cfg-bg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#0f172a"/><stop offset="100%" style="stop-color:#1e293b"/></linearGradient><linearGradient id="cfg-acc" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#f59e0b"/><stop offset="100%" style="stop-color:#ef4444"/></linearGradient></defs><rect width="256" height="256" rx="40" fill="url(#cfg-bg)"/><rect x="22" y="54" width="88" height="112" rx="10" fill="#1e3a5f"/><rect x="22" y="54" width="88" height="112" rx="10" fill="none" stroke="#334155" stroke-width="1.5"/><rect x="34" y="76" width="64" height="7" rx="3.5" fill="#475569"/><rect x="34" y="91" width="64" height="7" rx="3.5" fill="#334155"/><rect x="34" y="108" width="40" height="7" rx="3.5" fill="#475569"/><rect x="34" y="123" width="64" height="7" rx="3.5" fill="#334155"/><rect x="34" y="138" width="50" height="7" rx="3.5" fill="#475569"/><rect x="34" y="152" width="64" height="4" rx="2" fill="url(#cfg-acc)" opacity="0.6"/><line x1="118" y1="110" x2="140" y2="110" stroke="url(#cfg-acc)" stroke-width="3" stroke-linecap="round"/><polyline points="133,103 141,110 133,117" fill="none" stroke="url(#cfg-acc)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><rect x="146" y="78" width="88" height="64" rx="10" fill="url(#cfg-acc)"/><text x="190" y="121" font-family="Arial Black,Arial,sans-serif" font-weight="900" font-size="26" fill="#0f172a" text-anchor="middle" letter-spacing="-1">GHL</text><text x="128" y="193" font-family="Arial,sans-serif" font-weight="700" font-size="13" fill="#94a3b8" text-anchor="middle" letter-spacing="2">CONTACT FORM</text><text x="128" y="212" font-family="Arial,sans-serif" font-size="10" fill="#475569" text-anchor="middle" letter-spacing="1.5">INTEGRATION</text><circle cx="128" cy="232" r="3" fill="url(#cfg-acc)" opacity="0.7"/><circle cx="118" cy="232" r="2" fill="#475569" opacity="0.5"/><circle cx="138" cy="232" r="2" fill="#475569" opacity="0.5"/></svg></span>
        <span style="font-size:20px;font-weight:600;color:#1d2327;">Contact Form Settings</span>
    </h1>
    <?php if ( $saved ): ?>
    <div class="notice notice-success is-dismissible"><p><strong>Settings saved.</strong></p></div>
    <?php endif; ?>

    <style>
    /* ════════════════════════════════
       LAYOUT
    ════════════════════════════════ */
    #cfg-root{display:flex;align-items:flex-start;gap:0;margin:16px 0 0 -20px;min-height:85vh;}

    /* ════════════════════════════════
       SIDEBAR
    ════════════════════════════════ */
    .cfg-sidebar{
        width:220px;flex-shrink:0;
        background:#16181d;
        border-radius:10px 0 0 10px;
        padding:0 0 28px;
        position:sticky;top:32px;
        align-self:flex-start;
        overflow:hidden;
    }
    .cfg-sidebar-brand{
        display:flex;align-items:center;gap:11px;
        padding:20px 18px 17px;
        background:linear-gradient(180deg,#1e2128 0%,#16181d 100%);
        border-bottom:1px solid rgba(255,255,255,.06);
        margin-bottom:8px;
    }
    .cfg-brand-icon{
        width:34px;height:34px;border-radius:8px;
        background:linear-gradient(135deg,#3b82f6,#1d4ed8);
        display:flex;align-items:center;justify-content:center;
        font-size:10px;font-weight:800;color:#fff;letter-spacing:.03em;flex-shrink:0;
        box-shadow:0 2px 8px rgba(59,130,246,.35);
    }
    .cfg-brand-name{font-size:13px;font-weight:700;color:#fff;line-height:1.25;}
    .cfg-brand-sub{font-size:10px;color:rgba(255,255,255,.32);margin-top:2px;letter-spacing:.02em;}
    /* ── Group ── */
    .cfg-nav-group{margin:0 8px 2px;}
    .cfg-nav-group-hdr{
        display:flex;align-items:center;justify-content:space-between;
        padding:8px 10px;border-radius:6px;
        font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.09em;
        color:rgba(255,255,255,.35);
        cursor:pointer;transition:background .15s,color .15s;
        user-select:none;
    }
    .cfg-nav-group-hdr:hover{background:rgba(255,255,255,.05);color:rgba(255,255,255,.6);}
    .cfg-nav-group-hdr.open{color:rgba(255,255,255,.55);}
    .cfg-nav-arr{transition:transform .2s;flex-shrink:0;opacity:.5;}
    .cfg-nav-group-hdr.open .cfg-nav-arr{transform:rotate(90deg);opacity:.8;}
    .cfg-nav-group-body{overflow:hidden;transition:max-height .25s ease;}
    /* ── Item ── */
    .cfg-nav-item{
        display:flex;align-items:center;gap:9px;
        padding:7px 10px 7px 14px;
        border-radius:6px;
        font-size:12.5px;color:rgba(255,255,255,.55);
        cursor:pointer;transition:background .15s,color .15s;
        user-select:none;position:relative;
    }
    .cfg-nav-item:hover{background:rgba(255,255,255,.07);color:rgba(255,255,255,.88);}
    .cfg-nav-item.active{
        background:rgba(59,130,246,.18);
        color:#fff;font-weight:600;
    }
    .cfg-nav-item.active::before{
        content:'';position:absolute;left:0;top:20%;bottom:20%;
        width:2px;background:#3b82f6;border-radius:2px;
    }
    .cfg-nav-item-icon{width:15px;height:15px;opacity:.6;flex-shrink:0;}
    .cfg-nav-item.active .cfg-nav-item-icon{opacity:1;}
    /* ── Standalone items (outside groups) ── */
    .cfg-nav-standalone{margin:2px 8px;}
    /* ── Separator ── */
    .cfg-nav-sep{border:none;border-top:1px solid rgba(255,255,255,.06);margin:10px 14px;}
    /* ── Data section ── */
    .cfg-nav-section-label{
        padding:12px 18px 5px;
        font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.12em;
        color:rgba(255,255,255,.28);
    }

    /* ════════════════════════════════
       MAIN CONTENT
    ════════════════════════════════ */
    .cfg-main{flex:1;min-width:0;}

    /* ════════════════════════════════
       PANELS
    ════════════════════════════════ */
    .cfg-panel{
        display:none;
        background:#fff;
        border:1px solid #e2e4e9;
        border-left:none;
        border-radius:0 10px 10px 0;
        min-height:580px;
        overflow:hidden;
    }
    .cfg-panel.active{display:block;}
    .cfg-panel-hdr{
        padding:22px 32px 18px;
        border-bottom:1px solid #f1f3f6;
        background:linear-gradient(180deg,#fafbfc 0%,#fff 100%);
    }
    .cfg-panel-hdr h2{margin:0 0 3px;font-size:17px;font-weight:700;color:#0f172a;}
    .cfg-panel-hdr p{margin:0;font-size:12.5px;color:#6b7280;}
    .cfg-panel-body{padding:26px 32px 32px;}
    /* ── Save bar ── */
    #cfg-save-bar{
        background:#fafbfc;
        border:1px solid #e2e4e9;border-left:none;border-top:1px solid #e2e4e9;
        border-radius:0 0 10px 0;
        padding:14px 32px;
    }

    /* ════════════════════════════════
       FORM ELEMENTS
    ════════════════════════════════ */
    .cfg-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px 28px;}
    .cfg-full{grid-column:span 2;}
    .cfg-field{display:flex;flex-direction:column;gap:6px;}
    .cfg-field label{font-weight:600;font-size:12.5px;color:#374151;letter-spacing:.01em;}
    .cfg-field input[type=text],.cfg-field input[type=url],.cfg-field input[type=password],.cfg-field select,.cfg-field textarea{
        width:100%;padding:8px 12px;
        border:1px solid #d1d5db;border-radius:6px;
        font-size:13px;background:#fff;
        transition:border-color .15s,box-shadow .15s;color:#111827;
        box-shadow:0 1px 2px rgba(0,0,0,.04);
    }
    .cfg-field input:focus,.cfg-field select:focus,.cfg-field textarea:focus{
        border-color:#3b82f6;outline:none;box-shadow:0 0 0 3px rgba(59,130,246,.12);
    }
    .cfg-field textarea{min-height:80px;font-family:monospace;resize:vertical;line-height:1.55;}
    .cfg-desc{color:#6b7280;font-size:11.5px;line-height:1.55;margin-top:1px;}
    /* ── Toggle rows ── */
    .cfg-toggle-row{
        display:flex;align-items:center;gap:12px;
        padding:11px 0;border-bottom:1px solid #f3f4f6;
    }
    .cfg-toggle-row:last-child{border-bottom:none;}
    .cfg-toggle-row label{flex:1;font-size:13px;cursor:pointer;color:#1d2327;}
    .cfg-toggle-row input[type=checkbox]{width:16px;height:16px;cursor:pointer;accent-color:#3b82f6;}
    /* ── Section titles ── */
    .cfg-section-title{
        display:flex;align-items:center;gap:9px;
        font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;
        color:#374151;margin:28px 0 16px;
    }
    .cfg-section-title::before{
        content:'';display:inline-block;
        width:3px;height:14px;border-radius:2px;
        background:linear-gradient(180deg,#3b82f6,#1d4ed8);
        flex-shrink:0;
    }
    .cfg-section-title:first-child{margin-top:0;}
    /* ── Card sections ── */
    .cfg-card-section{
        background:#fafafa;
        border:1px solid #e5e7eb;
        border-radius:8px;
        padding:18px 22px;
        margin-bottom:16px;
        box-shadow:0 1px 3px rgba(0,0,0,.03);
    }
    .cfg-card-section h4{
        margin:0 0 14px;font-size:13px;font-weight:700;color:#111827;
        display:flex;align-items:center;gap:7px;
    }
    /* ── Colors ── */
    .cfg-color-row{display:flex;align-items:center;gap:8px;}
    .cfg-color-row input[type=color]{width:42px;height:36px;padding:2px;border:1px solid #d1d5db;border-radius:6px;cursor:pointer;flex-shrink:0;}
    .cfg-color-row input[type=text]{flex:1;}
    /* ── Badges ── */
    .cfg-badge{
        display:inline-block;background:#eff6ff;color:#2563eb;
        padding:1px 8px;border-radius:10px;font-size:10.5px;font-weight:600;
        margin-left:5px;vertical-align:middle;
    }
    </style>

    <div id="cfg-root">

    <!-- ── Sidebar ── -->
    <div class="cfg-sidebar">
        <div class="cfg-sidebar-brand">
            <div class="cfg-brand-icon">GHL</div>
            <div>
                <div class="cfg-brand-name">Contact Form</div>
                <div class="cfg-brand-sub">GoHighLevel</div>
            </div>
        </div>

        <!-- ── Group: General ── -->
        <div class="cfg-nav-group" id="cfg-grp-general">
            <div class="cfg-nav-group-hdr open" onclick="cfgToggleGroup('general')">
                <span>General</span>
                <svg class="cfg-nav-arr" width="10" height="10" viewBox="0 0 10 10" fill="currentColor"><path d="M3 2l4 3-4 3z"/></svg>
            </div>
            <div class="cfg-nav-group-body" id="cfg-grpb-general" style="max-height:200px;">
                <div class="cfg-nav-item active" onclick="cfgTab(this,'ghl')" data-group="general">GHL + Security</div>
                <div class="cfg-nav-item"        onclick="cfgTab(this,'design')" data-group="general">Design</div>
            </div>
        </div>

        <!-- ── Group: Forms ── -->
        <div class="cfg-nav-group" id="cfg-grp-forms">
            <div class="cfg-nav-group-hdr" onclick="cfgToggleGroup('forms')">
                <span>Forms</span>
                <svg class="cfg-nav-arr" width="10" height="10" viewBox="0 0 10 10" fill="currentColor"><path d="M3 2l4 3-4 3z"/></svg>
            </div>
            <div class="cfg-nav-group-body" id="cfg-grpb-forms" style="max-height:0;">
                <div class="cfg-nav-item" onclick="cfgTab(this,'form')" data-group="forms">Contact Form</div>
                <div class="cfg-nav-item" onclick="cfgTab(this,'bm')" data-group="forms">Booking Method</div>
                <div class="cfg-nav-item" onclick="cfgTab(this,'ty')" data-group="forms">Thank You Page</div>
            </div>
        </div>

        <!-- ── Group: Estimators ── -->
        <div class="cfg-nav-group" id="cfg-grp-est">
            <div class="cfg-nav-group-hdr" onclick="cfgToggleGroup('est')">
                <span>Estimators</span>
                <svg class="cfg-nav-arr" width="10" height="10" viewBox="0 0 10 10" fill="currentColor"><path d="M3 2l4 3-4 3z"/></svg>
            </div>
            <div class="cfg-nav-group-body" id="cfg-grpb-est" style="max-height:0;">
                <div class="cfg-nav-item" onclick="cfgTab(this,'alg')" data-group="est">Aligner Form</div>
                <div class="cfg-nav-item" onclick="cfgTab(this,'imp')" data-group="est">Implant Estimator</div>
            </div>
        </div>

        <!-- ── Group: Reference ── -->
        <div class="cfg-nav-group" id="cfg-grp-ref">
            <div class="cfg-nav-group-hdr" onclick="cfgToggleGroup('ref')">
                <span>Reference</span>
                <svg class="cfg-nav-arr" width="10" height="10" viewBox="0 0 10 10" fill="currentColor"><path d="M3 2l4 3-4 3z"/></svg>
            </div>
            <div class="cfg-nav-group-body" id="cfg-grpb-ref" style="max-height:0;">
                <div class="cfg-nav-item" onclick="cfgTab(this,'guide')" data-group="ref">Setup Guide</div>
                <div class="cfg-nav-item" onclick="cfgTab(this,'ghl_fields')" data-group="ref">GHL Fields</div>
            </div>
        </div>

        <hr class="cfg-nav-sep"/>

        <div class="cfg-nav-section-label">Data</div>
        <div class="cfg-nav-standalone">
            <div class="cfg-nav-item" onclick="cfgTab(this,'entries')">Entries</div>
            <div class="cfg-nav-item" onclick="cfgTab(this,'analytics')">Analytics</div>
        </div>
    </div>

    <!-- ── Main ── -->
    <div class="cfg-main">
    <form method="post" action="options.php">
    <?php settings_fields( CFG_SLUG ); ?>

    <!-- ═══ GHL + SECURITY TAB ═══ -->
    <div id="cfg-ghl" class="cfg-panel active">
        <div class="cfg-panel-hdr">
            <h2>GHL + Security</h2>
            <p>Connect your GoHighLevel account and configure spam protection.</p>
        </div>
        <div class="cfg-panel-body">
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
        </div><!-- /cfg-panel-body -->
    </div>

    <!-- ═══ DESIGN TAB ═══ -->
    <div id="cfg-design" class="cfg-panel">
        <div class="cfg-panel-hdr">
            <h2>Design</h2>
            <p>Customize colors, typography, and visual style across all forms.</p>
        </div>
        <div class="cfg-panel-body">
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
        </div><!-- /cfg-panel-body -->
    </div>

    <!-- ═══ CONTACT FORM TAB ═══ -->
    <div id="cfg-form" class="cfg-panel">
        <div class="cfg-panel-hdr">
            <h2>Contact Form</h2>
            <p>Configure the hero section, form fields, and back link.</p>
        </div>
        <div class="cfg-panel-body">
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
        </div><!-- /cfg-panel-body -->
    </div>

    <!-- ═══ BOOKING METHOD TAB ═══ -->
    <div id="cfg-bm" class="cfg-panel">
        <div class="cfg-panel-hdr">
            <h2>Booking Method</h2>
            <p>Customize the Call vs. Text booking choice page.</p>
        </div>
        <div class="cfg-panel-body">
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
        </div><!-- /cfg-panel-body -->
    </div>

    <!-- ═══ THANK YOU TAB ═══ -->
    <div id="cfg-ty" class="cfg-panel">
        <div class="cfg-panel-hdr">
            <h2>Thank You Page</h2>
            <p>Configure the post-submission confirmation page.</p>
        </div>
        <div class="cfg-panel-body">
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
        </div><!-- /cfg-panel-body -->
    </div>

    <!-- ═══ ALIGNER FORM TAB ═══ -->
    <div id="cfg-alg" class="cfg-panel">
        <div class="cfg-panel-hdr">
            <h2>Aligner Form</h2>
            <p>Configure the multi-step clear aligner estimate quiz.</p>
        </div>
        <div class="cfg-panel-body">
        <p class="cfg-desc">Use shortcode <code>[aligner_form_ghl]</code> on any page. Uses the GHL API key from the GHL + Security tab.</p>

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
        </div><!-- /cfg-panel-body -->
    </div>

    <!-- ═══ IMPLANT ESTIMATOR TAB ═══ -->
    <div id="cfg-imp" class="cfg-panel">
        <div class="cfg-panel-hdr">
            <h2>Implant Estimator</h2>
            <p>Configure the dental implant cost estimator sidebar and quiz.</p>
        </div>
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
        <div class="cfg-panel-body">
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
        <!--  3 · QUESTION EDITOR                                 -->
        <!-- ════════════════════════════════════════════════════ -->
        <div class="imp-section-hdr" style="margin-top:28px;">
            <div class="imp-section-icon" style="background:#fdf4ff;">📝</div>
            <div>
                <h3>Question Editor</h3>
                <p>Add, remove or reorder questions and options for each path. The current values are the defaults.</p>
            </div>
        </div>

        <style>
        .imp-q-editor-path{border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;margin-bottom:10px;}
        .imp-q-editor-path-hdr{display:flex;align-items:center;gap:10px;padding:13px 16px;cursor:pointer;background:#fafafa;user-select:none;}
        .imp-q-editor-path-hdr:hover{background:#f3f4f6;}
        .imp-q-editor-path-hdr .dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;}
        .imp-q-editor-path-hdr .ttl{flex:1;font-size:13px;font-weight:700;color:#1d2327;}
        .imp-q-editor-path-hdr .chev{font-size:11px;color:#9ca3af;transition:transform .2s;}
        .imp-q-editor-path-hdr.open .chev{transform:rotate(180deg);}
        .imp-q-editor-body{display:none;padding:16px;background:#fff;border-top:1px solid #e5e7eb;}
        .imp-q-editor-body.open{display:block;}
        .imp-q-card{background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:14px;margin-bottom:10px;position:relative;}
        .imp-q-card-hdr{display:flex;align-items:center;gap:8px;margin-bottom:10px;}
        .imp-q-card-num{width:22px;height:22px;border-radius:50%;background:#e5e7eb;font-size:11px;font-weight:700;color:#6b7280;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
        .imp-q-card-del{margin-left:auto;background:none;border:1px solid #fca5a5;color:#ef4444;border-radius:4px;padding:3px 9px;font-size:11px;cursor:pointer;font-weight:600;}
        .imp-q-card-del:hover{background:#fef2f2;}
        .imp-q-card-fields{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:10px;}
        .imp-q-card-field label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:#9ca3af;display:block;margin-bottom:3px;}
        .imp-q-card-field input,.imp-q-card-field select,.imp-q-card-field textarea{width:100%;padding:6px 9px;border:1px solid #d1d5db;border-radius:4px;font-size:12.5px;box-sizing:border-box;}
        .imp-q-card-field.full{grid-column:span 2;}
        .imp-q-opts-section{border-top:1px solid #e5e7eb;padding-top:10px;margin-top:4px;}
        .imp-q-opts-section label{font-size:11px;font-weight:700;text-transform:uppercase;color:#9ca3af;display:block;margin-bottom:6px;}
        .imp-opt-item{display:flex;align-items:center;gap:6px;margin-bottom:6px;}
        .imp-opt-item input{flex:1;padding:5px 8px;border:1px solid #d1d5db;border-radius:4px;font-size:12px;min-width:0;}
        .imp-opt-item input.sub{color:#9ca3af;}
        .imp-opt-del{flex-shrink:0;background:none;border:none;color:#ef4444;font-size:16px;line-height:1;cursor:pointer;padding:2px 4px;}
        .imp-add-opt-btn{background:none;border:1px dashed #d1d5db;color:#6b7280;border-radius:4px;padding:5px 12px;font-size:12px;cursor:pointer;margin-top:4px;}
        .imp-add-opt-btn:hover{border-color:#2271b1;color:#2271b1;}
        .imp-add-q-btn{width:100%;background:none;border:2px dashed #d1d5db;color:#6b7280;border-radius:8px;padding:10px;font-size:13px;cursor:pointer;margin-top:6px;}
        .imp-add-q-btn:hover{border-color:#2271b1;color:#2271b1;background:#f0f6fc;}
        .imp-router-opt-item{display:flex;align-items:center;gap:6px;margin-bottom:8px;background:#fff;border:1px solid #e5e7eb;border-radius:6px;padding:8px 10px;}
        .imp-router-opt-item input{flex:1;padding:5px 8px;border:1px solid #d1d5db;border-radius:4px;font-size:12px;min-width:0;}
        </style>

        <!-- Hidden JSON textareas (submitted with the form) -->
        <textarea name="<?= CFG_OPTION ?>[imp_router_opts]" id="imp-qs-router-json" style="display:none;"><?= esc_textarea( $s['imp_router_opts'] ) ?></textarea>
        <textarea name="<?= CFG_OPTION ?>[imp_single_qs]"   id="imp-qs-single-json"   style="display:none;"><?= esc_textarea( $s['imp_single_qs'] ) ?></textarea>
        <textarea name="<?= CFG_OPTION ?>[imp_multi_qs]"    id="imp-qs-multi-json"    style="display:none;"><?= esc_textarea( $s['imp_multi_qs'] ) ?></textarea>
        <textarea name="<?= CFG_OPTION ?>[imp_arch_qs]"     id="imp-qs-arch-json"     style="display:none;"><?= esc_textarea( $s['imp_arch_qs'] ) ?></textarea>
        <textarea name="<?= CFG_OPTION ?>[imp_ins_q]"       id="imp-qs-ins-json"      style="display:none;"><?= esc_textarea( $s['imp_ins_q'] ) ?></textarea>

        <!-- Router options editor -->
        <div class="imp-q-editor-path">
            <div class="imp-q-editor-path-hdr" onclick="impEdOpen(this,'router')">
                <span class="dot" style="background:#6b7280;"></span>
                <span class="ttl">Router Question</span>
                <span style="font-size:11px;color:#9ca3af;background:#f0f0f1;padding:2px 8px;border-radius:12px;">3 options</span>
                <span class="chev">▼</span>
            </div>
            <div class="imp-q-editor-body" id="imp-ed-router">
                <div class="imp-q-card-field full" style="margin-bottom:12px;">
                    <label>Question Title</label>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_router_title]" value="<?= esc_attr( $s['imp_router_title'] ) ?>"/>
                </div>
                <div class="imp-q-card-field full" style="margin-bottom:14px;">
                    <label>Sub-label</label>
                    <input type="text" name="<?= CFG_OPTION ?>[imp_router_sub]" value="<?= esc_attr( $s['imp_router_sub'] ) ?>"/>
                </div>
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">Route Options</div>
                <div id="imp-router-opts-list"></div>
                <p class="cfg-desc" style="margin-top:6px;">Note: the internal values (single / multiple / fullarch) cannot be changed as they control which question path loads.</p>
            </div>
        </div>

        <!-- Path editors -->
        <?php foreach ([
            'single'   => ['label'=>'Single Tooth Path',   'dot'=>'#3b82f6', 'count'=>'4 questions · A1–A4'],
            'multiple' => ['label'=>'Multiple Teeth Path', 'dot'=>'#8b5cf6', 'count'=>'5 questions · M1–M5'],
            'fullarch' => ['label'=>'Full Arch Path',      'dot'=>'#10b981', 'count'=>'3 questions · B1–B3'],
        ] as $path_key => $path_meta): ?>
        <div class="imp-q-editor-path">
            <div class="imp-q-editor-path-hdr" onclick="impEdOpen(this,'<?= $path_key ?>')">
                <span class="dot" style="background:<?= $path_meta['dot'] ?>;"></span>
                <span class="ttl"><?= $path_meta['label'] ?></span>
                <span style="font-size:11px;color:#9ca3af;background:#f0f0f1;padding:2px 8px;border-radius:12px;"><?= $path_meta['count'] ?></span>
                <span class="chev">▼</span>
            </div>
            <div class="imp-q-editor-body" id="imp-ed-<?= $path_key ?>"></div>
        </div>
        <?php endforeach; ?>

        <!-- Insurance editor -->
        <div class="imp-q-editor-path">
            <div class="imp-q-editor-path-hdr" onclick="impEdOpen(this,'ins')">
                <span class="dot" style="background:#f59e0b;"></span>
                <span class="ttl">Insurance Question</span>
                <span style="font-size:11px;color:#9ca3af;background:#f0f0f1;padding:2px 8px;border-radius:12px;">optional · toggle above</span>
                <span class="chev">▼</span>
            </div>
            <div class="imp-q-editor-body" id="imp-ed-ins"></div>
        </div>

        <script>
        // ── IMP QUESTION EDITOR ──────────────────────────────────
        var impEd = {
            router:   JSON.parse(document.getElementById('imp-qs-router-json').value || '[]'),
            single:   JSON.parse(document.getElementById('imp-qs-single-json').value || '[]'),
            multiple: JSON.parse(document.getElementById('imp-qs-multi-json').value || '[]'),
            fullarch: JSON.parse(document.getElementById('imp-qs-arch-json').value || '[]'),
            ins:      JSON.parse(document.getElementById('imp-qs-ins-json').value || '{}'),
        };
        var impEdRendered = {};

        function impEdSave(path) {
            var idMap = {router:'imp-qs-router-json',single:'imp-qs-single-json',multiple:'imp-qs-multi-json',fullarch:'imp-qs-arch-json',ins:'imp-qs-ins-json'};
            var el = document.getElementById(idMap[path]);
            if (el) el.value = JSON.stringify(impEd[path]);
        }

        function impEdOpen(hdr, path) {
            hdr.classList.toggle('open');
            var body = hdr.nextElementSibling;
            body.classList.toggle('open');
            if (!impEdRendered[path]) { impEdRendered[path] = true; impEdRender(path); }
        }

        function impEdRender(path) {
            if (path === 'router') { impEdRenderRouter(); return; }
            if (path === 'ins')    { impEdRenderSingleQ('ins', impEd.ins); return; }
            var qs = impEd[path];
            var body = document.getElementById('imp-ed-' + path);
            body.innerHTML = '';
            // Add button must come first so impEdRenderQ can insertBefore it
            var addBtn = document.createElement('button');
            addBtn.type = 'button'; addBtn.className = 'imp-add-q-btn';
            addBtn.textContent = '+ Add Question';
            (function(p){ addBtn.onclick = function(){ impEdAddQ(p); }; })(path);
            body.appendChild(addBtn);
            for (var i = 0; i < qs.length; i++) impEdRenderQ(path, i, body);
        }

        function impEdRenderRouter() {
            var list = document.getElementById('imp-router-opts-list');
            list.innerHTML = '';
            var opts = impEd.router;
            for (var i = 0; i < opts.length; i++) {
                (function(idx){
                    var o = opts[idx];
                    var row = document.createElement('div'); row.className = 'imp-router-opt-item';
                    row.innerHTML = '<span style="font-size:11px;font-weight:700;color:#9ca3af;flex-shrink:0;width:56px;">' + o.val + '</span>'
                        + '<input type="text" placeholder="Label" value="' + escHtml(o.label) + '"/>'
                        + '<input type="text" placeholder="Sub-label" value="' + escHtml(o.sub||'') + '" class="sub"/>';
                    var inputs = row.querySelectorAll('input');
                    inputs[0].oninput = function(){ impEd.router[idx].label = this.value; impEdSave('router'); };
                    inputs[1].oninput = function(){ impEd.router[idx].sub   = this.value; impEdSave('router'); };
                    list.appendChild(row);
                })(i);
            }
        }

        function impEdRenderSingleQ(path, q) {
            var body = document.getElementById('imp-ed-' + path);
            body.innerHTML = '';
            var card = impEdMakeQCard(path, 0, q, false);
            body.appendChild(card);
        }

        function impEdRenderQ(path, qi, container) {
            var q = impEd[path][qi];
            var card = impEdMakeQCard(path, qi, q, true);
            container.insertBefore(card, container.lastElementChild); // before add-btn
        }

        function impEdMakeQCard(path, qi, q, canDelete) {
            var isSingleQ = (path === 'ins');
            var card = document.createElement('div'); card.className = 'imp-q-card';
            card.id = 'imp-qcard-' + path + '-' + qi;

            var hdr = document.createElement('div'); hdr.className = 'imp-q-card-hdr';
            var num = document.createElement('span'); num.className = 'imp-q-card-num'; num.textContent = qi+1;
            hdr.appendChild(num);
            var titleSpan = document.createElement('span');
            titleSpan.style = 'flex:1;font-size:12.5px;color:#374151;font-weight:600;';
            titleSpan.textContent = q.title || 'New Question';
            hdr.appendChild(titleSpan);
            if (canDelete) {
                var upBtn = document.createElement('button'); upBtn.type='button'; upBtn.title='Move up';
                upBtn.style='background:none;border:1px solid #d1d5db;border-radius:4px;padding:1px 6px;cursor:pointer;font-size:12px;color:#6b7280;margin-right:2px;';
                upBtn.textContent='↑';
                (function(p,i){ upBtn.onclick = function(e){ e.stopPropagation(); impEdMoveQ(p, i, -1); }; })(path, qi);
                hdr.appendChild(upBtn);
                var dnBtn = document.createElement('button'); dnBtn.type='button'; dnBtn.title='Move down';
                dnBtn.style='background:none;border:1px solid #d1d5db;border-radius:4px;padding:1px 6px;cursor:pointer;font-size:12px;color:#6b7280;margin-right:6px;';
                dnBtn.textContent='↓';
                (function(p,i){ dnBtn.onclick = function(e){ e.stopPropagation(); impEdMoveQ(p, i, +1); }; })(path, qi);
                hdr.appendChild(dnBtn);
                var delBtn = document.createElement('button'); delBtn.type='button'; delBtn.className='imp-q-card-del'; delBtn.textContent='x Remove';
                (function(p,i){ delBtn.onclick = function(){ impEdDelQ(p, i); }; })(path, qi);
                hdr.appendChild(delBtn);
            }
            card.appendChild(hdr);

            var fields = document.createElement('div'); fields.className = 'imp-q-card-fields';

            // Title
            var titleF = impEdField('Question Title', 'full');
            var titleIn = document.createElement('input'); titleIn.type='text'; titleIn.value = q.title||'';
            titleIn.oninput = (function(p,i,ts){ return function(){
                var data = isSingleQ ? impEd[p] : impEd[p][i];
                data.title = this.value; impEdSave(p); ts.textContent = this.value||'New Question';
            }; })(path, qi, titleSpan);
            titleF.appendChild(titleIn); fields.appendChild(titleF);

            // Subtitle
            var subF = impEdField('Sub-text (optional)', 'full');
            var subIn = document.createElement('input'); subIn.type='text'; subIn.value = q.subtitle||'';
            subIn.oninput = (function(p,i){ return function(){
                var data = isSingleQ ? impEd[p] : impEd[p][i];
                data.subtitle = this.value; impEdSave(p);
            }; })(path, qi);
            subF.appendChild(subIn); fields.appendChild(subF);

            // Field key
            var fkF = impEdField('Field Key (GHL)');
            var fkIn = document.createElement('input'); fkIn.type='text'; fkIn.value = q.field||'';
            fkIn.style.fontFamily='monospace';
            fkIn.oninput = (function(p,i){ return function(){
                var data = isSingleQ ? impEd[p] : impEd[p][i];
                data.field = this.value; impEdSave(p);
            }; })(path, qi);
            fkF.appendChild(fkIn); fields.appendChild(fkF);

            // Type
            var typeF = impEdField('Type');
            var typeSel = document.createElement('select');
            typeSel.innerHTML = '<option value="radio">Button Cards (radio)</option><option value="dropdown">Dropdown</option><option value="text">Short Text</option><option value="textarea">Long Text</option>';
            typeSel.value = q.type || 'radio';
            var optsSection; // reference set below
            typeSel.onchange = (function(p,i,os){ return function(){
                var data = isSingleQ ? impEd[p] : impEd[p][i];
                data.type = this.value; impEdSave(p);
                if (os) os.style.display = (this.value==='radio'||this.value==='dropdown') ? 'block' : 'none';
            }; });
            typeF.appendChild(typeSel); fields.appendChild(typeF);

            card.appendChild(fields);

            // Options section (radio/dropdown only)
            var showOpts = (q.type === 'radio' || q.type === 'dropdown' || !q.type);
            optsSection = document.createElement('div'); optsSection.className = 'imp-q-opts-section';
            optsSection.style.display = showOpts ? 'block' : 'none';
            // wire up typeSel now we have optsSection
            typeSel.onchange = (function(p,i,os){ return function(){
                var data = isSingleQ ? impEd[p] : impEd[p][i];
                data.type = this.value; impEdSave(p);
                os.style.display = (this.value==='radio'||this.value==='dropdown') ? 'block' : 'none';
            }; })(path, qi, optsSection);

            var optsLabel = document.createElement('label'); optsLabel.textContent='Answer Options';
            optsSection.appendChild(optsLabel);
            var optsList = document.createElement('div'); optsList.id = 'imp-opts-' + path + '-' + qi;
            optsSection.appendChild(optsList);
            var addOptBtn = document.createElement('button'); addOptBtn.type='button'; addOptBtn.className='imp-add-opt-btn'; addOptBtn.textContent='+ Add Option';
            (function(p,i,ol){ addOptBtn.onclick = function(){ impEdAddOpt(p,i,ol); }; })(path, qi, optsList);
            optsSection.appendChild(addOptBtn);
            card.appendChild(optsSection);

            // Render existing opts
            var opts = q.opts || [];
            for (var oi=0; oi<opts.length; oi++) impEdRenderOpt(path, qi, oi, optsList, isSingleQ);

            return card;
        }

        function impEdRenderOpt(path, qi, oi, container, isSingleQ) {
            var q = isSingleQ ? impEd[path] : impEd[path][qi];
            var o = (q.opts || [])[oi]; if (!o) return;
            var row = document.createElement('div'); row.className='imp-opt-item'; row.id='imp-opt-'+path+'-'+qi+'-'+oi;
            var numSpan = document.createElement('span');
            numSpan.style='flex-shrink:0;width:20px;height:20px;border-radius:50%;background:#e5e7eb;font-size:11px;font-weight:700;color:#6b7280;display:flex;align-items:center;justify-content:center;';
            numSpan.textContent = oi+1;
            row.appendChild(numSpan);
            var valIn = document.createElement('input'); valIn.type='text'; valIn.placeholder='value (internal)'; valIn.value=o.val||'';
            valIn.style.fontFamily='monospace';
            var lblIn = document.createElement('input'); lblIn.type='text'; lblIn.placeholder='Label'; lblIn.value=o.label||'';
            var subIn = document.createElement('input'); subIn.type='text'; subIn.placeholder='Sub-label (opt)'; subIn.value=o.sub||''; subIn.className='sub';
            valIn.oninput = (function(p,qi,oi,isSQ){ return function(){ var q2=isSQ?impEd[p]:impEd[p][qi]; if(q2.opts&&q2.opts[oi])q2.opts[oi].val=this.value; impEdSave(p); }; })(path,qi,oi,isSingleQ);
            lblIn.oninput = (function(p,qi,oi,isSQ){ return function(){ var q2=isSQ?impEd[p]:impEd[p][qi]; if(q2.opts&&q2.opts[oi])q2.opts[oi].label=this.value; impEdSave(p); }; })(path,qi,oi,isSingleQ);
            subIn.oninput = (function(p,qi,oi,isSQ){ return function(){ var q2=isSQ?impEd[p]:impEd[p][qi]; if(q2.opts&&q2.opts[oi])q2.opts[oi].sub=this.value; impEdSave(p); }; })(path,qi,oi,isSingleQ);
            var delBtn = document.createElement('button'); delBtn.type='button'; delBtn.className='imp-opt-del'; delBtn.innerHTML='&times;';
            (function(p,qi,oi,isSQ,c){ delBtn.onclick = function(){
                var q2=isSQ?impEd[p]:impEd[p][qi]; if(q2.opts) q2.opts.splice(oi,1); impEdSave(p);
                // re-render whole card opts
                var container2=document.getElementById('imp-opts-'+p+'-'+qi); if(!container2)return;
                container2.innerHTML='';
                var newOpts=(isSQ?impEd[p]:impEd[p][qi]).opts||[];
                for(var k=0;k<newOpts.length;k++) impEdRenderOpt(p,qi,k,container2,isSQ);
            }; })(path,qi,oi,isSingleQ,container);
            row.appendChild(valIn); row.appendChild(lblIn); row.appendChild(subIn); row.appendChild(delBtn);
            container.appendChild(row);
        }

        function impEdAddOpt(path, qi, container) {
            var isSQ = (path==='ins');
            var q = isSQ ? impEd[path] : impEd[path][qi];
            if (!q.opts) q.opts = [];
            q.opts.push({val:'',label:'',sub:''});
            impEdSave(path);
            impEdRenderOpt(path, qi, q.opts.length-1, container, isSQ);
        }

        function impEdAddQ(path) {
            var newQ = {id:path+'_q'+(impEd[path].length+1),title:'New Question',subtitle:'',type:'radio',field:'customField'+(impEd[path].length+1),opts:[{val:'yes',label:'Yes',sub:''},{val:'no',label:'No',sub:''}]};
            impEd[path].push(newQ);
            impEdSave(path);
            // re-render
            impEdRendered[path] = false;
            impEdRender(path);
        }

        function impEdDelQ(path, qi) {
            if (!confirm('Remove this question?')) return;
            impEd[path].splice(qi, 1);
            impEdSave(path);
            impEdRendered[path] = false;
            impEdRender(path);
        }

        function impEdMoveQ(path, qi, dir) {
            var qs = impEd[path];
            var target = qi + dir;
            if (target < 0 || target >= qs.length) return;
            var tmp = qs[qi]; qs[qi] = qs[target]; qs[target] = tmp;
            impEdSave(path);
            impEdRendered[path] = false;
            impEdRender(path);
        }

        function impEdField(labelText, cls) {
            var f = document.createElement('div'); f.className='imp-q-card-field'+(cls?' '+cls:'');
            var lbl = document.createElement('label'); lbl.textContent=labelText;
            f.appendChild(lbl); return f;
        }

        function escHtml(s) {
            return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        }
        </script>

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
                <div class="cfg-field">
                    <label>Button URL <span style="font-weight:400;color:#9ca3af;">— leave blank to start quiz</span></label>
                    <input type="url" name="<?= CFG_OPTION ?>[imp_intro_btn_url]" value="<?= esc_attr( $s['imp_intro_btn_url'] ) ?>" placeholder="https://… (optional, overrides quiz start)"/>
                    <span class="cfg-desc">If set, clicking the button navigates to this URL instead of launching the quiz.</span>
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
                    <div class="cfg-field cfg-full" style="color:#6b7280;font-size:12px;padding:8px 10px;background:#f9fafb;border-radius:6px;">Financing note text is configured in the <strong>Consultation Offer Step</strong> section below.</div>
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

            <!-- ── What's Included ── -->
            <div class="cfg-card-section">
                <h4>What's Included in the Estimate</h4>
                <p class="cfg-desc" style="margin:0 0 14px;">Toggle each item on or off. These appear as a checklist inside the price card on the result screen. Add or remove items freely.</p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
                    <!-- Single / Multiple path -->
                    <div>
                        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#3b82f6;margin-bottom:10px;">Single &amp; Multiple Teeth</div>
                        <div id="imp-single-includes-list" style="display:flex;flex-direction:column;gap:8px;">
                        <?php
                        $si_raw = json_decode( $s['imp_single_includes'] ?? '[]', true ) ?: [];
                        foreach ( $si_raw as $idx => $inc ):
                        ?>
                        <div class="imp-inc-row" style="display:flex;align-items:center;gap:8px;">
                            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;flex:1;min-width:0;">
                                <input type="checkbox" name="<?= CFG_OPTION ?>[imp_single_includes_chk][<?= $idx ?>]" value="1" <?= ! empty($inc['enabled']) ? 'checked' : '' ?> style="width:15px;height:15px;accent-color:#3b82f6;flex-shrink:0;"/>
                                <input type="text" name="<?= CFG_OPTION ?>[imp_single_includes_lbl][<?= $idx ?>]" value="<?= esc_attr( $inc['label'] ) ?>" style="flex:1;min-width:0;border:1px solid #ddd;border-radius:5px;padding:5px 8px;font-size:13px;"/>
                            </label>
                            <button type="button" onclick="impRemoveIncRow(this)" style="flex-shrink:0;width:24px;height:24px;display:flex;align-items:center;justify-content:center;background:none;border:1px solid #ddd;border-radius:4px;cursor:pointer;color:#9ca3af;" title="Remove">&times;</button>
                        </div>
                        <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="impAddIncRow('imp-single-includes-list','<?= CFG_OPTION ?>','imp_single_includes_chk','imp_single_includes_lbl')" style="margin-top:8px;font-size:12px;padding:5px 12px;border:1px dashed #3b82f6;border-radius:5px;background:none;color:#3b82f6;cursor:pointer;">+ Add item</button>
                    </div>
                    <!-- Full Arch path -->
                    <div>
                        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#10b981;margin-bottom:10px;">Full Arch</div>
                        <div id="imp-arch-includes-list" style="display:flex;flex-direction:column;gap:8px;">
                        <?php
                        $ai_raw = json_decode( $s['imp_fullarch_includes'] ?? '[]', true ) ?: [];
                        foreach ( $ai_raw as $idx => $inc ):
                        ?>
                        <div class="imp-inc-row" style="display:flex;align-items:center;gap:8px;">
                            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;flex:1;min-width:0;">
                                <input type="checkbox" name="<?= CFG_OPTION ?>[imp_fullarch_includes_chk][<?= $idx ?>]" value="1" <?= ! empty($inc['enabled']) ? 'checked' : '' ?> style="width:15px;height:15px;accent-color:#10b981;flex-shrink:0;"/>
                                <input type="text" name="<?= CFG_OPTION ?>[imp_fullarch_includes_lbl][<?= $idx ?>]" value="<?= esc_attr( $inc['label'] ) ?>" style="flex:1;min-width:0;border:1px solid #ddd;border-radius:5px;padding:5px 8px;font-size:13px;"/>
                            </label>
                            <button type="button" onclick="impRemoveIncRow(this)" style="flex-shrink:0;width:24px;height:24px;display:flex;align-items:center;justify-content:center;background:none;border:1px solid #ddd;border-radius:4px;cursor:pointer;color:#9ca3af;" title="Remove">&times;</button>
                        </div>
                        <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="impAddIncRow('imp-arch-includes-list','<?= CFG_OPTION ?>','imp_fullarch_includes_chk','imp_fullarch_includes_lbl')" style="margin-top:8px;font-size:12px;padding:5px 12px;border:1px dashed #10b981;border-radius:5px;background:none;color:#10b981;cursor:pointer;">+ Add item</button>
                    </div>
                </div>
                <p class="cfg-desc" style="margin-top:10px;">Checked items are displayed. Unchecked items are hidden but saved for easy re-enabling.</p>
            </div>

            <!-- ── Bone Grafting Display ── -->
            <div class="cfg-card-section">
                <h4>Bone Grafting — How to Display It</h4>
                <p class="cfg-desc" style="margin:0 0 14px;">If the patient indicates they may need bone grafting, how should it appear on their estimate?</p>
                <?php $gd = $s['imp_graft_display'] ?? 'addon'; ?>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;padding:10px 12px;border:2px solid <?= $gd==='mention' ? '#3b82f6' : '#e5e7eb' ?>;border-radius:8px;background:<?= $gd==='mention' ? '#eff6ff' : '#fff' ?>;">
                        <input type="radio" name="<?= CFG_OPTION ?>[imp_graft_display]" value="mention" <?= checked('mention',$gd,false) ?> style="margin-top:2px;accent-color:#3b82f6;" onchange="impGraftStyleUpdate(this)"/>
                        <div><strong style="font-size:13px;">Mentioned as "may be required"</strong><br><span style="font-size:12px;color:#6b7280;">Shows a note that bone grafting may be needed, with the price range listed as a possible extra cost per area.</span></div>
                    </label>
                    <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;padding:10px 12px;border:2px solid <?= $gd==='included' ? '#3b82f6' : '#e5e7eb' ?>;border-radius:8px;background:<?= $gd==='included' ? '#eff6ff' : '#fff' ?>;">
                        <input type="radio" name="<?= CFG_OPTION ?>[imp_graft_display]" value="included" <?= checked('included',$gd,false) ?> style="margin-top:2px;accent-color:#3b82f6;" onchange="impGraftStyleUpdate(this)"/>
                        <div><strong style="font-size:13px;">Included within the higher end of the range</strong><br><span style="font-size:12px;color:#6b7280;">No separate note is shown. The graft cost is assumed to be factored into your price range already.</span></div>
                    </label>
                    <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;padding:10px 12px;border:2px solid <?= $gd==='addon' ? '#3b82f6' : '#e5e7eb' ?>;border-radius:8px;background:<?= $gd==='addon' ? '#eff6ff' : '#fff' ?>;">
                        <input type="radio" name="<?= CFG_OPTION ?>[imp_graft_display]" value="addon" <?= checked('addon',$gd,false) ?> style="margin-top:2px;accent-color:#3b82f6;" onchange="impGraftStyleUpdate(this)"/>
                        <div><strong style="font-size:13px;">Clearly stated as an additional procedure if required</strong><br><span style="font-size:12px;color:#6b7280;">Adds a clear note: bone grafting is an additional procedure if needed, at approximately the price range per area.</span></div>
                    </label>
                </div>
            </div>

            <!-- ── CTA Buttons ── -->
            <div class="cfg-card-section">
                <h4>Call-to-Action Buttons</h4>
                <p class="cfg-desc" style="margin:0 0 14px;">Configure the buttons shown at the bottom of the result screen. Each can be toggled on/off independently.</p>
                <div style="display:flex;flex-direction:column;gap:16px;">
                    <!-- Book button -->
                    <div style="padding:14px;border:1px solid #e5e7eb;border-radius:8px;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                            <label style="display:flex;align-items:center;gap:6px;font-weight:600;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="<?= CFG_OPTION ?>[imp_cta_book_enabled]" value="1" <?= checked('1',$s['imp_cta_book_enabled']??'1',false) ?> style="accent-color:#2271b1;"/>
                                Primary Button (Book)
                            </label>
                            <span style="font-size:11px;color:#6b7280;">filled style</span>
                        </div>
                        <div class="cfg-grid" style="--cols:2;">
                            <div class="cfg-field"><label>Label</label><input type="text" name="<?= CFG_OPTION ?>[imp_cta_book_label]" value="<?= esc_attr( $s['imp_cta_book_label'] ) ?>" placeholder="Book My Consultation"/></div>
                            <div class="cfg-field"><label>URL <span class="cfg-badge">optional</span></label><input type="url" name="<?= CFG_OPTION ?>[imp_cta_book_url]" value="<?= esc_url( $s['imp_cta_book_url'] ) ?>" placeholder="Leave blank to go to lead form step"/></div>
                        </div>
                    </div>
                    <!-- Call button -->
                    <div style="padding:14px;border:1px solid #e5e7eb;border-radius:8px;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                            <label style="display:flex;align-items:center;gap:6px;font-weight:600;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="<?= CFG_OPTION ?>[imp_cta_call_enabled]" value="1" <?= checked('1',$s['imp_cta_call_enabled']??'0',false) ?> style="accent-color:#2271b1;"/>
                                Secondary Button (Call)
                            </label>
                            <span style="font-size:11px;color:#6b7280;">outline style — requires phone number</span>
                        </div>
                        <div class="cfg-grid" style="--cols:2;">
                            <div class="cfg-field"><label>Label</label><input type="text" name="<?= CFG_OPTION ?>[imp_cta_call_label]" value="<?= esc_attr( $s['imp_cta_call_label'] ) ?>" placeholder="Call the Office"/></div>
                            <div class="cfg-field"><label>Phone Number</label><input type="tel" name="<?= CFG_OPTION ?>[imp_cta_phone]" value="<?= esc_attr( $s['imp_cta_phone'] ) ?>" placeholder="+1 (555) 000-0000"/></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Result Info Sections ── -->
            <div class="cfg-card-section">
                <h4>Info Sections Below Price Card</h4>
                <p class="cfg-desc" style="margin:0 0 14px;">The three informational boxes shown below the price on the result screen. Each section has a title and a list of bullet points. Add, remove, or reorder freely.</p>
                <div id="imp-sections-editor" style="display:flex;flex-direction:column;gap:16px;">
                <?php
                $secs = json_decode( $s['imp_result_sections'] ?? '[]', true ) ?: [];
                foreach ( $secs as $si => $sec ):
                ?>
                <div class="imp-sec-block" style="border:1px solid #e5e7eb;border-radius:8px;padding:14px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                        <input type="text" name="<?= CFG_OPTION ?>[imp_result_sections_title][<?= $si ?>]" value="<?= esc_attr( $sec['title'] ) ?>" placeholder="Section title" style="flex:1;border:1px solid #ddd;border-radius:5px;padding:6px 10px;font-size:13px;font-weight:600;"/>
                        <button type="button" onclick="impRemoveSection(this)" style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;background:none;border:1px solid #ddd;border-radius:4px;cursor:pointer;color:#9ca3af;flex-shrink:0;" title="Remove section">&times;</button>
                    </div>
                    <div class="imp-sec-items" style="display:flex;flex-direction:column;gap:6px;margin-bottom:8px;">
                    <?php foreach ( ( $sec['items'] ?? [] ) as $ii => $item ): ?>
                    <div class="imp-sec-item-row" style="display:flex;align-items:center;gap:6px;">
                        <span style="color:#9ca3af;font-size:14px;">&#9675;</span>
                        <input type="text" name="<?= CFG_OPTION ?>[imp_result_sections_items][<?= $si ?>][]" value="<?= esc_attr( $item ) ?>" placeholder="Bullet text" style="flex:1;border:1px solid #ddd;border-radius:5px;padding:5px 8px;font-size:13px;"/>
                        <button type="button" onclick="impRemoveSecItem(this)" style="width:22px;height:22px;display:flex;align-items:center;justify-content:center;background:none;border:1px solid #ddd;border-radius:4px;cursor:pointer;color:#9ca3af;flex-shrink:0;">&times;</button>
                    </div>
                    <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="impAddSecItem(this)" style="font-size:12px;padding:4px 10px;border:1px dashed #9ca3af;border-radius:5px;background:none;color:#6b7280;cursor:pointer;">+ Add bullet</button>
                </div>
                <?php endforeach; ?>
                </div>
                <button type="button" onclick="impAddSection()" style="margin-top:10px;font-size:12px;padding:6px 14px;border:1px dashed #2271b1;border-radius:5px;background:none;color:#2271b1;cursor:pointer;">+ Add section</button>
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
        <!--  6 · CONSULTATION OFFER STEP                         -->
        <!-- ════════════════════════════════════════════════════ -->
        <div class="imp-section-hdr" style="margin-top:28px;">
            <div class="imp-section-icon" style="background:#fef3c7;">📬</div>
            <div>
                <h3>Consultation Offer Step</h3>
                <p>The lead capture screen shown after the patient sees their estimate</p>
            </div>
        </div>

        <!-- Consultation positioning -->
        <div class="cfg-card-section">
            <h4>Consultation Positioning</h4>
            <p class="cfg-desc" style="margin:0 0 14px;">How should the consultation be presented to the patient? This sets the tone for the title and subtitle below.</p>
            <?php $ct = $s['imp_consult_type'] ?? 'free'; ?>
            <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:18px;">
                <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;padding:10px 12px;border:2px solid <?= $ct==='free' ? '#2271b1' : '#e5e7eb' ?>;border-radius:8px;background:<?= $ct==='free' ? '#eff6ff' : '#fff' ?>;">
                    <input type="radio" name="<?= CFG_OPTION ?>[imp_consult_type]" value="free" <?= checked('free',$ct,false) ?> style="margin-top:2px;accent-color:#2271b1;" onchange="impConsultTypeChange(this)"/>
                    <div><strong style="font-size:13px;">Complimentary implant consultation</strong><br><span style="font-size:12px;color:#6b7280;">Free consultation — no cost to the patient.</span></div>
                </label>
                <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;padding:10px 12px;border:2px solid <?= $ct==='paid_cbct' ? '#2271b1' : '#e5e7eb' ?>;border-radius:8px;background:<?= $ct==='paid_cbct' ? '#eff6ff' : '#fff' ?>;">
                    <input type="radio" name="<?= CFG_OPTION ?>[imp_consult_type]" value="paid_cbct" <?= checked('paid_cbct',$ct,false) ?> style="margin-top:2px;accent-color:#2271b1;" onchange="impConsultTypeChange(this)"/>
                    <div><strong style="font-size:13px;">Complimentary consultation + paid CBCT</strong><br><span style="font-size:12px;color:#6b7280;">Consult is free; 3D imaging (CBCT) is a separate paid item.</span></div>
                </label>
                <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;padding:10px 12px;border:2px solid <?= $ct==='paid_credited' ? '#2271b1' : '#e5e7eb' ?>;border-radius:8px;background:<?= $ct==='paid_credited' ? '#eff6ff' : '#fff' ?>;">
                    <input type="radio" name="<?= CFG_OPTION ?>[imp_consult_type]" value="paid_credited" <?= checked('paid_credited',$ct,false) ?> style="margin-top:2px;accent-color:#2271b1;" onchange="impConsultTypeChange(this)"/>
                    <div><strong style="font-size:13px;">Paid consultation (credited if proceeding)</strong><br><span style="font-size:12px;color:#6b7280;">There is a consultation fee, but it is applied as a credit toward treatment.</span></div>
                </label>
            </div>
            <div class="cfg-grid">
                <div class="cfg-field"><label>Title</label><input type="text" id="imp_contact_title" name="<?= CFG_OPTION ?>[imp_contact_title]" value="<?= esc_attr( $s['imp_contact_title'] ) ?>"/></div>
                <div class="cfg-field cfg-full"><label>Subtitle</label><textarea id="imp_contact_subtitle" name="<?= CFG_OPTION ?>[imp_contact_subtitle]"><?= esc_textarea( $s['imp_contact_subtitle'] ) ?></textarea></div>
                <div class="cfg-field"><label>Submit Button Text</label><input type="text" name="<?= CFG_OPTION ?>[imp_contact_btn]" value="<?= esc_attr( $s['imp_contact_btn'] ) ?>"/></div>
                <div class="cfg-field">
                    <label>Redirect URL after submit <span style="font-weight:400;color:#9ca3af;">— optional</span></label>
                    <input type="url" name="<?= CFG_OPTION ?>[imp_contact_btn_url]" value="<?= esc_attr( $s['imp_contact_btn_url'] ) ?>" placeholder="https://… (overrides global Success URL)"/>
                    <span class="cfg-desc">Where to send the patient after they submit their details. Overrides the global Success Redirect URL for this step only.</span>
                </div>
            </div>

            <div class="cfg-card-section" style="margin-top:14px;">
                <h4>Secondary Button <span style="font-weight:400;color:#6b7280;font-size:12px;">— optional link shown below the form</span></h4>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:12px;">
                    <div><div style="font-size:13px;font-weight:600;">Show secondary button</div><div style="font-size:12px;color:#6b7280;margin-top:2px;">Displays an outline button below the submit button (e.g. "Call Instead")</div></div>
                    <label class="imp-sw" style="flex-shrink:0;">
                        <input type="checkbox" name="<?= CFG_OPTION ?>[imp_contact_btn2_enabled]" value="1" <?= checked( $s['imp_contact_btn2_enabled'], '1', false ) ?>/>
                        <span class="imp-sw-slider"></span>
                    </label>
                </div>
                <div class="cfg-grid">
                    <div class="cfg-field"><label>Label</label><input type="text" name="<?= CFG_OPTION ?>[imp_contact_btn2_label]" value="<?= esc_attr( $s['imp_contact_btn2_label'] ) ?>" placeholder="Call Instead"/></div>
                    <div class="cfg-field"><label>URL</label><input type="url" name="<?= CFG_OPTION ?>[imp_contact_btn2_url]" value="<?= esc_attr( $s['imp_contact_btn2_url'] ) ?>" placeholder="tel:+1… or https://…"/></div>
                </div>
            </div>
        </div>

        <!-- Financing -->
        <div class="cfg-card-section">
            <h4>Financing / Payment Options</h4>
            <p class="cfg-desc" style="margin:0 0 14px;">Should the estimator mention that monthly payment options may be available?</p>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:12px;">
                <div>
                    <div style="font-size:13px;font-weight:600;color:#1d2327;">Show financing note on result screen</div>
                    <div style="font-size:12px;color:#6b7280;margin-top:2px;">Appears as a banner below the price card when enabled</div>
                </div>
                <label class="imp-sw" style="flex-shrink:0;">
                    <input type="checkbox" name="<?= CFG_OPTION ?>[imp_show_financing]" value="1" <?= checked( $s['imp_show_financing'], '1', false ) ?>/>
                    <span class="imp-sw-slider"></span>
                </label>
            </div>
            <div class="cfg-field cfg-full">
                <label>Financing Note Text</label>
                <input type="text" name="<?= CFG_OPTION ?>[imp_financing_text]" value="<?= esc_attr( $s['imp_financing_text'] ) ?>" placeholder="Flexible financing available — ask us about monthly payment plans."/>
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

        /* ── Includes lists ── */
        function impRemoveIncRow(btn) { btn.closest('.imp-inc-row').remove(); }
        function impAddIncRow(listId, opt, chkName, lblName) {
            var list = document.getElementById(listId);
            var idx  = list.querySelectorAll('.imp-inc-row').length;
            var row  = document.createElement('div');
            row.className = 'imp-inc-row';
            row.style.cssText = 'display:flex;align-items:center;gap:8px;';
            row.innerHTML = '<label style="display:flex;align-items:center;gap:6px;cursor:pointer;flex:1;min-width:0;">'
                + '<input type="checkbox" name="' + opt + '[' + chkName + '][' + idx + ']" value="1" checked style="width:15px;height:15px;flex-shrink:0;"/>'
                + '<input type="text" name="' + opt + '[' + lblName + '][' + idx + ']" placeholder="Item label" style="flex:1;min-width:0;border:1px solid #ddd;border-radius:5px;padding:5px 8px;font-size:13px;"/>'
                + '</label>'
                + '<button type="button" onclick="impRemoveIncRow(this)" style="flex-shrink:0;width:24px;height:24px;display:flex;align-items:center;justify-content:center;background:none;border:1px solid #ddd;border-radius:4px;cursor:pointer;color:#9ca3af;">&times;</button>';
            list.appendChild(row);
            row.querySelector('input[type=text]').focus();
        }

        /* ── Result sections ── */
        function impRemoveSection(btn) { btn.closest('.imp-sec-block').remove(); }
        function impAddSecItem(btn) {
            var block  = btn.closest('.imp-sec-block');
            var items  = block.querySelector('.imp-sec-items');
            var si     = Array.from(document.querySelectorAll('.imp-sec-block')).indexOf(block);
            var row    = document.createElement('div');
            row.className = 'imp-sec-item-row';
            row.style.cssText = 'display:flex;align-items:center;gap:6px;';
            row.innerHTML = '<span style="color:#9ca3af;font-size:14px;">&#9675;</span>'
                + '<input type="text" name="<?= CFG_OPTION ?>[imp_result_sections_items][' + si + '][]" placeholder="Bullet text" style="flex:1;border:1px solid #ddd;border-radius:5px;padding:5px 8px;font-size:13px;"/>'
                + '<button type="button" onclick="impRemoveSecItem(this)" style="width:22px;height:22px;display:flex;align-items:center;justify-content:center;background:none;border:1px solid #ddd;border-radius:4px;cursor:pointer;color:#9ca3af;">&times;</button>';
            items.appendChild(row);
            row.querySelector('input').focus();
        }
        function impRemoveSecItem(btn) { btn.closest('.imp-sec-item-row').remove(); }
        function impAddSection() {
            var editor = document.getElementById('imp-sections-editor');
            var si     = editor.querySelectorAll('.imp-sec-block').length;
            var block  = document.createElement('div');
            block.className = 'imp-sec-block';
            block.style.cssText = 'border:1px solid #e5e7eb;border-radius:8px;padding:14px;';
            block.innerHTML = '<div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">'
                + '<input type="text" name="<?= CFG_OPTION ?>[imp_result_sections_title][' + si + ']" placeholder="Section title" style="flex:1;border:1px solid #ddd;border-radius:5px;padding:6px 10px;font-size:13px;font-weight:600;"/>'
                + '<button type="button" onclick="impRemoveSection(this)" style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;background:none;border:1px solid #ddd;border-radius:4px;cursor:pointer;color:#9ca3af;flex-shrink:0;">&times;</button>'
                + '</div>'
                + '<div class="imp-sec-items" style="display:flex;flex-direction:column;gap:6px;margin-bottom:8px;"></div>'
                + '<button type="button" onclick="impAddSecItem(this)" style="font-size:12px;padding:4px 10px;border:1px dashed #9ca3af;border-radius:5px;background:none;color:#6b7280;cursor:pointer;">+ Add bullet</button>';
            editor.appendChild(block);
            block.querySelector('input').focus();
        }

        /* ── Graft display radio highlight ── */
        function impGraftStyleUpdate(radio) {
            radio.closest('.cfg-card-section').querySelectorAll('label').forEach(function(lbl) {
                var sel = lbl.querySelector('input[type=radio]').checked;
                lbl.style.borderColor = sel ? '#3b82f6' : '#e5e7eb';
                lbl.style.background  = sel ? '#eff6ff' : '#fff';
            });
        }

        /* ── Consultation type radio highlight + prefill ── */
        var _consultCopy = {
            free:         {title: 'Book Your Free Consultation',         sub: "Enter your details and we'll reach out to confirm your complimentary implant consultation."},
            paid_cbct:    {title: 'Book Your Consultation',              sub: "Enter your details and we'll be in touch to schedule your consultation. Note: 3D imaging (CBCT) is a separate paid item at your appointment."},
            paid_credited:{title: 'Book Your Consultation',              sub: "Enter your details and we'll reach out to confirm your appointment. Your consultation fee is applied as a credit toward your treatment if you proceed."}
        };
        function impConsultTypeChange(radio) {
            radio.closest('.cfg-card-section').querySelectorAll('label').forEach(function(lbl) {
                var inp = lbl.querySelector('input[type=radio]');
                if (!inp) return;
                var sel = inp.checked;
                lbl.style.borderColor = sel ? '#2271b1' : '#e5e7eb';
                lbl.style.background  = sel ? '#eff6ff' : '#fff';
            });
            var copy = _consultCopy[radio.value];
            if (copy) {
                var t = document.getElementById('imp_contact_title');
                var s = document.getElementById('imp_contact_subtitle');
                if (t && !t._userEdited) t.value = copy.title;
                if (s && !s._userEdited) s.value = copy.sub;
            }
        }
        // Mark fields as user-edited once they type manually
        ['imp_contact_title','imp_contact_subtitle'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.addEventListener('input', function(){ el._userEdited = true; });
        });
        </script>
        </div><!-- /cfg-panel-body -->
    </div>

    <!-- ═══ SETUP GUIDE TAB ═══ -->
    <div id="cfg-guide" class="cfg-panel">
        <div class="cfg-panel-hdr">
            <h2>Setup Guide</h2>
            <p>Step-by-step instructions to connect and configure the plugin.</p>
        </div>
        <style>
        .og-wrap{max-width:860px;}
        .og-phase{display:flex;align-items:center;gap:12px;margin:32px 0 16px;padding-bottom:10px;border-bottom:2px solid #2271b1;}
        .og-phase:first-of-type{margin-top:0;}
        .og-phase-badge{background:#2271b1;color:#fff;font-weight:700;font-size:11px;letter-spacing:.08em;text-transform:uppercase;padding:4px 10px;border-radius:20px;white-space:nowrap;}
        .og-phase-title{font-size:16px;font-weight:700;color:#1d2327;margin:0;}
        .og-phase-sub{font-size:12px;color:#646970;margin:2px 0 0;}
        .og-step{display:flex;gap:14px;align-items:flex-start;padding:16px 0;border-bottom:1px solid #f0f0f1;}
        .og-step:last-child{border-bottom:none;}
        .og-num{flex-shrink:0;width:30px;height:30px;border-radius:50%;background:#2271b1;color:#fff;font-weight:700;font-size:13px;display:flex;align-items:center;justify-content:center;margin-top:1px;}
        .og-body{flex:1;min-width:0;}
        .og-body h3{margin:0 0 5px;font-size:13.5px;font-weight:700;color:#1d2327;}
        .og-body p{margin:0 0 8px;font-size:13px;color:#3c434a;line-height:1.6;}
        .og-body p:last-child{margin-bottom:0;}
        .og-body ul{margin:6px 0 8px 18px;padding:0;font-size:13px;color:#3c434a;line-height:1.75;}
        .og-body ul:last-child{margin-bottom:0;}
        .og-code{display:inline-block;background:#f0f0f0;border:1px solid #ddd;border-radius:3px;padding:1px 6px;font-family:monospace;font-size:12px;color:#1d2327;}
        .og-tip{background:#fff8e1;border-left:4px solid #f0b429;padding:10px 14px;font-size:12.5px;color:#3c434a;border-radius:0 4px 4px 0;margin-top:10px;line-height:1.6;}
        .og-warn{background:#fef2f2;border-left:4px solid #ef4444;padding:10px 14px;font-size:12.5px;color:#3c434a;border-radius:0 4px 4px 0;margin-top:10px;line-height:1.6;}
        .og-table{width:100%;border-collapse:collapse;font-size:12.5px;margin:10px 0 4px;}
        .og-table th{background:#f0f6fc;padding:7px 11px;text-align:left;border:1px solid #dde3e9;font-weight:700;color:#1d2327;}
        .og-table td{padding:6px 11px;border:1px solid #e5e5e5;color:#3c434a;vertical-align:top;line-height:1.55;}
        .og-table tr:nth-child(even) td{background:#fafafa;}
        .og-tag{display:inline-block;background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;font-size:11.5px;font-weight:600;padding:2px 8px;border-radius:4px;font-family:monospace;}
        .og-field{display:inline-block;background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;font-size:11.5px;font-weight:600;padding:2px 8px;border-radius:4px;font-family:monospace;}
        .og-checklist{list-style:none;margin:8px 0 0;padding:0;}
        .og-checklist li{display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#3c434a;line-height:1.6;margin-bottom:5px;}
        .og-checklist li::before{content:"☐";font-size:15px;line-height:1.2;color:#9ca3af;flex-shrink:0;}
        .og-section-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#9ca3af;margin:16px 0 6px;}
        </style>
        <div class="cfg-panel-body">
        <div class="og-wrap">

        <p style="font-size:13px;color:#3c434a;line-height:1.65;margin:0 0 24px;padding:14px 16px;background:#f0f6fc;border-radius:6px;border-left:4px solid #2271b1;">
            This checklist walks you through everything needed to connect the implant estimator to GoHighLevel — from API keys through to live workflow testing. Complete the steps in order the first time you set up a new sub-account.
        </p>

        <!-- ═══ PHASE 1 — API CONNECTION ═══ -->
        <div class="og-phase">
            <span class="og-phase-badge">Phase 1</span>
            <div><p class="og-phase-title">Connect the Plugin to GHL</p><p class="og-phase-sub">One-time setup per sub-account — takes about 5 minutes</p></div>
        </div>

        <div class="og-step">
            <div class="og-num">1</div>
            <div class="og-body">
                <h3>Create a Private Integration API Key</h3>
                <p>In GHL go to <strong>Settings → Integrations → Private Integrations</strong> and click <strong>+ Add Integration</strong>.</p>
                <ul>
                    <li>Name it anything — e.g. <em>WordPress Implant Estimator</em></li>
                    <li>Select <strong>Location level</strong></li>
                    <li>Enable scope: <strong>Contacts — Read &amp; Write</strong></li>
                </ul>
                <p>Copy the <strong>Bearer Token</strong> and paste it into <em>API Key / Bearer Token</em> on the <strong>⚡ GHL + Security</strong> tab.</p>
            </div>
        </div>

        <div class="og-step">
            <div class="og-num">2</div>
            <div class="og-body">
                <h3>Find Your Location ID</h3>
                <p>Go to <strong>Settings → Business Profile</strong> and scroll to the <strong>Location ID</strong> field (looks like <code class="og-code">AbCdEfGhIj123456</code>). Paste it into the <em>Location ID</em> field on the <strong>⚡ GHL + Security</strong> tab.</p>
                <div class="og-tip"><strong>Tip:</strong> The Location ID is also in your GHL browser URL — it's the string after <code class="og-code">/location/</code> in the address bar.</div>
            </div>
        </div>

        <!-- ═══ PHASE 2 — CUSTOM FIELDS ═══ -->
        <div class="og-phase">
            <span class="og-phase-badge">Phase 2</span>
            <div><p class="og-phase-title">Create Custom Fields in GHL</p><p class="og-phase-sub">Settings → Custom Fields → Contacts — all fields are type <strong>Text</strong></p></div>
        </div>

        <div class="og-step">
            <div class="og-num">3</div>
            <div class="og-body">
                <h3>UTM Tracking Fields</h3>
                <p>These capture ad campaign data from the page URL and are sent on every form submission. Create one Text field for each:</p>
                <table class="og-table">
                    <tr><th>Field Key (exact)</th><th>Suggested Label</th><th>What it captures</th></tr>
                    <tr><td><span class="og-field">utm_campaign</span></td><td>UTM Campaign</td><td>Google Ads campaign name</td></tr>
                    <tr><td><span class="og-field">utm_medium</span></td><td>UTM Medium</td><td>Traffic medium (e.g. <em>cpc</em>, <em>email</em>)</td></tr>
                    <tr><td><span class="og-field">utm_content</span></td><td>UTM Content</td><td>Ad variation / creative ID</td></tr>
                    <tr><td><span class="og-field">utm_keyword</span></td><td>UTM Keyword</td><td>Search keyword that triggered the ad</td></tr>
                    <tr><td><span class="og-field">gclid</span></td><td>Google Click ID</td><td>Google auto-tagging ID (for import into Google Ads)</td></tr>
                </table>
                <div class="og-tip"><strong>Why this matters:</strong> These fields let you see exactly which campaign, ad, and keyword produced each lead — and import offline conversions back into Google Ads via the <code class="og-code">gclid</code>.</div>
            </div>
        </div>

        <div class="og-step">
            <div class="og-num">4</div>
            <div class="og-body">
                <h3>Contact Form Fields</h3>
                <p>Sent on every contact form submission. Create these as Text fields in GHL.</p>
                <table class="og-table">
                    <tr><th>Field Key (exact)</th><th>Suggested Label</th><th>Example value</th></tr>
                    <tr><td><span class="og-field">treatment_type</span></td><td>Treatment Type</td><td><em>Invisalign</em>, <em>Implants</em>, <em>General</em> — set by the treatment dropdown on the form</td></tr>
                </table>
                <div class="og-tip"><strong>Note:</strong> The treatment dropdown options are fully configurable in the Contact Form settings tab. The value sent to GHL is exactly the option label the patient selected.</div>
            </div>
        </div>

        <div class="og-step">
            <div class="og-num">5</div>
            <div class="og-body">
                <h3>Aligner / Invisalign Form Fields</h3>
                <p>Sent on every aligner quiz submission. These capture the patient's quiz answers and treatment type.</p>
                <table class="og-table">
                    <tr><th>Field Key (exact)</th><th>Suggested Label</th><th>Example value</th></tr>
                    <tr><td><span class="og-field">treatment_type</span></td><td>Treatment Type</td><td><em>Invisalign</em> — always set automatically</td></tr>
                    <tr><td><span class="og-field">prev_orthodontic</span></td><td>Previous Orthodontic Treatment</td><td><em>yes</em> or <em>no</em></td></tr>
                    <tr><td><span class="og-field">dental_work</span></td><td>Existing Dental Work</td><td><em>yes</em> or <em>no</em></td></tr>
                    <tr><td><span class="og-field">teeth_alignment</span></td><td>Teeth Alignment</td><td><em>Very crowded</em>, <em>Slightly crowded</em>, etc.</td></tr>
                    <tr><td><span class="og-field">bite_issues</span></td><td>Bite Issues</td><td><em>Overbite</em>, <em>Underbite</em>, <em>None of the above</em>, etc.</td></tr>
                </table>
                <div class="og-tip"><strong>Note:</strong> The aligner quiz steps are fully customizable in the Aligner Form settings tab — field keys match whatever you set in the <em>Field Key</em> input for each step. Only steps with a non-empty answer are sent.</div>
            </div>
        </div>

        <div class="og-step">
            <div class="og-num">6</div>
            <div class="og-body">
                <h3>Implant Estimator Answer Fields</h3>
                <p>These capture what the patient selected during the quiz. Each answer is stored in its own field so you can filter and segment in GHL.</p>
                <table class="og-table">
                    <tr><th>Field Key (exact)</th><th>Suggested Label</th><th>Example value</th></tr>
                    <tr><td><span class="og-field">implant_flow</span></td><td>Implant Path</td><td><em>single</em>, <em>multiple</em>, or <em>fullarch</em></td></tr>
                    <tr><td><span class="og-field">implant_toothLocation</span></td><td>Tooth Location</td><td><em>front</em> or <em>back</em></td></tr>
                    <tr><td><span class="og-field">implant_boneGraft</span></td><td>Bone Graft Needed</td><td><em>yes</em>, <em>no</em>, or <em>not-sure</em></td></tr>
                    <tr><td><span class="og-field">implant_teethCount</span></td><td>Teeth Count</td><td><em>2</em>, <em>3</em> … <em>7</em></td></tr>
                    <tr><td><span class="og-field">implant_archSelection</span></td><td>Arch Selection</td><td><em>upper</em>, <em>lower</em>, or <em>both</em></td></tr>
                    <tr><td><span class="og-field">implant_insurance</span></td><td>Has Dental Insurance</td><td><em>yes</em> or <em>no</em></td></tr>
                    <tr><td><span class="og-field">implant_range</span></td><td>Estimated Price Range</td><td><em>$9,750 – $13,500 — 2 implants</em></td></tr>
                </table>
                <div class="og-tip"><strong>Note:</strong> Field keys are prefixed with <code class="og-code">implant_</code> followed by the quiz field name exactly as configured in the estimator settings. Only fields with a non-empty answer are sent — blank answers are skipped. <strong>These fields are created automatically on the first form submission</strong> — no manual setup needed.</div>
            </div>
        </div>

        <!-- ═══ PHASE 3 — TAGS ═══ -->
        <div class="og-phase">
            <span class="og-phase-badge">Phase 3</span>
            <div><p class="og-phase-title">Understand the Tags the Plugin Sends</p><p class="og-phase-sub">Tags are applied automatically on every submission — use them as workflow triggers</p></div>
        </div>

        <div class="og-step">
            <div class="og-num">7</div>
            <div class="og-body">
                <h3>Tags Applied per Form</h3>
                <p>Every submission adds tags to the contact in GHL. No setup needed — they are applied automatically. Here is the full list:</p>
                <div class="og-section-label">Contact Form</div>
                <ul>
                    <li><span class="og-tag">website-contact-form</span> — every contact form submission</li>
                </ul>
                <div class="og-section-label">Aligner / Invisalign Form</div>
                <ul>
                    <li><span class="og-tag">website-invisalign-form</span> — use this as your primary workflow trigger</li>
                    <li><span class="og-tag">aligner-quiz</span> — also applied on every submission</li>
                    <li><span class="og-tag">website-lead</span> — applied on every aligner and implant lead</li>
                </ul>
                <div class="og-section-label">Implant Estimator</div>
                <ul>
                    <li><span class="og-tag">implant-estimator</span> — every implant lead</li>
                    <li><span class="og-tag">website-lead</span> — applied on every implant and aligner lead</li>
                    <li><span class="og-tag">implant-single</span> / <span class="og-tag">implant-multiple</span> / <span class="og-tag">implant-fullarch</span> — the path they took</li>
                    <li><span class="og-tag">bone-graft-yes</span> / <span class="og-tag">bone-graft-no</span> / <span class="og-tag">bone-graft-not-sure</span> — their bone graft answer</li>
                    <li><span class="og-tag">has-insurance</span> / <span class="og-tag">no-insurance</span> — their insurance answer (if enabled)</li>
                </ul>
                <div class="og-tip"><strong>Tip:</strong> Use <em>Contact Tag Added</em> as your workflow trigger (not <em>Contact Created</em>). This fires even when an existing patient re-submits — and <span class="og-tag">website-invisalign-form</span> is the cleanest trigger for the aligner workflow.</div>
            </div>
        </div>

        <!-- ═══ PHASE 4 — WORKFLOWS ═══ -->
        <div class="og-phase">
            <span class="og-phase-badge">Phase 4</span>
            <div><p class="og-phase-title">Build Workflows in GHL</p><p class="og-phase-sub">Automation → Workflows → + New Workflow</p></div>
        </div>

        <div class="og-step">
            <div class="og-num">8</div>
            <div class="og-body">
                <h3>Workflow 1 — Implant Lead Follow-Up</h3>
                <p><strong>Trigger:</strong> Contact Tag Added → tag equals <span class="og-tag">implant-estimator</span></p>
                <p>Recommended actions in order:</p>
                <ul>
                    <li><strong>Wait 0 min</strong> → Send SMS: <em>"Hi [First Name], thanks for using our implant cost estimator! Your estimated range is [Custom Value: implant_range]. We'd love to get you in for a free consultation — reply YES to book."</em></li>
                    <li><strong>Wait 5 min</strong> → Send Email: personalised implant follow-up with their range and a booking link</li>
                    <li><strong>Wait 1 day</strong> → Internal notification to assign to a team member for manual follow-up</li>
                    <li><strong>Add to Pipeline:</strong> Pipeline = <em>Implant Leads</em>, Stage = <em>Estimator Completed</em></li>
                    <li><strong>Assign User</strong> to the appropriate team member or round-robin</li>
                </ul>
                <div class="og-tip"><strong>Personalisation tip:</strong> Use GHL custom value syntax <code class="og-code">{{contact.implant_range}}</code> in your SMS/email body to pull in the exact price range the patient saw.</div>
            </div>
        </div>

        <div class="og-step">
            <div class="og-num">9</div>
            <div class="og-body">
                <h3>Workflow 2 — Full-Arch Leads (high-value segment)</h3>
                <p><strong>Trigger:</strong> Contact Tag Added → tag equals <span class="og-tag">implant-fullarch</span></p>
                <p>These are your highest-value leads. Route them differently:</p>
                <ul>
                    <li>Immediate internal SMS notification to a designated team member</li>
                    <li>Higher-priority pipeline stage (e.g. <em>High Value — Call Now</em>)</li>
                    <li>Different email sequence focused on All-on-4 / All-on-6 treatment</li>
                </ul>
            </div>
        </div>

        <div class="og-step">
            <div class="og-num">10</div>
            <div class="og-body">
                <h3>Workflow 3 — Bone Graft Segment</h3>
                <p><strong>Trigger:</strong> Contact Tag Added → tag equals <span class="og-tag">bone-graft-yes</span> <em>or</em> <span class="og-tag">bone-graft-not-sure</span></p>
                <p>These patients may need an additional procedure. Tailor your messaging:</p>
                <ul>
                    <li>Add a note to their contact: <em>"Patient indicated possible bone grafting need"</em></li>
                    <li>Include bone graft context in the follow-up email (the <code class="og-code">implant_range</code> field already reflects the graft add-on price if the estimator is set to <em>addon</em> mode)</li>
                </ul>
            </div>
        </div>

        <div class="og-step">
            <div class="og-num">11</div>
            <div class="og-body">
                <h3>Workflow 4 — Contact Form Enquiries</h3>
                <p><strong>Trigger:</strong> Contact Tag Added → tag equals <span class="og-tag">website-contact-form</span></p>
                <ul>
                    <li>Send confirmation email: <em>"Thanks for reaching out, we'll be in touch within [X] hours."</em></li>
                    <li>Create task / assign to front desk</li>
                    <li>Add to pipeline: <em>New Leads → Contacted</em></li>
                </ul>
            </div>
        </div>

        <div class="og-step">
            <div class="og-num">12</div>
            <div class="og-body">
                <h3>Add Contacts to Your Pipeline on Every Workflow</h3>
                <p>Every workflow above should include an <strong>Add to Pipeline / Stage</strong> action so new leads don't fall through the cracks. Suggested pipeline stages:</p>
                <table class="og-table">
                    <tr><th>Stage</th><th>Who goes here</th></tr>
                    <tr><td>Estimator Completed</td><td>All implant estimator leads</td></tr>
                    <tr><td>High Value — Call Now</td><td>Full-arch leads</td></tr>
                    <tr><td>Consultation Booked</td><td>Moved here manually or via booking trigger</td></tr>
                    <tr><td>New Enquiry</td><td>Contact form submissions</td></tr>
                </table>
            </div>
        </div>

        <!-- ═══ PHASE 5 — TEST ═══ -->
        <div class="og-phase">
            <span class="og-phase-badge">Phase 5</span>
            <div><p class="og-phase-title">Test &amp; Verify Everything</p><p class="og-phase-sub">Do this before going live</p></div>
        </div>

        <div class="og-step">
            <div class="og-num">13</div>
            <div class="og-body">
                <h3>Submit a Test Implant Lead</h3>
                <p>Go to the page with your implant estimator shortcode and append test UTM parameters to the URL:</p>
                <p><code class="og-code">?utm_campaign=test-campaign&amp;utm_medium=cpc&amp;utm_keyword=dental+implants&amp;gclid=test123</code></p>
                <p>Complete the full quiz and submit your details. Then in GHL <strong>Contacts</strong>, find your test contact and verify:</p>
                <ul class="og-checklist">
                    <li>Contact was created with correct name, email, and phone</li>
                    <li>Tag <span class="og-tag">implant-estimator</span> was applied</li>
                    <li>Path tag (<span class="og-tag">implant-single</span>, <span class="og-tag">implant-multiple</span>, or <span class="og-tag">implant-fullarch</span>) was applied</li>
                    <li>Custom field <span class="og-field">implant_range</span> shows the correct price range</li>
                    <li>Custom field <span class="og-field">utm_campaign</span> shows <em>test-campaign</em></li>
                    <li>Custom field <span class="og-field">gclid</span> shows <em>test123</em></li>
                    <li>Workflow was triggered (check the contact's <strong>Workflow History</strong> tab)</li>
                    <li>Contact was added to the correct pipeline stage</li>
                </ul>
                <div class="og-tip"><strong>Workflow not triggered?</strong> Check that the workflow is <strong>Published</strong> (not Draft), and that the trigger is set to <em>Contact Tag Added</em> — not <em>Contact Created</em> or <em>Tag Changed</em>.</div>
            </div>
        </div>

        <div class="og-step">
            <div class="og-num">14</div>
            <div class="og-body">
                <h3>Submit a Test Contact Form Lead</h3>
                <p>Fill out the main contact form (not the estimator) with a test email and verify:</p>
                <ul class="og-checklist">
                    <li>Contact created / updated in GHL</li>
                    <li>Tag <span class="og-tag">website-contact-form</span> applied</li>
                    <li>UTM custom fields populated (if URL has UTM params)</li>
                    <li>Contact form workflow triggered</li>
                </ul>
            </div>
        </div>

        </div><!-- /og-wrap -->
        </div><!-- /cfg-panel-body -->
    </div>

    <!-- ══════════════════ GHL FIELDS PANEL ══════════════════ -->
    <div id="cfg-ghl_fields" class="cfg-panel">
        <div class="cfg-panel-hdr">
            <h2>GHL Custom Fields</h2>
            <p>Check, create, and organise all required custom fields in GoHighLevel.</p>
        </div>
        <div class="cfg-panel-body">

            <!-- ── Folder IDs ── -->
            <?php
            $s           = get_option( CFG_OPTION, [] ) + cfg_defaults();
            $location_id = $s['ghl_location_id'] ?? '';
            $saved_fids  = cfg_get_folder_ids( $location_id );
            $folder_names = [ 'Contact Form', 'Invisalign Form', 'Implants Form', 'UTM Forms' ];
            ?>
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px 20px;margin-bottom:22px;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:14px;">
                    <div>
                        <strong style="font-size:13px;color:#1e293b;">Folder IDs</strong>
                        <div style="margin-top:8px;font-size:11px;color:#64748b;line-height:1.9;">
                            <strong style="color:#0f172a;font-size:11.5px;">One-time setup — follow these steps in order:</strong><br>
                            <strong style="color:#2563eb;">Step 1.</strong> In GHL → Settings → Custom Fields → create 4 folders named exactly:&nbsp;
                            <code style="background:#e2e8f0;padding:1px 5px;border-radius:3px;">Contact Form</code>&nbsp;
                            <code style="background:#e2e8f0;padding:1px 5px;border-radius:3px;">Invisalign Form</code>&nbsp;
                            <code style="background:#e2e8f0;padding:1px 5px;border-radius:3px;">Implants Form</code>&nbsp;
                            <code style="background:#e2e8f0;padding:1px 5px;border-radius:3px;">UTM Forms</code><br>
                            <strong style="color:#2563eb;">Step 2.</strong> Click <strong>+ Create Checker Fields</strong> — 4 temporary marker fields will appear in GHL under Additional Info<br>
                            <strong style="color:#2563eb;">Step 3.</strong> In GHL, drag each checker field into its matching folder (names make it obvious)<br>
                            <strong style="color:#2563eb;">Step 4.</strong> Click <strong>Auto-detect</strong> — folder IDs are found and saved automatically<br>
                            <strong style="color:#2563eb;">Step 5.</strong> Click <strong>Move All to Folders</strong> — all fields are organised into their folders<br>
                            <strong style="color:#2563eb;">Step 6.</strong> Click <strong>Delete Checkers</strong> — temporary marker fields removed from GHL
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:6px;align-items:flex-end;">
                        <button type="button" id="cfg-create-checkers-btn" class="button button-primary" style="font-size:11px;padding:4px 14px;white-space:nowrap;" title="Creates 4 temporary marker fields in GHL — drag each to its folder, then Auto-detect">
                            &#43; Create Checker Fields
                        </button>
                        <button type="button" id="cfg-detect-folders-btn" class="button" style="font-size:11px;padding:4px 14px;white-space:nowrap;">
                            &#128269; Auto-detect
                        </button>
                        <button type="button" id="cfg-delete-checkers-btn" class="button" style="font-size:11px;padding:4px 14px;white-space:nowrap;color:#dc2626;border-color:#fca5a5;" title="Deletes the 4 temporary checker fields from GHL">
                            &#128465; Delete Checkers
                        </button>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:10px;" id="cfg-folder-id-grid">
                    <?php foreach ( $folder_names as $fn ): $sk = str_replace( ' ', '_', strtolower( $fn ) ); ?>
                    <label style="font-size:12px;color:#374151;">
                        <?= esc_html( $fn ) ?>
                        <input type="text" id="cfg-fid-<?= esc_attr($sk) ?>" placeholder="folder ID…"
                               value="<?= esc_attr( $saved_fids[ $fn ] ?? '' ) ?>"
                               style="display:block;width:100%;margin-top:4px;font-family:monospace;font-size:11px;padding:4px 7px;border:1px solid #cbd5e1;border-radius:4px;box-sizing:border-box;">
                    </label>
                    <?php endforeach; ?>
                </div>
                <div style="margin-top:12px;padding:10px 12px;background:#f1f5f9;border-radius:6px;font-size:11px;color:#374151;">
                    <strong>Paste GHL URL to extract ID:</strong>
                    <div style="display:flex;gap:8px;margin-top:6px;">
                        <input type="text" id="cfg-folder-url-input" placeholder="Paste GHL URL here (e.g. …?folderId=AbCdEf…)" style="flex:1;font-size:11px;padding:4px 7px;border:1px solid #cbd5e1;border-radius:4px;">
                        <select id="cfg-folder-url-target" style="font-size:11px;padding:4px 7px;border:1px solid #cbd5e1;border-radius:4px;">
                            <option value="contact_form">Contact Form</option>
                            <option value="invisalign_form">Invisalign Form</option>
                            <option value="implants_form">Implants Form</option>
                            <option value="utm_forms">UTM Forms</option>
                        </select>
                        <button type="button" id="cfg-folder-url-btn" class="button" style="font-size:11px;padding:3px 10px;">Extract</button>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px;margin-top:12px;">
                    <button type="button" id="cfg-save-folder-ids-btn" class="button button-secondary" style="font-size:12px;padding:4px 14px;">
                        &#10003; Save Folder IDs
                    </button>
                    <span id="cfg-folder-ids-status" style="font-size:11px;color:#6b7280;"></span>
                </div>
            </div>

            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-bottom:24px;">
                <button type="button" id="cfg-fields-check-btn" class="button button-primary" style="font-size:13px;padding:6px 18px;">
                    &#9654; Check Fields
                </button>
                <button type="button" id="cfg-fields-create-all-btn" class="button" style="font-size:13px;padding:6px 18px;display:none;">
                    &#43; Create All Missing
                </button>
                <button type="button" id="cfg-fields-move-btn" class="button" style="font-size:13px;padding:6px 18px;" title="Move all existing fields into their correct GHL folders (requires folder IDs saved above)">
                    &#8594; Move All to Folders
                </button>
                <span id="cfg-fields-status" style="font-size:12px;color:#6b7280;"></span>
            </div>

            <table id="cfg-fields-table" style="width:100%;border-collapse:collapse;font-size:13px;display:none;">
                <thead>
                    <tr style="border-bottom:2px solid #e5e7eb;">
                        <th style="text-align:left;padding:8px 12px;color:#374151;font-weight:600;">Status</th>
                        <th style="text-align:left;padding:8px 12px;color:#374151;font-weight:600;">Field Name</th>
                        <th style="text-align:left;padding:8px 12px;color:#374151;font-weight:600;">Field Key</th>
                        <th style="text-align:left;padding:8px 12px;color:#374151;font-weight:600;">Form</th>
                        <th style="text-align:left;padding:8px 12px;color:#374151;font-weight:600;">Action</th>
                    </tr>
                </thead>
                <tbody id="cfg-fields-tbody"></tbody>
            </table>

            <script>
            (function(){
                var NONCE       = '<?= wp_create_nonce('cfg_fields_nonce') ?>';
                var AJAX        = '<?= admin_url('admin-ajax.php') ?>';
                var FOLDER_KEYS = ['contact_form','invisalign_form','implants_form','utm_forms'];
                var FOLDER_NAMES = {'contact_form':'Contact Form','invisalign_form':'Invisalign Form','implants_form':'Implants Form','utm_forms':'UTM Forms'};

                // ── Save folder IDs ──
                document.getElementById('cfg-save-folder-ids-btn').addEventListener('click', function(){
                    var btn = this, fst = document.getElementById('cfg-folder-ids-status');
                    btn.disabled = true;
                    fst.textContent = 'Saving…'; fst.style.color = '#6b7280';
                    var body = 'action=cfg_save_folder_ids&nonce=' + NONCE;
                    FOLDER_KEYS.forEach(function(k){
                        var val = (document.getElementById('cfg-fid-' + k) || {}).value || '';
                        body += '&folder_' + k + '=' + encodeURIComponent(val);
                    });
                    fetch(AJAX, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body: body })
                    .then(function(r){ return r.json(); })
                    .then(function(res){
                        btn.disabled = false;
                        fst.textContent = res.success ? '✓ Saved' : '✗ ' + (res.data || 'Error');
                        fst.style.color  = res.success ? '#16a34a' : '#dc2626';
                    }).catch(function(){ btn.disabled=false; fst.textContent='✗ Request failed'; fst.style.color='#dc2626'; });
                });

                // ── URL extractor ──
                document.getElementById('cfg-folder-url-btn').addEventListener('click', function(){
                    var url    = document.getElementById('cfg-folder-url-input').value.trim();
                    var target = document.getElementById('cfg-folder-url-target').value;
                    var fst    = document.getElementById('cfg-folder-ids-status');
                    // Try ?folderId=X or /folderId/X or hash #folderId=X
                    var m = url.match(/[?#&/]folderId[=/]([A-Za-z0-9_-]+)/i) ||
                            url.match(/folder[_-]?id[=:/]([A-Za-z0-9_-]+)/i) ||
                            url.match(/\/([A-Za-z0-9]{15,25})(?:[/?#]|$)/);
                    if (!m) { fst.textContent = '✗ No folder ID found in URL — try copying the full URL'; fst.style.color='#dc2626'; return; }
                    var extracted = m[1];
                    var el = document.getElementById('cfg-fid-' + target);
                    if (el) { el.value = extracted; fst.textContent = '✓ Extracted: ' + extracted; fst.style.color='#16a34a'; }
                    document.getElementById('cfg-folder-url-input').value = '';
                });

                // ── Create checker fields ──
                document.getElementById('cfg-create-checkers-btn').addEventListener('click', function(){
                    var btn = this, fst = document.getElementById('cfg-folder-ids-status');
                    btn.disabled = true; fst.textContent = 'Creating checker fields…'; fst.style.color='#6b7280';
                    fetch(AJAX, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'},
                        body: 'action=cfg_create_checker_fields&nonce=' + NONCE })
                    .then(function(r){ return r.json(); })
                    .then(function(res){
                        btn.disabled = false;
                        if (res.success) {
                            var d = res.data;
                            fst.textContent = '✓ Created ' + d.created.length + ' checker fields in GHL. Now drag each into its folder, then click Auto-detect.';
                            fst.style.color = d.errors.length ? '#d97706' : '#16a34a';
                        } else { fst.textContent = '✗ ' + (res.data||'Error'); fst.style.color='#dc2626'; }
                    }).catch(function(){ btn.disabled=false; fst.textContent='✗ Request failed'; fst.style.color='#dc2626'; });
                });

                // ── Delete checker fields ──
                document.getElementById('cfg-delete-checkers-btn').addEventListener('click', function(){
                    var btn = this, fst = document.getElementById('cfg-folder-ids-status');
                    btn.disabled = true; fst.textContent = 'Deleting checker fields…'; fst.style.color='#6b7280';
                    fetch(AJAX, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'},
                        body: 'action=cfg_delete_checker_fields&nonce=' + NONCE })
                    .then(function(r){ return r.json(); })
                    .then(function(res){
                        btn.disabled = false;
                        if (res.success) {
                            var d = res.data;
                            fst.textContent = '✓ Deleted ' + d.deleted.length + ' checker field(s).' + (d.errors.length ? ' Errors: '+d.errors.join(', ') : '');
                            fst.style.color = d.errors.length ? '#d97706' : '#16a34a';
                        } else { fst.textContent = '✗ ' + (res.data||'Error'); fst.style.color='#dc2626'; }
                    }).catch(function(){ btn.disabled=false; fst.textContent='✗ Request failed'; fst.style.color='#dc2626'; });
                });

                // ── Auto-detect folder IDs from existing GHL fields ──
                document.getElementById('cfg-detect-folders-btn').addEventListener('click', function(){
                    var btn = this, fst = document.getElementById('cfg-folder-ids-status');
                    btn.disabled = true;
                    fst.textContent = 'Detecting…'; fst.style.color = '#6b7280';
                    fetch(AJAX, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'},
                        body: 'action=cfg_detect_folder_ids&nonce=' + NONCE })
                    .then(function(r){ return r.json(); })
                    .then(function(res){
                        btn.disabled = false;
                        if (!res.success) { fst.textContent = '✗ ' + (res.data||'Error'); fst.style.color='#dc2626'; return; }
                        var detected  = res.data.detected;
                        var byName    = res.data.by_name || {};  // folder name → id, matched by name
                        var stored    = res.data.stored;

                        // ── Best case: GHL returned folders by name ──
                        var nameMatches = Object.keys(byName).length;
                        if (nameMatches > 0) {
                            // Fill inputs from by_name map
                            Object.keys(byName).forEach(function(name){
                                var k  = name.toLowerCase().replace(/ /g,'_');
                                var el = document.getElementById('cfg-fid-' + k);
                                if (el) el.value = byName[name];
                            });
                            fst.textContent = '✓ Matched ' + nameMatches + ' of 4 folders by name — saved automatically.';
                            fst.style.color = nameMatches === 4 ? '#16a34a' : '#d97706';
                            return;
                        }
                        // Pre-fill stored values first
                        Object.keys(stored).forEach(function(name){
                            var k = name.toLowerCase().replace(/ /g,'_');
                            var el = document.getElementById('cfg-fid-' + k);
                            if (el) el.value = stored[name];
                        });
                        // Auto-match detected folder IDs to our groups by scoring field key overlap
                        var ids = Object.keys(detected);
                        if (!ids.length) { fst.textContent = 'No folders detected — create folders in GHL UI, move one field into each, then retry.'; fst.style.color='#d97706'; return; }

                        // Checker fields score 999 so they always win unambiguously
                        var groupKeys = {
                            'contact_form':    ['cfg_checker_contact_form','treatment_type','automation_tester'],
                            'invisalign_form': ['cfg_checker_invisalign_form','prev_orthodontic','dental_work','teeth_alignment','bite_issues','has_insurance','cdcp_covered'],
                            'implants_form':   ['cfg_checker_implants_form','implant_flow','implant_range','implant_toothlocation','implant_timemissing','implant_bonegraft',
                                               'implant_situationsingle','implant_teethcount','implant_teethlocation','implant_timemissingmult',
                                               'implant_bonegraftmult','implant_situationmult','implant_archselection','implant_situationarch',
                                               'implant_archduration','implant_insurance'],
                            'utm_forms':       ['cfg_checker_utm_forms','utmcampaign_custom','utmmedium_custom','utmcontent_custom','utmkeyword_custom','utmterm_custom','gclid_custom']
                        };
                        // Boost checker keys to guaranteed win
                        var checkerKeys = {
                            'contact_form':'cfg_checker_contact_form','invisalign_form':'cfg_checker_invisalign_form',
                            'implants_form':'cfg_checker_implants_form','utm_forms':'cfg_checker_utm_forms'
                        };

                        // Score each folder ID against each group
                        var scores = {}; // id => { gk: score }
                        ids.forEach(function(id){
                            var keys = (detected[id]||[]).map(function(k){ return k.toLowerCase(); });
                            scores[id] = {};
                            Object.keys(groupKeys).forEach(function(gk){
                                // Checker key present → guaranteed win
                                if (keys.indexOf(checkerKeys[gk]) >= 0) { scores[id][gk] = 999; return; }
                                var s = groupKeys[gk].filter(function(k){ return keys.indexOf(k) >= 0; }).length;
                                if (gk === 'implants_form') s += keys.filter(function(k){ return k.indexOf('implant_') === 0; }).length;
                                if (gk === 'utm_forms')     s += keys.filter(function(k){ return k.indexOf('utmcampaign') === 0 || k.indexOf('utmmedium') === 0 || k.indexOf('utmcontent') === 0 || k === 'gclid_custom'; }).length;
                                scores[id][gk] = s;
                            });
                        });

                        // Exclusive assignment: each folder ID → only the ONE group it scores highest for
                        // Then per group, pick the folder ID with the highest score
                        var bestMatch = {}; // gk => { id, score }
                        ids.forEach(function(id){
                            // Find which group this folder ID fits best
                            var topGk = null, topScore = 0;
                            Object.keys(groupKeys).forEach(function(gk){
                                if (scores[id][gk] > topScore) { topScore = scores[id][gk]; topGk = gk; }
                            });
                            if (!topGk || topScore === 0) return; // skip unrecognised folders
                            if (topScore > ((bestMatch[topGk] || {}).score || 0)) {
                                bestMatch[topGk] = { id: id, score: topScore };
                            }
                        });

                        var filled = 0;
                        Object.keys(bestMatch).forEach(function(gk){
                            var el = document.getElementById('cfg-fid-' + gk);
                            if (el) { el.value = bestMatch[gk].id; filled++; }
                        });

                        var unmatched = ids.filter(function(id){
                            return !Object.values(bestMatch).some(function(m){ return m.id === id; });
                        });

                        if (filled === 0) {
                            fst.textContent = 'No fields matched any folder — move at least one field per folder in GHL UI, then re-detect.';
                            fst.style.color = '#d97706';
                            return;
                        }

                        // Auto-save detected IDs immediately
                        fst.textContent = 'Saving…'; fst.style.color = '#6b7280';
                        var saveBody = 'action=cfg_save_folder_ids&nonce=' + NONCE;
                        FOLDER_KEYS.forEach(function(k){
                            var val = (document.getElementById('cfg-fid-' + k) || {}).value || '';
                            saveBody += '&folder_' + k + '=' + encodeURIComponent(val);
                        });
                        fetch(AJAX, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body: saveBody })
                        .then(function(r){ return r.json(); })
                        .then(function(sr){
                            var msg = (sr.success ? '✓ Auto-filled & saved ' : '⚠ Filled but save failed — ') + filled + ' of 4 folder IDs.';
                            if (unmatched.length) msg += ' ' + unmatched.length + ' unrecognised: ' + unmatched.join(', ');
                            if (filled < 4) msg += ' — ' + (4 - filled) + ' still missing, paste manually then Save.';
                            fst.textContent = msg;
                            fst.style.color = sr.success && filled === 4 ? '#16a34a' : '#d97706';
                        })
                        .catch(function(){ fst.textContent = '⚠ Filled but save request failed — click Save Folder IDs manually.'; fst.style.color='#d97706'; });
                    }).catch(function(){ btn.disabled=false; fst.textContent='✗ Request failed'; fst.style.color='#dc2626'; });
                });

                document.getElementById('cfg-fields-check-btn').addEventListener('click', function(){
                    var btn = this;
                    btn.disabled = true;
                    document.getElementById('cfg-fields-status').textContent = 'Checking…';
                    document.getElementById('cfg-fields-table').style.display = 'none';
                    document.getElementById('cfg-fields-create-all-btn').style.display = 'none';

                    fetch(AJAX, {
                        method: 'POST',
                        headers: {'Content-Type':'application/x-www-form-urlencoded'},
                        body: 'action=cfg_check_ghl_fields&nonce=' + NONCE
                    })
                    .then(function(r){ return r.json(); })
                    .then(function(res){
                        btn.disabled = false;
                        if (!res.success) {
                            document.getElementById('cfg-fields-status').textContent = '✗ ' + (res.data || 'Error');
                            document.getElementById('cfg-fields-status').style.color = '#dc2626';
                            return;
                        }
                        var fields  = res.data;
                        var missing = fields.filter(function(f){ return !f.exists; }).length;
                        document.getElementById('cfg-fields-status').textContent =
                            (fields.length - missing) + ' / ' + fields.length + ' fields exist' +
                            (missing ? ' — ' + missing + ' missing' : ' ✓');
                        document.getElementById('cfg-fields-status').style.color = missing ? '#d97706' : '#16a34a';

                        var tbody = document.getElementById('cfg-fields-tbody');
                        tbody.innerHTML = '';
                        var prevGroup = null;
                        fields.forEach(function(f){
                            if (f.group !== prevGroup) {
                                var gr = document.createElement('tr');
                                gr.innerHTML = '<td colspan="5" style="padding:12px 12px 4px;font-weight:700;font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:#9ca3af;background:#f9fafb;">' + f.group + '</td>';
                                tbody.appendChild(gr);
                                prevGroup = f.group;
                            }
                            var tr = document.createElement('tr');
                            tr.id = 'cfg-field-row-' + f.key;
                            tr.style.borderBottom = '1px solid #f3f4f6';
                            tr.innerHTML =
                                '<td style="padding:8px 12px;">' +
                                    (f.exists
                                        ? '<span style="color:#16a34a;font-size:16px;">&#10003;</span>'
                                        : '<span style="color:#dc2626;font-size:16px;">&#10007;</span>') +
                                '</td>' +
                                '<td style="padding:8px 12px;color:#111827;">' + f.name + '</td>' +
                                '<td style="padding:8px 12px;font-family:monospace;color:#4b5563;font-size:12px;">' + f.key + '</td>' +
                                '<td style="padding:8px 12px;color:#6b7280;">' + f.group + '</td>' +
                                '<td style="padding:8px 12px;">' +
                                    (!f.exists
                                        ? '<button type="button" class="button" style="font-size:11px;padding:2px 10px;" onclick="cfgCreateField(\'' + f.key + '\',\'' + f.name.replace(/'/g,"\\'") + '\',\'' + f.group.replace(/'/g,"\\'") + '\',this)">Create</button>'
                                        : '') +
                                '</td>';
                            tbody.appendChild(tr);
                        });

                        document.getElementById('cfg-fields-table').style.display = 'table';
                        if (missing) document.getElementById('cfg-fields-create-all-btn').style.display = '';
                    })
                    .catch(function(e){
                        btn.disabled = false;
                        document.getElementById('cfg-fields-status').textContent = '✗ Request failed';
                        document.getElementById('cfg-fields-status').style.color = '#dc2626';
                    });
                });

                document.getElementById('cfg-fields-create-all-btn').addEventListener('click', function(){
                    var rows = document.querySelectorAll('#cfg-fields-tbody tr[id^="cfg-field-row-"]');
                    rows.forEach(function(row){
                        var btn = row.querySelector('button.button');
                        if (btn) btn.click();
                    });
                });

                document.getElementById('cfg-fields-move-btn').addEventListener('click', function(){
                    var btn = this;
                    var status = document.getElementById('cfg-fields-status');
                    btn.disabled = true;
                    status.textContent = 'Moving fields to folders…';
                    status.style.color = '#6b7280';
                    fetch(AJAX, {
                        method: 'POST',
                        headers: {'Content-Type':'application/x-www-form-urlencoded'},
                        body: 'action=cfg_move_ghl_fields&nonce=' + NONCE
                    })
                    .then(function(r){ return r.json(); })
                    .then(function(res){
                        btn.disabled = false;
                        if (res.success) {
                            var d = res.data;
                            var msg = '✓ Moved ' + d.moved + ' field(s) to folders';
                            if (d.skipped) msg += ' (' + d.skipped + ' already correct/missing)';
                            if (d.errors && d.errors.length) msg += ' — ' + d.errors.length + ' error(s): ' + d.errors.join('; ');
                            status.textContent = msg;
                            status.style.color = d.errors && d.errors.length ? '#d97706' : '#16a34a';
                        } else {
                            status.textContent = '✗ ' + (res.data || 'Error');
                            status.style.color = '#dc2626';
                        }
                    })
                    .catch(function(){
                        btn.disabled = false;
                        status.textContent = '✗ Request failed';
                        status.style.color = '#dc2626';
                    });
                });

                window.cfgCreateField = function(key, name, folder, btn) {
                    btn.disabled = true;
                    btn.textContent = '…';
                    fetch(AJAX, {
                        method: 'POST',
                        headers: {'Content-Type':'application/x-www-form-urlencoded'},
                        body: 'action=cfg_create_ghl_field&nonce=' + NONCE +
                              '&field_key=' + encodeURIComponent(key) +
                              '&field_name=' + encodeURIComponent(name) +
                              '&folder=' + encodeURIComponent(folder)
                    })
                    .then(function(r){ return r.json(); })
                    .then(function(res){
                        var row = document.getElementById('cfg-field-row-' + key);
                        if (res.success) {
                            row.querySelector('td:first-child').innerHTML = '<span style="color:#16a34a;font-size:16px;">&#10003;</span>';
                            btn.remove();
                        } else {
                            btn.disabled = false;
                            btn.textContent = 'Retry';
                            btn.title = res.data || 'Error';
                        }
                    })
                    .catch(function(){
                        btn.disabled = false;
                        btn.textContent = 'Retry';
                    });
                };
            })();
            </script>
        </div><!-- /cfg-panel-body -->
    </div>
    <!-- ══════════════════ /GHL FIELDS PANEL ══════════════════ -->

    <div id="cfg-save-bar">
    <?php submit_button( 'Save All Settings', 'primary large' ); ?>
    </div>
    </form>

    <?php
    // ── Entries panel (outside the settings form) ──
    global $wpdb;
    $entries_table = $wpdb->prefix . 'cfg_entries';

    // Handle delete/clear actions
    if ( isset( $_GET['cfg_action'] ) && current_user_can( 'manage_options' ) ) {
        check_admin_referer( 'cfg_entries_action' );
        if ( $_GET['cfg_action'] === 'delete' && ! empty( $_GET['entry_id'] ) ) {
            $wpdb->delete( $entries_table, [ 'id' => absint( $_GET['entry_id'] ) ], [ '%d' ] );
            echo '<div class="notice notice-success is-dismissible"><p>Entry deleted.</p></div>';
        } elseif ( $_GET['cfg_action'] === 'clear_all' ) {
            $wpdb->query( "TRUNCATE TABLE {$entries_table}" );
            echo '<div class="notice notice-success is-dismissible"><p>All entries cleared.</p></div>';
        }
    }

    // Handle bulk delete
    if ( isset( $_POST['cfg_bulk_delete'] ) && ! empty( $_POST['entry_ids'] ) && current_user_can( 'manage_options' ) ) {
        check_admin_referer( 'cfg_bulk_delete' );
        $ids = array_map( 'absint', (array) $_POST['entry_ids'] );
        if ( $ids ) {
            $placeholders = implode( ',', array_fill( 0, count( $ids ), '%d' ) );
            $wpdb->query( $wpdb->prepare( "DELETE FROM {$entries_table} WHERE id IN ({$placeholders})", $ids ) );
            echo '<div class="notice notice-success is-dismissible"><p>' . count( $ids ) . ' entries deleted.</p></div>';
        }
    }

    // Handle CSV export
    if ( isset( $_GET['cfg_action'] ) && $_GET['cfg_action'] === 'export_csv' && current_user_can( 'manage_options' ) ) {
        check_admin_referer( 'cfg_entries_action' );
        $all = $wpdb->get_results( "SELECT * FROM {$entries_table} ORDER BY created_at DESC", ARRAY_A );
        header( 'Content-Type: text/csv; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename="form-entries-' . date('Y-m-d') . '.csv"' );
        $out = fopen( 'php://output', 'w' );
        fputcsv( $out, [ 'ID', 'Date', 'Form', 'First Name', 'Last Name', 'Email', 'Phone', 'GHL Status', 'Meta' ] );
        foreach ( $all as $row ) {
            fputcsv( $out, [ $row['id'], $row['created_at'], $row['form_type'], $row['first_name'], $row['last_name'], $row['email'], $row['phone'], $row['ghl_status'], $row['meta'] ] );
        }
        fclose( $out );
        exit;
    }

    // Filters
    $filter_type   = sanitize_text_field( $_GET['filter_type'] ?? '' );
    $filter_search = sanitize_text_field( $_GET['filter_search'] ?? '' );
    $filter_status = sanitize_text_field( $_GET['filter_status'] ?? '' );
    $per_page      = 25;
    $current_page  = max( 1, absint( $_GET['entries_page'] ?? 1 ) );
    $offset        = ( $current_page - 1 ) * $per_page;

    $where  = 'WHERE 1=1';
    $params = [];
    if ( $filter_type )   { $where .= ' AND form_type = %s';                         $params[] = $filter_type; }
    if ( $filter_status ) { $where .= ' AND ghl_status = %s';                        $params[] = $filter_status; }
    if ( $filter_search ) {
        $like = '%' . $wpdb->esc_like( $filter_search ) . '%';
        $where .= ' AND (first_name LIKE %s OR last_name LIKE %s OR email LIKE %s OR phone LIKE %s)';
        $params[] = $like; $params[] = $like; $params[] = $like; $params[] = $like;
    }

    $count_sql = $params
        ? $wpdb->prepare( "SELECT COUNT(*) FROM {$entries_table} {$where}", $params )
        : "SELECT COUNT(*) FROM {$entries_table} {$where}";
    $total = (int) $wpdb->get_var( $count_sql );

    $rows_sql = $params
        ? $wpdb->prepare( "SELECT * FROM {$entries_table} {$where} ORDER BY created_at DESC LIMIT %d OFFSET %d", array_merge( $params, [ $per_page, $offset ] ) )
        : $wpdb->prepare( "SELECT * FROM {$entries_table} {$where} ORDER BY created_at DESC LIMIT %d OFFSET %d", $per_page, $offset );
    $rows = $wpdb->get_results( $rows_sql, ARRAY_A );

    $total_pages = max( 1, ceil( $total / $per_page ) );
    $base_url    = admin_url( 'admin.php?page=' . CFG_SLUG . '&cfg_tab=entries' );
    $nonce_url   = wp_nonce_url( $base_url, 'cfg_entries_action' );
    ?>

    <div id="cfg-entries-wrap" style="display:none;background:#fff;border:1px solid #e2e4e9;border-left:none;border-radius:0 10px 10px 0;min-height:580px;overflow:hidden;">
        <div class="cfg-panel-hdr"><h2>Entries</h2><p>All form submissions logged by the plugin.</p></div>
        <div class="cfg-panel-body" style="padding-top:8px;">

    <style>
    .cfg-entries-toolbar{display:flex;flex-wrap:wrap;gap:10px;align-items:center;padding:14px 0 12px;}
    .cfg-entries-toolbar input[type=text]{padding:6px 10px;border:1px solid #8c8f94;border-radius:4px;font-size:13px;width:220px;}
    .cfg-entries-toolbar select{padding:6px 10px;border:1px solid #8c8f94;border-radius:4px;font-size:13px;}
    .cfg-entries-toolbar .spacer{flex:1;}
    #cfg-entries-table{width:100%;border-collapse:collapse;background:#fff;border:1px solid #c3c4c7;border-radius:4px;overflow:hidden;}
    #cfg-entries-table th{background:#f6f7f7;padding:9px 12px;font-size:12px;font-weight:700;text-align:left;border-bottom:1px solid #c3c4c7;color:#1d2327;white-space:nowrap;}
    #cfg-entries-table td{padding:9px 12px;font-size:13px;border-bottom:1px solid #f0f0f1;vertical-align:middle;}
    #cfg-entries-table tr:last-child td{border-bottom:none;}
    #cfg-entries-table tr:hover td{background:#f9f9f9;}
    .cfg-badge-ok{display:inline-block;background:#dcfce7;color:#166534;padding:2px 8px;border-radius:12px;font-size:11px;font-weight:600;}
    .cfg-badge-error{display:inline-block;background:#fee2e2;color:#991b1b;padding:2px 8px;border-radius:12px;font-size:11px;font-weight:600;}
    .cfg-badge-form{display:inline-block;background:#e0e7ff;color:#3730a3;padding:2px 8px;border-radius:12px;font-size:11px;font-weight:600;}
    .cfg-entry-details{display:none;background:#f8fafc;border-top:1px solid #e5e7eb;padding:20px 16px;}
    .cfg-detail-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;}
    .cfg-detail-group{background:#fff;border:1px solid #e5e7eb;border-radius:7px;padding:14px 16px;}
    .cfg-detail-group-title{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#9ca3af;margin-bottom:10px;}
    .cfg-detail-row{display:flex;gap:8px;padding:5px 0;border-bottom:1px solid #f3f4f6;align-items:flex-start;}
    .cfg-detail-row:last-child{border-bottom:none;padding-bottom:0;}
    .cfg-detail-key{font-size:12px;font-weight:600;color:#6b7280;min-width:110px;flex-shrink:0;}
    .cfg-detail-val{font-size:12px;color:#111827;word-break:break-word;}
    .cfg-pagination{display:flex;align-items:center;gap:6px;margin-top:14px;font-size:13px;}
    .cfg-pagination a,.cfg-pagination span{padding:5px 10px;border:1px solid #c3c4c7;border-radius:4px;text-decoration:none;color:#2271b1;background:#fff;}
    .cfg-pagination span.current{background:#2271b1;color:#fff;border-color:#2271b1;}
    .cfg-count-bar{font-size:12px;color:#646970;margin-bottom:10px;}
    .cfg-bulk-bar{display:flex;gap:8px;align-items:center;margin-top:10px;}
    </style>

    <div class="cfg-entries-toolbar">
        <form method="get" action="" style="display:contents;">
            <input type="hidden" name="page" value="<?= esc_attr( CFG_SLUG ) ?>"/>
            <input type="hidden" name="cfg_tab" value="entries"/>
            <input type="text" name="filter_search" value="<?= esc_attr( $filter_search ) ?>" placeholder="Search name, email, phone…"/>
            <select name="filter_type">
                <option value="">All forms</option>
                <option value="contact"  <?= selected( $filter_type, 'contact',  false ) ?>>Contact Form</option>
                <option value="aligner"  <?= selected( $filter_type, 'aligner',  false ) ?>>Aligner Quiz</option>
                <option value="implant"  <?= selected( $filter_type, 'implant',  false ) ?>>Implant Estimator</option>
            </select>
            <select name="filter_status">
                <option value="">All statuses</option>
                <option value="ok"    <?= selected( $filter_status, 'ok',    false ) ?>>GHL OK</option>
                <option value="error" <?= selected( $filter_status, 'error', false ) ?>>GHL Error</option>
            </select>
            <button type="submit" class="button">Filter</button>
            <?php if ( $filter_type || $filter_search || $filter_status ): ?>
            <a href="<?= esc_url( $base_url ) ?>" class="button">Clear</a>
            <?php endif; ?>
        </form>
        <div class="spacer"></div>
        <a href="<?= esc_url( add_query_arg( [ 'cfg_action' => 'export_csv' ], $nonce_url ) ) ?>" class="button">⬇ Export CSV</a>
        <?php if ( $total > 0 ): ?>
        <a href="<?= esc_url( add_query_arg( [ 'cfg_action' => 'clear_all' ], $nonce_url ) ) ?>"
           class="button" style="color:#b91c1c;border-color:#fca5a5;"
           onclick="return confirm('Delete ALL <?= $total ?> entries? This cannot be undone.')">🗑 Clear All</a>
        <?php endif; ?>
    </div>

    <div class="cfg-count-bar">
        Showing <?= $total === 0 ? 0 : $offset + 1 ?>–<?= min( $offset + $per_page, $total ) ?> of <strong><?= $total ?></strong> entries
    </div>

    <form method="post" action="">
    <?php wp_nonce_field( 'cfg_bulk_delete' ); ?>
    <input type="hidden" name="cfg_tab" value="entries"/>

    <table id="cfg-entries-table">
    <thead>
        <tr>
            <th><input type="checkbox" id="cfg-check-all" onclick="document.querySelectorAll('.cfg-entry-chk').forEach(c=>c.checked=this.checked)"/></th>
            <th>Date</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Form</th>
            <th>GHL</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if ( empty( $rows ) ): ?>
        <tr><td colspan="8" style="text-align:center;padding:32px;color:#646970;">No entries yet.</td></tr>
    <?php else: foreach ( $rows as $row ):
        $meta    = json_decode( $row['meta'] ?? '{}', true ) ?: [];
        $form_labels = [ 'contact' => 'Contact Form', 'aligner' => 'Aligner Quiz', 'implant' => 'Implant Estimator' ];
        $form_label  = $form_labels[ $row['form_type'] ] ?? $row['form_type'];
    ?>
        <tr style="cursor:pointer;" onclick="cfgToggleDetail(<?= $row['id'] ?>)">
            <td onclick="event.stopPropagation()"><input type="checkbox" name="entry_ids[]" value="<?= $row['id'] ?>" class="cfg-entry-chk"/></td>
            <td><?= esc_html( date( 'M j, Y g:ia', strtotime( $row['created_at'] ) ) ) ?></td>
            <td><?= esc_html( trim( $row['first_name'] . ' ' . $row['last_name'] ) ) ?></td>
            <td><?= esc_html( $row['email'] ) ?></td>
            <td><?= esc_html( $row['phone'] ) ?></td>
            <td><span class="cfg-badge-form"><?= esc_html( $form_label ) ?></span></td>
            <td><span class="cfg-badge-<?= $row['ghl_status'] === 'ok' ? 'ok' : 'error' ?>"><?= $row['ghl_status'] === 'ok' ? '✓ Sent' : '✗ Error' ?></span></td>
            <td onclick="event.stopPropagation()">
                <a href="<?= esc_url( add_query_arg( [ 'cfg_action' => 'delete', 'entry_id' => $row['id'] ], $nonce_url ) ) ?>"
                   class="button button-small" style="color:#b91c1c;"
                   onclick="return confirm('Delete this entry?')">Delete</a>
            </td>
        </tr>
        <tr id="cfg-detail-<?= $row['id'] ?>"><td colspan="8" style="padding:0;">
            <div class="cfg-entry-details">
            <?php
            // ── Label map ──
            $label_map = [
                // Estimate
                'flow'              => 'Treatment Path',
                'range'             => 'Estimated Range',
                'range_type'        => 'Range Type',
                // Implant single
                'toothLocation'     => 'Tooth Location',
                'timeMissing'       => 'Time Missing',
                'boneGraft'         => 'Bone Graft',
                'situationSingle'   => 'Situation',
                // Implant multiple
                'teethCount'        => 'Tooth Count',
                'teethLocation'     => 'Teeth Location',
                'timeMissingMult'   => 'Time Missing',
                'boneGraftMult'     => 'Bone Graft',
                'situationMult'     => 'Situation',
                // Implant full arch
                'archSelection'     => 'Arch Selection',
                'situationArch'     => 'Situation',
                'archDuration'      => 'Duration',
                // Insurance
                'insurance'         => 'Insurance',
                // Contact form
                'treatment'         => 'Treatment Interest',
                // Aligner answers (dynamic keys)
                // UTM
                'utm_campaign'      => 'UTM Campaign',
                'utm_medium'        => 'UTM Medium',
                'utm_content'       => 'UTM Content',
                'utm_keyword'       => 'UTM Keyword',
                'gclid'             => 'Google Click ID',
            ];
            $utm_keys  = [ 'utm_campaign', 'utm_medium', 'utm_content', 'utm_keyword', 'gclid' ];
            $est_keys  = [ 'flow', 'range', 'range_type' ];
            $quiz_keys = array_diff( array_keys( $meta ), array_merge( $est_keys, $utm_keys ) );

            $det_row = function( $k, $v ) use ( $label_map ) {
                $label = $label_map[ $k ] ?? ucwords( str_replace( '_', ' ', $k ) );
                $val   = is_array( $v ) ? implode( ', ', $v ) : $v;
                if ( $val === '' ) return '';
                return '<div class="cfg-detail-row"><span class="cfg-detail-key">' . esc_html( $label ) . '</span><span class="cfg-detail-val">' . esc_html( $val ) . '</span></div>';
            };
            ?>
            <div class="cfg-detail-grid">

                <!-- Contact Info -->
                <div class="cfg-detail-group">
                    <div class="cfg-detail-group-title">Contact</div>
                    <div class="cfg-detail-row"><span class="cfg-detail-key">Name</span><span class="cfg-detail-val"><?= esc_html( trim( $row['first_name'] . ' ' . $row['last_name'] ) ) ?></span></div>
                    <div class="cfg-detail-row"><span class="cfg-detail-key">Email</span><span class="cfg-detail-val"><a href="mailto:<?= esc_attr( $row['email'] ) ?>" style="color:#2271b1;"><?= esc_html( $row['email'] ) ?></a></span></div>
                    <div class="cfg-detail-row"><span class="cfg-detail-key">Phone</span><span class="cfg-detail-val"><a href="tel:<?= esc_attr( $row['phone'] ) ?>" style="color:#2271b1;"><?= esc_html( $row['phone'] ) ?></a></span></div>
                    <div class="cfg-detail-row"><span class="cfg-detail-key">Submitted</span><span class="cfg-detail-val"><?= esc_html( date( 'M j, Y g:ia', strtotime( $row['created_at'] ) ) ) ?></span></div>
                    <div class="cfg-detail-row"><span class="cfg-detail-key">GHL Status</span><span class="cfg-detail-val"><?= $row['ghl_status'] === 'ok' ? '<span style="color:#16a34a;font-weight:600;">✓ Sent (HTTP ' . ( $meta['_ghl_http_code'] ?? '?' ) . ')</span>' : '<span style="color:#b91c1c;font-weight:600;">✗ Failed (HTTP ' . ( $meta['_ghl_http_code'] ?? '?' ) . ')</span>' ?></span></div>
                    <?php if ( ! empty( $meta['_ghl_response']['contact']['id'] ) ): ?>
                    <div class="cfg-detail-row"><span class="cfg-detail-key">GHL Contact ID</span><span class="cfg-detail-val" style="font-family:monospace;font-size:12px;"><?= esc_html( $meta['_ghl_response']['contact']['id'] ) ?></span></div>
                    <?php endif; ?>
                </div>

                <?php if ( ! empty( $meta['_ghl_fields_sent'] ) ): ?>
                <div class="cfg-detail-group">
                    <div class="cfg-detail-group-title">Custom Fields Sent to GHL</div>
                    <?php foreach ( $meta['_ghl_fields_sent'] as $cf ): ?>
                    <div class="cfg-detail-row">
                        <span class="cfg-detail-key" style="font-family:monospace;font-size:12px;"><?= esc_html( $cf['key'] ) ?></span>
                        <span class="cfg-detail-val"><?= esc_html( $cf['field_value'] ) ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if ( ! empty( array_intersect_key( $meta, array_flip( $est_keys ) ) ) ): ?>
                <!-- Estimate -->
                <div class="cfg-detail-group">
                    <div class="cfg-detail-group-title">Estimate</div>
                    <?php foreach ( $est_keys as $k ): if ( empty( $meta[$k] ) ) continue; echo $det_row( $k, $meta[$k] ); endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if ( ! empty( $quiz_keys ) && array_filter( array_intersect_key( $meta, array_flip( $quiz_keys ) ) ) ): ?>
                <!-- Answers -->
                <div class="cfg-detail-group">
                    <div class="cfg-detail-group-title">Quiz Answers</div>
                    <?php foreach ( $quiz_keys as $k ): if ( empty( $meta[$k] ) ) continue; echo $det_row( $k, $meta[$k] ); endforeach; ?>
                </div>
                <?php endif; ?>

                <?php
                $utm_present = array_filter( array_intersect_key( $meta, array_flip( $utm_keys ) ) );
                if ( ! empty( $utm_present ) ): ?>
                <!-- Traffic Source -->
                <div class="cfg-detail-group">
                    <div class="cfg-detail-group-title">Traffic Source</div>
                    <?php foreach ( $utm_keys as $k ): if ( empty( $meta[$k] ) ) continue; echo $det_row( $k, $meta[$k] ); endforeach; ?>
                </div>
                <?php endif; ?>

            </div>
            </div>
        </td></tr>
    <?php endforeach; endif; ?>
    </tbody>
    </table>

    <div class="cfg-bulk-bar">
        <button type="submit" name="cfg_bulk_delete" class="button" style="color:#b91c1c;" onclick="return document.querySelectorAll('.cfg-entry-chk:checked').length > 0 || (alert('No entries selected.'), false)">Delete Selected</button>
    </div>
    </form>

    <?php if ( $total_pages > 1 ): ?>
    <div class="cfg-pagination">
        <?php for ( $p = 1; $p <= $total_pages; $p++ ): ?>
            <?php if ( $p === $current_page ): ?>
                <span class="current"><?= $p ?></span>
            <?php else: ?>
                <a href="<?= esc_url( add_query_arg( [ 'entries_page' => $p, 'filter_type' => $filter_type, 'filter_search' => $filter_search, 'filter_status' => $filter_status ], $base_url ) ) ?>"><?= $p ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

        </div><!-- /cfg-panel-body -->
    </div><!-- /cfg-entries-wrap -->

    <?php
    // ── Analytics panel ──
    $an_table = $wpdb->prefix . 'cfg_entries';

    // Last 30 days daily counts
    $daily = $wpdb->get_results(
        "SELECT DATE(created_at) AS day, COUNT(*) AS cnt
         FROM {$an_table}
         WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 29 DAY)
         GROUP BY DATE(created_at)
         ORDER BY day ASC",
        ARRAY_A
    );
    // Fill in zero days
    $daily_map = [];
    foreach ( $daily as $row ) $daily_map[ $row['day'] ] = (int) $row['cnt'];
    $daily_filled = [];
    for ( $i = 29; $i >= 0; $i-- ) {
        $d = date( 'Y-m-d', strtotime( "-{$i} days" ) );
        $daily_filled[] = [ 'day' => date( 'M j', strtotime( $d ) ), 'cnt' => $daily_map[ $d ] ?? 0 ];
    }
    $max_daily = max( 1, max( array_column( $daily_filled, 'cnt' ) ) );

    // Source breakdown
    $all_meta = $wpdb->get_col( "SELECT meta FROM {$an_table} WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)" );
    $src = [ 'Google Ads' => 0, 'UTM Campaign' => 0, 'Direct / Organic' => 0 ];
    foreach ( $all_meta as $m ) {
        $d = json_decode( $m, true ) ?: [];
        if ( ! empty( $d['gclid'] ) )          $src['Google Ads']++;
        elseif ( ! empty( $d['utm_campaign'] ) ) $src['UTM Campaign']++;
        else                                     $src['Direct / Organic']++;
    }
    $src_total = max( 1, array_sum( $src ) );

    // Form type breakdown
    $by_form = $wpdb->get_results(
        "SELECT form_type, COUNT(*) AS cnt FROM {$an_table} WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY form_type",
        ARRAY_A
    );
    $form_map = [];
    foreach ( $by_form as $r ) $form_map[ $r['form_type'] ] = (int) $r['cnt'];
    $form_labels_all = [ 'contact' => 'Contact Form', 'aligner' => 'Aligner Quiz', 'implant' => 'Implant Estimator' ];

    // GHL success rate
    $total_30   = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$an_table} WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)" );
    $errors_30  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$an_table} WHERE ghl_status='error' AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)" );
    $success_30 = $total_30 - $errors_30;
    $success_pct = $total_30 > 0 ? round( $success_30 / $total_30 * 100 ) : 100;
    ?>

    <div id="cfg-analytics-wrap" style="display:none;background:#fff;border:1px solid #e2e4e9;border-left:none;border-radius:0 10px 10px 0;min-height:580px;overflow:hidden;">
        <div class="cfg-panel-hdr"><h2>Analytics</h2><p>Conversion stats and source breakdown for all forms.</p></div>
        <div class="cfg-panel-body">
    <style>
    .cfg-an-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;}
    .cfg-an-card{background:#fff;border:1px solid #c3c4c7;border-radius:6px;padding:20px 24px;}
    .cfg-an-card h3{margin:0 0 16px;font-size:13px;font-weight:700;color:#1d2327;text-transform:uppercase;letter-spacing:.05em;}
    .cfg-bar-chart{display:flex;align-items:flex-end;gap:3px;height:100px;margin-bottom:6px;}
    .cfg-bar-col{flex:1;display:flex;flex-direction:column;align-items:center;gap:3px;}
    .cfg-bar{width:100%;background:#2271b1;border-radius:2px 2px 0 0;min-height:2px;transition:opacity .15s;}
    .cfg-bar:hover{opacity:.75;}
    .cfg-bar-label{font-size:9px;color:#9ca3af;white-space:nowrap;overflow:hidden;text-overflow:clip;}
    .cfg-src-row{display:flex;align-items:center;gap:10px;margin-bottom:10px;}
    .cfg-src-bar-bg{flex:1;background:#f3f4f6;border-radius:4px;height:8px;overflow:hidden;}
    .cfg-src-bar-fill{height:100%;border-radius:4px;background:#2271b1;}
    .cfg-src-label{font-size:13px;color:#374151;width:140px;flex-shrink:0;}
    .cfg-src-count{font-size:12px;color:#6b7280;width:32px;text-align:right;flex-shrink:0;}
    .cfg-stat-row{display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid #f3f4f6;}
    .cfg-stat-row:last-child{border-bottom:none;}
    .cfg-an-full{grid-column:span 2;}
    </style>

    <p style="font-size:12px;color:#6b7280;margin:14px 0 16px;">All stats are for the last 30 days.</p>

    <div class="cfg-an-grid">

        <!-- Submissions chart -->
        <div class="cfg-an-card cfg-an-full">
            <h3>Daily Submissions — Last 30 Days</h3>
            <div class="cfg-bar-chart">
            <?php foreach ( $daily_filled as $d ): ?>
                <div class="cfg-bar-col" title="<?= esc_attr( $d['day'] ) ?>: <?= $d['cnt'] ?> submission<?= $d['cnt'] !== 1 ? 's' : '' ?>">
                    <div class="cfg-bar" style="height:<?= $d['cnt'] > 0 ? round( $d['cnt'] / $max_daily * 100 ) : 2 ?>%;background:<?= $d['cnt'] > 0 ? '#2271b1' : '#e5e7eb' ?>;"></div>
                </div>
            <?php endforeach; ?>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:10px;color:#9ca3af;margin-top:4px;">
                <span><?= esc_html( $daily_filled[0]['day'] ) ?></span>
                <span><?= esc_html( $daily_filled[14]['day'] ) ?></span>
                <span><?= esc_html( $daily_filled[29]['day'] ) ?></span>
            </div>
        </div>

        <!-- Traffic source breakdown -->
        <div class="cfg-an-card">
            <h3>Traffic Source</h3>
            <?php foreach ( $src as $label => $count ):
                $colors = [ 'Google Ads' => '#4285f4', 'UTM Campaign' => '#f59e0b', 'Direct / Organic' => '#10b981' ];
                $pct = round( $count / $src_total * 100 );
            ?>
            <div class="cfg-src-row">
                <span class="cfg-src-label"><?= esc_html( $label ) ?></span>
                <div class="cfg-src-bar-bg">
                    <div class="cfg-src-bar-fill" style="width:<?= $pct ?>%;background:<?= $colors[$label] ?>;"></div>
                </div>
                <span class="cfg-src-count"><?= $count ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Form type breakdown -->
        <div class="cfg-an-card">
            <h3>By Form</h3>
            <?php foreach ( $form_labels_all as $key => $label ):
                $cnt = $form_map[ $key ] ?? 0;
                $pct = $total_30 > 0 ? round( $cnt / $total_30 * 100 ) : 0;
                $fc  = [ 'contact' => '#2271b1', 'aligner' => '#7c3aed', 'implant' => '#0891b2' ];
            ?>
            <div class="cfg-src-row">
                <span class="cfg-src-label"><?= esc_html( $label ) ?></span>
                <div class="cfg-src-bar-bg">
                    <div class="cfg-src-bar-fill" style="width:<?= $pct ?>%;background:<?= $fc[$key] ?>;"></div>
                </div>
                <span class="cfg-src-count"><?= $cnt ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- GHL status -->
        <div class="cfg-an-card">
            <h3>GHL Send Rate (30 days)</h3>
            <div style="display:flex;align-items:center;gap:20px;margin-bottom:16px;">
                <div style="position:relative;width:80px;height:80px;flex-shrink:0;">
                    <svg viewBox="0 0 36 36" style="width:80px;height:80px;transform:rotate(-90deg)">
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#f3f4f6" stroke-width="3.5"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="<?= $success_pct >= 90 ? '#16a34a' : ($success_pct >= 70 ? '#f59e0b' : '#dc2626') ?>" stroke-width="3.5"
                            stroke-dasharray="<?= round( $success_pct * 100 / 100 ) ?> 100" stroke-linecap="round"/>
                    </svg>
                    <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:#1d2327;"><?= $success_pct ?>%</div>
                </div>
                <div>
                    <div style="font-size:13px;color:#374151;margin-bottom:4px;">✓ <strong><?= $success_30 ?></strong> sent successfully</div>
                    <div style="font-size:13px;color:#b91c1c;">✗ <strong><?= $errors_30 ?></strong> failed</div>
                </div>
            </div>
            <?php if ( $errors_30 > 0 ): ?>
            <a href="<?= esc_url( admin_url( 'admin.php?page=' . CFG_SLUG . '&cfg_tab=entries&filter_status=error' ) ) ?>" style="font-size:12px;color:#b91c1c;">View failed entries →</a>
            <?php else: ?>
            <p style="font-size:12px;color:#16a34a;margin:0;">All submissions reached GHL successfully.</p>
            <?php endif; ?>
        </div>

        <!-- Summary stats -->
        <div class="cfg-an-card">
            <h3>Quick Stats</h3>
            <?php
            $today_cnt = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$an_table} WHERE DATE(created_at) = CURDATE()" );
            $week_cnt  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$an_table} WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)" );
            $all_time  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$an_table}" );
            ?>
            <div class="cfg-stat-row"><span style="font-size:13px;color:#374151;">Today</span><strong><?= $today_cnt ?></strong></div>
            <div class="cfg-stat-row"><span style="font-size:13px;color:#374151;">This week</span><strong><?= $week_cnt ?></strong></div>
            <div class="cfg-stat-row"><span style="font-size:13px;color:#374151;">Last 30 days</span><strong><?= $total_30 ?></strong></div>
            <div class="cfg-stat-row"><span style="font-size:13px;color:#374151;">All time</span><strong><?= $all_time ?></strong></div>
        </div>

    </div><!-- /cfg-an-grid -->
        </div><!-- /cfg-panel-body -->
    </div><!-- /cfg-analytics-wrap -->
    </div><!-- /cfg-main -->
    </div><!-- /cfg-root -->

    <script>
    function cfgToggleDetail(id) {
        var row = document.getElementById('cfg-detail-' + id);
        if (!row) return;
        var detail = row.querySelector('.cfg-entry-details');
        if (detail) detail.style.display = detail.style.display === 'block' ? 'none' : 'block';
    }
    (function() {
        var params = new URLSearchParams(window.location.search);
        var activeTab = params.get('cfg_tab');
        if (activeTab) {
            var tab = document.querySelector('.cfg-nav-item[onclick*="cfgTab(this,\'' + activeTab + '\')"]');
            if (tab) tab.click();
        }
    })();
    </script>

    <script>
    /* ── Sidebar group toggle ── */
    function cfgToggleGroup(grp) {
        var hdr  = document.querySelector('#cfg-grp-' + grp + ' .cfg-nav-group-hdr');
        var body = document.getElementById('cfg-grpb-' + grp);
        if (!hdr || !body) return;
        var isOpen = hdr.classList.contains('open');
        if (isOpen) {
            hdr.classList.remove('open');
            body.style.maxHeight = '0';
        } else {
            hdr.classList.add('open');
            body.style.maxHeight = body.scrollHeight + 'px';
        }
    }
    function cfgOpenGroup(grp) {
        var hdr  = document.querySelector('#cfg-grp-' + grp + ' .cfg-nav-group-hdr');
        var body = document.getElementById('cfg-grpb-' + grp);
        if (!hdr || !body || hdr.classList.contains('open')) return;
        hdr.classList.add('open');
        body.style.maxHeight = body.scrollHeight + 'px';
    }

    /* ── Tab navigation ── */
    function cfgTab(el, id) {
        document.querySelectorAll('.cfg-nav-item').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.cfg-panel').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        // Auto-expand parent group if item is inside one
        var grp = el.getAttribute('data-group');
        if (grp) cfgOpenGroup(grp);
        var isOuter = (id === 'entries' || id === 'analytics');
        var saveBar      = document.getElementById('cfg-save-bar');
        var entriesWrap  = document.getElementById('cfg-entries-wrap');
        var analyticsWrap= document.getElementById('cfg-analytics-wrap');
        if (saveBar)       saveBar.style.display       = isOuter ? 'none' : '';
        if (entriesWrap)   entriesWrap.style.display   = id === 'entries'   ? 'block' : 'none';
        if (analyticsWrap) analyticsWrap.style.display = id === 'analytics' ? 'block' : 'none';
        if (!isOuter) document.getElementById('cfg-' + id).classList.add('active');
        try {
            var u = new URL(window.location.href);
            u.searchParams.set('cfg_tab', id);
            history.replaceState(null, '', u.toString());
        } catch(e) {}
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
                            <input id="cfg_phone" name="phone" type="tel" <?= $s['req_phone'] === '1' ? 'required' : '' ?> placeholder="Phone number" style="<?= $input_style ?>"/>
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
                utm_term:     _up.get('utm_term')     || '',
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
                        <input id="cfge_phone" name="phone" type="tel" <?= $s['req_phone'] === '1' ? 'required' : '' ?> placeholder="Phone number" style="<?= $input_style ?>"/>
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
                utm_term:     _up.get('utm_term')     || '',
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
    $custom_fields[] = [ 'key' => 'automation_tester', 'field_value' => 'contact_form_ok' ];
    if ( ! empty( $treatment ) ) {
        $custom_fields[] = [ 'key' => 'treatment_type', 'field_value' => $treatment ];
    }
    $utm_key_map      = get_option( 'cfg_utm_key_map_' . md5( $s['ghl_location_id'] ), [] );
    $utm_display_keys = [ 'utm_campaign' => 'UTMCampaign_custom', 'utm_medium' => 'UTMMedium_custom',
                          'utm_content'  => 'UTMContent_custom',  'utm_keyword' => 'UTMKeyword_custom',
                          'utm_term'     => 'UTMTerm_custom',      'gclid'       => 'GCLID_custom' ];
    foreach ( $utm_display_keys as $post_key => $fallback_key ) {
        $val     = sanitize_text_field( $_POST[ $post_key ] ?? '' );
        $ghl_key = $utm_key_map[ $post_key ] ?? $fallback_key;
        $ghl_key = preg_replace( '/^contact\./', '', $ghl_key ); // strip contact. prefix — GHL payload uses bare key
        if ( $val !== '' ) $custom_fields[] = [ 'key' => $ghl_key, 'field_value' => $val ];
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

    $ghl_ok = ( $code === 200 || $code === 201 );
    $entry_meta = array_filter( [
        'treatment'    => $treatment,
        'utm_campaign' => sanitize_text_field( $_POST['utm_campaign'] ?? '' ),
        'utm_medium'   => sanitize_text_field( $_POST['utm_medium']   ?? '' ),
        'utm_content'  => sanitize_text_field( $_POST['utm_content']  ?? '' ),
        'utm_keyword'  => sanitize_text_field( $_POST['utm_keyword']  ?? '' ),
        'utm_term'     => sanitize_text_field( $_POST['utm_term']     ?? '' ),
        'gclid'        => sanitize_text_field( $_POST['gclid']        ?? '' ),
    ] );
    $entry_meta['_ghl_fields_sent'] = $custom_fields;
    $entry_meta['_ghl_http_code']   = $code;
    $entry_meta['_ghl_response']    = $body;
    error_log( '[CFG Contact] sent customFields: ' . wp_json_encode( $custom_fields ) );
    error_log( '[CFG Contact] GHL HTTP ' . $code . ': ' . wp_json_encode( $body ) );
    cfg_log_entry( 'contact', $first, $last, $email, $phone, $entry_meta, $ghl_ok ? 'ok' : 'error' );

    if ( $ghl_ok ) {
        wp_send_json_success( 'Contact created.' );
    } else {
        $msg = $body['message'] ?? ( 'Unexpected error (HTTP ' . $code . ').' );
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
                        echo '<div><label style="display:block;margin-bottom:0.4rem;font-size:0.83rem;font-weight:600;color:#374151;">Phone <span style="color:' . $accent . '">*</span></label><input type="tel" name="phone" required placeholder="Phone number" class="' . $uid . '-input"/></div>';
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
            ['utm_campaign','utm_medium','utm_content','utm_keyword','utm_term','gclid'].forEach(function(k){ _fd.append(k,_up.get(k)||''); });
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
    $tags = [ 'aligner-quiz', 'website-lead', 'website-invisalign-form' ];
    foreach ( $answers as $key => $val ) {
        $tags[] = sanitize_title( $key . '-' . $val );
    }

    // Custom fields
    $custom = [];
    $custom[] = [ 'key' => 'treatment_type', 'field_value' => 'Invisalign' ];
    foreach ( $answers as $key => $val ) {
        $custom[] = [ 'key' => sanitize_key( $key ), 'field_value' => sanitize_text_field( $val ) ];
    }
    $utm_key_map      = get_option( 'cfg_utm_key_map_' . md5( $s['ghl_location_id'] ), [] );
    $utm_display_keys = [ 'utm_campaign' => 'UTMCampaign_custom', 'utm_medium' => 'UTMMedium_custom',
                          'utm_content'  => 'UTMContent_custom',  'utm_keyword' => 'UTMKeyword_custom',
                          'utm_term'     => 'UTMTerm_custom',      'gclid'       => 'GCLID_custom' ];
    foreach ( $utm_display_keys as $post_key => $fallback_key ) {
        $val     = sanitize_text_field( $_POST[ $post_key ] ?? '' );
        $ghl_key = $utm_key_map[ $post_key ] ?? $fallback_key;
        $ghl_key = preg_replace( '/^contact\./', '', $ghl_key );
        if ( $val !== '' ) $custom[] = [ 'key' => $ghl_key, 'field_value' => $val ];
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

    $ghl_ok = ( $code === 200 || $code === 201 );
    $entry_meta = array_filter( array_merge( $answers, [
        'utm_campaign' => sanitize_text_field( $_POST['utm_campaign'] ?? '' ),
        'utm_medium'   => sanitize_text_field( $_POST['utm_medium']   ?? '' ),
        'utm_content'  => sanitize_text_field( $_POST['utm_content']  ?? '' ),
        'utm_keyword'  => sanitize_text_field( $_POST['utm_keyword']  ?? '' ),
        'utm_term'     => sanitize_text_field( $_POST['utm_term']     ?? '' ),
        'gclid'        => sanitize_text_field( $_POST['gclid']        ?? '' ),
    ] ) );
    $entry_meta['_ghl_fields_sent'] = $custom;
    $entry_meta['_ghl_http_code']   = $code;
    $entry_meta['_ghl_response']    = $body;
    error_log( '[CFG Aligner] sent customFields: ' . wp_json_encode( $custom ) );
    error_log( '[CFG Aligner] GHL HTTP ' . $code . ': ' . wp_json_encode( $body ) );
    cfg_log_entry( 'aligner', $first, $last, $email, $phone, $entry_meta, $ghl_ok ? 'ok' : 'error' );

    if ( $ghl_ok ) {
        wp_send_json_success( 'Contact created.' );
    } else {
        $msg = $body['message'] ?? ( 'Unexpected error (HTTP ' . $code . ').' );
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
     .'<div id="'.esc_attr($uid).'-range-wrap" style="filter:blur(8px);transition:filter 0.5s ease;user-select:none;">'
     .'<p id="'.esc_attr($uid).'-sidebar-range" class="imp-sr-'.esc_attr($uid).'" style="font-family:\'Cormorant Garamond\',serif;font-weight:700;font-size:1.5rem;line-height:1;color:hsl(var(--foreground));display:none;">—</p>'
     .'<p id="'.esc_attr($uid).'-sidebar-range-suffix" class="imp-sr-sfx-'.esc_attr($uid).'" style="font-family:Inter,sans-serif;font-size:.72rem;color:hsl(var(--muted-foreground));margin-top:.25rem;display:none;"></p>'
     .'<p id="'.esc_attr($uid).'-sidebar-range-placeholder" style="font-family:Inter,sans-serif;font-size:.8rem;color:hsl(var(--muted-foreground)/.5);">Answer the questions to see your range</p>'
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
#<?= $uid ?>-app .imp-cta-btn-outline{display:inline-flex;align-items:center;gap:.625rem;padding:1.1rem 2.25rem;background:transparent;color:hsl(var(--foreground));border-radius:.5rem;font-family:Inter,sans-serif;font-size:1rem;font-weight:500;letter-spacing:.02em;border:1.5px solid hsl(var(--border));cursor:pointer;transition:border-color .2s,background .2s,transform .15s;text-decoration:none;}
#<?= $uid ?>-app .imp-cta-btn-outline:hover{border-color:hsl(var(--primary)/.5);background:hsl(var(--accent)/.5);transform:translateY(-1px);}
#<?= $uid ?>-app .imp-cta-btn-outline:active{transform:translateY(0);}
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
/* Text question type */
#<?= $uid ?>-app .die-text-q-wrap{display:flex;flex-direction:column;gap:12px;padding:4px 0;}
#<?= $uid ?>-app .die-text-input{width:100%;padding:12px 16px;border:1px solid hsl(var(--border));border-radius:8px;font-size:1rem;font-family:inherit;box-sizing:border-box;}
#<?= $uid ?>-app .die-next-btn{align-self:flex-start;padding:12px 28px;background:hsl(var(--primary));color:#fff;border:none;border-radius:8px;font-size:0.9rem;font-weight:600;cursor:pointer;}
#<?= $uid ?>-app .die-next-btn:hover{opacity:.9;}
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
            <?php if ( ! empty( $s['imp_intro_btn_url'] ) ): ?>
            <a href="<?= esc_url( $s['imp_intro_btn_url'] ) ?>" class="imp-cta-btn" style="text-decoration:none;display:inline-flex;align-items:center;gap:.5rem;">
              <?= esc_html( $s['imp_intro_btn'] ) ?>
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
            <?php else: ?>
            <button onclick="<?= $uid ?>Nav('router')" class="imp-cta-btn">
              <?= esc_html( $s['imp_intro_btn'] ) ?>
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
            <?php endif; ?>
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

<?php
// ── Decode path configs ──
$single_qs        = json_decode( $s['imp_single_qs'],   true ) ?: [];
$multi_qs         = json_decode( $s['imp_multi_qs'],    true ) ?: [];
$arch_qs          = json_decode( $s['imp_arch_qs'],     true ) ?: [];
$ins_q            = json_decode( $s['imp_ins_q'],       true ) ?: null;
$router_opts_data = json_decode( $s['imp_router_opts'], true ) ?: [];

// ── Router ──
$router_html = '';
foreach ( $router_opts_data as $ro ) {
    $route_path = $ro['val']; // 'single','multiple','fullarch'
    if ( $route_path === 'fullarch' && ! $show_arch ) continue;
    // find the first question id of that path
    $path_qs   = $route_path === 'multiple' ? $multi_qs : ( $route_path === 'fullarch' ? $arch_qs : $single_qs );
    $first_id  = ! empty( $path_qs ) ? $path_qs[0]['id'] : 'summary';
    $router_html .= $opt( 'router', $ro['val'], $ro['label'], $first_id, $ro['sub'] ?? '' );
}
echo $qpanel( 'router', $s['imp_router_title'], $s['imp_router_sub'], $router_html );

// ── Render a path ──
$render_path = function( $qs, $path_end_next ) use ( $opt, $qpanel ) {
    foreach ( $qs as $i => $q ) {
        $next    = isset( $qs[ $i + 1 ] ) ? $qs[ $i + 1 ]['id'] : $path_end_next;
        $type    = $q['type'] ?? 'radio';
        $sub     = $q['subtitle'] ?? '';
        if ( $type === 'radio' || $type === 'dropdown' ) {
            $opts_html = '';
            foreach ( $q['opts'] ?? [] as $o ) {
                $opts_html .= $opt( $q['field'], $o['val'], $o['label'], $next, $o['sub'] ?? '' );
            }
            echo $qpanel( $q['id'], $q['title'], $sub, $opts_html );
        } elseif ( $type === 'text' || $type === 'textarea' ) {
            echo $qpanel( $q['id'], $q['title'], $sub,
                '<div class="die-text-q-wrap">'
                . ( $type === 'textarea'
                    ? '<textarea id="' . esc_attr($q['id']) . '-txt" rows="3" class="die-text-input" onchange="window[uid+\'Sel\'](this,\'' . esc_js($q['field']) . '\',this.value,this.value,\'' . esc_js($next) . '\')"></textarea>'
                    : '<input type="text" id="' . esc_attr($q['id']) . '-txt" class="die-text-input" placeholder="Type your answer..." />'
                  )
                . ( $type === 'text'
                    ? '<button class="die-next-btn" onclick="var el=document.getElementById(\'' . esc_attr($q['id']) . '-txt\');window[uid+\'Sel\'](this,\'' . esc_js($q['field']) . '\',el.value,el.value,\'' . esc_js($next) . '\')">Continue &#x2192;</button>'
                    : '<button class="die-next-btn" onclick="var el=document.getElementById(\'' . esc_attr($q['id']) . '-txt\');window[uid+\'Sel\'](this,\'' . esc_js($q['field']) . '\',el.value,el.value,\'' . esc_js($next) . '\')">Continue &#x2192;</button>'
                  )
                . '</div>'
            );
        }
    }
};

// ── Single-tooth path ──
$render_path( $single_qs, $ins_next );

// ── Multiple-teeth path ──
$render_path( $multi_qs, $ins_next );

// ── Full-arch path ──
$render_path( $arch_qs, 'summary' );

// ── Insurance ──
if ( $show_insurance && $ins_q ) {
    $ins_opts_html = '';
    foreach ( $ins_q['opts'] ?? [] as $o ) {
        $ins_opts_html .= $opt( $ins_q['field'], $o['val'], $o['label'], 'summary', $o['sub'] ?? '' );
    }
    echo $qpanel( $ins_q['id'], $ins_q['title'], $ins_q['subtitle'] ?? '', $ins_opts_html );
}
?>

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
                <input type="tel" id="<?= $uid ?>-phone" class="imp-input" placeholder="Phone number" autocomplete="tel" required>
              </div>
              <button type="submit" id="<?= $uid ?>-reveal-btn" disabled
                style="display:inline-flex;justify-content:center;align-items:center;gap:.5rem;background:hsl(var(--primary));color:hsl(var(--primary-foreground));padding:1rem 2rem;border-radius:.5rem;width:100%;font-family:Inter,sans-serif;font-weight:500;font-size:1rem;letter-spacing:.025em;border:none;cursor:not-allowed;opacity:.6;margin-top:4px;transition:box-shadow .2s;">
                <?= esc_html( $s['imp_contact_btn'] ) ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
              </button>
            </form>
            <?php if ( $s['imp_contact_btn2_enabled'] === '1' && ! empty( $s['imp_contact_btn2_url'] ) ): ?>
            <div style="text-align:center;margin-top:1rem;">
              <a href="<?= esc_url( $s['imp_contact_btn2_url'] ) ?>"
                 style="display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.75rem;background:transparent;color:hsl(var(--foreground));border:1.5px solid hsl(var(--border));border-radius:.5rem;font-family:Inter,sans-serif;font-size:.9rem;font-weight:500;text-decoration:none;transition:border-color .2s,background .2s;">
                <?= esc_html( $s['imp_contact_btn2_label'] ) ?>
              </a>
            </div>
            <?php endif; ?>
            <p style="margin-top:1rem;font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.5);font-size:.75rem;text-align:center;">Your information is kept private and never sold.</p>
          </div>
        </div>
        <?= $sidebar ?>
      </div>
    </div>
  </main>
</div>

<?php
// ── Helper: check-item row ──
$rci = function( $label ) {
    return '<div style="display:flex;align-items:center;gap:.5rem;">'
         . '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));flex-shrink:0;"><polyline points="20 6 9 13 4 10"/></svg>'
         . '<span style="font-family:Inter,sans-serif;color:hsl(var(--foreground));font-size:.875rem;">' . esc_html($label) . '</span>'
         . '</div>';
};

// ── Configurable includes per flow ──
$single_includes_raw = json_decode( $s['imp_single_includes']  ?? '[]', true ) ?: [];
$arch_includes_raw   = json_decode( $s['imp_fullarch_includes'] ?? '[]', true ) ?: [];
$single_includes_html = '';
foreach ( $single_includes_raw as $inc ) {
    if ( ! empty( $inc['enabled'] ) ) $single_includes_html .= $rci( $inc['label'] );
}
$arch_includes_html = '';
foreach ( $arch_includes_raw as $inc ) {
    if ( ! empty( $inc['enabled'] ) ) $arch_includes_html .= $rci( $inc['label'] );
}

// ── Bone graft note (text varies by display mode) ──
$graft_display = $s['imp_graft_display'] ?? 'addon';
$g_min = esc_html($currency) . esc_html( number_format( (int)($s['imp_graft_min'] ?? 650) ) );
$g_max = esc_html($currency) . esc_html( number_format( (int)($s['imp_graft_max'] ?? 1100) ) );
if ( $graft_display === 'included' ) {
    $graft_note_inner = '';
} elseif ( $graft_display === 'mention' ) {
    $graft_note_inner = '<strong>Bone grafting may be required.</strong> If so, an additional fee of approximately <strong>' . $g_min . ' &ndash; ' . $g_max . ' per area</strong> may apply &mdash; confirmed after your clinical exam.';
} else {
    $graft_note_inner = '<strong>Bone grafting, if required, is a separate additional procedure.</strong> Estimated cost: <strong>' . $g_min . ' &ndash; ' . $g_max . ' per area</strong>. Whether it is needed is confirmed after your clinical exam.';
}

// ── Result info sections (3 info boxes below price card) ──
$result_sections      = json_decode( $s['imp_result_sections'] ?? '[]', true ) ?: [];
$result_sections_html = '';
foreach ( $result_sections as $sec ) {
    $result_sections_html .= '<div style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;padding:1.25rem 1.5rem;box-shadow:0 1px 3px rgba(0,0,0,.06);margin-bottom:1rem;">';
    $result_sections_html .= '<p style="font-family:Inter,sans-serif;font-weight:600;color:hsl(var(--foreground));font-size:.9375rem;margin-bottom:.875rem;display:flex;align-items:center;gap:.5rem;"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><circle cx="12" cy="16" r=".5" fill="currentColor"/></svg>' . esc_html( $sec['title'] ) . '</p>';
    $result_sections_html .= '<div style="display:flex;flex-direction:column;gap:.5rem;">';
    foreach ( ( $sec['items'] ?? [] ) as $item ) {
        $result_sections_html .= '<div style="display:flex;align-items:flex-start;gap:.5rem;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--muted-foreground)/.5);flex-shrink:0;margin-top:2px;"><circle cx="12" cy="12" r="10"/></svg><span style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.875rem;line-height:1.5;">' . esc_html( $item ) . '</span></div>';
    }
    $result_sections_html .= '</div></div>';
}

// ── CTA buttons (dual: Book + optional Call) ──
$cal_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>';
$ph_svg  = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>';
$show_book = ( $s['imp_cta_book_enabled'] ?? '1' ) === '1';
$show_call = ( $s['imp_cta_call_enabled'] ?? '0' ) === '1' && ! empty( $s['imp_cta_phone'] );
$book_href = ! empty( $s['imp_cta_book_url'] ) ? esc_url( $s['imp_cta_book_url'] ) : ( ! empty( $s['imp_success_url'] ) ? esc_url( $s['imp_success_url'] ) : ( ! empty( $s['success_redirect_url'] ) ? esc_url( $s['success_redirect_url'] ) : '#' ) );
$phone_clean = esc_attr( preg_replace('/[^0-9+\-\(\)\s]/', '', $s['imp_cta_phone'] ?? '' ) );
$cta_buttons = '';
if ( $show_book || $show_call ) {
    $cta_buttons = '<div style="display:flex;gap:.75rem;flex-wrap:wrap;justify-content:center;padding-top:1.25rem;">';
    if ( $show_book ) {
        $cta_buttons .= '<a href="' . $book_href . '" class="imp-cta-btn" style="text-decoration:none;">' . $cal_svg . ' ' . esc_html( $s['imp_cta_book_label'] ) . '</a>';
    }
    if ( $show_call ) {
        $cta_buttons .= '<a href="tel:' . $phone_clean . '" class="imp-cta-btn-outline">' . $ph_svg . ' ' . esc_html( $s['imp_cta_call_label'] ) . '</a>';
    }
    $cta_buttons .= '</div>';
}

$fin_block = ( $show_fin && ! empty( $s['imp_financing_text'] ) )
    ? '<div style="display:flex;align-items:flex-start;gap:.75rem;background:hsl(var(--accent)/.4);padding:1rem 1.25rem;border:1px solid hsl(var(--border));border-radius:.75rem;margin-bottom:1rem;">'
      . '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));flex-shrink:0;margin-top:1px;"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>'
      . '<p style="font-family:Inter,sans-serif;color:hsl(var(--foreground)/.8);font-size:.875rem;">' . esc_html( $s['imp_financing_text'] ) . '</p>'
      . '</div>'
    : '';
$disc_block = ! empty( $s['imp_disclaimer'] )
    ? '<div style="margin-bottom:1.5rem;text-align:center;"><p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.7);font-size:.75rem;line-height:1.65;">' . esc_html( $s['imp_disclaimer'] ) . '</p></div>'
    : '';
$np_href = ! empty( $s['imp_success_url'] ) ? esc_url( $s['imp_success_url'] ) : '';
$no_price_card = '<div style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;padding:2.5rem 2rem;box-shadow:0 1px 3px rgba(0,0,0,.06);text-align:center;margin-bottom:1.5rem;">'
    . '<div style="width:3.5rem;height:3.5rem;border-radius:9999px;background:hsl(var(--primary)/.1);display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>'
    . '<h2 style="font-family:\'Cormorant Garamond\',serif;font-weight:600;color:hsl(var(--foreground));font-size:clamp(1.5rem,4vw,2rem);line-height:1.25;margin:0 0 1rem;">' . esc_html($no_price_title) . '</h2>'
    . '<p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.9375rem;line-height:1.65;margin:0 auto 2rem;max-width:26rem;">' . esc_html($no_price_sub) . '</p>'
    . ( $np_href
        ? '<a href="' . $np_href . '" class="imp-cta-btn" style="text-decoration:none;margin:0 auto;">' . esc_html($no_price_btn) . '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></a>'
        : '<button type="button" class="imp-cta-btn" style="margin:0 auto;" onclick="window[\'' . esc_js($uid) . 'Nav\'](\'lead\')">' . esc_html($no_price_btn) . '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></button>'
      )
    . '</div>';
?>

<?php
$_badge = function($txt) use ($uid) {
    return '<div style="display:flex;justify-content:center;margin-bottom:1.5rem;"><div style="display:inline-flex;align-items:center;gap:.375rem;background:hsl(var(--accent)/.6);padding:.375rem 1rem;border:1px solid hsl(var(--border));border-radius:9999px;font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.75rem;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:hsl(var(--primary));"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>' . esc_html($txt) . '</div></div>';
};
?>

<!-- RESULT: SINGLE -->
<div class="die-panel" id="<?= $uid ?>-panel-result-single">
  <main style="display:flex;flex-direction:column;flex:1;">
    <div style="flex:1;margin:0 auto;padding:1.5rem 1rem 2rem;width:100%;max-width:48rem;box-sizing:border-box;">
      <?= $_badge('Your Estimate Is Ready') ?>
      <?php if ( $show_price ): ?>
      <div style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;padding:2rem 2rem 2rem;box-shadow:0 1px 3px rgba(0,0,0,.06);text-align:center;margin-bottom:1rem;">
        <p id="<?= $uid ?>-result-single-label" style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.8125rem;font-weight:500;margin-bottom:.5rem;"><?= esc_html( $s['imp_result_title'] ) ?></p>
        <p id="<?= $uid ?>-result-single-range" style="font-family:'Cormorant Garamond',serif;font-weight:700;color:hsl(var(--foreground));font-size:clamp(2rem,8vw,3.25rem);line-height:1;margin-bottom:.375rem;">Calculating&hellip;</p>
        <p style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.7);font-size:.875rem;margin-bottom:<?= $single_includes_html ? '1.5rem' : '.5rem' ?>;"><?= esc_html( $s['imp_result_subtitle'] ) ?></p>
        <?php if ( $single_includes_html ): ?>
        <div style="display:flex;flex-direction:column;gap:.5rem;max-width:20rem;margin:0 auto;text-align:left;">
          <p style="font-family:Inter,sans-serif;font-weight:600;color:hsl(var(--foreground));font-size:.8125rem;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.25rem;">Included in your estimate</p>
          <?= $single_includes_html ?>
        </div>
        <?php endif; ?>
        <?php if ( $graft_note_inner ): ?>
        <div id="<?= $uid ?>-graft-note-single" style="display:none;background:hsl(var(--accent)/.5);padding:.875rem 1rem;border:1px solid hsl(var(--border));border-radius:.75rem;text-align:left;margin-top:1.25rem;">
          <p style="font-family:Inter,sans-serif;color:hsl(var(--foreground)/.8);font-size:.875rem;line-height:1.6;"><?= $graft_note_inner ?></p>
        </div>
        <?php endif; ?>
      </div>
      <?= $result_sections_html ?>
      <?= $fin_block ?>
      <?= $disc_block ?>
      <?= $cta_buttons ?>
      <?php else: ?>
      <?= $no_price_card ?>
      <?= $disc_block ?>
      <?php endif; ?>
    </div>
  </main>
</div>

<!-- RESULT: MULTIPLE -->
<div class="die-panel" id="<?= $uid ?>-panel-result-multiple">
  <main style="display:flex;flex-direction:column;flex:1;">
    <div style="flex:1;margin:0 auto;padding:1.5rem 1rem 2rem;width:100%;max-width:48rem;box-sizing:border-box;">
      <?= $_badge('Your Estimate Is Ready') ?>
      <?php if ( $show_price ): ?>
      <div style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;padding:2rem 2rem 2rem;box-shadow:0 1px 3px rgba(0,0,0,.06);text-align:center;margin-bottom:1rem;">
        <p id="<?= $uid ?>-result-multiple-label" style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.8125rem;font-weight:500;margin-bottom:.5rem;"><?= esc_html( $s['imp_result_title'] ) ?></p>
        <p id="<?= $uid ?>-result-multiple-range" style="font-family:'Cormorant Garamond',serif;font-weight:700;color:hsl(var(--foreground));font-size:clamp(2rem,8vw,3.25rem);line-height:1;margin-bottom:.375rem;">Calculating&hellip;</p>
        <p id="<?= $uid ?>-result-multiple-count" style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.7);font-size:.875rem;margin-bottom:.75rem;"><?= esc_html( $s['imp_result_subtitle'] ) ?></p>
        <div id="<?= $uid ?>-multi-tier-note" style="display:none;background:hsl(var(--accent)/.4);border:1px solid hsl(var(--border));border-radius:.75rem;padding:.875rem 1rem;text-align:left;margin-bottom:1rem;">
          <p id="<?= $uid ?>-multi-tier-text" style="font-family:Inter,sans-serif;font-size:.825rem;color:hsl(var(--foreground)/.75);line-height:1.6;margin:0;"></p>
        </div>
        <?php if ( $single_includes_html ): ?>
        <div style="display:flex;flex-direction:column;gap:.5rem;max-width:20rem;margin:0 auto;text-align:left;">
          <p style="font-family:Inter,sans-serif;font-weight:600;color:hsl(var(--foreground));font-size:.8125rem;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.25rem;">Included per implant</p>
          <?= $single_includes_html ?>
        </div>
        <?php endif; ?>
        <?php if ( $graft_note_inner ): ?>
        <div id="<?= $uid ?>-graft-note-multiple" style="display:none;background:hsl(var(--accent)/.5);padding:.875rem 1rem;border:1px solid hsl(var(--border));border-radius:.75rem;text-align:left;margin-top:1.25rem;">
          <p style="font-family:Inter,sans-serif;color:hsl(var(--foreground)/.8);font-size:.875rem;line-height:1.6;"><?= $graft_note_inner ?></p>
        </div>
        <?php endif; ?>
      </div>
      <?= $result_sections_html ?>
      <?= $fin_block ?>
      <?= $disc_block ?>
      <?= $cta_buttons ?>
      <?php else: ?>
      <?= $no_price_card ?>
      <?= $disc_block ?>
      <?php endif; ?>
    </div>
  </main>
</div>

<!-- RESULT: FULL ARCH -->
<div class="die-panel" id="<?= $uid ?>-panel-result-fullarch">
  <main style="display:flex;flex-direction:column;flex:1;">
    <div style="flex:1;margin:0 auto;padding:1.5rem 1rem 2rem;width:100%;max-width:48rem;box-sizing:border-box;">
      <?= $_badge('Your Estimate Is Ready') ?>
      <?php if ( $show_price ): ?>
      <div style="background:hsl(var(--card));border:1px solid hsl(var(--border));border-radius:1rem;padding:2rem 2rem 2rem;box-shadow:0 1px 3px rgba(0,0,0,.06);text-align:center;margin-bottom:1rem;">
        <p id="<?= $uid ?>-result-fullarch-label" style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground));font-size:.8125rem;font-weight:500;margin-bottom:.5rem;"><?= esc_html( $s['imp_result_title'] ) ?></p>
        <p id="<?= $uid ?>-result-fullarch-range" style="font-family:'Cormorant Garamond',serif;font-weight:700;color:hsl(var(--foreground));font-size:clamp(2rem,8vw,3.25rem);line-height:1;margin-bottom:.375rem;">Calculating&hellip;</p>
        <p id="<?= $uid ?>-result-fullarch-suffix" style="font-family:Inter,sans-serif;color:hsl(var(--muted-foreground)/.7);font-size:.875rem;margin-bottom:<?= $arch_includes_html ? '1.5rem' : '.5rem' ?>;"><?= esc_html( $s['imp_result_subtitle'] ) ?></p>
        <?php if ( $arch_includes_html ): ?>
        <div style="display:flex;flex-direction:column;gap:.5rem;max-width:20rem;margin:0 auto;text-align:left;">
          <p style="font-family:Inter,sans-serif;font-weight:600;color:hsl(var(--foreground));font-size:.8125rem;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.25rem;">Included in your estimate</p>
          <?= $arch_includes_html ?>
        </div>
        <?php endif; ?>
      </div>
      <?= $result_sections_html ?>
      <?= $fin_block ?>
      <?= $disc_block ?>
      <?= $cta_buttons ?>
      <?php else: ?>
      <?= $no_price_card ?>
      <?= $disc_block ?>
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
    showIns:  <?= $show_insurance ? 'true' : 'false' ?>,
    result_suffix_single:   '<?= esc_js( $s['imp_result_single_suffix'] ) ?>',
    result_suffix_multiple: '<?= esc_js( $s['imp_result_multiple_suffix'] ) ?>',
    result_suffix_fullarch: '<?= esc_js( $s['imp_result_fullarch_suffix'] ) ?>',
    successUrl:        '<?= esc_js( ! empty( $s['imp_contact_btn_url'] ) ? $s['imp_contact_btn_url'] : ( ! empty( $s['imp_success_url'] ) ? $s['imp_success_url'] : $s['success_redirect_url'] ) ) ?>',
    graftDisplay: '<?= esc_js( $s['imp_graft_display'] ?? 'addon' ) ?>'
  };

  /* ── STATE ── */
  var s = {
    flow: null,
    answers:  {},   // {fieldKey: val}
    answersL: {}    // {fieldKey: label}
  };

  // ── Path configs injected by PHP ──
  var impPaths = <?php echo json_encode([
    'router'   => $router_opts_data,
    'single'   => $single_qs,
    'multiple' => $multi_qs,
    'fullarch' => $arch_qs,
    'ins'      => $ins_q,
  ], JSON_UNESCAPED_UNICODE); ?>;

  function getPathQs(flow) {
    return flow === 'multiple' ? impPaths.multiple : (flow === 'fullarch' ? impPaths.fullarch : impPaths.single);
  }
  function getGraftVal(flow) {
    var qs = getPathQs(flow);
    if (!qs) return '';
    for (var i=0; i<qs.length; i++) {
      if (qs[i].pricing_role === 'bone_graft') return s.answers[qs[i].field] || '';
    }
    return '';
  }

  var currentPanel = 'intro';
  var navHistory   = [];

  /* ── STEP MAP ── */
  function buildStepMap() {
    var map = { intro: {label:'Get Started', pct:5}, router: {label:'Step 1', pct:11} };
    ['single','multiple','fullarch'].forEach(function(flow) {
      var qs = getPathQs(flow);
      var hasIns = (flow !== 'fullarch') && <?php echo $show_insurance ? 'true' : 'false'; ?>;
      // total steps = 1 (router) + qs.length + (hasIns?1:0) + 1 (summary) + 1 (lead) + 1 (result)
      var total = qs.length + 4 + (hasIns ? 1 : 0);
      qs.forEach(function(q, i) {
        map[q.id] = {label:'Step '+(i+2)+' of '+total, pct: Math.round((i+2)/total*100)};
      });
      if (hasIns && impPaths.ins) {
        map['ins'] = {label:'Step '+(qs.length+2)+' of '+total, pct: Math.round((qs.length+2)/total*100)};
      }
    });
    return map;
  }
  var stepMap = buildStepMap();

  function getStepInfo(id) {
    if (stepMap[id]) return stepMap[id];
    var flow = s.flow || 'single';
    var qs = getPathQs(flow);
    var hasIns = (flow !== 'fullarch') && <?php echo $show_insurance ? 'true' : 'false'; ?>;
    var total = qs.length + 4 + (hasIns ? 1 : 0);
    if (id === 'summary') return {label:'Step '+(total-2)+' of '+total, pct:76};
    if (id === 'lead')    return {label:'Step '+(total-1)+' of '+total, pct:88};
    if (id.indexOf('result') === 0) return {label:'Step '+total+' of '+total, pct:100};
    return {label:'', pct:0};
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
      var arch = s.answers['archSelection'] || '';
      var multi = arch === 'both' ? 2 : 1;
      var archSuffix = arch === 'both' ? 'for both arches' : arch === 'upper' ? 'upper arch' : arch === 'lower' ? 'lower arch' : config.result_suffix_fullarch;
      return {label: fmt(p.arch_min * multi)+' \u2013 '+fmt(p.arch_max * multi), suffix: ' \u2014 '+archSuffix};
    }
    var graftVal = getGraftVal(s.flow);
    var addGraft = config.graftDisplay !== 'included' && (graftVal === 'yes' || graftVal === 'not-sure');
    var bMin, bMax;
    if (s.flow === 'multiple') {
      var count = s.teethCountN;
      if (count === null || isNaN(count)) {
        // Unknown count — show the configured multiple range as-is
        bMin = p.multi_min;
        bMax = p.multi_max;
        if (addGraft) { bMin += p.graft_min; bMax += p.graft_max; }
        return {label: fmt(bMin)+' \u2013 '+fmt(bMax), suffix: ' \u2014 multiple implants'};
      }
      bMin = p.single_min * count;
      bMax = p.single_max * count;
      // Cap at configured multiple max
      if (bMin > p.multi_max) bMin = p.multi_max;
      if (bMax > p.multi_max) bMax = p.multi_max;
      if (addGraft) { bMin += p.graft_min; bMax += p.graft_max; }
      return {label: fmt(bMin)+' \u2013 '+fmt(bMax), suffix: ' \u2014 '+count+' implants'};
    }
    bMin = p.single_min; bMax = p.single_max;
    if (addGraft) { bMin += p.graft_min; bMax += p.graft_max; }
    return {label: fmt(bMin)+' \u2013 '+fmt(bMax), suffix: ' \u2014 '+config.result_suffix_single};
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
      tags.push({l:'Replacing:', v:'One missing tooth'});
    } else if (s.flow === 'multiple') {
      tags.push({l:'Replacing:', v:'Several missing teeth'});
    } else if (s.flow === 'fullarch') {
      tags.push({l:'Replacing:', v:'Full arch / denture'});
    }
    var pathQs = getPathQs(s.flow) || [];
    for (var si = 0; si < pathQs.length; si++) {
      var sq = pathQs[si];
      var sv = s.answersL[sq.field];
      if (sv) tags.push({l: (sq.sidebar_label || sq.title.split(' ').slice(0,2).join(' ') + ':'), v: sv});
    }
    if (impPaths.ins) {
      var insV = s.answersL[impPaths.ins.field];
      if (insV) tags.push({l:'Insurance:', v:insV});
    }

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
      var pqs = getPathQs(s.flow) || [];
      var maxA = pqs.length + 1 + (s.flow !== 'fullarch' && impPaths.ins ? 1 : 0);
      var pct = Math.max(5, Math.min(90, (tags.length / maxA) * 90));
      // Progressive blur — starts at 8px, clears as answers accumulate
      var blurPx = Math.max(0, Math.round(8 - (pct / 90) * 8));
      var rw = document.getElementById(uid + '-range-wrap');
      if (rw) { rw.style.filter = blurPx > 0 ? 'blur(' + blurPx + 'px)' : ''; rw.style.userSelect = blurPx > 0 ? 'none' : ''; }
      // Show live price range — hide placeholder, reveal range
      var placeholder = document.getElementById(uid + '-sidebar-range-placeholder');
      if (placeholder) placeholder.style.display = 'none';
      document.querySelectorAll('.imp-sr-' + uid).forEach(function(el){
        el.style.display = 'block';
        el.textContent = r.label;
      });
      document.querySelectorAll('.imp-sr-sfx-' + uid).forEach(function(el){
        el.style.display = 'block';
        el.textContent = r.suffix.replace(/^\s*—\s*/, '');
      });
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
    s.answers[key]  = val;
    s.answersL[key] = label;
    if (key === 'router') {
      s.flow = val; // 'single','multiple','fullarch'
    }
    // special: teethCount numeric for pricing
    if (key === 'teethCount') {
      var parsed = parseInt(val, 10);
      s.teethCountN = isNaN(parsed) ? null : parsed;
    }
    var par = btn.closest ? btn.closest('.die-options') : btn.parentNode;
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
    var flowLabel = s.flow === 'multiple' ? 'multiple missing teeth'
                  : s.flow === 'fullarch' ? 'full arch / denture'
                  : 'one missing tooth';
    items.push(ck('Replacing: <strong>' + flowLabel + '</strong>'));

    var pathQs = getPathQs(s.flow) || [];
    for (var i = 0; i < pathQs.length; i++) {
      var q = pathQs[i];
      var ans = s.answersL[q.field];
      if (ans) {
        var qLabel = q.summary_label || q.title;
        items.push(ck(qLabel + ': <strong>' + ans + '</strong>'));
      }
    }
    if (impPaths.ins) {
      var insAns = s.answersL[impPaths.ins.field];
      if (insAns) items.push(ck('Insurance: <strong>' + insAns + '</strong>'));
    }
    var desc = s.flow === 'single'
      ? 'We\u2019ve prepared your likely treatment range based on a single missing tooth. Enter your details to unlock the full estimate.'
      : s.flow === 'multiple'
      ? 'We\u2019ve prepared your likely treatment range based on ' + (s.answersL['teethCount'] || 'multiple') + ' missing teeth. Enter your details to unlock the full estimate.'
      : 'We\u2019ve prepared your likely treatment range based on full-arch restoration. Enter your details to unlock the full estimate.';
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

  var _n2w = {1:'Single',2:'Two',3:'Three',4:'Four',5:'Five',6:'Six',7:'Seven'};
  function renderResult(panelId) {
    // Fully unblur the sidebar price card on result screen
    var rw = document.getElementById(uid + '-range-wrap');
    if (rw) { rw.style.filter = ''; rw.style.userSelect = ''; }
    var r = getRange();
    var showGraft = config.graftDisplay !== 'included';
    if (panelId === 'result-single') {
      animateRange(uid + '-result-single-range', r.label);
      var lbl = document.getElementById(uid + '-result-single-label');
      if (lbl) lbl.textContent = 'Single Tooth Implant Treatment';
      var gns = document.getElementById(uid + '-graft-note-single');
      var gv  = getGraftVal('single');
      if (gns) gns.style.display = (showGraft && (gv === 'yes' || gv === 'not-sure')) ? 'block' : 'none';
    } else if (panelId === 'result-multiple') {
      animateRange(uid + '-result-multiple-range', r.label);
      var count = s.teethCountN;
      var countKnown = count !== null && !isNaN(count);
      var word  = countKnown ? (_n2w[count] || count) : 'Multiple';
      var lbl2  = document.getElementById(uid + '-result-multiple-label');
      if (lbl2) lbl2.textContent = word + '-Tooth Implant Treatment';
      var cnt   = document.getElementById(uid + '-result-multiple-count');
      if (cnt)  cnt.textContent  = countKnown ? (count + ' implants \u00d7 single-implant rate') : 'Multiple implants \u2014 estimated range';
      var gvm   = getGraftVal('multiple');
      var gnm   = document.getElementById(uid + '-graft-note-multiple');
      if (gnm)  gnm.style.display = (showGraft && (gvm === 'yes' || gvm === 'not-sure')) ? 'block' : 'none';
      var tierNote = document.getElementById(uid + '-multi-tier-note');
      var tierText = document.getElementById(uid + '-multi-tier-text');
      if (tierNote && tierText) {
        if (count >= 5) {
          tierText.textContent = 'This estimate is based on ' + count + ' individual implants at the single-implant rate. For larger cases, a full-arch solution (All-on-4 / All-on-6) may offer better value \u2014 ask us about it at your consultation.';
          tierNote.style.display = 'block';
        } else {
          tierNote.style.display = 'none';
        }
      }
    } else if (panelId === 'result-fullarch') {
      animateRange(uid + '-result-fullarch-range', r.label);
      var arch      = s.answers['archSelection'] || '';
      var archWord  = arch === 'both' ? 'Full Arch (Upper & Lower) Treatment' : arch === 'upper' ? 'Upper Arch Implant Treatment' : arch === 'lower' ? 'Lower Arch Implant Treatment' : 'Full Arch Implant Treatment';
      var lbl3      = document.getElementById(uid + '-result-fullarch-label');
      if (lbl3) lbl3.textContent = archWord;
      var archPanelSfx = document.getElementById(uid + '-result-fullarch-suffix');
      if (archPanelSfx) archPanelSfx.textContent = r.suffix.replace(/^\s*\u2014\s*/, '');
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
    fd.append('flow', s.flow || '');
    // Append all path answers
    var allQs = (getPathQs(s.flow) || []).concat(impPaths.ins ? [impPaths.ins] : []);
    for (var qi = 0; qi < allQs.length; qi++) {
      var qf = allQs[qi].field;
      fd.append('answer[' + qf + ']',  s.answers[qf]  || '');
      fd.append('answerL[' + qf + ']', s.answersL[qf] || '');
    }
    fd.append('range',           r.label + r.suffix);
    fd.append('rangeType',       panel);
    var _up = new URLSearchParams(window.location.search);
    ['utm_campaign','utm_medium','utm_content','utm_keyword','utm_term','gclid'].forEach(function(k){ fd.append(k, _up.get(k) || ''); });
    fetch(config.ajaxUrl, { method:'POST', body:fd })
      .then(function(res){ return res.json(); })
      .then(function(data){
        if (btn) { btn.disabled = false; btn.style.opacity = '1'; btn.style.cursor = 'pointer'; }
        isSubmitting = false;
        if (config.successUrl) { window.location.href = config.successUrl; } else { navigate(panel); }
      })
      .catch(function(){
        if (btn) { btn.disabled = false; btn.style.opacity = '1'; btn.style.cursor = 'pointer'; }
        isSubmitting = false;
        if (config.successUrl) { window.location.href = config.successUrl; } else { navigate(panel); }
      });
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

    // Decode path configs
    $single_qs = json_decode( $s['imp_single_qs'], true ) ?: [];
    $multi_qs  = json_decode( $s['imp_multi_qs'],  true ) ?: [];
    $arch_qs   = json_decode( $s['imp_arch_qs'],   true ) ?: [];
    $ins_q     = json_decode( $s['imp_ins_q'],     true ) ?: null;

    $flow = sanitize_text_field( $_POST['flow'] ?? '' );
    $range = sanitize_text_field( $_POST['range'] ?? '' );
    $range_type = sanitize_text_field( $_POST['rangeType'] ?? '' );

    $path_qs = $flow === 'multiple' ? $multi_qs : ( $flow === 'fullarch' ? $arch_qs : $single_qs );
    $all_qs  = $path_qs;
    if ( $ins_q ) $all_qs[] = $ins_q;

    // Tags
    $tags = [ 'implant-estimator', 'website-lead' ];
    if ( $flow === 'single' )        $tags[] = 'implant-single';
    elseif ( $flow === 'multiple' )  $tags[] = 'implant-multiple';
    elseif ( $flow === 'fullarch' )  $tags[] = 'implant-fullarch';

    // Custom fields — dynamic
    $answers  = $_POST['answer']  ?? [];
    $custom   = [];
    $custom[] = [ 'key' => 'implant_flow',  'field_value' => $flow ];
    $custom[] = [ 'key' => 'implant_range', 'field_value' => $range ];
    foreach ( $all_qs as $q ) {
        $field = sanitize_key( $q['field'] ?? '' );
        $val   = sanitize_text_field( $answers[ $field ] ?? '' );
        if ( $field !== '' && $val !== '' ) {
            $custom[] = [ 'key' => 'implant_' . $field, 'field_value' => $val ];
        }
    }
    $utm_key_map      = get_option( 'cfg_utm_key_map_' . md5( $s['ghl_location_id'] ), [] );
    $utm_display_keys = [ 'utm_campaign' => 'UTMCampaign_custom', 'utm_medium' => 'UTMMedium_custom',
                          'utm_content'  => 'UTMContent_custom',  'utm_keyword' => 'UTMKeyword_custom',
                          'utm_term'     => 'UTMTerm_custom',      'gclid'       => 'GCLID_custom' ];
    foreach ( $utm_display_keys as $post_key => $fallback_key ) {
        $val     = sanitize_text_field( $_POST[ $post_key ] ?? '' );
        $ghl_key = $utm_key_map[ $post_key ] ?? $fallback_key;
        $ghl_key = preg_replace( '/^contact\./', '', $ghl_key );
        if ( $val !== '' ) $custom[] = [ 'key' => $ghl_key, 'field_value' => $val ];
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

    $ghl_ok = ( $code === 200 || $code === 201 );
    $entry_meta = array_filter( [
        'flow'         => $flow,
        'range'        => $range,
        'range_type'   => $range_type,
        'utm_campaign' => sanitize_text_field( $_POST['utm_campaign'] ?? '' ),
        'utm_medium'   => sanitize_text_field( $_POST['utm_medium']   ?? '' ),
        'utm_content'  => sanitize_text_field( $_POST['utm_content']  ?? '' ),
        'utm_keyword'  => sanitize_text_field( $_POST['utm_keyword']  ?? '' ),
        'utm_term'     => sanitize_text_field( $_POST['utm_term']     ?? '' ),
        'gclid'        => sanitize_text_field( $_POST['gclid']        ?? '' ),
    ] );
    foreach ( $all_qs as $q ) {
        $field = sanitize_key( $q['field'] ?? '' );
        $val   = sanitize_text_field( $answers[ $field ] ?? '' );
        if ( $field !== '' && $val !== '' ) $entry_meta[ $field ] = $val;
    }
    $entry_meta['_ghl_fields_sent'] = $custom;
    $entry_meta['_ghl_http_code']   = $code;
    $entry_meta['_ghl_response']    = $body;
    error_log( '[CFG Implant] sent customFields: ' . wp_json_encode( $custom ) );
    error_log( '[CFG Implant] GHL HTTP ' . $code . ': ' . wp_json_encode( $body ) );
    cfg_log_entry( 'implant', $first, $last, $email, $phone, $entry_meta, $ghl_ok ? 'ok' : 'error' );

    if ( $ghl_ok ) {
        wp_send_json_success( 'Contact created.' );
    } else {
        $msg = $body['message'] ?? ( 'Unexpected error (HTTP ' . $code . ').' );
        wp_send_json_error( $msg );
    }
}
