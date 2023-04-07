
const logoIcon = document.querySelector("#logo-icon");
const headerId = document.querySelector("#header-id");
const SectionId = document.querySelector("#section-id");
const preLoader = document.querySelector("#pre-loader");
const faqH3 = document.querySelectorAll(".faq-content h3");




window.addEventListener("load", () => {

  preLoader.classList.add('display-none');
  headerId.classList.remove('display-none');
  SectionId.classList.remove('display-none');


  logoIcon.addEventListener('click', e => {
    let a = logoIcon.querySelector('a');
    a.classList.toggle("active");
    $(".main-menu").slideToggle(1500);
    $(".auth").slideToggle(1500);
  });

  
faqH3.forEach((h3) => {
    h3.addEventListener("click", e => {
      let parent = e.target.parentNode;
      let p = parent.querySelector("p");
      let arrow = parent.querySelector("#arrow");
      let style = window.getComputedStyle(p);
      let display = style.getPropertyValue("display");

      $(p).slideToggle(700);

      if (display === "block") {
        arrow.classList.remove("fa-arrow-right");
        arrow.classList.add("fa-arrow-down");
      } else {
        arrow.classList.remove("fa-arrow-down");
        arrow.classList.add("fa-arrow-right");
      }
    });
  });
  



});
const toTop = document.querySelector(".to-top");
window.addEventListener("scroll", () => {
  if (window.pageYOffset > 300) {
    toTop.classList.add("active");
  } else {
    toTop.classList.remove("active");
  }
});



let matches = window.matchMedia("(min-width: 750px)").matches;
matches
  ? (options = { threshold: 0.2, rootMargin: "-80px 0px" })
  : (options = { threshold: 0.4, rootMargin: "0px 0px" });
const planObserver = new IntersectionObserver(
  plansObserver,
  options
);

function plansObserver(entries, planObserver) {
  entries.forEach(entry => {
    if (!entry.isIntersecting) {
      return;
    } else {
      const plan = entry.target;
      plan.classList.add("smooth-flow");
      planObserver.unobserve(plan);
    }
  });
}

let plans = document.querySelectorAll(".pricing-plans");
plans.forEach(plan => {
  planObserver.observe(plan);
});

let assurances = document.querySelectorAll(".assurances .flex div");
assurances.forEach(assurance => {
  planObserver.observe(assurance);
});


let flexMatches = window.matchMedia("(min-width: 913px)").matches;
flexMatches
  ? (options = { threshold: 0.5, rootMargin: "-80px 0px" })
  : (options = { threshold: 1, rootMargin: "-200px 0px" });
const flexObserver = new IntersectionObserver(
  flexsObserver,
  options
);

function flexsObserver(entries, flexObserver) {
  entries.forEach(entry => {
    if (!entry.isIntersecting) {
      return;
    } else {
      const flex = entry.target;
      let font =flex.querySelector('.font');
      let detail = flex.querySelector('.detail');
      font.classList.add("smooth-flow");
      detail.classList.add("smooth-flow");
      flexObserver.unobserve(flex);
    }
  });
}

let flexs = document.querySelectorAll(".how-it-works .flex");
flexs.forEach(flex => {
  flexObserver.observe(flex);
});

let testimonialMatches = window.matchMedia("(min-width: 913px)").matches;

testimonialMatches
  ? (options = { threshold: 0.5, rootMargin: "-80px 0px" })
  : (options = { threshold: 0.4, rootMargin: "-120px 0px" });
const testimonialObserver = new IntersectionObserver(
  testimonialsObserver,
  options
);

function testimonialsObserver(entries, testimonialObserver) {
  entries.forEach(entry => {
    if (!entry.isIntersecting) {
      return;
    } else {
      const testimonial = entry.target;   
      testimonial.classList.add("smooth-flow");      
      testimonialObserver.unobserve(testimonial);
    }
  });
}

let testimonials = document.querySelectorAll(".testimonial-container .testimonial");
testimonials.forEach(testimonial => {
  testimonialObserver.observe(testimonial);
});
