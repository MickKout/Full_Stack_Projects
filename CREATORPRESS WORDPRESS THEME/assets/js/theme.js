( function () {
    const menuToggle = document.querySelector( '.menu-toggle' );
    const mobileMenu = document.querySelector( '#creatorpress-mobile-menu' );
    const themeButton = document.querySelector( '#creatorpress-color-mode' );
    const storageKey = 'creatorpress-color-mode';

    function setDarkMode( active ) {
        const html = document.documentElement;
        if ( active ) {
            html.classList.add( 'dark' );
            localStorage.setItem( storageKey, 'dark' );
            themeButton?.setAttribute( 'aria-label', 'Switch to light mode' );
            themeButton?.classList.add( 'bg-slate-900', 'text-white' );
            themeButton?.classList.remove( 'bg-slate-100', 'text-slate-950' );
        } else {
            html.classList.remove( 'dark' );
            localStorage.setItem( storageKey, 'light' );
            themeButton?.setAttribute( 'aria-label', 'Switch to dark mode' );
            themeButton?.classList.add( 'bg-slate-100', 'text-slate-950' );
            themeButton?.classList.remove( 'bg-slate-900', 'text-white' );
        }
    }

    function initializeTheme() {
        const stored = localStorage.getItem( storageKey );
        const prefersDark = window.matchMedia( '(prefers-color-scheme: dark)' ).matches;
        const darkMode = stored ? stored === 'dark' : prefersDark;
        setDarkMode( darkMode );
    }

    function toggleMenu() {
        if ( mobileMenu ) {
            const isOpen = mobileMenu.classList.toggle( 'hidden' );
            menuToggle.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );
        }
    }

    if ( menuToggle ) {
        menuToggle.addEventListener( 'click', toggleMenu );
    }

    if ( themeButton ) {
        themeButton.addEventListener( 'click', function () {
            const isDark = document.documentElement.classList.contains( 'dark' );
            setDarkMode( ! isDark );
        } );
    }

    initializeTheme();
} )();
