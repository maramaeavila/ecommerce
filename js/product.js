var swiper = new Swiper(".swiper-container", {
  slidesPerView: "auto",
  spaceBetween: 5,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    768: {
      slidesPerView: 4,
    },
    576: {
      slidesPerView: 2,
    },
    0: {
      slidesPerView: 1,
    },
  },
});

$("#categories .box-area").slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 1000,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
      },
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
      },
    },
  ],
});

function filterProducts(category) {
  let allProducts = document.querySelectorAll(".prod");
  allProducts.forEach((product) => {
    product.style.display = "none";

    if (
      product.classList.contains(category.toLowerCase()) ||
      product.querySelector(".prod-title").innerText === category
    ) {
      product.style.display = "block";
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  let section = document.querySelectorAll("section");
  let navLinks = document.querySelectorAll("nav a");

  window.onscroll = () => {
    section.forEach((sec) => {
      let top = window.scrollY;
      let offset = sec.offsetTop;
      let height = sec.offsetHeight;
      let id = sec.getAttribute("id");

      if (top >= offset && top < offset + height) {
        navLinks.forEach((links) => {
          links.classList.remove("active");
          document
            .querySelector("nav a[href*=" + id + "]")
            .classList.add("active");
        });
      }
    });
  };
});
