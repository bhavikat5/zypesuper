<?php
namespace ZypeSuper\ElementorWidgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Loan_By_Amount_Widget extends Widget_Base {

    public function get_name() {
        return 'loan_buttons';
    }

    public function get_title() {
        return __('Loan By Amount', 'zype-super');
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return ['zype-super'];
    }

    public function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Settings', 'zype-super'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Language selector
        $this->add_control(
            'language',
            [
                'label' => __('Language', 'zype-super'),
                'type' => Controls_Manager::SELECT,
                'default' => 'en',
                'options' => [
                    'en' => __('English', 'zype-super'),
                    'hindi' => __('Hindi', 'zype-super'),
                    'mr' => __('Marathi', 'zype-super'),
                    'tamil' => __('Tamil', 'zype-super'),
                ],
            ]
        );

        // Get loan options for exclusion
        $loan_amounts = $this->get_loan_amounts();
        $options = [];
        foreach ($loan_amounts as $slug => $label) {
            $options[$slug] = $label['en']; // default display labels
        }

        $this->add_control(
            'excluded_amounts',
            [
                'label' => __('Exclude Loan Amounts', 'zype-super'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $options,
                'default' => [],
            ]
        );

        $this->end_controls_section();
    }

    private function get_loan_amounts() {
        return [
            '3000' => [
                'en' => '₹3,000',
                'hindi' => '₹3,000',
                'mr' => '₹3,000',
                'tamil' => '₹3,000',
            ],
            '4000' => [
                'en' => '₹4,000',
                'hindi' => '₹4,000',
                'mr' => '₹4,000',
            ],
            '5000' => [
                'en' => '₹5,000',
                'hindi' => '₹5,000',
                'mr' => '₹5,000',
                'tamil' => '₹5,000',
            ],
            '6000' => [
                'en' => '₹6,000',
            ],
            '7000' => [
                'en' => '₹7,000',
            ],
            '8000' => [
                'en' => '₹8,000',
                'mr' => '₹8,000',
            ],
            '10000' => [
                'en' => '₹10,000',
                'hindi' => '₹10,000',
                'mr' => '₹10,000',
                'tamil' => '₹10,000',
            ],
            '15000' => [
                'en' => '₹15,000',
                'hindi' => '₹15,000',
                'mr' => '₹15,000',
                'tamil' => '₹15,000',
            ],
            '16000' => [
                'en' => '₹16,000',
            ],
            '17000' => [
                'en' => '₹17,000',
            ],
            '20000' => [
                'en' => '₹20,000',
                'hindi' => '₹20,000',
                'mr' => '₹20,000',
                'tamil' => '₹20,000',
            ],
            '25000' => [
                'en' => '₹25,000',
                'hindi' => '₹25,000',
                'mr' => '₹25,000',
                'tamil' => '₹25,000',
            ],
            '30000' => [
                'en' => '₹30,000',
                'hindi' => '₹30,000',
                'mr' => '₹30,000',
                'tamil' => '₹30,000',
            ],
            '35000' => [
                'en' => '₹35,000',
                'hindi' => '₹35,000',
                'mr' => '₹35,000',
                'tamil' => '₹35,000',
            ],
            '40000' => [
                'en' => '₹40,000',
                'hindi' => '₹40,000',
                'mr' => '₹40,000',
                'tamil' => '₹40,000',
            ],
            '45000' => [
                'en' => '₹45,000',
                'hindi' => '₹45,000',
                'mr' => '₹45,000',
            ],
            '50000' => [
                'en' => '₹50,000',
                'hindi' => '₹50,000',
                'mr' => '₹50,000',
                'tamil' => '₹50,000',
            ],
            '60000' => [
                'en' => '₹60,000',
                'hindi' => '₹60,000',
                'mr' => '₹60,000',
                'tamil' => '₹60,000',
            ],
            '70000' => [
                'en' => '₹70,000',
                'hindi' => '₹70,000',
                'mr' => '₹70,000',
                'tamil' => '₹70,000',
            ],
            '75000' => [
                'en' => '₹75,000',
                'hindi' => '₹75,000',
                'mr' => '₹75,000',
            ],
            '80000' => [
                'en' => '₹80,000',
                'hindi' => '₹80,000',
                'mr' => '₹80,000',
                'tamil' => '₹80,000',
            ],
            '90000' => [
                'en' => '₹90,000',
                'hindi' => '₹90,000',
                'mr' => '₹90,000',
            ],
            '95000' => [
                'en' => '₹95,000',
                'hindi' => '₹95,000',
                'mr' => '₹95,000',
            ],
            '1-lakh' => [
                'en' => '₹1 Lakh',
                'hindi' => '₹1 लाख',
                'mr' => '₹1 लाख',
            ],
            '1.5-lakh' => [
                'en' => '₹1.5 Lakh',
                'hindi' => '₹1.5 लाख',
                'mr' => '₹1.5 लाख',
            ],
            '2-lakh' => [
                'en' => '₹2 Lakh',
                'hindi' => '₹2 लाख',
                'mr' => '₹2 लाख',
            ],
            '3-lakh' => [
                'en' => '₹3 Lakh',
                'hindi' => '₹3 लाख',
                'mr' => '₹3 लाख',
            ],
            '4-lakh' => [
                'en' => '₹4 Lakh',
                'hindi' => '₹4 लाख',
                'mr' => '₹4 लाख',
            ],
            '5-lakh' => [
                'en' => '₹5 Lakh',
                'hindi' => '₹5 लाख',
                'mr' => '₹5 लाख',
            ],
        ];
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $excluded = $settings['excluded_amounts'];
        $language = $settings['language'];
        $loan_amounts = $this->get_loan_amounts();
    
        // URL path by language
        $url_prefix = ($language === 'en') ? '' : "{$language}/";
    
        // Text translation
        $loan_texts = [
            'en' => 'Personal Loan',
            'hindi' => 'पर्सनल लोन',
            'mr' => 'वैयक्तिक कर्ज',
            'tamil' => "தனிநபர் கடன்"
        ];
    
        echo '<div class="zype-loan-links">';
        foreach ($loan_amounts as $slug => $labels) {
            if (in_array($slug, $excluded)) continue;
    
            if (!isset($labels[$language])) {
                continue; // skip if translation missing
            }
    
            $label = $labels[$language];
    
            // ✅ Special case: only English 20000 goes to urgent URL
            if ((string)$slug === '20000' && $language === 'en') {
                $url = esc_url("https://www.getzype.com/20000-urgent-personal-loan/");
            } else {
                $url = esc_url("https://www.getzype.com/{$url_prefix}{$slug}-personal-loan/");
            }
    
            echo '<a href="' . $url . '">';
            echo '<span class="titleBold">' . esc_html($label) . '</span><br>' . esc_html($loan_texts[$language]);
            echo '</a>';
        }
        echo '</div>';
    }

    public function get_style_depends() {
        return ['widget-css'];
    }
}
