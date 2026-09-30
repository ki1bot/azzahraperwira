document.addEventListener("DOMContentLoaded", function () {
  const root = document.documentElement;
  const body = document.body;

  const adminProfileButton = document.getElementById("adminProfileButton");

  const adminProfileDropdown = document.getElementById("adminProfileDropdown");

  const adminSidebar = document.getElementById("adminSidebar");

  const adminSidebarToggle = document.getElementById("adminSidebarToggle");

  const adminSidebarToggleIcon = document.getElementById(
    "adminSidebarToggleIcon",
  );

  const mobileAdminBackdrop = document.getElementById("mobileAdminBackdrop");

  const desktopMedia = window.matchMedia("(min-width: 1024px)");

  function updateToggleButton() {
    if (!adminSidebarToggle || !adminSidebarToggleIcon) {
      return;
    }

    if (desktopMedia.matches) {
      const closed = root.classList.contains("admin-sidebar-closed");

      adminSidebarToggleIcon.className = closed
        ? "fa fa-angle-right"
        : "fa fa-angle-left";

      adminSidebarToggle.setAttribute(
        "aria-label",
        closed ? "Buka sidebar" : "Tutup sidebar",
      );

      adminSidebarToggle.setAttribute(
        "title",
        closed ? "Buka sidebar" : "Tutup sidebar",
      );

      adminSidebarToggle.setAttribute(
        "aria-expanded",
        closed ? "false" : "true",
      );

      return;
    }

    const opened = root.classList.contains("admin-sidebar-mobile-open");

    adminSidebarToggleIcon.className = opened ? "fa fa-times" : "fa fa-bars";

    adminSidebarToggle.setAttribute(
      "aria-label",
      opened ? "Tutup menu" : "Buka menu",
    );

    adminSidebarToggle.setAttribute(
      "title",
      opened ? "Tutup menu" : "Buka menu",
    );

    adminSidebarToggle.setAttribute("aria-expanded", opened ? "true" : "false");
  }

  function setDesktopSidebar(closed, save = true) {
    if (!desktopMedia.matches) {
      return;
    }

    root.classList.toggle("admin-sidebar-closed", closed);

    if (save) {
      try {
        localStorage.setItem("admin-sidebar-closed", closed ? "true" : "false");
      } catch (error) {}
    }

    updateToggleButton();
  }

  function openMobileSidebar() {
    if (desktopMedia.matches) {
      return;
    }

    root.classList.add("admin-sidebar-mobile-open");

    body.classList.add("overflow-hidden");

    updateToggleButton();
  }

  function closeMobileSidebar() {
    root.classList.remove("admin-sidebar-mobile-open");

    body.classList.remove("overflow-hidden");

    updateToggleButton();
  }

  function syncSidebar() {
    root.classList.remove("admin-sidebar-mobile-open");

    body.classList.remove("overflow-hidden");

    if (desktopMedia.matches) {
      let closed = false;

      try {
        closed = localStorage.getItem("admin-sidebar-closed") === "true";
      } catch (error) {}

      setDesktopSidebar(closed, false);

      return;
    }

    root.classList.remove("admin-sidebar-closed");

    updateToggleButton();
  }

  if (adminSidebarToggle && adminSidebar) {
    adminSidebarToggle.addEventListener("click", function (event) {
      event.stopPropagation();

      if (desktopMedia.matches) {
        const closed = root.classList.contains("admin-sidebar-closed");

        setDesktopSidebar(!closed);

        return;
      }

      if (root.classList.contains("admin-sidebar-mobile-open")) {
        closeMobileSidebar();
      } else {
        openMobileSidebar();
      }
    });
  }

  if (mobileAdminBackdrop) {
    mobileAdminBackdrop.addEventListener("click", closeMobileSidebar);
  }

  if (adminSidebar) {
    adminSidebar.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        if (!desktopMedia.matches) {
          closeMobileSidebar();
        }
      });
    });
  }

  if (typeof desktopMedia.addEventListener === "function") {
    desktopMedia.addEventListener("change", syncSidebar);
  } else {
    desktopMedia.addListener(syncSidebar);
  }

  syncSidebar();

  if (adminProfileButton && adminProfileDropdown) {
    adminProfileButton.addEventListener("click", function (event) {
      event.stopPropagation();

      const open = !adminProfileDropdown.classList.contains("hidden");

      adminProfileDropdown.classList.toggle("hidden");

      adminProfileButton.setAttribute("aria-expanded", open ? "false" : "true");
    });

    document.addEventListener("click", function (event) {
      if (
        !adminProfileDropdown.contains(event.target) &&
        !adminProfileButton.contains(event.target)
      ) {
        adminProfileDropdown.classList.add("hidden");

        adminProfileButton.setAttribute("aria-expanded", "false");
      }
    });
  }

  document.addEventListener("keydown", function (event) {
    if (event.key !== "Escape") {
      return;
    }

    if (adminProfileDropdown) {
      adminProfileDropdown.classList.add("hidden");
    }

    if (adminProfileButton) {
      adminProfileButton.setAttribute("aria-expanded", "false");
    }

    if (!desktopMedia.matches) {
      closeMobileSidebar();
    }
  });

  document
    .querySelectorAll("[data-toggle-password]")
    .forEach(function (button) {
      button.addEventListener("click", function () {
        const inputId = button.getAttribute("data-toggle-password");

        const input = document.getElementById(inputId);

        if (!input) {
          return;
        }

        const password = input.type === "password";

        input.type = password ? "text" : "password";

        button.textContent = password ? "Tutup" : "Lihat";

        button.setAttribute(
          "aria-label",
          password ? "Sembunyikan password" : "Tampilkan password",
        );
      });
    });

  document
    .querySelectorAll("[data-editor-toolbar]")
    .forEach(function (toolbar) {
      const targetId = toolbar.getAttribute("data-editor-toolbar");

      const textarea = document.getElementById(targetId);

      if (!textarea) {
        return;
      }

      const formatMap = {
        bold: ["**", "**", "teks tebal"],
        italic: ["*", "*", "teks miring"],
        underline: ["__", "__", "teks bergaris bawah"],
        strike: ["~~", "~~", "teks dicoret"],
      };

      toolbar.querySelectorAll("[data-format]").forEach(function (button) {
        button.addEventListener("click", function () {
          const format = button.getAttribute("data-format");

          const config = formatMap[format];

          if (!config) {
            return;
          }

          const start = textarea.selectionStart;

          const end = textarea.selectionEnd;

          const selected = textarea.value.substring(start, end);

          const text = selected || config[2];

          const replacement = config[0] + text + config[1];

          textarea.value =
            textarea.value.substring(0, start) +
            replacement +
            textarea.value.substring(end);

          textarea.focus();

          textarea.selectionStart = start + config[0].length;

          textarea.selectionEnd = start + config[0].length + text.length;

          textarea.dispatchEvent(
            new Event("input", {
              bubbles: true,
            }),
          );
        });
      });
    });

  document
    .querySelectorAll("[data-file-name-target]")
    .forEach(function (input) {
      input.addEventListener("change", function () {
        const targetId = input.getAttribute("data-file-name-target");

        const target = document.getElementById(targetId);

        const file = input.files && input.files[0] ? input.files[0] : null;

        if (target) {
          target.textContent = file ? file.name : "Belum ada file baru dipilih";
        }

        const previewId = input.getAttribute("data-image-preview");

        if (!previewId || !file || !file.type.startsWith("image/")) {
          return;
        }

        const preview = document.getElementById(previewId);

        if (!preview) {
          return;
        }

        const objectUrl = URL.createObjectURL(file);

        const image = document.createElement("img");

        image.src = objectUrl;

        image.alt = "Pratinjau gambar baru";

        image.className = "h-full max-h-80 w-full rounded-lg object-contain";

        image.onload = function () {
          URL.revokeObjectURL(objectUrl);
        };

        preview.innerHTML = "";

        preview.appendChild(image);
      });
    });
});
