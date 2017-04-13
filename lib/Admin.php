<?php
/**
 * Objectiv Admin
 *
 * @package Objectiv\Admin
 * @author  Objectiv
 * @license GPL-2.0+
 * @link    http://objectiv.co
 */

namespace Objectiv;

class Admin {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Create the admin menu
     *
     * @since 1.0
     */
    public function admin_menu() {
        add_menu_page( 
            'Theme Settings', 
            'Objectiv', 
            'manage_options', 
            'objectiv', 
            array( $this, 'admin' ),
            'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iNDlweCIgaGVpZ2h0PSI0OXB4IiB2aWV3Qm94PSIwIDAgNDkgNDkiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+CiAgICA8IS0tIEdlbmVyYXRvcjogU2tldGNoIDQzLjEgKDM5MDEyKSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5vYmplY3RpdjwvdGl0bGU+CiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4KICAgIDxkZWZzPjwvZGVmcz4KICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxnIGlkPSJvYmplY3RpdiIgZmlsbC1ydWxlPSJub256ZXJvIiBmaWxsPSIjRkZGRkZGIj4KICAgICAgICAgICAgPGcgaWQ9Im9iamVjdGl2LW8td2hpdGUtZmlsbCI+CiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMjAuNzM5NzgyNiwxMi42OTE0ODk0IEMyNy4wMzQxODI1LDEyLjY4NjExMTIgMzIuNzExMTg3MiwxNi40NzA0MDMxIDM1LjEyMDY3ODUsMjIuMjc3Nzk2MSBDMzcuNTMwMTY5OCwyOC4wODUxODkgMzYuMTk2OTg1NywzNC43NzA0NDA0IDMxLjc0MzQ3ODMsMzkuMjEyNzY2IEw0MC42ODA2NTIyLDQ4LjEzODI5NzkgQzUxLjY5MzY5MDMsMzcuMTM5NjA1OCA1MS42OTM2OTAzLDE5LjMwNzIwMjcgNDAuNjgwNjUyMiw4LjMwODUxMDY0IEMyOS42Njc2MTQsLTIuNjkwMTgxNCAxMS44MTE5NTEyLC0yLjY5MDE4MTQgMC43OTg5MTMwNDMsOC4zMDg1MTA2NCBMOS43MzYwODY5NiwxNy4yMzQwNDI2IEMxMi42NTI3NDI1LDE0LjMxODA3MTMgMTYuNjEyODEwOCwxMi42ODMyNzMyIDIwLjczOTc4MjYsMTIuNjkxNDg5NCBMMjAuNzM5NzgyNiwxMi42OTE0ODk0IFoiIGlkPSJTaGFwZSI+PC9wYXRoPgogICAgICAgICAgICAgICAgPHBhdGggZD0iTTUuMTg3NjA4NywyOC4yMjM0MDQzIEM1LjE4MjIyMzQ4LDM0LjUwOTYwNDggOC45NzE0NTE0Myw0MC4xNzkyMTQzIDE0Ljc4NjQxOTMsNDIuNTg1NTY2OSBDMjAuNjAxMzg3MSw0NC45OTE5MTk1IDI3LjI5NTM1ODMsNDMuNjYwNDcyIDMxLjc0MzQ3ODMsMzkuMjEyNzY2IEw5Ljc0NjczOTEzLDE3LjI0NDY4MDkgQzYuODI1Njc2MDEsMjAuMTUzMTg3MyA1LjE4NTAzODkyLDI0LjEwMzk2MjggNS4xODc2MDg3LDI4LjIyMzQwNDMgTDUuMTg3NjA4NywyOC4yMjM0MDQzIFoiIGlkPSJTaGFwZSI+PC9wYXRoPgogICAgICAgICAgICA8L2c+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4=',
            2 
        );
    }

