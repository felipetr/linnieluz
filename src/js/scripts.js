function checkScrollPosition() {
  const header = document.querySelector("body");
  const logoLink = document.querySelector("a#logo-a");
  const zero = 0;
  if (window.scrollY > zero) {
    header.classList.add("scrolled-header");
    logoLink.addEventListener("click", scrollToTop, { once: true });
  } else {
    header.classList.remove("scrolled-header");
    logoLink.removeEventListener("click", scrollToTop);
  }
}
function scrollToTop(event) {
  event.preventDefault();
  window.scrollTo({
    top: zero,
    behavior: "smooth",
  });
}
window.addEventListener("scroll", checkScrollPosition);
document.addEventListener("DOMContentLoaded", checkScrollPosition);
const siteModal = new bootstrap.Modal(document.getElementById("siteModal"), {});

document.addEventListener("click", function (event) {
  if (event.target.closest(".modal-btn")) {
    const modalBtn = event.target.closest(".modal-btn");

    const modalTitle = modalBtn.querySelector(".modal-title")?.innerHTML;
    const modalContent = modalBtn.querySelector(".modal-content")?.innerHTML;

    const siteModalTitle = document.querySelector("#siteModal .modal-title");
    const siteModalBody = document.querySelector("#siteModal .modal-body");

    if (siteModalTitle) siteModalTitle.innerHTML = modalTitle;
    if (siteModalBody) siteModalBody.innerHTML = modalContent;

    siteModal.show();
  }

});
