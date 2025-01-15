document.addEventListener("DOMContentLoaded", () => {
    // Toggle visibility of semesters
    document.querySelectorAll(".toggle-year").forEach((btn) => {
      btn.addEventListener("click", () => {
        const semesters = btn.nextElementSibling;
        semesters.style.display = semesters.style.display === "block" ? "none" : "block";
      });
    });
  
    // Toggle visibility of subjects
    document.querySelectorAll(".toggle-semester").forEach((btn) => {
      btn.addEventListener("click", () => {
        const subjects = btn.nextElementSibling;
        subjects.style.display = subjects.style.display === "block" ? "none" : "block";
      });
    });
  });
  