    /**
     * Markup for the Settings page
     *
     * @since 1.0
     */
    public function admin() {
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
        ?>
        <div class="obj-masthead">
            <div class="obj-masthead__container">
                <div class="obj-masthead__logo-container">
                    <a href="#" class="obj-mast-head__logo-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 288 69.08"><defs><style>.a{fill:#fff;}</style></defs><title>objectiv-wordmark-white-fill</title><path class="a" d="M81.5,17.31a19.44,19.44,0,0,0-8.06-1.86c-4.27,0-8.14,1.17-11.1,4.34V4H50.89V55h11V50.95H62c2,3.72,7,5.38,11,5.38,11.93,0,19.3-9.17,19.3-20.68C92.25,27.72,88.87,20.75,81.5,17.31ZM71.22,45.64c-5.58,0-9.31-4.41-9.31-9.86a9.45,9.45,0,1,1,18.89.07A9.52,9.52,0,0,1,71.22,45.64Z"/><path class="a" d="M98.81,53.74c0,3-.21,5.79-4.07,5.79H93.22v9.55h2.83c11.17,0,14.2-4.34,14.2-14.89V16.75H98.81Z"/><path class="a" d="M137.07,15.44C125.83,15.44,117,24.89,117,36a20.3,20.3,0,0,0,20.27,20.27c8.62,0,15.37-5.58,18.68-13.24H144.24a8.21,8.21,0,0,1-7,3.59c-4.48,0-8.27-2.69-9-7.24H157a15,15,0,0,0,.28-3C157.27,24.82,148.79,15.44,137.07,15.44Zm-8.62,16.2c.9-4.14,4.55-6.55,8.69-6.55s7.79,2.41,8.69,6.55Z"/><path class="a" d="M182.37,45.57c-5.58,0-9.1-4.34-9.1-9.72,0-5.17,3.31-9.72,8.82-9.72a8.81,8.81,0,0,1,8.55,5.38h11.58c-2-9.72-10.48-16.06-20.27-16.06a20.08,20.08,0,0,0-20.2,20.34,20.55,20.55,0,0,0,40.54,4.69H190.64A8.8,8.8,0,0,1,182.37,45.57Z"/><polygon class="a" points="222.29 4 210.85 4 210.85 16.75 205.2 16.75 205.2 25.76 210.85 25.76 210.85 55.02 222.29 55.02 222.29 25.76 227.81 25.76 227.81 16.75 222.29 16.75 222.29 4"/><rect class="a" x="232.78" y="16.75" width="11.44" height="38.26"/><polygon class="a" points="276.14 16.75 268.83 40.61 268.7 40.61 261.39 16.75 249.53 16.75 263.25 55.02 274.21 55.02 288 16.75 276.14 16.75"/><circle class="a" cx="104.53" cy="6.45" r="6.45"/><circle class="a" cx="238.5" cy="6.45" r="6.45"/><path class="a" d="M18.72,3A26.39,26.39,0,0,0,0,10.79l8.39,8.39A14.6,14.6,0,1,1,29,39.83l8.39,8.39A26.47,26.47,0,0,0,18.72,3Z"/><path class="a" d="M4.12,29.51A14.6,14.6,0,0,0,29,39.83L8.39,19.18A14.56,14.56,0,0,0,4.12,29.51Z"/></svg>
                    </a>
                </div>
                <ul class="obj-masthead__links">
                    <li class="obj-masthead__links-li"><a href="#">Need Help?</a></li>
                </ul>
            </div>
        </div>
        <div class="obj-nav">
            <div class="obj-nav__panel">
                <div class="obj-nav-group">
                    <div class="obj-nav-tabs">
                        <ul class="obj-nav-tabs__list">
                            <li class="obj-nav-tabs__list-li"><a href="?page=objectiv&tab=general" class="<?php echo $active_tab == 'general' ? 'is-current-tab' : ''; ?>">General</a></li>
                            <li class="obj-nav-tabs__list-li"><a href="?page=objectiv&tab=seo" class="<?php echo $active_tab == 'seo' ? 'is-current-tab' : ''; ?>">SEO</a></li>
                            <li class="obj-nav-tabs__list-li"><a href="?page=objectiv&tab=analytics" class="<?php echo $active_tab == 'analytics' ? 'is-current-tab' : ''; ?>">Analytics</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="obj-body">
            <div class="obj-body__container">
                <form method="post" action="options.php">
                    <?php if ( $active_tab == 'general' ): ?>
                        <div class="obj-body__section">
                            <h3 class="obj-body__section-title">General Options</h3>
                            <ul class="obj-section__list">
                                <?php
                                ob_start();
                                settings_fields( 'objectiv_settings' );
                                do_settings_sections( 'objectiv_settings' );
                                echo ob_get_clean();
                                ?>
                            </ul>
                        </div>
                    <?php elseif ( $active_tab == 'seo' ): ?>
                        <div class="obj-body__section">
                            <h3 class="obj-body__section-title">SEO Options</h3>
                            <ul class="obj-section__list">
                                <?php do_action( 'seo_options' ); ?>
                            </ul>
                        </div>
                    <?php elseif ( $active_tab == 'analytics' ): ?>
                        <div class="obj-body__section">
                            <h3 class="obj-body__section-title">Analytics Options</h3>
                            <ul class="obj-section__list">
                                <?php do_action( 'analytics_options' ); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="obj-body__footer">
                        <?php submit_button( 'Save Options', 'primary', 'submit', false ); ?>
                    </div>
                </form>
            </div>
        </div>
        <div class="obj-footer">
            <div class="obj-footer__container">
                <div class="obj-footer__image">
                    <img src="<?php echo PARENT_THEME_ADMIN_IMAGES_DIR . '2016_headshots_Erik.jpg'; ?>" />
                </div>
                <div class="obj-footer__content">
                    <h4 class="obj-footer__header">Need Help? We are one email away.</h4>
                    <p class="obj-footer__description">We won't ever leave you in the lurch. If you have a question or found a bug with your website, please let us know.</p>
                    <p class="obj-footer__description">
                        <a href="http://objectiv.co/contact" title="Go to Objectiv Support" class="button button-primary">Contact Us</a>
                    </p>
                </div>
            </div>
        </div>
        <?php
    }
}
