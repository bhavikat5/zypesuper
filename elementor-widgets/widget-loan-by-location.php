<?php
namespace ZypeSuper\ElementorWidgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class Loan_By_Location_Widget extends Widget_Base {

    public function get_name() {
        return 'loan_by_location';
    }

    public function get_title() {
        return __('Loan By Location', 'zype-super');
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return ['zype-super'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Settings', 'zype-super'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Language selector
        $this->add_control(
            'language',
            [
                'label'   => __('Language', 'zype-super'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'en',
                'options' => [
                    'en'    => __('English', 'zype-super'),
                    'hindi' => __('Hindi', 'zype-super'),
                    'mr'    => __('Marathi', 'zype-super'),
                    'tamil' => __('Tamil', 'zype-super'),
                ],
            ]
        );

        // Exclude options
        $location_options = $this->get_location_options();
        $options = [];
        foreach ($location_options as $slug => $label) {
            $options[$slug] = $label['en']; // show English in editor dropdown
        }

        $this->add_control(
            'excluded_locations',
            [
                'label'    => __('Exclude Locations', 'zype-super'),
                'type'     => Controls_Manager::SELECT2,
                'multiple' => true,
                'options'  => $options, // fixed to flat array
                'default'  => [],
            ]
        );

        $this->end_controls_section();
    }

    private function get_location_options() {
       $locations = [
    'mumbai'          => ['en' => 'Mumbai'],
    'bangalore'       => ['en' => 'Bangalore'],
    'delhi'           => ['en' => 'Delhi'],
    'kerala'          => ['en' => 'Kerala'],
    'chennai'         => ['en' => 'Chennai'],
    'hyderabad'       => ['en' => 'Hyderabad'],
    'noida'           => ['en' => 'Noida'],
    'kanchipuram'     => ['en' => 'Kanchipuram'],
    'kolkata'         => ['en' => 'Kolkata'],
    'coimbatore'      => ['en' => 'Coimbatore'],
    'pune'            => ['en' => 'Pune'],
    'ahmedabad'       => ['en' => 'Ahmedabad'],
    'patna'           => ['en' => 'Patna'],
    'jaipur'          => ['en' => 'Jaipur'],
    'bhubaneswar'     => ['en' => 'Bhubaneswar'],
    'lucknow'         => ['en' => 'Lucknow'],
    'nagpur'          => ['en' => 'Nagpur'],
    'agra'            => ['en' => 'Agra'],
    'kochi'           => ['en' => 'Kochi'],
    'indore'          => ['en' => 'Indore'],
    'gurgaon'         => ['en' => 'Gurgaon'],
    'ghaziabad'       => ['en' => 'Ghaziabad'],
    'bhopal'          => ['en' => 'Bhopal'],
    'guwahati'        => ['en' => 'Guwahati'],
    'ludhiana'        => ['en' => 'Ludhiana'],
    'siliguri'        => ['en' => 'Siliguri'],
    'visakhapatnam'   => ['en' => 'Visakhapatnam'],
    'surat'           => ['en' => 'Surat'],
    'thiruvananthapuram' => ['en' => 'Thiruvananthapuram'],
    'madurai'         => ['en' => 'Madurai'],
    'chandigarh'      => ['en' => 'Chandigarh'],
    'rajkot'          => ['en' => 'Rajkot'],
    'meerut'          => ['en' => 'Meerut'],
    'jodhpur'         => ['en' => 'Jodhpur'],
    'varanasi'        => ['en' => 'Varanasi'],
    'sonipat'         => ['en' => 'Sonipat'],
    'panipat'         => ['en' => 'Panipat'],
    'kota'            => ['en' => 'Kota'],
    'jabalpur'        => ['en' => 'Jabalpur'],
    'mysuru'          => ['en' => 'Mysuru'],
    'kanpur'          => ['en' => 'Kanpur'],
    'shimla'          => ['en' => 'Shimla'],
    'rourkela'         => ['en' => 'Rourkela'],
    'srinagar'        => ['en' => 'Srinagar'],
    'pimpri-chinchwad' => ['en' => 'Pimpri-Chinchwad'],
];
        return $locations;
    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        $language           = $settings['language'];
        $excluded_locations = $settings['excluded_locations'];
        $location_options   = $this->get_location_options();

        // URL prefix by language (adjust if your site has proper subdirectories)
        $url_prefix = ($language === 'en') ? '' : "{$language}/";

        // Loan text translations
        $loan_texts = [
            'en'    => 'Personal Loan in ',
            'hindi' => 'पर्सनल लोन ',
            'mr'    => 'वैयक्तिक कर्ज ',
            'tamil' => 'தனிநபர் கடன் ',
        ];

        echo '<div class="zype-loan-links">';
        foreach ($location_options as $slug => $label) {
            if (in_array($slug, $excluded_locations)) {
                continue; // skip excluded
            }

            // Use selected language, fallback to English
            $city_label = isset($label[$language]) ? $label[$language] : $label['en'];

            // Build URL
            $url = esc_url("https://www.getzype.com/{$url_prefix}personal-loan-in-{$slug}/");

            echo '<a href="' . $url . '" class="loan-location-link">';
            echo esc_html($loan_texts[$language]) . '<br><span class="titleBold">' . esc_html($city_label) . '</span>';
            echo '</a>';
        }
        echo '</div>';
    }

    public function get_style_depends() {
        return ['widget-css'];
    }
}
