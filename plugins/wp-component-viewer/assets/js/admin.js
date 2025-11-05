/**
 * Admin JavaScript for WP Component Viewer
 */
(function ($) {
    'use strict';

    function init() {
        initSearch();
        initRefreshButton();
        initCodeHighlighting();
        initVariationSelector();
        initTabs();
        initVariationButtons();
        initPreviewColumnsToggle();
        initTabWidthToggle();

        // Re-init after HTMX swaps content
        document.body.addEventListener('htmx:afterSwap', () => {
            initCodeHighlighting();
        });
    }

    /**
     * Initialize search functionality
     */
    function initSearch() {
        $('#component-search').on('input', function () {
            const searchTerm = $(this).val().toLowerCase();

            // Always start by showing everything
            const $components = $('.wp-component-viewer__component');
            const $groups = $('.wp-component-viewer__group');
            $components.show();
            $groups.show();

            if (!searchTerm) {
                // If input is empty, show all and return
                return;
            }

            // Filter components
            $components.each(function () {
                const componentName = $(this).find('a').text().toLowerCase();
                const isMatch = componentName.includes(searchTerm);
                $(this).toggle(isMatch);
            });

            // Show/hide groups based on visible children
            $groups.each(function () {
                const visibleComponents = $(this).find(
                    '.wp-component-viewer__component:visible'
                ).length;
                $(this).toggle(visibleComponents > 0);
            });
        });
    }

    /**
     * Initialize syntax highlighting
     */
    function initCodeHighlighting() {
        // Select all code blocks with our custom class
        document
            .querySelectorAll('code.wp-component-viewer__code-content')
            .forEach((el) => {
                // Decode HTML entities if present
                if (
                    el.innerHTML.includes('&lt;') ||
                    el.innerHTML.includes('&gt;')
                ) {
                    const decoded = el.innerHTML
                        .replace(/&lt;/g, '<')
                        .replace(/&gt;/g, '>')
                        .replace(/&amp;/g, '&')
                        .replace(/&quot;/g, '"')
                        .replace(/&#039;/g, "'");

                    el.textContent = decoded; // Ensure textContent is used, not innerHTML
                }

                // Apply Highlight.js syntax highlighting
                if (typeof hljs !== 'undefined') {
                    hljs.highlightElement(el);
                }
            });
    }

    /**
     * Initialize the refresh button
     */
    function initRefreshButton() {
        $('.wp-component-viewer__refresh-btn').on('click', function (e) {
            if ($(this).attr('href')) return; // Let external links work

            e.preventDefault();
            const $button = $(this);
            const originalText = $button.text();

            $button
                .text(wpComponentViewer.refreshingText)
                .attr('disabled', true);

            $.ajax({
                url: wpComponentViewer.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'scan_components',
                    nonce: wpComponentViewer.nonce,
                },
                success(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        console.error(
                            'Error refreshing components:',
                            response.data
                        );
                        $button.text(originalText).attr('disabled', false);
                    }
                },
                error(xhr, status, error) {
                    console.error('AJAX error:', error);
                    $button.text(originalText).attr('disabled', false);
                },
            });
        });
    }

    /**
     * Toggle variations inside a component block
     */
    function initVariationSelector() {
        document
            .querySelectorAll('.wp-component-variation-selector button')
            .forEach((button) => {
                button.addEventListener('click', function () {
                    const variationId = this.dataset.variation;
                    const componentId = this.closest(
                        '.wp-component-viewer-item'
                    ).dataset.component;

                    this.parentNode
                        .querySelectorAll('button')
                        .forEach((btn) => btn.classList.remove('active'));
                    this.classList.add('active');

                    document
                        .querySelectorAll(
                            `.component-${componentId} .component-variation`
                        )
                        .forEach((variation) => {
                            variation.style.display = 'none';
                        });

                    const active = document.querySelector(
                        `.component-${componentId} .component-variation-${variationId}`
                    );
                    if (active) active.style.display = 'block';
                });
            });
    }

    /**
     * Initialize tab navigation (tab-panel + tab-content)
     */
    function initTabs() {
        const tabNavs = [
            ['.wp-component-viewer__tab', '.wp-component-viewer__tab-panel'],
            [
                '.wp-component-viewer__tab-btn',
                '.wp-component-viewer__tab-content',
            ],
        ];

        tabNavs.forEach(([tabSelector, panelSelector]) => {
            const tabs = document.querySelectorAll(tabSelector);
            const panels = document.querySelectorAll(panelSelector);

            tabs.forEach((button) => {
                button.addEventListener('click', () => {
                    const tab = button.getAttribute('data-tab');

                    tabs.forEach((t) => t.classList.remove('active'));
                    button.classList.add('active');

                    panels.forEach((p) => {
                        p.classList.toggle(
                            'active',
                            p.getAttribute('data-tab') === tab
                        );
                    });
                });
            });
        });
    }

    /**
     * Variation buttons + preview link update
     */
    function initVariationButtons() {
        $('.wp-component-viewer__variation-tab').on('click', function () {
            const $button = $(this);
            const variation = $button.data('variation');
            const component = $button.data('component');

            $('.wp-component-viewer__variation-tab').removeClass('active');
            $button.addClass('active');

            // Update preview link
            const $previewLink = $('.wp-component-viewer__preview-link');
            if ($previewLink.length) {
                const baseUrl =
                    window.location.origin +
                    window.location.pathname.split('/wp-admin')[0];
                $previewLink.attr(
                    'href',
                    `${baseUrl}/components/${encodeURIComponent(
                        component
                    )}/preview/${encodeURIComponent(variation)}`
                );
            }

            $('.wp-component-viewer__variation').each(function () {
                const $variation = $(this);
                $variation.toggleClass(
                    'active',
                    $variation.data('variation') === variation
                );
            });
        });

        // Tabs for variations
        $('.wp-component-viewer__variation-tab').on('click', function () {
            const $tab = $(this);
            const variation = $tab.data('variation');

            $('.wp-component-viewer__variation-tab').removeClass('active');
            $tab.addClass('active');

            $('.wp-component-viewer__variation').each(function () {
                const $v = $(this);
                $v.toggleClass('active', $v.data('variation') === variation);
            });
        });
    }

    /**
     * Initialize preview columns toggle for admin preview
     */
    function initPreviewColumnsToggle() {
        const toggle = document.querySelector(
            '.wp-component-viewer__preview-columns-toggle'
        );
        if (!toggle) return;
        const wrapper = document.querySelector(
            '.wp-component-viewer__preview-columns-wrapper'
        );
        if (!wrapper) return;
        toggle.addEventListener('click', function (e) {
            if (e.target.closest('button')) {
                const btn = e.target.closest('button');
                const cols = btn.getAttribute('data-cols');
                toggle
                    .querySelectorAll('button')
                    .forEach((b) => b.classList.remove('active'));
                btn.classList.add('active');
                wrapper.classList.remove(
                    'wp-component-viewer__preview-columns-1',
                    'wp-component-viewer__preview-columns-2',
                    'wp-component-viewer__preview-columns-3'
                );
                wrapper.classList.add(
                    'wp-component-viewer__preview-columns-' + cols
                );
            }
        });
    }

    /**
     * Initialize tab width toggle for admin preview
     */
    function initTabWidthToggle() {
        const dropdown = document.querySelector(
            '.wp-component-viewer__tab-width-dropdown'
        );
        if (!dropdown) return;
        const toggleBtn = dropdown.querySelector(
            '.wp-component-viewer__tab-width-toggle'
        );
        const icon = toggleBtn.querySelector(
            '.wp-component-viewer__tab-width-toggle-icon'
        );
        const menu = dropdown.querySelector(
            '.wp-component-viewer__tab-width-menu'
        );
        const items = menu.querySelectorAll(
            '.wp-component-viewer__tab-width-menu-item'
        );
        const tabContents = document.querySelectorAll(
            '.wp-component-viewer__preview-columns-wrapper'
        );
        const widthStates = {
            desktop: {
                cls: '',
                svg: '<svg data-width="desktop" width="28" height="28" viewBox="0 0 18 18" fill="none"><rect x="3" y="4" width="12" height="8" rx="2" fill="#0073aa"/><rect x="7" y="13" width="4" height="1.5" rx="0.75" fill="#0073aa"/></svg>',
            },
            tablet: {
                cls: 'wp-component-viewer__tab-width-tablet',
                svg: '<svg data-width="tablet" width="28" height="28" viewBox="0 0 18 18" fill="none"><rect x="4" y="3" width="10" height="12" rx="2" fill="#0073aa"/><rect x="8" y="14" width="2" height="1" rx="0.5" fill="#fff"/></svg>',
            },
            mobile: {
                cls: 'wp-component-viewer__tab-width-mobile',
                svg: '<svg data-width="mobile" width="28" height="28" viewBox="0 0 18 18" fill="none"><rect x="5" y="2.5" width="8" height="13" rx="2" fill="#0073aa"/><rect x="8" y="14.5" width="2" height="1" rx="0.5" fill="#fff"/></svg>',
            },
        };
        let current = 'desktop';

        function applyState(state) {
            tabContents.forEach((tc) => {
                tc.classList.remove(
                    'wp-component-viewer__tab-width-mobile',
                    'wp-component-viewer__tab-width-tablet'
                );
                if (widthStates[state].cls)
                    tc.classList.add(widthStates[state].cls);
            });
            if (icon) icon.innerHTML = widthStates[state].svg;
            items.forEach((item) => {
                item.classList.toggle('active', item.dataset.width === state);
                item.setAttribute(
                    'aria-selected',
                    item.dataset.width === state ? 'true' : 'false'
                );
            });
        }

        // Toggle dropdown menu
        toggleBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const expanded = toggleBtn.getAttribute('aria-expanded') === 'true';
            toggleBtn.setAttribute('aria-expanded', !expanded);
            menu.style.display = expanded ? 'none' : 'block';
        });

        // Select menu item
        items.forEach((item) => {
            item.addEventListener('click', function (e) {
                e.stopPropagation();
                current = item.dataset.width;
                applyState(current);
                menu.style.display = 'none';
                toggleBtn.setAttribute('aria-expanded', 'false');
            });
        });

        // Close dropdown on outside click
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target)) {
                menu.style.display = 'none';
                toggleBtn.setAttribute('aria-expanded', 'false');
            }
        });

        // Set initial state
        applyState(current);
    }

    // Initialize everything once DOM is ready
    $(document).ready(init);
})(jQuery);
