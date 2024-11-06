function checkScrollPosition() {
    const header = document.querySelector('body');
    const logoLink = document.querySelector('a#logo-a');
  
    if (window.scrollY > 0) {
        header.classList.add('scrolled-header');
        logoLink.addEventListener('click', scrollToTop, { once: true });
    } else {
        header.classList.remove('scrolled-header');
        logoLink.removeEventListener('click', scrollToTop);
    }
}
function scrollToTop(event) {
    event.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}
window.addEventListener('scroll', checkScrollPosition);
document.addEventListener('DOMContentLoaded', checkScrollPosition);
  