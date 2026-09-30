document.addEventListener("DOMContentLoaded", function () {
  const body = document.body;
  const adminProfileButton = document.getElementById("adminProfileButton");
  const adminProfileDropdown = document.getElementById("adminProfileDropdown");
  const mobileAdminToggle = document.getElementById("mobileAdminToggle");
  const mobileAdminClose = document.getElementById("mobileAdminClose");
  const mobileAdminBackdrop = document.getElementById("mobileAdminBackdrop");
  const adminSidebar = document.getElementById("adminSidebar");

  function bukaMenuAdmin() {
    if (!adminSidebar || !mobileAdminBackdrop) {
      return;
    }

    adminSidebar.classList.remove("-translate-x-full");
    adminSidebar.classList.add("translate-x-0");
    mobileAdminBackdrop.classList.remove("hidden");
    body.classList.add("overflow-hidden");
  }

  function tutupMenuAdmin() {
    if (!adminSidebar || !mobileAdminBackdrop) {
      return;
    }

    adminSidebar.classList.remove("translate-x-0");
    adminSidebar.classList.add("-translate-x-full");
    mobileAdminBackdrop.classList.add("hidden");
    body.classList.remove("overflow-hidden");
  }

  if (mobileAdminToggle && adminSidebar && mobileAdminBackdrop) {
    mobileAdminToggle.addEventListener("click", function (event) {
      event.stopPropagation();

      if (adminSidebar.classList.contains("translate-x-0")) {
        tutupMenuAdmin();
      } else {
        bukaMenuAdmin();
      }
    });

    mobileAdminBackdrop.addEventListener("click", tutupMenuAdmin);

    if (mobileAdminClose) {
      mobileAdminClose.addEventListener("click", function (event) {
        event.stopPropagation();
        tutupMenuAdmin();
      });
    }

    adminSidebar.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        if (window.innerWidth < 1024) {
          tutupMenuAdmin();
        }
      });
    });

    window.addEventListener("resize", function () {
      if (window.innerWidth >= 1024) {
        tutupMenuAdmin();
      }
    });
  }

  if (adminProfileButton && adminProfileDropdown) {
    adminProfileButton.addEventListener("click", function (event) {
      event.stopPropagation();

      const sedangTerbuka = !adminProfileDropdown.classList.contains("hidden");

      adminProfileDropdown.classList.toggle("hidden");
      adminProfileButton.setAttribute(
        "aria-expanded",
        sedangTerbuka ? "false" : "true",
      );
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

    tutupMenuAdmin();
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

        const sedangPassword = input.type === "password";

        input.type = sedangPassword ? "text" : "password";
        button.textContent = sedangPassword ? "Tutup" : "Lihat";
        button.setAttribute(
          "aria-label",
          sedangPassword ? "Sembunyikan password" : "Tampilkan password",
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
