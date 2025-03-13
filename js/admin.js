document.addEventListener("DOMContentLoaded", function () {
  const sections = document.querySelectorAll("main.content section");
  const links = document.querySelectorAll(".sidebar ul li a");

  function showSection(sectionId) {
    sections.forEach((section) => (section.style.display = "none"));

    const activeSection = document.getElementById(sectionId);

    if (activeSection) {
      activeSection.style.display = "block";
    } else {
      console.warn(
        `Section with ID "${sectionId}" not found! Defaulting to "products".`
      );
      localStorage.setItem("activeSection", "products");
      document.getElementById("products").style.display = "block";
    }

    links.forEach((link) => link.classList.remove("active"));

    const activeLink = document.querySelector(
      `.sidebar ul li a[href="#${sectionId}"]`
    );
    if (activeLink) {
      activeLink.classList.add("active");
    }

    localStorage.setItem("activeSection", sectionId);
  }

  const savedSection = localStorage.getItem("activeSection") || "products";
  showSection(savedSection);

  links.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      const targetId = this.getAttribute("href").substring(1);
      showSection(targetId);
    });
  });
});
