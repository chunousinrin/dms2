$(function () {
    Fancybox.bind("[data-fancybox]", {
        mainClass: "pdf-fancybox",
        dragToClose: false,
        Navigation: false,
        Html: {
            iframeAttr: {
                allow: "autoplay; fullscreen",
            },
        },
    });
});
