$(document).ready(function () {
  // ============= select custom ==========

  const selects = $("select.form-select");

  selects.each((index, item) => {
    const selectBox = $(item)
      .parent()
      .append(`<div class="custom-select"></div>`)
      .find(".custom-select");
    const thisSelect = $(item).detach();
    selectBox.append(thisSelect);
    const dropdown = selectBox
      .append(`<ul class="custom-dropdown"></ul>`)
      .find(".custom-dropdown");
    dropdown.slideUp();
    const options = $(item).find("option");
    options.each((index, item) => {
      if ($(item).prop("selected")) {
        dropdown.append(
          `<li data-val="${item.value}" class="selected-option">${$(
            item
          ).text()}</li>`
        );
      } else {
        dropdown.append(`<li data-val="${item.value}">${$(item).text()}</li>`);
      }
    });

    $(item).on("blur", function (event) {
      dropdown.slideUp();
    });

    dropdown.on("mousedown", function (event) {
      event.stopPropagation();
      dropdown.find("li").removeClass("selected-option");
      $(event.target).addClass("selected-option");
      thisSelect.val($(event.target).data("val"));
      thisSelect.change();
    });

    $(item)
      .on("mousedown", function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).focus();
        dropdown.slideToggle();
      })
      .on("keydown", function (event) {
        if (event.key == "Enter" || event.key == " ") {
          event.stopPropagation();
          event.preventDefault();
          $(this).focus();
          dropdown.slideToggle();
        }
      })
      .on("change", function () {
        dropdown.find("li").removeClass("selected-option");
        options.each((index, item) => {
          if ($(item).prop("selected")) {
            dropdown.find("li")[index].classList.add("selected-option");
          }
        });
      });
  });
});
