document.addEventListener("DOMContentLoaded", function () {
  const root = document.documentElement;
  const adminSidebar = document.getElementById("adminSidebar");
  const adminSidebarToggle = document.getElementById("adminSidebarToggle");
  const adminSidebarToggleIcon = document.getElementById(
    "adminSidebarToggleIcon",
  );
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
    return desktopMedia.matches ? !desktopSidebarClosed() : mobileSidebarOpen();
  }

  function updateSidebarButton() {
    if (!adminSidebarToggle) {
      return;
    }

    const expanded = sidebarExpanded();

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

    if (adminSidebarToggleIcon) {
      adminSidebarToggleIcon.className = expanded
        ? "fa fa-angle-left"
        : "fa fa-angle-right";
    }
  }

  function saveDesktopSidebarState(closed) {
    try {
      localStorage.setItem("admin-sidebar-closed", closed ? "true" : "false");
    } catch (error) {}
  }

  function openDesktopSidebar() {
    root.classList.remove("admin-sidebar-closed");
    saveDesktopSidebarState(false);
    updateSidebarButton();
  }

  function closeDesktopSidebar() {
    root.classList.add("admin-sidebar-closed");
    saveDesktopSidebarState(true);
    updateSidebarButton();
  }

  function openMobileSidebar() {
    root.classList.add("admin-sidebar-mobile-open");
    updateSidebarButton();
  }

  function closeMobileSidebar() {
    root.classList.remove("admin-sidebar-mobile-open");
    updateSidebarButton();
  }

  function toggleSidebar() {
    if (desktopMedia.matches) {
      if (desktopSidebarClosed()) {
        openDesktopSidebar();
      } else {
        closeDesktopSidebar();
      }

      return;
    }

    if (mobileSidebarOpen()) {
      closeMobileSidebar();
    } else {
      openMobileSidebar();
    }
  }

  function syncSidebarWithViewport() {
    root.classList.remove("admin-sidebar-mobile-open");

    if (desktopMedia.matches) {
      let closed = false;

      try {
        closed = localStorage.getItem("admin-sidebar-closed") === "true";
      } catch (error) {}

      root.classList.toggle("admin-sidebar-closed", closed);
    } else {
      root.classList.remove("admin-sidebar-closed");
    }

    updateSidebarButton();
  }

  if (adminSidebarToggle) {
    adminSidebarToggle.addEventListener("click", function (event) {
      event.preventDefault();
      event.stopPropagation();

      toggleSidebar();
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

      const willOpen = adminProfileDropdown.classList.contains("hidden");

      adminProfileDropdown.classList.toggle("hidden", !willOpen);

      adminProfileButton.setAttribute(
        "aria-expanded",
        willOpen ? "true" : "false",
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

        const passwordHidden = input.type === "password";

        input.type = passwordHidden ? "text" : "password";
        button.textContent = passwordHidden ? "Tutup" : "Lihat";

        button.setAttribute(
          "aria-label",
          passwordHidden ? "Sembunyikan password" : "Tampilkan password",
        );
      });
    });

  function escapeHtml(value) {
    return value
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  function sourceToEditorHtml(source) {
    const value = String(source || "").replace(/\r\n?/g, "\n");
    const definitions = [
      {
        marker: "***",
        open: "<strong><em>",
        close: "</em></strong>",
        nested: true,
      },
      {
        marker: "**",
        open: "<strong>",
        close: "</strong>",
        nested: true,
      },
      {
        marker: "__",
        open: "<u>",
        close: "</u>",
        nested: true,
      },
      {
        marker: "~~",
        open: "<del>",
        close: "</del>",
        nested: true,
      },
      {
        marker: "`",
        open: "<code>",
        close: "</code>",
        nested: false,
      },
      {
        marker: "*",
        open: "<em>",
        close: "</em>",
        nested: true,
      },
    ];

    function findClosing(text, marker, start) {
      let position = start;

      while (position < text.length) {
        position = text.indexOf(marker, position);

        if (position === -1) {
          return -1;
        }

        if (
          marker === "*" &&
          (text[position - 1] === "*" || text[position + 1] === "*")
        ) {
          position += 1;
          continue;
        }

        return position;
      }

      return -1;
    }

    function parse(text) {
      let html = "";
      let index = 0;

      while (index < text.length) {
        let matched = false;

        for (const definition of definitions) {
          if (!text.startsWith(definition.marker, index)) {
            continue;
          }

          const contentStart = index + definition.marker.length;
          const closing = findClosing(text, definition.marker, contentStart);

          if (closing === -1) {
            continue;
          }

          const inner = text.substring(contentStart, closing);
          const content = definition.nested ? parse(inner) : escapeHtml(inner);

          html += definition.open + content + definition.close;
          index = closing + definition.marker.length;
          matched = true;
          break;
        }

        if (matched) {
          continue;
        }

        const character = text[index];

        html += character === "\n" ? "<br>" : escapeHtml(character);
        index += 1;
      }

      return html;
    }

    return parse(value);
  }

  function wrapFormattedSource(value, marker) {
    if (value === "") {
      return "";
    }

    return value
      .split("\n")
      .map(function (line) {
        return line === "" ? "" : marker + line + marker;
      })
      .join("\n");
  }

  function editorNodeToSource(node) {
    if (node.nodeType === Node.TEXT_NODE) {
      return (node.nodeValue || "").replace(/\u00a0/g, " ");
    }

    if (node.nodeType !== Node.ELEMENT_NODE) {
      return "";
    }

    const element = node;
    const tag = element.tagName.toUpperCase();

    if (tag === "BR") {
      return "\n";
    }

    let value = Array.from(element.childNodes).map(editorNodeToSource).join("");

    if (tag === "STRONG" || tag === "B") {
      value = wrapFormattedSource(value, "**");
    } else if (tag === "EM" || tag === "I") {
      value = wrapFormattedSource(value, "*");
    } else if (tag === "U") {
      value = wrapFormattedSource(value, "__");
    } else if (tag === "DEL" || tag === "S" || tag === "STRIKE") {
      value = wrapFormattedSource(value, "~~");
    } else if (tag === "CODE") {
      value = wrapFormattedSource(value, "`");
    } else if (tag === "SPAN") {
      const style = window.getComputedStyle(element);
      const weight = Number.parseInt(style.fontWeight, 10);
      const bold =
        style.fontWeight === "bold" || (!Number.isNaN(weight) && weight >= 600);
      const italic = style.fontStyle === "italic";
      const decoration = style.textDecorationLine || style.textDecoration || "";

      if (bold) {
        value = wrapFormattedSource(value, "**");
      }

      if (italic) {
        value = wrapFormattedSource(value, "*");
      }

      if (decoration.includes("underline")) {
        value = wrapFormattedSource(value, "__");
      }

      if (decoration.includes("line-through")) {
        value = wrapFormattedSource(value, "~~");
      }
    }

    if (
      (tag === "DIV" || tag === "P") &&
      value !== "" &&
      !value.endsWith("\n")
    ) {
      value += "\n";
    }

    return value;
  }

  document
    .querySelectorAll("[data-editor-toolbar]")
    .forEach(function (toolbar) {
      const targetId = toolbar.getAttribute("data-editor-toolbar");
      const textarea = document.getElementById(targetId);

      if (!textarea || textarea.dataset.richEditorReady === "true") {
        return;
      }

      const editor = document.createElement("div");
      const formatMap = {
        bold: "bold",
        italic: "italic",
        underline: "underline",
        strike: "strikeThrough",
      };

      textarea.dataset.richEditorReady = "true";

      editor.id = targetId + "-rich-editor";
      editor.className = textarea.className;
      editor.setAttribute("contenteditable", "true");
      editor.setAttribute("role", "textbox");
      editor.setAttribute("aria-multiline", "true");
      editor.setAttribute("data-rich-editor", "true");
      editor.setAttribute("data-placeholder", textarea.placeholder || "");
      editor.style.overflowY = "auto";
      editor.style.whiteSpace = "pre-wrap";
      editor.innerHTML = sourceToEditorHtml(textarea.value);

      Array.from(document.querySelectorAll("label")).forEach(function (label) {
        if (label.htmlFor === targetId) {
          label.htmlFor = editor.id;
        }
      });

      textarea.hidden = true;
      textarea.setAttribute("aria-hidden", "true");
      textarea.tabIndex = -1;
      textarea.parentNode.insertBefore(editor, textarea);

      function selectionInsideEditor() {
        const selection = window.getSelection();

        if (!selection || selection.rangeCount === 0) {
          return false;
        }

        const anchor = selection.anchorNode;

        return anchor === editor || editor.contains(anchor);
      }

      function focusEditorAtEnd() {
        editor.focus();

        const selection = window.getSelection();
        const range = document.createRange();

        range.selectNodeContents(editor);
        range.collapse(false);

        selection.removeAllRanges();
        selection.addRange(range);
      }

      function syncSource() {
        let value = Array.from(editor.childNodes)
          .map(editorNodeToSource)
          .join("");

        value = value
          .replace(/\r\n?/g, "\n")
          .replace(/\n{3,}/g, "\n\n")
          .replace(/\n+$/g, "");

        textarea.value = value;
        textarea.dispatchEvent(
          new Event("input", {
            bubbles: true,
          }),
        );
      }

      function updateEmptyState() {
        const empty = (editor.textContent || "").trim() === "";

        editor.setAttribute("data-empty", empty ? "true" : "false");
      }

      function updateToolbarState() {
        const inside = selectionInsideEditor();

        toolbar.querySelectorAll("[data-format]").forEach(function (button) {
          const format = button.getAttribute("data-format");
          const command = formatMap[format];
          let active = false;

          if (inside && command) {
            try {
              active = document.queryCommandState(command);
            } catch (error) {
              active = false;
            }
          }

          button.setAttribute("aria-pressed", active ? "true" : "false");
        });
      }

      toolbar.querySelectorAll("[data-format]").forEach(function (button) {
        button.setAttribute("aria-pressed", "false");

        button.addEventListener("mousedown", function (event) {
          event.preventDefault();
        });

        button.addEventListener("click", function () {
          const format = button.getAttribute("data-format");
          const command = formatMap[format];

          if (!command) {
            return;
          }

          if (!selectionInsideEditor()) {
            focusEditorAtEnd();
          }

          try {
            document.execCommand("styleWithCSS", false, false);
            document.execCommand(command, false, null);
          } catch (error) {
            return;
          }

          syncSource();
          updateEmptyState();
          updateToolbarState();
          editor.focus();
        });
      });

      editor.addEventListener("input", function () {
        syncSource();
        updateEmptyState();
        updateToolbarState();
      });

      editor.addEventListener("paste", function (event) {
        event.preventDefault();

        const clipboard = event.clipboardData || window.clipboardData;
        const text = clipboard ? clipboard.getData("text/plain") : "";

        document.execCommand("insertText", false, text);
      });

      editor.addEventListener("keyup", updateToolbarState);
      editor.addEventListener("mouseup", updateToolbarState);
      editor.addEventListener("focus", updateToolbarState);
      editor.addEventListener("blur", function () {
        syncSource();
        updateEmptyState();
      });

      document.addEventListener("selectionchange", function () {
        if (document.activeElement === editor || selectionInsideEditor()) {
          updateToolbarState();
        }
      });

      if (textarea.form) {
        textarea.form.addEventListener("submit", function () {
          syncSource();
        });
      }

      updateEmptyState();
      syncSource();
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
