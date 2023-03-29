(function ($) {
  let direction = getUrlParams("dir");
  if (direction != "rtl") {
    direction = "ltr";
  }

  $("#darkmode-btn").on("click", function (event) {
    this.classList.toggle("switch-to-dark");
    console.log(this);
    let dezSettingOptions = {};
    if (body.attr("data-theme-version") == "light") {
      //   this.typography = typography || "roboto";
      //   this.version = version || "light";
      //   this.layout = layout || "vertical";
      //   this.navheaderBg = navheaderBg || "color_1";
      //   this.headerBg = headerBg || "color_1";
      //   this.sidebarStyle = sidebarStyle || "full";
      //   this.sidebarBg = sidebarBg || "color_1";
      //   this.sidebarPosition = sidebarPosition || "static";
      //   this.headerPosition = headerPosition || "static";
      //   this.containerLayout = containerLayout || "wide";
      //   this.direction = direction || "rtl";
      //   this.primary = primary || "color_1";

      dezSettingOptions = {
        typography: "roboto",
        version: "dark",
        layout: "Vertical",
        headerBg: "color_1",
        navheaderBg: "color_1",
        sidebarBg: "color_1",
        sidebarStyle: "mini",
        sidebarPosition: "fixed",
        headerPosition: "fixed",
        containerLayout: "full",
        direction: direction,
      };
    } else {
      dezSettingOptions = {
        typography: "roboto",
        version: "light",
        layout: "Vertical",
        headerBg: "color_1",
        navheaderBg: "color_3",
        sidebarBg: "color_3",
        sidebarStyle: "mini",
        sidebarPosition: "fixed",
        headerPosition: "fixed",
        containerLayout: "full",
        direction: direction,
        primary: "color_1",
      };
    }

    new dezSettings(dezSettingOptions);
    jQuery(window).on("resize", function () {
      new dezSettings(dezSettingOptions);
    });
  });
})(jQuery);
