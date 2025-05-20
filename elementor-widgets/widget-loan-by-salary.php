<?php
namespace ZypeSuper\ElementorWidgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class Loan_By_Salary_Widget extends Widget_Base {

    public function get_name() {
        return 'loan_by_salary';
    }

    public function get_title() {
        return __('Loan By Salary', 'zype-super');
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

        // Exclude options
        $salary_options = $this->get_salary_options();
        $options = [];
        foreach ($salary_options as $slug => $label) {
            $options[$slug] = $label['en'];
        }

        $this->add_control(
            'excluded_salaries',
            [
                'label' => __('Exclude Salary Amounts', 'zype-super'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $options,
                'default' => [],
            ]
        );

        $this->end_controls_section();
    }

    private function get_salary_options() {
        return [
            '15000' => [
                'en' => '₹15,000',
                'hindi' => '₹15,000',
                'mr' => '₹15,000',
            ],
            '18000' => [
                'en' => '₹18,000',
                'hindi' => '₹18,000',
                'mr' => '₹18,000',
            ],
            '20000' => [
                'en' => '₹20,000',
                'hindi' => '₹20,000',
                'mr' => '₹20,000',
            ],
            '25000' => [
                'en' => '₹25,000',
                'hindi' => '₹25,000',
                'mr' => '₹25,000',
            ],
            '30000' => [
                'en' => '₹30,000',
                'hindi' => '₹30,000',
                'mr' => '₹30,000',
            ],
            '35000' => [
                'en' => '₹35,000',
//                 'hindi' => '₹35,000',
//                 'mr' => '₹35,000',
            ],
            '40000' => [
                'en' => '₹40,000',
                'hindi' => '₹40,000',
                'mr' => '₹40,000',
            ],
            '50000' => [
                'en' => '₹50,000',
                'hindi' => '₹50,000',
                'mr' => '₹50,000',
            ],
            '60000' => [
                'en' => '₹60,000',
                // 'hindi' => '₹60,000',
                // 'mr' => '₹60,000',
            ],
            '95000' => [
                'en' => '₹95,000',
                // 'hindi' => '₹95,000',
                // 'mr' => '₹95,000',
            ],
        ];
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $excluded = $settings['excluded_salaries'];
        $language = $settings['language'];
        $salary_options = $this->get_salary_options();

        // URL path by language
        $url_prefix = ($language === 'en') ? '' : "{$language}/";

        $loan_texts = [
            'en' => 'Salary Personal Loan',
            'hindi' => 'वेतन व्यक्तिगत ऋण',
            'mr' => 'पगार वैयक्तिक कर्ज',
            'tamil' => 'சம்பளம் தனிநபர் கடன்',
        ];

        echo '<div class="zype-loan-links">';
        foreach ($salary_options as $slug => $labels) {
            if (in_array($slug, $excluded)) continue;
            if (!isset($labels[$language])) continue;

            $label = $labels[$language] ?? $labels['en'];
            $url = esc_url("https://www.getzype.com/{$url_prefix}personal-loan-for-{$slug}-salary/");

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