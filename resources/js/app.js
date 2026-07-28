import Alpine from "alpinejs";
import GLightbox from "glightbox";
import "glightbox/dist/css/glightbox.min.css";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

window.Alpine = Alpine;
Alpine.start();

const themeToggle = document.querySelector("#theme-toggle");
const menuToggle = document.querySelector("#menu-toggle");
const navigation = document.querySelector("#main-navigation");

function closeMobileMenu() {
    navigation?.classList.remove("open");
    menuToggle?.setAttribute("aria-expanded", "false");
    menuToggle?.setAttribute("aria-label", "Abrir menú");

    const icon = menuToggle?.querySelector("i");
    icon?.classList.add("fa-bars");
    icon?.classList.remove("fa-xmark");
}

menuToggle?.addEventListener("click", () => {
    const willOpen = !navigation?.classList.contains("open");
    navigation?.classList.toggle("open", willOpen);
    menuToggle.setAttribute("aria-expanded", String(willOpen));
    menuToggle.setAttribute("aria-label", willOpen ? "Cerrar menú" : "Abrir menú");

    const icon = menuToggle.querySelector("i");
    icon?.classList.toggle("fa-bars", !willOpen);
    icon?.classList.toggle("fa-xmark", willOpen);
});

navigation?.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", closeMobileMenu);
});

document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") closeMobileMenu();
});

document.addEventListener("click", (event) => {
    if (
        navigation?.classList.contains("open") &&
        !navigation.contains(event.target) &&
        !menuToggle?.contains(event.target)
    ) {
        closeMobileMenu();
    }
});

function updateThemeButton() {
    if (!themeToggle) return;

    const isDark = document.documentElement.dataset.theme === "dark";
    const icon = themeToggle.querySelector("i");
    icon?.classList.toggle("fa-moon", !isDark);
    icon?.classList.toggle("fa-sun", isDark);
    themeToggle.setAttribute(
        "aria-label",
        isDark ? "Activar modo claro" : "Activar modo oscuro"
    );
}

themeToggle?.addEventListener("click", () => {
    const isDark = document.documentElement.dataset.theme === "dark";

    if (isDark) {
        delete document.documentElement.dataset.theme;
        localStorage.setItem("portfolio-theme", "light");
    } else {
        document.documentElement.dataset.theme = "dark";
        localStorage.setItem("portfolio-theme", "dark");
    }

    updateThemeButton();
});

updateThemeButton();

const filterButtons = document.querySelectorAll(".filter-button");
const projectCards = document.querySelectorAll(".project-card");

filterButtons.forEach((button) => {
    button.addEventListener("click", () => {
        const filter = button.dataset.filter;

        filterButtons.forEach((item) => {
            const selected = item === button;
            item.classList.toggle("active", selected);
            item.setAttribute("aria-pressed", String(selected));
        });

        projectCards.forEach((card) => {
            const technologies = card.dataset.technologies?.split(" ") ?? [];
            const visible = filter === "all" || technologies.includes(filter);
            card.hidden = !visible;
        });
    });
});

GLightbox({
    selector: ".project-gallery",
    touchNavigation: true,
    loop: true,
});

const navigationItems = document.querySelectorAll(".navigation li[data-section]");
const sections = document.querySelectorAll("section[id]");

const sectionObserver = new IntersectionObserver(
    (entries) => {
        const visible = entries
            .filter((entry) => entry.isIntersecting)
            .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

        if (!visible) return;

        const activeSection = visible.target.id === "stack"
            ? "inicio"
            : visible.target.id;

        navigationItems.forEach((item) => {
            item.classList.toggle("active", item.dataset.section === activeSection);
        });
    },
    { rootMargin: "-20% 0px -55% 0px", threshold: [0.1, 0.25, 0.5] }
);

sections.forEach((section) => sectionObserver.observe(section));

if (!window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    gsap.registerPlugin(ScrollTrigger);

    gsap.from(".hero-text > *", {
        opacity: 0,
        y: 24,
        duration: 0.65,
        stagger: 0.09,
        ease: "power2.out",
    });

    gsap.from(".avatar", {
        opacity: 0,
        scale: 0.88,
        duration: 0.8,
        ease: "back.out(1.4)",
    });

    gsap.utils.toArray(".reveal").forEach((element) => {
        gsap.from(element, {
            opacity: 0,
            y: 34,
            duration: 0.65,
            ease: "power2.out",
            scrollTrigger: {
                trigger: element,
                start: "top 88%",
                once: true,
            },
        });
    });
}
