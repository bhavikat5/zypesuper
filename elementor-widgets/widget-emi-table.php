<?php
namespace ZypeSuper\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

class EMI_Table_Widget extends Widget_Base {

    public function get_name() {
        return 'emi_table';
    }

    public function get_title() {
        return __('EMI Table', 'zype-super');
    }

    public function get_icon() {
        return 'eicon-table';
    }

    public function get_categories() {
        return ['zype-super'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'zype-super'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'loan_amount',
            [
                'label' => __('Loan Amount', 'zype-super'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3000,
            ]
        );

        $default_interest = get_option('zype_super_default_interest', 18);

        $this->add_control(
            'interest_rate',
            [
                'label' => __('Interest Rate (%)', 'zype-super'),
                'type' => Controls_Manager::NUMBER,
                'default' => $default_interest,
            ]
        );

        $this->add_control(
            'language',
            [
                'label' => __('Language', 'zype-super'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'en' => __('English', 'zype-super'),
                    'hi' => __('Hindi', 'zype-super'),
                    'mr' => __('Marathi', 'zype-super'),
                    'ta' => __('Tamil', 'zype-super'),
                ],
                'default' => 'en',
            ]
        );

        $this->end_controls_section();
    }

    public function render() {
        $loan_amount = $this->get_settings_for_display('loan_amount');
        $language = $this->get_settings_for_display('language');
        $interest_rate = $this->get_settings_for_display('interest_rate');
$default_interest = get_option('zype_super_default_interest', 18);
if (!is_numeric($interest_rate) || $interest_rate === '') {
    $interest_rate = $default_interest;
}

        $labels = $this->get_translated_labels($language);
        $note = $this->get_translated_note($language);
        $tenures = [ 6, 9, 12, 18];
        $monthly_rate = $interest_rate / (12 * 100);
        
        echo '<table class="productTable">';
        echo '<thead><tr>';
        echo '<th>' . esc_html($labels['loan_amount']) . '</th>';
        echo '<th>' . esc_html($labels['interest_rate']) . '</th>';
        echo '<th>' . esc_html($labels['tenure']) . '</th>';
        echo '<th>' . esc_html($labels['emi']) . '</th>';
        echo '</tr></thead><tbody>';

        foreach ($tenures as $months) {
            $emi = ($loan_amount * $monthly_rate * pow(1 + $monthly_rate, $months)) / (pow(1 + $monthly_rate, $months) - 1);
            echo '<tr>';
            echo '<td>' . number_format($loan_amount) . '</td>';
            echo '<td>' . $interest_rate . '</td>';
            echo '<td>' . $months . '</td>';
            echo '<td>' . number_format($emi, 2) . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
        echo '<p class="tableNote">' . esc_html($note) . '</p>';
    }

    private function get_translated_labels($lang) {
        switch ($lang) {
            case 'hi': // Hindi
                return [
                    'loan_amount' => 'लोन राशि (₹)',
                    'interest_rate' => 'ब्याज दर (%)',
                    'tenure' => 'अवधि (महीने)',
                    'emi' => 'ईएमआई (₹)',
                ];
            case 'mr': // Marathi
                return [
                    'loan_amount' => 'कर्ज रक्कम (₹)',
                    'interest_rate' => 'व्याज दर (%)',
                    'tenure' => 'कालावधी (महिने)',
                    'emi' => 'ईएमआय (₹)',
                ];
            case 'ta': // Tamil
                return [
                    'loan_amount' => 'கடன் தொகை (₹)',
                    'interest_rate' => 'வட்டி விகிதம் (%)',
                    'tenure' => 'காலம் (மாதங்கள்)',
                    'emi' => 'EMI (₹)',
                ];
            default: // English
                return [
                    'loan_amount' => 'Loan Amount (₹)',
                    'interest_rate' => 'Interest Rate (%)',
                    'tenure' => 'Tenure (in months)',
                    'emi' => 'EMI (₹)',
                ];
        }
    }
    private function get_translated_note($lang) {
    switch ($lang) {
        case 'hi': // Hindi
            return 'नोट: उपरोक्त तालिका केवल उदाहरण के उद्देश्य से है। वास्तविक संख्याएँ भिन्न हो सकती हैं।';
        case 'mr': // Marathi
            return 'नोंद: वरील तक्त्याचा उद्देश केवळ उदाहरणासाठी आहे. प्रत्यक्ष आकडे वेगळे असू शकतात.';
        case 'ta': // Tamil
            return 'குறிப்பு: மேலே உள்ள அட்டவணை விளக்கக் குறிக்கோளுக்காக மட்டுமே. உண்மையான எண்ணிக்கை மாறுபடக்கூடும்.';
        default: // English
            return 'Note: The above table is just for illustration purpose. The actual number may differ.';
    }
}
  public function get_style_depends() {
        return ['widget-css'];
    }

}
