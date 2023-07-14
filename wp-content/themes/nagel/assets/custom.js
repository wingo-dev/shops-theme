document.addEventListener("DOMContentLoaded", function () {
  var tabs = document.querySelectorAll(".tab");

  tabs.forEach(function (tab) {
    tab.addEventListener("click", function () {
      var selectedTab = this;
      var tabContents = document.querySelectorAll(".tab-content");

      tabs.forEach(function (tab) {
        tab.classList.remove("active");
      });

      tabContents.forEach(function (content) {
        content.classList.remove("active");
      });

      selectedTab.classList.add("active");
      document
        .getElementById(selectedTab.getAttribute("data-tab"))
        .classList.add("active");
    });
  });

  document
    .getElementById("upload-photo-button")
    .addEventListener("click", function () {
      document.getElementById("upload-photo").click();
    });
});
