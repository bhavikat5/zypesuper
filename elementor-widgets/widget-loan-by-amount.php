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
                'mr' => '३,०००',
                // 'hindi' => '₹3,000',
            ],
            '4000' => [
                'en' => '₹4,000',
                'hindi' => '₹4,000',
                // 'mr' => '४,०००',
            ],
            '5000' => [
                'en' => '₹5,000',
                'hindi' => '₹5,000',
                'mr' => '५,०००',
            ],
            '10000' => [
                'en' => '₹10,000',
                'hindi' => '₹10,000',
                'mr' => '१०,०००',
            ],
            '15000' => [
                'en' => '₹15,000',
                'hindi' => '₹15,000',
                'mr' => '१५,०००',
            ],
            '20000' => [
                'en' => '₹20,000',
                'hindi' => '₹20,000',
                'mr' => '२०,०००',
            ],
            '25000' => [
                'en' => '₹25,000',
                'hindi' => '₹25,000',
                'mr' => '२५,०००',
            ],
            '30000' => [
                'en' => '₹30,000',
                'hindi' => '₹30,000',
                'mr' => '३०,०००',
            ],
            '35000' => [
                'en' => '₹35,000',
                'hindi' => '₹35,000',
                'mr' => '३५,०००',
            ],
            '40000' => [
                'en' => '₹40,000',
                'hindi' => '₹40,000',
                'mr' => '४०,०००',
            ],
            '45000' => [
                'en' => '₹45,000',
                'hindi' => '₹45,000',
                'mr' => '४५,०००',
            ],
            '50000' => [
                'en' => '₹50,000',
                'hindi' => '₹50,000',
                'mr' => '५०,०००',
            ],
            '60000' => [
                'en' => '₹60,000',
                'hindi' => '₹60,000',
                'mr' => '६०,०००',
            ],
            '70000' => [
                'en' => '₹70,000',
                'hindi' => '₹70,000',
                'mr' => '७०,०००',
            ],
            '80000' => [
                'en' => '₹80,000',
                'hindi' => '₹80,000',
                'mr' => '८०,०००',
            ],

            '90000' => [
                'en' => '₹90,000',
                'hindi' => '₹90,000',
                'mr' => '९०,०००',
            ],
            '95000' => [
                'en' => '₹95,000',
                'hindi' => '₹95,000',
                'mr' => '९५,०००',
            ],
            '100000' => [
                'en' => '₹1,00,000',
                'hindi' => '₹1,00,000',
                'mr' => '१,००,०००',
            ],
            '1.5-Lakh' => [
                'en' => '₹1,50,000',
                'hindi' => '₹1,50,000',
                'mr' => '१,५०,०००',
            ],
            '2-Lakh' => [
                'en' => '₹2,00,000',
                'hindi' => '₹2,00,000',
                'mr' => '२,००,०००',
            ],
            '3-Lakh' => [
                'en' => '₹3,00,000',
                'hindi' => '₹3,00,000',
                'mr' => '३,००,०००',
            ],
            '4-Lakh' => [
                'en' => '₹4,00,000',
                'hindi' => '₹4,00,000',
                'mr' => '४,००,०००',
            ],
            '5-Lakh' => [
                'en' => '₹5,00,000',
                'hindi' => '₹5,00,000',
                'mr' => '५,००,०००',
            ],
         
            // Add more as needed...
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
        ];
    
        echo '<div class="zype-loan-links">';
        foreach ($loan_amounts as $slug => $labels) {
            if (in_array($slug, $excluded)) continue;
    
            // Check if the label for the selected language exists
            if (!isset($labels[$language])) {
                // Skip this loan amount if the label is missing for the selected language
                continue;
            }
    
            $label = $labels[$language];
            $url = esc_url("https://www.getzype.com/{$url_prefix}{$slug}-personal-loan/");
    
            echo '<a href="' . $url . '">';
            echo '<span class="titleBold">' . esc_html($label) . '</span><br>' . esc_html($loan_texts[$language]);
            echo '</a>';
        }
        echo '</div>';
    }

    public function get_style_depends() {
        return ['zype-loan-buttons'];
    }
}