import './bootstrap';
import './permission';
import './article'
import 'toastr/build/toastr.min.css';
import toastr from 'toastr';
// import Swal from 'sweetalert2';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Make jQuery globally available
window.$ = window.jQuery = $;

// Make toastr and Swal globally available
window.toastr = toastr;
window.Swal = Swal;

// Initialize toastr options
toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut"
};

// Register Service Worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('ServiceWorker registration successful');
            })
            .catch(err => {
                console.log('ServiceWorker registration failed: ', err);
            });
    });
}

// Handle Install Prompt
let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;

    // Show install prompt immediately
    Swal.fire({
        title: 'Install TeterERP',
        text: 'Install our app for a better experience!',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Install',
        cancelButtonText: 'Not now'
    }).then((result) => {
        if (result.isConfirmed) {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the install prompt');
                }
                deferredPrompt = null;
            });
        }
    });
});

// Initialize toastr for session messages
$(document).ready(function() {
    if (window.sessionData) {
        if (window.sessionData.success) {
            toastr.success(window.sessionData.success);
        }
        if (window.sessionData.error) {
            toastr.error(window.sessionData.error);
        }
        if (window.sessionData.errors && window.sessionData.errors.length > 0) {
            window.sessionData.errors.forEach(error => {
                toastr.error(error);
            });
        }
    }
});

