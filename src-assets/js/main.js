import ready from './ready.js';
import setScrollbarWidth from 'set-scrollbar-width';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
ready( () => Alpine.start() );

document.addEventListener('alpine:init', () => {
  // Bootstrap for Alpine components goes here
});

// Get scrollbar width for breakout calculations
ready( () => setScrollbarWidth() );

// Open offsite links and PDFs in new window/tab
ready( () => {
    const link_nodes = document.querySelectorAll('a[href]');
    Array.from(link_nodes).filter(
        a => (a.hostname && a.hostname !== location.hostname) || (a.pathname && a.pathname.slice(-4) === '.pdf')
    ).forEach( 
        a => a.setAttribute('target', '_blank') 
    );
} );

