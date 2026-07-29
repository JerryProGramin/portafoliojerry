import Alpine from "alpinejs";
import GLightbox from "glightbox";
import "glightbox/dist/css/glightbox.min.css";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

window.Alpine = Alpine;
Alpine.start();

const starfield = document.querySelector("#starfield");
const starContext = starfield?.getContext("2d");
const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
let stars = [];
let starAnimationFrame;

function createStars() {
    if (!starfield || !starContext) return;

    const pixelRatio = Math.min(window.devicePixelRatio || 1, 2);
    const width = window.innerWidth;
    const height = window.innerHeight;
    starfield.width = Math.floor(width * pixelRatio);
    starfield.height = Math.floor(height * pixelRatio);
    starContext.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);

    const amount = Math.min(240, Math.max(80, Math.floor((width * height) / 7500)));
    stars = Array.from({ length: amount }, () => ({
        x: Math.random() * width,
        y: Math.random() * height,
        radius: Math.random() * 1.35 + 0.3,
        alpha: Math.random() * 0.65 + 0.2,
        speed: Math.random() * 0.012 + 0.004,
        phase: Math.random() * Math.PI * 2,
        tone: Math.random(),
    }));
}

function drawStars(time = 0) {
    if (!starfield || !starContext) return;

    const isDark = document.documentElement.dataset.theme === "dark";
    starContext.clearRect(0, 0, window.innerWidth, window.innerHeight);

    stars.forEach((star) => {
        const twinkle = reduceMotion
            ? star.alpha
            : star.alpha * (0.68 + Math.sin(time * star.speed + star.phase) * 0.32);

        if (isDark) {
            starContext.fillStyle = star.tone > 0.72
                ? `rgba(45, 212, 191, ${twinkle})`
                : `rgba(224, 247, 255, ${twinkle})`;
        } else {
            starContext.fillStyle = star.tone > 0.72
                ? `rgba(15, 159, 154, ${twinkle * 0.52})`
                : `rgba(8, 79, 120, ${twinkle * 0.38})`;
        }

        starContext.beginPath();
        starContext.arc(star.x, star.y, star.radius, 0, Math.PI * 2);
        starContext.fill();
    });

    if (!reduceMotion) {
        starAnimationFrame = requestAnimationFrame(drawStars);
    }
}

createStars();
drawStars();

window.addEventListener("resize", () => {
    cancelAnimationFrame(starAnimationFrame);
    createStars();
    drawStars();
});

const themeChoices = document.querySelectorAll("[data-theme-choice]");

function updateThemeButtons() {
    const isDark = document.documentElement.dataset.theme === "dark";

    themeChoices.forEach((button) => {
        const selected = button.dataset.themeChoice === (isDark ? "dark" : "light");
        button.classList.toggle("active", selected);
        button.setAttribute("aria-pressed", String(selected));
    });
}

themeChoices.forEach((button) => {
    button.addEventListener("click", () => {
        const theme = button.dataset.themeChoice;

        if (theme === "dark") {
            document.documentElement.dataset.theme = "dark";
        } else {
            delete document.documentElement.dataset.theme;
        }

        localStorage.setItem("portfolio-theme", theme);
        updateThemeButtons();
    });
});

updateThemeButtons();

const typeFilters = document.querySelectorAll(".type-filter");
const technologyFilters = document.querySelectorAll(".technology-filter");
const projectCards = document.querySelectorAll(".project-card");
const projectSearch = document.querySelector("#project-search");
const projectsEmpty = document.querySelector("#projects-empty");
let selectedType = "all";
let selectedTechnology = "all";

function applyProjectFilters() {
    const search = projectSearch?.value.trim().toLocaleLowerCase("es") ?? "";
    let visibleCount = 0;

    projectCards.forEach((card) => {
        const technologies = card.dataset.technologies?.split(" ") ?? [];
        const matchesType = selectedType === "all" || card.dataset.type === selectedType;
        const matchesTechnology = selectedTechnology === "all"
            || technologies.includes(selectedTechnology);
        const matchesSearch = search === ""
            || card.dataset.search?.toLocaleLowerCase("es").includes(search);
        const visible = matchesType && matchesTechnology && matchesSearch;

        card.hidden = !visible;
        if (visible) visibleCount += 1;
    });

    if (projectsEmpty) projectsEmpty.hidden = visibleCount !== 0;
}

typeFilters.forEach((button) => {
    button.addEventListener("click", () => {
        selectedType = button.dataset.type ?? "all";
        typeFilters.forEach((item) => {
            const selected = item === button;
            item.classList.toggle("active", selected);
            item.setAttribute("aria-pressed", String(selected));
        });
        applyProjectFilters();
    });
});

technologyFilters.forEach((button) => {
    button.addEventListener("click", () => {
        selectedTechnology = button.dataset.technology ?? "all";
        technologyFilters.forEach((item) => {
            const selected = item === button;
            item.classList.toggle("active", selected);
            item.setAttribute("aria-pressed", String(selected));
        });
        applyProjectFilters();
    });
});

projectSearch?.addEventListener("input", applyProjectFilters);

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
