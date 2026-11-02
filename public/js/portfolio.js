'use strict';

const menuButton = document.querySelector('.menu-toggle');
const mobileNav = document.getElementById('mobile-nav');

function closeMenu() {
    if (!menuButton || !mobileNav) return;
    mobileNav.hidden = true;
    menuButton.setAttribute('aria-expanded', 'false');
    menuButton.setAttribute('aria-label', 'Buka navigasi');
}

menuButton?.addEventListener('click', () => {
    const expanded = menuButton.getAttribute('aria-expanded') === 'true';
    mobileNav.hidden = expanded;
    menuButton.setAttribute('aria-expanded', String(!expanded));
    menuButton.setAttribute('aria-label', expanded ? 'Buka navigasi' : 'Tutup navigasi');
});
mobileNav?.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));
document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && mobileNav && !mobileNav.hidden) {
        closeMenu();
        menuButton.focus();
    }
});
window.matchMedia('(min-width: 761px)').addEventListener('change', event => {
    if (event.matches) closeMenu();
});

// Category links retain a real server-rendered URL and work without JavaScript.
const filters = [...document.querySelectorAll('[data-filter]')];
const projects = [...document.querySelectorAll('.project-card')];
const projectGroups = [...document.querySelectorAll('[data-project-group]')];
function applyFilter(category) {
    if (!filters.some(link => link.dataset.filter === category)) category = 'semua';
    filters.forEach(link => {
        const active = link.dataset.filter === category;
        link.classList.toggle('active', active);
        if (active) link.setAttribute('aria-current', 'true');
        else link.removeAttribute('aria-current');
    });
    let count = 0;
    const visibleProjects = new Set();
    projectGroups.forEach(group => {
        group.hidden = category !== 'semua' && group.dataset.projectGroup !== category;
    });
    projects.forEach(project => {
        const show = category === 'semua' || project.dataset.category === category;
        project.hidden = !show;
        if (show) {
            count++;
            visibleProjects.add(project.dataset.projectSlug);
        }
    });
    const counter = document.getElementById('work-count');
    if (counter) counter.textContent = `${visibleProjects.size} karya · ${count} gambar`;
}
filters.forEach(link => link.addEventListener('click', event => {
    if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || event.button !== 0) return;
    event.preventDefault();
    applyFilter(link.dataset.filter);
    history.pushState(null, '', link.href);
}));
window.addEventListener('popstate', () => {
    if (filters.length) applyFilter(new URL(location.href).searchParams.get('kategori') || 'semua');
});

// Service shortcuts select the matching inquiry type.
document.querySelectorAll('[data-service]').forEach(link => link.addEventListener('click', () => {
    const field = document.getElementById('service');
    if (field) field.value = link.dataset.service;
}));

// Bring server validation results into view, including after a redirected POST.
const contactResult = document.querySelector('[data-contact-result]');
if (contactResult) {
    document.getElementById('kontak')?.scrollIntoView();
    const invalid = document.querySelector('[aria-invalid="true"]');
    if (invalid) invalid.focus({ preventScroll: true });
}

if ('IntersectionObserver' in window) {
    const sectionObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            document.querySelectorAll('[data-nav]').forEach(link => {
                link.classList.toggle('active', link.dataset.nav === entry.target.id);
            });
        });
    }, { rootMargin: '-15% 0px -65% 0px' });
    document.querySelectorAll('#karya, #tentang, #layanan, #kontak').forEach(section => sectionObserver.observe(section));
}
