<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Morioh.com</title>
        <link rel="icon" href="./favicon.ico">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
        <link rel="stylesheet" href="./fonticon/fonticon.css">
        <link rel="stylesheet" href="./splash-screen.css"> @vite('resources/css/app.css')
    </head>
    <body class="page-loading">
        <!--begin::Theme mode setup on page load-->
        <script>
           /* if (document.documentElement) {
                var defaultThemeMode = "system"; var name = document.body.getAttribute("data-kt-name");
                var themeMode = localStorage.getItem("kt_" + (name ? name + "_" : "") + "theme_mode_value"); if (themeMode === null) {
            if (defaultThemeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            } else {
                themeMode = defaultThemeMode;
            }
            }
                document.documentElement.setAttribute("data-theme", themeMode);
            } */
        </script>
        <!--end::Theme mode setup on page load-->
        <div id="app">
            </div> <!--begin::Loading markup-->
        <div class="splash-screen">
            <img src="./media/logos/default-small.svg" alt="morioh.com" />
            <span>Welcome to Morioh.com ... </span>
        </div>
        <!--end::Loading markup-->
        @vite('resources/ts/app.ts')
    </body>
</html>

