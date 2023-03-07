// loading animation

gsap.fromTo(
  ".loading_page",
  {
    opacity: 1,
    display: "flex",
  },
  {
    opacity: 0,
    display: "none",
    duration: 1,
    delay: 3,
  }
);

gsap.fromTo(
  ".logo_name",
  {
    y: 50,
    opacity: 0,
  },
  {
    y: 0,
    opacity: 1,
    duration: 2,
    delay: 0.5,
  }
);
