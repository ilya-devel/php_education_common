<!DOCTYPE html>
<html class="h-100">

<head>
    <title>{{ title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/main.js"></script>
</head>

<body class="h-100 d-flex flex-column">
    <!-- {{ xdebug | raw }} -->

    <div class="container header">
        <header
            class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <div class="col-md-3 mb-2 mb-md-0">
                <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
                    <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>
            </div>

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/" class="nav-link px-2">Home</a></li>
                <li><a href="/user/index" class="nav-link px-2">Users</a></li>
            </ul>

            <div class="col-md-3 text-end d-flex">
                <!-- <button type="button" class="btn btn-outline-primary me-2">Login</button>
                <div class="btn btn-primary">Sign-up</div> -->
                {% include "auth-template.tpl" %}
            </div>
        </header>
    </div>

    <!-- <p><a href="/">Home</a></p>
    <p><a href="/user/index">Users</a></p> -->

    <main class="flex-shrink-0">
        <div class="container">
            {% include content_template_name %}
        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <p class="text-center text-body-secondary">© 2024 Company, Inc</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>