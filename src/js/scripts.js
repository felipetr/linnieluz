function checkScrollPosition() {
  const header = document.querySelector("body");
  const logoLink = document.querySelector("a#logo-a");

  if (window.scrollY > 0) {
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
    top: 0,
    behavior: "smooth",
  });
}
window.addEventListener("scroll", checkScrollPosition);
document.addEventListener("DOMContentLoaded", checkScrollPosition);

document.addEventListener("click", function (event) {
    
    if (event.target.closest(".modal-btn")) {
      const modalBtn = event.target.closest(".modal-btn");
      
      const modalTitle = modalBtn.querySelector(".modal-title")?.innerHTML;
      const modalContent = modalBtn.querySelector(".modal-content")?.innerHTML;
  
      const siteModalTitle = document.querySelector("#siteModal .modal-title");
      const siteModalBody = document.querySelector("#siteModal .modal-body");
  
      if (siteModalTitle) siteModalTitle.innerHTML = modalTitle;
      if (siteModalBody) siteModalBody.innerHTML = modalContent;
      const siteModal = new bootstrap.Modal(document.getElementById("siteModal"), {});
      siteModal.show();
    }
  });
