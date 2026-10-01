document.addEventListener("DOMContentLoaded", function () {
  const root = document.documentElement;
  const body = document.body;

  const adminSidebar = document.getElementById("adminSidebar");

  const adminSidebarToggle = document.getElementById("adminSidebarToggle");

  const adminSidebarToggleIcon = document.getElementById(
    "adminSidebarToggleIcon",
  );

  const adminSidebarClose = document.getElementById("adminSidebarClose");

  const mobileAdminBackdrop = document.getElementById("mobileAdminBackdrop");

  const adminProfileButton = document.getElementById("adminProfileButton");

  const adminProfileDropdown = document.getElementById("adminProfileDropdown");

  const desktopMedia = window.matchMedia("(min-width: 1024px)");

  function desktopSidebarClosed() {
    return root.classList.contains("admin-sidebar-closed");
  }

  function mobileSidebarOpen() {
    return root.classList.contains("admin-sidebar-mobile-open");
  }

  function sidebarExpanded() {
    if (desktopMedia.matches) {
      return !desktopSidebarClosed();
    }

    return mobileSidebarOpen();
  }

  function updateSidebarButtons() {
    const expanded = sidebarExpanded();

    if (adminSidebarToggle) {
      adminSidebarToggle.setAttribute(
        "aria-expanded",
        expanded ? "true" : "false",
      );

      adminSidebarToggle.setAttribute(
        "aria-label",
        expanded ? "Tutup sidebar" : "Buka sidebar",
      );

      adminSidebarToggle.setAttribute(
        "title",
        expanded ? "Tutup sidebar" : "Buka sidebar",
      );
    }

    if (adminSidebarToggleIcon) {
      adminSidebarToggleIcon.className = expanded
        ? "fa fa-angle-left"
        : "fa fa-angle-right";
    }

    if (adminSidebarClose) {
      adminSidebarClose.setAttribute(
        "aria-expanded",
        mobileSidebarOpen() ? "true" : "false",
      );
    }
  }

  function saveDesktopSidebarState(closed) {
    try {
      localStorage.setItem("admin-sidebar-closed", closed ? "true" : "false");
    } catch (error) {}
  }

  function openDesktopSidebar(save = true) {
    if (!desktopMedia.matches) {
      return;
    }

    root.classList.remove("admin-sidebar-closed");

    if (save) {
      saveDesktopSidebarState(false);
    }

    updateSidebarButtons();
  }

  function closeDesktopSidebar(save = true) {
    if (!desktopMedia.matches) {
      return;
    }

    root.classList.add("admin-sidebar-closed");

    if (save) {
      saveDesktopSidebarState(true);
    }

    updateSidebarButtons();
  }

  function toggleDesktopSidebar() {
    if (!desktopMedia.matches) {
      return;
    }

    if (desktopSidebarClosed()) {
      openDesktopSidebar();
    } else {
      closeDesktopSidebar();
    }
  }

  function openMobileSidebar() {
    if (desktopMedia.matches) {
      return;
    }

    root.classList.add("admin-sidebar-mobile-open");
    body.classList.add("overflow-hidden");

    updateSidebarButtons();
  }

  function closeMobileSidebar() {
    root.classList.remove("admin-sidebar-mobile-open");
    body.classList.remove("overflow-hidden");

    updateSidebarButtons();
  }

  function toggleMobileSidebar() {
    if (desktopMedia.matches) {
      return;
    }

    if (mobileSidebarOpen()) {
      closeMobileSidebar();
    } else {
      openMobileSidebar();
    }
  }

  function toggleSidebar() {
    if (desktopMedia.matches) {
      toggleDesktopSidebar();
    } else {
      toggleMobileSidebar();
    }
  }

  function syncSidebarWithViewport() {
    root.classList.remove("admin-sidebar-mobile-open");
    body.classList.remove("overflow-hidden");

    if (desktopMedia.matches) {
      let closed = false;

      try {
        closed = localStorage.getItem("admin-sidebar-closed") === "true";
      } catch (error) {}

      root.classList.toggle("admin-sidebar-closed", closed);
    } else {
      root.classList.remove("admin-sidebar-closed");
    }

    updateSidebarButtons();
  }

  if (adminSidebarToggle) {
    adminSidebarToggle.addEventListener("click", function (event) {
      event.preventDefault();
      event.stopPropagation();

      toggleSidebar();
    });
  }

  if (adminSidebarClose) {
    adminSidebarClose.addEventListener("click", function (event) {
      event.preventDefault();
      event.stopPropagation();

      closeMobileSidebar();
    });
  }

  if (mobileAdminBackdrop) {
    mobileAdminBackdrop.addEventListener("click", function () {
      closeMobileSidebar();
    });
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
    desktopMedia.addEventListener("change", syncSidebarWithViewport);
  } else {
    desktopMedia.addListener(syncSidebarWithViewport);
  }

  syncSidebarWithViewport();

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