(function ($) {

    'use strict';

    var language = localStorage.getItem('language');
    // Default Language
    var default_lang = 'en';

    function setLanguage(lang) {
        if (document.getElementById("header-lang-img")) {
            if (lang == 'en') {
                document.getElementById("header-lang-img").src = "build/images/flags/us.jpg";
            } else if (lang == 'sp') {
                document.getElementById("header-lang-img").src = "build/images/flags/spain.jpg";
            }
            else if (lang == 'gr') {
                document.getElementById("header-lang-img").src = "build/images/flags/germany.jpg";
            }
            else if (lang == 'it') {
                document.getElementById("header-lang-img").src = "build/images/flags/italy.jpg";
            }
            else if (lang == 'ru') {
                document.getElementById("header-lang-img").src = "build/images/flags/russia.jpg";
            }
            localStorage.setItem('language', lang);
            language = localStorage.getItem('language');
            getLanguage();
        }
    }

    // Multi language setting
    function getLanguage() {
        (language == null) ? setLanguage(default_lang) : false;
        $.getJSON('assets/lang/' + language + '.json', function (lang) {
            $('html').attr('lang', language);
            $.each(lang, function (index, val) {
                (index === 'head') ? $(document).attr("title", val['title']) : false;
                $("[key='" + index + "']").text(val);
            });
        });
    }

    function initMetisMenu() {
        //metis menu
        $("#side-menu").metisMenu({
            toggle: false,
            doubleTapToGo: true,
            preventDefault: true,
            activeClass: 'mm-active',
            collapseClass: 'mm-collapse',
            collapseInClass: 'mm-show',
            collapsingClass: 'mm-collapsing'
        });

        // Set initial active states based on current URL
        var pageUrl = window.location.href.split(/[?#]/)[0];
        var sidebarLinks = document.querySelectorAll('#sidebar-menu a');

        sidebarLinks.forEach(function(link) {
            if (link.href === pageUrl) {
                link.classList.add('active');
                var parent = link.parentElement;
                while (parent && parent.id !== 'sidebar-menu') {
                    if (parent.tagName === 'LI') {
                        parent.classList.add('mm-active');
                        var submenu = parent.querySelector('.sub-menu');
                        if (submenu) {
                            submenu.setAttribute('aria-expanded', 'true');
                        }
                    }
                    parent = parent.parentElement;
                }
            }
        });
    }

    function initLeftMenuCollapse() {
        $('#vertical-menu-btn').on('click', function (event) {
            event.preventDefault();
            $('body').toggleClass('sidebar-enable');
            if ($(window).width() >= 992) {
                $('body').toggleClass('vertical-collpsed');
            } else {
                $('body').removeClass('vertical-collpsed');
            }
        });
    }

    function initActiveMenu() {
        // === following js will activate the menu in left side bar based on url ====
        $("#sidebar-menu a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("mm-active");
                $(this).parent().parent().addClass("mm-show");
                $(this).parent().parent().prev().addClass("mm-active");
                $(this).parent().parent().parent().addClass("mm-active");
                $(this).parent().parent().parent().parent().addClass("mm-show");
                $(this).parent().parent().parent().parent().parent().addClass("mm-active");

                // Ensure submenu is expanded
                var submenu = $(this).closest('.sub-menu');
                if (submenu.length) {
                    submenu.attr('aria-expanded', 'true');
                }
            }
        });
    }

    function initMenuItemScroll() {
        // focus active menu in left sidebar
        $(document).ready(function () {
            if ($("#sidebar-menu").length > 0 && $("#sidebar-menu .mm-active .active").length > 0) {
                var activeMenu = $("#sidebar-menu .mm-active .active").offset().top;
                if (activeMenu > 300) {
                    activeMenu = activeMenu - 300;
                    $(".vertical-menu .simplebar-content-wrapper").animate({ scrollTop: activeMenu }, "slow");
                }
            }
        });
    }

    function initHoriMenuActive() {
        $(".navbar-nav a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("active");
                $(this).parent().parent().addClass("active");
                $(this).parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().parent().parent().addClass("active");
            }
        });
    }

    function initFullScreen() {
        $('[data-bs-toggle="fullscreen"]').on("click", function (e) {
            e.preventDefault();
            const $icon = $(this).find('i');
            $('body').toggleClass('fullscreen-enable');

            if (!document.fullscreenElement &&
                !document.mozFullScreenElement &&
                !document.webkitFullscreenElement &&
                !document.msFullscreenElement) {
                // Enter fullscreen
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                }
                $icon.removeClass('bx-fullscreen').addClass('bx-exit-fullscreen');
            } else {
                // Exit fullscreen
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
                $icon.removeClass('bx-exit-fullscreen').addClass('bx-fullscreen');
            }
        });

        // Handle fullscreen change events
        function handleFullscreenChange() {
            const $icon = $('[data-bs-toggle="fullscreen"]').find('i');
            if (!document.fullscreenElement &&
                !document.mozFullScreenElement &&
                !document.webkitFullscreenElement &&
                !document.msFullscreenElement) {
                $('body').removeClass('fullscreen-enable');
                $icon.removeClass('bx-exit-fullscreen').addClass('bx-fullscreen');
            } else {
                $('body').addClass('fullscreen-enable');
                $icon.removeClass('bx-fullscreen').addClass('bx-exit-fullscreen');
            }
        }

        document.addEventListener('fullscreenchange', handleFullscreenChange);
        document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
        document.addEventListener('mozfullscreenchange', handleFullscreenChange);
        document.addEventListener('MSFullscreenChange', handleFullscreenChange);
    }

    function initRightSidebar() {
        // right side-bar toggle
        $('.right-bar-toggle').on('click', function (e) {
            $('body').toggleClass('right-bar-enabled');
        });

        $(document).on('click', 'body', function (e) {
            if ($(e.target).closest('.right-bar-toggle, .right-bar').length > 0) {
                return;
            }

            $('body').removeClass('right-bar-enabled');
            return;
        });
    }

    function initDropdownMenu() {
        if (document.getElementById("topnav-menu-content")) {
            var elements = document.getElementById("topnav-menu-content").getElementsByTagName("a");
            for (var i = 0, len = elements.length; i < len; i++) {
                elements[i].onclick = function (elem) {
                    if (elem.target.getAttribute("href") === "#") {
                        elem.target.parentElement.classList.toggle("active");
                        elem.target.nextElementSibling.classList.toggle("show");
                    }
                }
            }
            window.addEventListener("resize", updateMenu);
        }
    }

    function updateMenu() {
        var elements = document.getElementById("topnav-menu-content").getElementsByTagName("a");
        for (var i = 0, len = elements.length; i < len; i++) {
            if (elements[i].parentElement.getAttribute("class") === "nav-item dropdown active") {
                elements[i].parentElement.classList.remove("active");
                if (elements[i].nextElementSibling !== null) {
                    elements[i].nextElementSibling.classList.remove("show");
                }
            }
        }
    }

    function initComponents() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });

        var offcanvasElementList = [].slice.call(document.querySelectorAll('.offcanvas'))
        var offcanvasList = offcanvasElementList.map(function (offcanvasEl) {
            return new bootstrap.Offcanvas(offcanvasEl)
        })
    }

    function initPreloader() {
        $(window).on('load', function () {
            $('#status').fadeOut();
            $('#preloader').delay(350).fadeOut('slow');
        });
    }

    function initSettings() {
        if (window.sessionStorage) {
            // Get theme from data attribute (set by blade template)
            const dbTheme = $('html').attr('data-bs-theme');
            const defaultTheme = dbTheme || 'light';
            
            // Set initial theme
            $('html').attr('data-bs-theme', defaultTheme);
            
            // Update switches based on theme
            if (defaultTheme === 'dark') {
                $("#dark-mode-switch").prop('checked', true);
                $("#light-mode-switch").prop('checked', false);
            } else {
                $("#light-mode-switch").prop('checked', true);
                $("#dark-mode-switch").prop('checked', false);
            }
            
            // Store in session storage
            sessionStorage.setItem("is_visited", `${defaultTheme}-mode-switch`);
        }

        // Theme switcher event handlers
        $("#light-mode-switch, #dark-mode-switch").on("change", function (e) {
            updateThemeSetting(e.target.id);
        });
    }

    function updateThemeSetting(id) {
        // Reset all switches
        $(".theme-choice").prop('checked', false);

        // Set the selected switch
        $("#" + id).prop('checked', true);

        // Get the base URL for assets
        const baseUrl = window.location.origin;

        if (id === "light-mode-switch") {
            $('html').attr('data-bs-theme', 'light');
            $("#bootstrap-style").attr('href', baseUrl + '/build/css/bootstrap.min.css');
            $("#app-style").attr('href', baseUrl + '/build/css/app.min.css');
            sessionStorage.setItem("is_visited", "light-mode-switch");
            
            // Update theme in database
            updateThemeInDatabase('light');
        } else if (id === "dark-mode-switch") {
            $('html').attr('data-bs-theme', 'dark');
            $("#bootstrap-style").attr('href', baseUrl + '/build/css/bootstrap.min.css');
            $("#app-style").attr('href', baseUrl + '/build/css/app.min.css');
            sessionStorage.setItem("is_visited", "dark-mode-switch");
            
            // Update theme in database
            updateThemeInDatabase('dark');
        }
    }

    // Function to update theme in database
    function updateThemeInDatabase(theme) {
        $.ajax({
            url: '/preferences/update-theme',
            method: 'POST',
            data: {
                theme: theme,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (!response.success) {
                    console.error('Failed to update theme');
                } 
            },
            error: function(xhr, status, error) {
                console.error('Error updating theme:', error);
            }
        });
    }

    // Initialize theme on page load
    function initTheme() {
        if (window.sessionStorage) {
            const savedTheme = sessionStorage.getItem("is_visited");
            if (savedTheme) {
                $(".theme-choice").prop('checked', false);
                $("#" + savedTheme).prop('checked', true);
                updateThemeSetting(savedTheme);
            }
        }
    }

    function initLanguage() {
        // Auto Loader
        if (language != null && language !== default_lang)
            setLanguage(language);
        $('.language').on('click', function (e) {
            setLanguage($(this).attr('data-lang'));
        });
    }

    function initCheckAll() {
        $('#checkAll').on('change', function () {
            $('.table-check .form-check-input').prop('checked', $(this).prop("checked"));
        });
        $('.table-check .form-check-input').change(function () {
            if ($('.table-check .form-check-input:checked').length == $('.table-check .form-check-input').length) {
                $('#checkAll').prop('checked', true);
            } else {
                $('#checkAll').prop('checked', false);
            }
        });
    }

    function init() {
        initMetisMenu();
        initLeftMenuCollapse();
        initActiveMenu();
        initMenuItemScroll();
        initHoriMenuActive();
        initFullScreen();
        initRightSidebar();
        initDropdownMenu();
        initComponents();
        initSettings();
        initTheme();
        initLanguage();
        initPreloader();
        Waves.init();
        initCheckAll();
    }

    init();

})(jQuery)
