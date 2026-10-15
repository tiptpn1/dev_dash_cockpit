
        $(document).ready(function() {
            function toggleSidebar(forceState) {
                var $sidebar = $('.sidebar');
                var $backdrop = $('#sidebarBackdrop');
                var willOpen = forceState !== undefined ? forceState : !$sidebar.hasClass('open');

                if (willOpen) {
                    $sidebar.addClass('open');
                    $backdrop.addClass('active');
                } else {
                    $sidebar.removeClass('open');
                    $backdrop.removeClass('active');
                }
            }

            // Click menu icon
            $(document).on('click', '#menuIcon', function(e) {
                e.stopPropagation();
                toggleSidebar();
            });

            // Click close button inside sidebar header
            $(document).on('click', '#sidebarCloseBtn', function(e) {
                e.stopPropagation();
                toggleSidebar(false);
            });

            // Click backdrop overlay to close sidebar on mobile
            $(document).on('click', '#sidebarBackdrop', function() {
                toggleSidebar(false);
            });
        });
        $('.sidebar .parent').click(function(event) {
            event.preventDefault();
            var $this = $(this);
            var $submenu = $this.next('.submenu');
            var $icon = $this.find('.toggle-icon');

            // Close all other submenus
            $('.submenu').not($submenu).slideUp();
            $('.sidebar .parent').not($this).removeClass('active');
            $('.toggle-icon').not($icon).removeClass('open');
            $('.parents').removeClass('active');
            $('.parents .toggle-icon').removeClass('open');

            // Toggle the clicked submenu and icon
            $submenu.slideToggle();
            $this.toggleClass('active');
            $icon.toggleClass('open');
        });
        $('.sidebar .parents').click(function(event) {
            event.preventDefault();
            var $this = $(this);
            var $submenu = $this.next('.parents .submenu');
            var $icon = $this.find('.toggle-icon');

            // Close all other submenus
            $('.parents .submenu').not($submenu).slideUp();
            $('.sidebar .parents').not($this).removeClass('active');
            $('.toggle-icon').not($icon).removeClass('open');

            // Toggle the clicked submenu and icon
            $submenu.slideToggle();
            $this.toggleClass('active');
            $icon.toggleClass('open');
        });
    