$(function () {

    // Toggle dropdown
    // Click: Toggle pinned state
    $(document).on('click', '.category-dropdown > a', function (e) {
        e.stopPropagation();

        const $dropdown = $(this).closest('.category-dropdown');

        if ($dropdown.hasClass('clicked-open')) {
            $dropdown.removeClass('clicked-open');
            closeMenu($dropdown);
        } else {
            // Close all other dropdowns
            $('.category-dropdown.clicked-open').each(function () {
                $(this).removeClass('clicked-open');
                closeMenu($(this));
            });

            $dropdown.addClass('clicked-open');
            openMenu($dropdown);
        }
    });

    // Hover
    $(document).on('mouseenter', '.category-dropdown', function () {
        openMenu($(this));
    });

    // Leave
    $(document).on('mouseleave', '.category-dropdown', function () {
        // Don't close if it was opened by click
        if (!$(this).hasClass('clicked-open')) {
            closeMenu($(this));
        }
    });

    // Outside click
    $(document).on('click', function () {
        $('.category-dropdown.clicked-open').each(function () {
            $(this).removeClass('clicked-open');
            closeMenu($(this));
        });
    });

    // Close when clicking outside
    $(document).on('click', function () {
        $('.category-dropdown').each(function () {
            closeMenu($(this));
        });
    });

    // Prevent closing when clicking inside menu
    $(document).on('click', '.categoryDropdownMenu', function (e) {
        e.stopPropagation();
    });

    // Close on ESC
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            $('.category-dropdown').each(function () {
                closeMenu($(this));
            });
        }
    });

    function openMenu($dropdown) {
        const $menu = $dropdown.find('.categoryDropdownMenu');
        const $button = $dropdown.children('a');
        const $chevron = $dropdown.find('.categoryChevronIcon');

        $menu.removeClass('hidden');

        setTimeout(function () {
            $menu.removeClass('opacity-0 -translate-y-2')
                .addClass('opacity-100 translate-y-0');
        }, 10);

        $button.addClass('bg-navy-800 text-white shadow-md');
        $chevron.addClass('rotate-180');
    }

    function closeMenu($dropdown) {
        const $menu = $dropdown.find('.categoryDropdownMenu');
        const $button = $dropdown.children('a');
        const $chevron = $dropdown.find('.categoryChevronIcon');

        $menu.removeClass('opacity-100 translate-y-0')
            .addClass('opacity-0 -translate-y-2');

        $button.removeClass('bg-navy-800 text-white shadow-md');
        $chevron.removeClass('rotate-180');

        setTimeout(function () {
            $menu.addClass('hidden');
        }, 200);
    }

});
