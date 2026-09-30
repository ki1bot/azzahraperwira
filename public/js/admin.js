(function () {
  const temaTersimpan = localStorage.getItem("tema-admin-yayasan");
  const tema = temaTersimpan === "dark" ? "dark" : "light";
  document.documentElement.setAttribute("data-admin-theme", tema);
})();

document.addEventListener("DOMContentLoaded", function () {
  const html = document.documentElement;
  const body = document.body;
  const tombolTema = document.getElementById("themeToggle");
  const teksTema = document.getElementById("themeText");
  const ikonTema = document.getElementById("themeIcon");
  const adminProfileButton = document.getElementById("adminProfileButton");
  const adminProfileDropdown = document.getElementById("adminProfileDropdown");
  const mobileAdminToggle = document.getElementById("mobileAdminToggle");
  const mobileAdminClose = document.getElementById("mobileAdminClose");
  const mobileAdminBackdrop = document.getElementById("mobileAdminBackdrop");
  const adminSidebar = document.getElementById("adminSidebar");

  function setTemaAdmin(tema) {
    const temaAktif = tema === "dark" ? "dark" : "light";

    html.setAttribute("data-admin-theme", temaAktif);
    localStorage.setItem("tema-admin-yayasan", temaAktif);

    if (teksTema) {
      teksTema.textContent =
        temaAktif === "dark" ? "Mode Terang" : "Mode Gelap";
    }

    if (ikonTema) {
      ikonTema.className =
        temaAktif === "dark" ? "fa fa-sun-o" : "fa fa-moon-o";
    }
  }

  function bukaMenuAdmin() {
    if (!adminSidebar || !mobileAdminBackdrop) {
      return;
    }

    adminSidebar.classList.add("is-open");
    mobileAdminBackdrop.classList.add("is-open");
    body.classList.add("admin-menu-open");
  }

  function tutupMenuAdmin() {
    if (!adminSidebar || !mobileAdminBackdrop) {
      return;
    }

    adminSidebar.classList.remove("is-open");
    mobileAdminBackdrop.classList.remove("is-open");
    body.classList.remove("admin-menu-open");
  }

  setTemaAdmin(html.getAttribute("data-admin-theme") || "light");

  if (tombolTema) {
    tombolTema.addEventListener("click", function () {
      const temaAktif = html.getAttribute("data-admin-theme");

      setTemaAdmin(temaAktif === "dark" ? "light" : "dark");
    });
  }

  if (mobileAdminToggle && adminSidebar && mobileAdminBackdrop) {
    mobileAdminToggle.addEventListener("click", function (event) {
      event.stopPropagation();

      if (adminSidebar.classList.contains("is-open")) {
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
        if (window.innerWidth <= 1100) {
          tutupMenuAdmin();
        }
      });
    });

    window.addEventListener("resize", function () {
      if (window.innerWidth > 1100) {
        tutupMenuAdmin();
      }
    });
  }

  if (adminProfileButton && adminProfileDropdown) {
    adminProfileButton.addEventListener("click", function (event) {
      event.stopPropagation();

      adminProfileDropdown.classList.toggle("show");
    });

    document.addEventListener("click", function (event) {
      if (
        !adminProfileDropdown.contains(event.target) &&
        !adminProfileButton.contains(event.target)
      ) {
        adminProfileDropdown.classList.remove("show");
      }
    });
  }

  document.addEventListener("keydown", function (event) {
    if (event.key !== "Escape") {
      return;
    }

    if (adminProfileDropdown) {
      adminProfileDropdown.classList.remove("show");
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
        image.className = "preview-img";

        image.onload = function () {
          URL.revokeObjectURL(objectUrl);
        };

        preview.innerHTML = "";
        preview.appendChild(image);
      });
    });
});
