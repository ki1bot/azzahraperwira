document.addEventListener("DOMContentLoaded", function () {
  const root = document.documentElement;
  const body = document.body;

  const adminSidebar = document.getElementById("adminSidebar");

  const adminSidebarOpen = document.getElementById("adminSidebarOpen");

  const adminSidebarClose = document.getElementById("adminSidebarClose");

  const mobileAdminBackdrop = document.getElementById("mobileAdminBackdrop");

  const adminProfileButton = document.getElementById("adminProfileButton");

  const adminProfileDropdown = document.getElementById("adminProfileDropdown");

  const desktopMedia = window.matchMedia("(min-width: 1024px)");

  function updateSidebarButtons() {
    const desktopClosed = root.classList.contains("admin-sidebar-closed");

    const mobileOpen = root.classList.contains("admin-sidebar-mobile-open");

    if (adminSidebarOpen) {
      const expanded = desktopMedia.matches ? !desktopClosed : mobileOpen;

      adminSidebarOpen.setAttribute(
        "aria-expanded",
        expanded ? "true" : "false",
      );
    }

    if (adminSidebarClose) {
      adminSidebarClose.setAttribute(
        "aria-expanded",
        desktopMedia.matches
          ? desktopClosed
            ? "false"
            : "true"
          : mobileOpen
            ? "true"
            : "false",
      );
    }
  }

  function closeDesktopSidebar(save = true) {
    if (!desktopMedia.matches) {
      return;
    }

    root.classList.add("admin-sidebar-closed");

    if (save) {
      try {
        localStorage.setItem("admin-sidebar-closed", "true");
      } catch (error) {}
    }

    updateSidebarButtons();
  }

  function openDesktopSidebar(save = true) {
    if (!desktopMedia.matches) {
      return;
    }

    root.classList.remove("admin-sidebar-closed");

    if (save) {
      try {
        localStorage.setItem("admin-sidebar-closed", "false");
      } catch (error) {}
    }

    updateSidebarButtons();
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

  if (adminSidebarOpen) {
    adminSidebarOpen.addEventListener("click", function (event) {
      event.stopPropagation();

      if (desktopMedia.matches) {
        openDesktopSidebar();

        return;
      }

      openMobileSidebar();
    });
  }

  if (adminSidebarClose) {
    adminSidebarClose.addEventListener("click", function (event) {
      event.stopPropagation();

      if (desktopMedia.matches) {
        closeDesktopSidebar();

        return;
      }

      closeMobileSidebar();
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
